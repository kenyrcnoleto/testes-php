<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\post;

test('an email was sent', function () {
    //se eu falar que é faço ele não encaminhar para .env
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-email', $user))->assertOk();


    Mail::assertSent(WelcomeEmail::class);
});


