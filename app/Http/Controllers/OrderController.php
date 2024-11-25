<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function paginacomanda() {
        $categories = Category::latest()->get();
        return view('pagini.paginacomanda', ['categories' => $categories]);
    }

    public function plata(Request $request) {
        $date = $request->validate([
            'nume'=>['required', 'min:3', 'max:20'],
            'prenume'=>['required', 'min:3', 'max:20'],
            'numartelefon'=>['required', 'regex:/^(07)[0-9]{8}$/'],
            'judet'=>['required', 'min:3', 'max:20'],
            'localitate'=>['required', 'min:3', 'max:20'],
            'adresa'=>['required', 'min:3', 'max:100'],
            'numarcard'=>['required', 'string', 'size:16'],
            'dataexpirarii'=>['required', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'],
            'cvv'=>['required', 'digits_between:3,4'],
            'numedetinator'=>['required', 'min:6', 'max:40'],
        ]);
        $date['id_utilizator'] = Auth::id();

        $cart_products = CartProduct::where('id_utilizator', Auth::id())->get();
        $totalproduse = 0;
        foreach ($cart_products as $cart_product) {
            $totalproduse += $cart_product['pret'] * $cart_product['cantitate'];
        }
        $totalproduse += 10;

        $date['total'] = number_format($totalproduse, 2, '.', '');

        $produse = Product::latest()->get();

        foreach ($cart_products as $cart_product) {
            $date['produse'][] = [
                'id_produs' => $cart_product['id_produs'],
                'name' => $cart_product['name'],
                'image' => $cart_product['image'],
                'cantitate' => $cart_product['cantitate'],
                'pret' => $cart_product['pret'],
            ];
            foreach ($produse as $produs) {
                if($produs['id'] === $cart_product['id_produs']) {
                    $produs['stoc'] = $produs['stoc'] - $cart_product['cantitate'];
                    $produs->update([$produs['stoc']]); 
                }
            }
        }

        $date = Order::create([
            'id_utilizator' => $date['id_utilizator'],
            'nume' => $date['nume'],
            'prenume' => $date['prenume'],
            'numartelefon' => $date['numartelefon'],
            'judet' => $date['judet'],
            'localitate' => $date['localitate'],
            'adresa' => $date['adresa'],
            'total' => $date['total'],
            'produse' => $date['produse'],
        ]);

        CartProduct::where('id_utilizator', Auth::id())->delete();

        return redirect('/')->with('success', 'Comanda a fost plasată!');
    }
}
