<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function stergererec(Review $review) {
        $review->delete();
        return back()->with('success', 'Recenzia a fost ștearsă!');
    }

    public function pageditare(Review $review) {
        if(Auth::id() !== $review['id_utilizator']){
            return redirect('/');
        }

        $categories = Category::latest()->get();

        return view('pagini.editrec', [ 'categories' => $categories, 'review' => $review ]);
    }

    public function editarerec(Review $review, Request $request) {
        $date = $request->validate([
            'rating'=>['integer', 'min:1', 'max:5'],
            'titlu'=>['min:5', 'max:20'],
            'continut'=>['min:5', 'max:200']
        ]);

        $review->update($date);
        return redirect('/')->with('success', 'Recenzia a fost editată cu succes!');
    }

    public function adaugarerecenzie(Request $request, Product $product) {
        $date = $request->validate([
            'rating'=>['required', 'integer', 'min:1', 'max:5'],
            'titlu'=>['required', 'min:5', 'max:20'],
            'continut'=>['required', 'min:5', 'max:200']
        ]);

        $date['id_utilizator'] = Auth::id();
        $date['id_produs'] = $product->id;
        
        $date = Review::create($date);
        return back()->with('success', 'Review-ul a fost publicat!');
    }
}
