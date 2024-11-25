<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function paginacat(Category $category, User $user) {
        $categories = Category::latest()->get();
        $products = Product::latest()->where('id_categorie', 'like', $category->id)->paginate(8);

        return view('pagini.paginacat', ['categories' => $categories, 'products' => $products, 'category' => $category, 'user' => $user]);
    }
}
