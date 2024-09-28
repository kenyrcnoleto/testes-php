<?php

use App\Models\User;
use App\Notifications\NewProductionNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('should sends notifications about a new product', function () {


    //notification é um serviço do laravel, tem uma facede para o serviço, consegue deixar em modo o fake

    Notification::fake();
    $user = User::factory()->create();

    //precisa logar com o usuario
    actingAs($user);

    $data = ['title' => 'Product'];
    postJson(route('product.store'), $data)->assertCreated();
        //201 é o estado de criação

        //asserts em notiticação tem varias possibilidades

        Notification::assertCount(1);

        //notifiable é um mixed - aceita coleção array...

        Notification::assertSentTo([$user], NewProductionNotification::class);
});
