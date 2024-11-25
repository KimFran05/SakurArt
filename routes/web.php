<?php

use App\Http\Controllers\AutController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\CosCumpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdController;
use App\Http\Controllers\ProdPrefController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::post('/', function() {
    session()->forget('success');
    return back();
});

Route::get('/inregistrare', function() {
    return view('pagini.inregistrare');
});

Route::post('/inregistrare', [AutController::class, 'inregistrare']);

Route::get('/logare', function() {
    return view('pagini.logare');
});

Route::post('/logare', [AutController::class, 'logare']);

Route::post('/delogare', [AutController::class, 'delogare']);

Route::get('/categorie/{category}', [CatController::class, 'paginacat']);

Route::get('/produs/{product}', [ProdController::class, 'paginaprod']);

Route::get('/profil/{user}', [UserController::class, 'profil']);

Route::get('/coscumparaturi', [CosCumpController::class, 'paginacoscump'])->middleware('auth');

Route::get('/prodpreferate', [ProdPrefController::class, 'paginaprodpref'])->middleware('auth');

Route::post('/adaugarerecenzie/{product}', [ReviewController::class, 'adaugarerecenzie'])->middleware('auth');

Route::get('/editarerec/{review}', [ReviewController::class, 'pageditare']);

Route::put('/editarerec/{review}', [ReviewController::class, 'editarerec']);

Route::delete('/stergererec/{review}', [ReviewController::class, 'stergererec']);

Route::post('/adaugareproduspref/{product}', [ProdController::class, 'adaugareproduspref'])->middleware('auth');

Route::post('/stergereproduspref/{product}', [ProdPrefController::class, 'stergereproduspref']);

Route::get('/editareprofil/{user}', [UserController::class, 'pageditareprofil']);

Route::put('/editareprofil/{user}', [UserController::class, 'editareprofil']);

Route::put('/stergerepoza/{user}', [UserController::class, 'stergerepoza']);

Route::get('/schimbareparola/{user}', [UserController::class, 'pagschimbareparola']);

Route::put('/schimbareparola/{user}', [UserController::class, 'schimbareparola']);

Route::get('/stergerecont/{user}', [UserController::class, 'pagstergerecont']);

Route::delete('/stergerecont/{user}', [UserController::class, 'stergerecont']);

Route::post('/adaugareproduscos/{product}', [ProdController::class, 'adaugareproduscos'])->middleware('auth');

Route::delete('/stergereproduscos/{cartProduct}', [CosCumpController::class, 'stergereproduscos']);

Route::put('/cantitateplus/{cartProduct}', [CosCumpController::class, 'cantitateplus']);

Route::put('/cantitateminus/{cartProduct}', [CosCumpController::class, 'cantitateminus']);

Route::delete('/stergereprodusecos', [CosCumpController::class, 'stergereprodusecos']);

Route::get('/plata', [OrderController::class, 'paginacomanda'])->middleware('auth');

Route::post('/plata', [OrderController::class, 'plata']);

Route::get('/paginaparola', function() {
    return view('pagini.paginaparola');
});
