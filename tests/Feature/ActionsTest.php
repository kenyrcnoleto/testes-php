<?php

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('it should the action to create a product', function () {
    //Actions não é do próprio Laravel, por isso deve trabalhar de forma diferente

    //Queue::fake();
    FacadesNotification::fake();

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
