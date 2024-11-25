<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CosCumpController extends Controller
{
    public function paginacoscump(User $user) {
        $user->id = Auth::id();
        $categories = Category::latest()->get();
        $cart_products = CartProduct::where('id_utilizator', Auth::id())->get();

        return view('pagini.paginacoscump', ['categories' => $categories, 'cart_products' => $cart_products, 'user' => $user]);
    }

    public function stergereproduscos(CartProduct $cartProduct) {
        $cartProduct->delete();
        return back();
    }

    public function cantitateplus(CartProduct $cartProduct) {
        $cart_Product = CartProduct::where('id', $cartProduct->id)->first();
        $product = Product::where('id', $cartProduct->id_produs)->first();
        if($product['stoc'] > $cart_Product['cantitate']) {
            $cart_Product['cantitate'] = $cart_Product['cantitate'] + 1;
            $cart_Product->update([$cart_Product['cantitate']]);
        } else if ($product['stoc'] <= $cart_Product['cantitate'] && $product['stoc'] != 0){
            $cart_Product['cantitate'] = $product['stoc'];
            $cart_Product->update([$cart_Product['cantitate']]);
        } else {
            $cart_Product->delete();
        }
        return back();
    }

    public function cantitateminus(CartProduct $cartProduct) {
        $cart_Product = CartProduct::where('id', $cartProduct->id)->first();
        if($cart_Product['cantitate'] > 1) {
            $cart_Product['cantitate'] = $cart_Product['cantitate'] - 1;
            $cart_Product->update([$cart_Product['cantitate']]);
        } else {
            $cart_Product->delete();
        }
        
        return back();
    }

    public function stergereprodusecos() {
        CartProduct::where('id_utilizator', Auth::id())->delete();

        return back();
    }
}
