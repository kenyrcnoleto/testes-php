<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('it should block a request if the user does not have the following email : roger@gmail.com', function () {

    $user = User::factory()->create(['email' => 'email@qualquer.com']);

    $roger = User::factory()->create(['email' => 'roger@gmail.com']);

    actingAs($user);

    get(route('secure-route'))->assertForbidden();

    actingAs($roger);

    get(route('secure-route'))->assertOk();

});
