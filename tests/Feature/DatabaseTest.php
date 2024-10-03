<?php

use App\Models\Product;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

it('should be able to create a product', function() {

    //Product::factory()->create();

    $user = User::factory()->create();


    actingAs($user);

    \Pest\Laravel\postJson(
        route('product.store'),
            [
                'title' => 'Titulo Qualquer',
            ]
        )
        ->assertCreated();

        //Essa é a mesma clausula do where para buscar no db
        assertDatabaseHas('products', [
            'title' => 'Titulo Qualquer'
        ]);

        assertTrue(
            Product::query()
                ->where('title', '=', 'Titulo Qualquer')
                ->exists()
        );

        assertDatabaseCount('products', 1);
});




it('should be able to update a product', function() {
    //Product::factory()->create();
    $product = Product::factory()->create(['title' => 'Titulo Qualquer']);
    //Verificar pois está sempre aparecendo com status positivo para qualquer rota inexistente.

    \Pest\Laravel\putJson(
        route('product.update', $product),
        ['title' => 'Atualizando o titulo']
    )->assertStatus(201);

    //Forma de verificar se realmente foi atualizando no db
    assertDatabaseHas('products', [
        'id' => $product->id,
        'title' => 'Atualizando o título'
    ]);


    //Outra forma de fazer
    //Nesse caso preciso dar um refresh na variável
    expect($product)
        ->refresh()
        ->title->toBe('Atualizando o título');

    assertSame('Atualizando o titulo', $product->title, 'tem que ser igual');


    assertDatabaseCount('products', 1);

})->todo();

it('should be able to delete a product', function() {
    $product = Product::factory()->create();


    deleteJson(route('product.destroy', $product))
    ->assertOk();

    assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);

    assertDatabaseCount('products', 0);
});


it('should be able to soft-delete a product', function() {
    $product = Product::factory()->create();


    deleteJson(route('product.soft-delete', $product))
    ->assertOk();

    //Verificar com o soft delete
    assertSoftDeleted('products', [
        'id' => $product->id,
    ]);

    assertDatabaseCount('products', 1);
});
