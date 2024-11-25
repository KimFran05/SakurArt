<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profil(User $user) {
        $categories = Category::latest()->get();
        $reviews = Review::latest()->where('id_utilizator', $user->id)->get();
        $orders = Order::latest()->where('id_utilizator', $user->id)->get();

        return view('pagini.profil', ['categories' => $categories, 'user' => $user, 'reviews' => $reviews, 'orders' => $orders]);
    }

    public function pageditareprofil(User $user) {
        if(Auth::id() !== $user['id']){
            return redirect('/');
        }
        $categories = Category::latest()->get();

        return view('pagini.editareprofil', ['categories' => $categories, 'user' => $user]);
    }

    public function editareprofil(User $user, Request $request) {
        $date = $request->validate([
            'name'=>['min:3', 'max:20'],
            'prenume'=>['min:3', 'max:20', 'nullable'],
            'image'=>['nullable', 'image']
        ]);

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profil', 'public');
            $date['image'] = $imagePath;

            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
        }

        $user->update($date);
        return redirect('/')->with('success', 'Profilul a fost editat cu succes!');
    }

    public function stergerepoza(User $user) {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user['image'] = '';
        $user->update([$user['image']]);

        return back();
    }

    public function pagschimbareparola(User $user) {
        if(Auth::id() !== $user['id']){
            return redirect('/');
        }
        $categories = Category::latest()->get();

        return view('pagini.schimbareparola', ['categories' => $categories, 'user' => $user]);
    }

    public function schimbareparola(User $user, Request $request) {
        $date = $request->validate([
            'password'=>['required', 'min:8', 'confirmed']
        ]);
        $date['password'] = bcrypt($date['password']);
        $user->update($date);
        auth()->logout();
        return redirect('/');
    }

    public function pagstergerecont(User $user) {
        if(Auth::id() !== $user['id']){
            return redirect('/');
        }
        $categories = Category::latest()->get();

        return view('pagini.stergerecont', ['categories' => $categories, 'user' => $user]);
    }

    public function stergerecont(User $user, Request $request) {
        $date = $request->validate([
            'password'=>['required', 'confirmed']
        ]);
        if(Hash::check($date['password'], $user['password'])) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            auth()->logout();
            $user->delete();
            return redirect('/')->with('success', 'Contul a fost șters!');
        } else {
            return back();
        }
    }
}
