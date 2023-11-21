<?php

namespace App\Http\Controllers;

use App\Models\Societe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Paiment;
use App\Models\Product;
use App\Models\Vent;
use Illuminate\Http\Request;

class VentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            $query = $user->vents();
            $vents = $query->where('date_vent', '>=', Carbon::now()->firstOfMonth())->limit(10)->get();
            return view('user.sales',compact('vents'));
        }
        return redirect('/login');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paiements =Paiment::all();
        $societes = Societe::all();
        $products =Product::all();
        return view('vent.create',compact('products','paiements','societes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $request->validate([
            'product' => 'required',
            'prix_vent' => 'required|numeric',
            'quantite'=>'required|numeric',
            'paiement'=>'required',
            'local' => 'required',
            'clientname' => 'required',
            'clientadresse' => 'required',
            'clientphone' => 'required',
            'clientemail' => 'required|email',
        ]);

        $vent = new Vent();

        $vent->product_id = $request->product;
        $vent->user_id = $user->id;
        $vent->date_vent = Carbon::now()->format('Y-m-d');
        $vent->prix_vent = $request->prix_vent;
        $vent->prix_achat = $request->prix_achat;
        $vent->quantite = $request->quantite;
        $vent->local = $request->local;
        $vent->paiement = $request->paiement;
        $vent->clientname = $request->clientname;
        $vent->clientadresse = $request->clientadresse;
        $vent->clientphone = $request->clientphone;
        $vent->clientemail = $request->clientemail;
        $vent->agent = $user->name;
        $vent->par = $user->name;
        $vent ->societe = $request->societes;
        $vent ->livraison = 0;

        $vent->save();
        return redirect('dashboard')->with('message',"Vent added successfully ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Vent::destroy($id);
        return redirect('dashboard');
    }
}
