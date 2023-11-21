<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Brand;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(15);
        $categories = Categorie::all();
        $brands =Brand::all();
        return(view('product.index',compact('products',"brands","categories")));
    }



    public function getProductInfo($id) {
        $product = Product::with('brand', 'categorie')->find($id);
        $achat = Achat::where('product_id', $id)->first();
        $data = [
            'quantite' => $product->quantite,
            'prix_promo' => $product->prix_promo,
            'prix_revendeur' => $product->prix_revendeur,
            'quantite_marrakech' => $product->quantite_marrakech,
            'quantite_rabat' => $product->quantite_rabat,
            'brand_id' => $product->brand->name,
            'category_id' => $product->categorie->name,
            'prix_achat' => $achat->prix_achat,

        ];
        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        return view('product.show',compact('product'));
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
        //
    }
}
