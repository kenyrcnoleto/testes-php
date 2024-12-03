<?php

use App\Console\Commands\ImportFromAmazonCommand;
use App\Models\User;
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
