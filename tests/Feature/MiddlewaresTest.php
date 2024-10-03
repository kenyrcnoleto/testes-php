<?php

use App\Http\Middleware\RogerMiddleware;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\mock;

test('it should block a request if the user does not have the following email : roger@gmail.com', function () {

    $user = User::factory()->create(['email' => 'email@qualquer.com']);

    $roger = User::factory()->create(['email' => 'roger@gmail.com']);

    actingAs($user);

    get(route('secure-route'))->assertForbidden();

    actingAs($roger);

    get(route('secure-route'))->assertOk();

});

test('check if is being called', function () {
    //FORMA DE testar se uma classe está sendo chamada... com o moc

    mock(RogerMiddleware::class)->shouldReceive('handle')->atLeast()->once();



    get(route('secure-route'));
});
