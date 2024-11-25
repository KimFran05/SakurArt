<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdPrefController extends Controller
{
    public function paginaprodpref() {
        $categories = Category::latest()->get();
        $favorites = Favorite::where('id_utilizator', Auth::id())->get();
        $idpref = $favorites->pluck('id_produs');
        $products = Product::whereIn('id', $idpref)->paginate(8);

        return view('pagini.paginaprodpref', ['categories' => $categories, 'products' => $products]);
    }

    public function stergereproduspref(Favorite $favorite, Product $product) {
        $favorite = Favorite::where('id_utilizator', Auth::id())->where('id_produs', $product->id);
        $favorite->delete();
        return back()->with('success', 'Produsul a fost șters din preferate!');
    }
}
