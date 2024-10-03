<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\User;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertCount;

test('it should be to create product via command', function () {

    $user = User::factory()->create();

    //$this->artisan()
    artisan(CreateProductCommand::class,
        ['title' => 'product 1', 'user' => $user->id])
            ->assertSuccessful();


    assertDatabaseHas('products', ['title' => 'product 1', 'owner_id' => $user->id]);

    assertDatabaseCount('products', 1);


});

test('it should asks for user and title if is not passed as argument', function () {

    $user = User::factory()->create();

    artisan(CreateProductCommand::class, [])
        ->expectsQuestion('Please, provide a valid user id', $user->id)
        ->expectsQuestion('Plese, provide a title for the product', 'Product 1')
        ->expectsOutputToContain('Product created!!')
        ->assertSuccessful();

});
