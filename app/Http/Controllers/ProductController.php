<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Brand;
use App\Models\Categorie;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand', 'categorie')->paginate(15);
        $categories = Categorie::all();
        $brands = Brand::all();

        return view('product.index', compact('products', 'brands', 'categories'));
    }

    /**
     * JSON used by the "new sale" form to fill in product details.
     */
    public function getProductInfo(string $id)
    {
        $product = Product::with('brand', 'categorie')->findOrFail($id);
        $prixAchat = Achat::where('product_id', $id)->value('prix_achat');

        return response()->json([
            'quantite' => $product->quantite,
            'prix_promo' => $product->prix_promo,
            'prix_revendeur' => $product->prix_revendeur,
            'quantite_marrakech' => $product->quantite_marrakech,
            'quantite_rabat' => $product->quantite_rabat,
            'brand_id' => $product->brand?->name,
            'category_id' => $product->categorie?->name,
            'prix_achat' => $prixAchat,
        ]);
    }

    public function show(string $id)
    {
        $product = Product::with('brand', 'categorie')->findOrFail($id);

        return view('product.show', compact('product'));
    }
}
