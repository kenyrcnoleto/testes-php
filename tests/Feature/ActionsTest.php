<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use App\Notifications\NewProductionNotification;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('it should the call the action to create a product', function () {
    //Actions não é do próprio Laravel, por isso deve trabalhar de forma diferente

    //Queue::fake();
    Notification::fake();

    //Neste caso muda um pouco em rels as posições do assert, arrange, act
    //Assert - Verifica se esse cara será chamado

    $this->mock(CreateProductAction::class)
    ->shouldReceive('handle')
    ->atLeast()->once();

    //Arrange - quando eu tiver este cenário

    $user = User::factory()->create();
    $title = 'Product 1';

    actingAs($user);

    //Act - quando eu agir desta maneira

    postJson(route('product.store'), ['title' => $title]);
});

it('should be able to create a product', function () {

    Notification::fake();

    $user = User::factory()->create();

    (new CreateProductAction())->handle('Product 1', $user);

    assertDatabaseCount('products', 1);

    assertDatabaseHas('products', [
        'title' => 'Product 1',
        'owner_id' => $user->id
    ]);

    Notification::assertSentTo([$user], NewProductionNotification::class);
});
