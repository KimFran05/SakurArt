<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(User $user, Product $product) {
        $categories = Category::latest()->get();
        $query = Product::latest();
        
        if(request()->has('search')){
            $search = request()->get('search', '');
            $query = $query->where('nume', 'like', '%' . $search . '%')->orWhere('producator', 'like', '%' . $search . '%');
        }

        $products = $query->paginate(8);

        return view('pagini.home', ['categories' => $categories, 'products' => $products, 'user' => $user]);
    }
}
