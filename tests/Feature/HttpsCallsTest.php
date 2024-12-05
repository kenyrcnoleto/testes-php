<?php

use App\Console\Commands\ExportProductToAmazon;
use App\Console\Commands\ImportFromAmazonCommand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

test('it should fake an api request', function () {
    User::factory()->create();
    Http::fake([
        'https://api.amazon.com/products' => Http::response([
            //Coloca exatamente o que sua api retorna
            ['title' => 'Product 1'],
            ['title' => 'Product 2']
        ])
        ]);

        //Se utilizar o guzzle client ou curl não vai funcionar o fake.
       // dd(Http::get('https://api.amazon.com/products')->json());


       artisan(ImportFromAmazonCommand::class)->assertSuccessful();

       assertDatabaseHas('products', ['title' => 'Product 1']);
       assertDatabaseHas('products', ['title' => 'Product 2']);

       assertDatabaseCount('products', 2);
});


test('testing the data that we send to amazon', function () {
    Http::fake();

    config()->set('services.amazon.api_key', 123123);

    Product::factory()->count(2)->create();

    (new ExportProductToAmazon)->handle();

    Http::assertSent(function(Request $request) {
        //dd visualiza qual o request correto para importar
        //dd($request);

        //dump($request->data(), Product::all()->map(fn($p) => ['title' => $p->title])->toArray());
        //dd($request->header('Authorization'));

        return $request->url() == 'https://api.amazon.com/products'
            && $request->header('Authorization') == ['Bearer '. config('services.amazon.api_key')]
            && $request->data() == Product::all()->map(fn($p) => ['title' => $p->title])->toArray();
    });
});

//forma de garantir que a sua chave está configurada no arquivo config.
test('it my config should have at least the key', function () {
    //dd(config('services.amazon.api_key'));
    expect(config('services'))
        ->toHaveKey('amazon')
        ->and(config('services.amazon'))
        ->toHaveKey('api_key');
});
