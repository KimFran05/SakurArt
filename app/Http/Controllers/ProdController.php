<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdController extends Controller
{
    public function paginaprod(Product $product, User $user) {
        $user->id = Auth::id();
        $categories = Category::latest()->get();
        $recenzieutil = Review::where('id_utilizator', Auth::id())->where('id_produs', $product->id)->exists();
        $reviews = Review::latest()->where('id_produs', 'like', $product->id)->get();

        return view('pagini.paginaprod', ['categories' => $categories, 'product' => $product, 'reviews' => $reviews, 'user' => $user, 'recenzieutil' => $recenzieutil]);
    }

    public function adaugareproduspref(Product $product) {
        $date['id_utilizator'] = Auth::id();
        $date['id_produs'] = $product->id;
        $prodpref = Favorite::where('id_utilizator', Auth::id())->where('id_produs', $product->id)->exists();

        if($prodpref){
            $favorite = Favorite::where('id_utilizator', Auth::id())->where('id_produs', $product->id);
            $favorite->delete();
            return back()->with('success', 'Produsul a fost șters din preferate!');
        } else {
            $date = Favorite::create($date);
            return back()->with('success', 'Produsul a fost adăugat la preferate!');  
        }       
    }

    public function adaugareproduscos(Product $product) {
        $date['id_utilizator'] = Auth::id();
        $date['id_produs'] = $product->id;
        $date['name'] = $product->nume;
        $date['pret'] = $product->pret;
        $date['image'] = $product->image;
        $date['cantitate'] = 1;
        $prodcos = CartProduct::where('id_utilizator', Auth::id())->where('id_produs', $product->id)->exists();

        if($prodcos){
            $cart_product = CartProduct::where('id_utilizator', Auth::id())->where('id_produs', $product->id)->first();
            $cart_product['cantitate'] = $cart_product->cantitate + 1;
            $cart_product->update([$cart_product['cantitate']]);
            return back()->with('success', 'Produsul a fost adăugat în coș!');
        } else {
            $date = CartProduct::create($date);
            return back()->with('success', 'Produsul a fost adăugat în coș!');  
        }       
    }
}
