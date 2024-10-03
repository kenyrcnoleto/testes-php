<?php


namespace App\Actions;

use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductionNotification;

class CreateProductAction
{
    public function handle(string $title, User $user) :void
    {
        $product =Product::query()->create([
            'title' => $title,
            'owner_id' => $user->id,
        ]);
        //dd($product);

        //Dentro do modo usertenho uma trait chamada notifiable, dar poder para ser modificado
        $user->notify(
            new NewProductionNotification()
        );
    }
}


