<?php

use App\Actions\CreateProductAction;
use App\Http\Middleware\RogerMiddleware;
use App\Jobs\ImportProductsJob;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductionNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
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
    return response('', 404);
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

Route::post('/products', function() {

    //Não entendi o motivo mas o teste funciona apenas para 'required|max:255' e não para 'required', 'max:255'
    request()->validate(
        ['title' => 'required|max:255']
    );

    //dd(request()->title);
    //envia tanto a chave quanto o valor -- request()->only('title')

    //Como não pertence o mundo Laravel não é view app, por isso precisa colocar o função app()
    //$action = new CreateProductAction();
    app(CreateProductAction::class)
        ->handle(
            request()->get( 'title'),auth()->user());



    // $product =Product::query()->create([
    //     'title' => request()->get('title'),
    //     'owner_id' => auth()->id(),
    // ]);
    // //dd($product);

    // //Dentro do modo usertenho uma trait chamada notifiable, dar poder para ser modificado
    // auth()->user()->notify(
    //     new NewProductionNotification()
    // );
    return response()->json('','201');

})->name('product.store');


Route::put('/products/{product}', function(Product $product) {
    $product->title = request()->get('title');
    $product->save();
})->name('product.update');

Route::delete('/products/{product}', function(Product $product) {
    //$product->delete(); respeita o soft-delete uma vez que foi implementado
    $product->forceDelete();
})->name('product.destroy');

Route::delete('products/{product}/soft-delete', function(Product $product) {
    $product->delete();
})->name('product.soft-delete');


Route::post('/sending-email/{user}', function (User $user)  {
    Mail::to($user)->send(new WelcomeEmail($user));
})->name('sending-email');


Route::post('/products-import', function() {
    $data = request()->get('data');
    //dd($data);

    ImportProductsJob::dispatch($data, auth()->id());
})->name('product.import');

Route::get('/secure-route', fn()=>['oi'])
    ->middleware('roger')
    ->name('secure-route');


Route::post('/upload-avatar', function() {

    $file = request()->file('file');

    //dd($file);

    $file->store(
        path: '/',
        options: ['disk' => 'avatar']
    );



})->name('upload-avatar');

