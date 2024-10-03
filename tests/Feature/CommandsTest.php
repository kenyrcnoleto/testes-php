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
