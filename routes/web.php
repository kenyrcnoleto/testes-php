<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/404', function() {
    return ['oi'];
});

Route::get('/403', function() {

    abort_if(true,403);

    return ['oi'];
});


Route::get('/products', function() {
    return view('products', [
        'products' => \App\Models\Product::all(),
    ]);
});
