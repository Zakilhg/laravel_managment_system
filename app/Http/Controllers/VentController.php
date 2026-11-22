<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Paiment;
use App\Models\Product;
use App\Models\Societe;
use App\Models\Vent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VentController extends Controller
{
    /**
     * This month's sales for the logged-in user.
     */
    public function index(Request $request)
    {
        $vents = $request->user()->vents()
            ->with('product')
            ->where('date_vent', '>=', Carbon::now()->firstOfMonth())
            ->latest('date_vent')
            ->get();

        return view('user.sales', compact('vents'));
    }

    public function create()
    {
        $paiements = Paiment::all();
        $societes = Societe::all();
        $products = Product::all();

        return view('vent.create', compact('products', 'paiements', 'societes'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'product' => 'required|exists:products,id',
            'prix_vent' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:1',
            'paiement' => 'required|exists:mode_de_paiement,name',
            'societes' => 'nullable|exists:societes,name',
            'local' => 'required|in:Marrakech,Rabat',
            'clientname' => 'required',
            'clientadresse' => 'required',
            'clientphone' => 'required',
            'clientemail' => 'required|email',
        ]);

        $stockColumn = 'quantite_'.strtolower($request->local);

        DB::transaction(function () use ($request, $user, $stockColumn) {
            // Lock the row so two sales can't both take the last units.
            $product = Product::lockForUpdate()->findOrFail($request->product);

            if ($request->quantite > $product->$stockColumn) {
                throw ValidationException::withMessages([
                    'quantite' => "Only {$product->$stockColumn} left in stock at {$request->local}.",
                ]);
            }

            $product->quantite -= $request->quantite;
            $product->$stockColumn -= $request->quantite;
            $product->save();

            // The purchase price comes from the database, never from the form,
            // so it can't be tampered with to fake the profit figures.
            $prixAchat = Achat::where('product_id', $request->product)->value('prix_achat') ?? 0;

            $vent = new Vent;
            $vent->product_id = $request->product;
            $vent->user_id = $user->id;
            $vent->date_vent = Carbon::now()->format('Y-m-d');
            $vent->prix_vent = $request->prix_vent;
            $vent->prix_achat = $prixAchat;
            $vent->quantite = $request->quantite;
            $vent->local = $request->local;
            $vent->paiement = $request->paiement;
            $vent->clientname = $request->clientname;
            $vent->clientadresse = $request->clientadresse;
            $vent->clientphone = $request->clientphone;
            $vent->clientemail = $request->clientemail;
            $vent->agent = $user->name;
            $vent->par = $user->name;
            $vent->societe = $request->societes;
            $vent->livraison = false;
            $vent->save();
        });

        return redirect('dashboard')->with('message', 'Vent added successfully');
    }

    public function destroy(Request $request, string $id)
    {
        // Only the user who recorded a sale may delete it.
        $vent = $request->user()->vents()->findOrFail($id);

        DB::transaction(function () use ($vent) {
            $product = Product::lockForUpdate()->find($vent->product_id);
            $stockColumn = 'quantite_'.strtolower($vent->local);

            // Sales recorded before the location check may have a free-text location.
            if ($product && in_array($vent->local, ['Marrakech', 'Rabat'], true)) {
                $product->quantite += $vent->quantite;
                $product->$stockColumn += $vent->quantite;
                $product->save();
            }

            $vent->delete();
        });

        return redirect('dashboard');
    }
}
