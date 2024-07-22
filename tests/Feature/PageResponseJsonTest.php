<?php

use App\Models\Product;
use function Pest\Laravel\get;

test('nossa api de produtos precisa retornar a lista de produtos')
    ->get('/api/products')
    ->assertOk()
    ->assertExactJson([

        ['title' => 'Produto A'],
        ['title' => 'Produto B'],
    ]);

 test('deve listar produtos do banco de dados', function() {
    //Para ignorar o error
    \Pest\Laravel\withoutExceptionHandling();

     $product1 = Product::factory()->create();
     $product2 = Product::factory()->create();

get('/api/products')
    ->assertOk()
    ->assertJson([
        ['title' => 'Produto A'],
        ['title' => 'Produto B'],
        ['title' => $product1->title],
        ['title' => $product2->title]
    ]);
 });
