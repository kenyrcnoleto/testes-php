<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\assertTrue;

test('model relationship :: product owner should be an user', function () {

    $user = User::factory()->create();

    $product = Product::factory()->create(['owner_id' => $user->id]);

    $owner = $product->owner;

    expect($owner)
        ->toBeInstanceOf(User::class);
});


test('model get mutator :: product title should always str()->title()', function () {
    //este é no get - quando pega a informação do db
    $product = Product::factory()->create(['title' => 'titulo']);

    //retorno do título tem que iniciar com letra T maiúscula - ver se funciona
    expect($product)
        ->title->toBe('Titulo');
});

test('model set mutator :: product code should be encrypted', function () {
    //este é no sett

    $product = Product::factory()->create(['code' => 'roger']);


    assertTrue(Hash::isHashed($product->code));

    //dd($product->code);

});


test('model scopes :: should bring only release products', function () {

  Product::factory()->count(10)->create(['released' => true]);
  Product::factory()->count(5)->create(['released' => false]);

  expect(Product::query()->released()->get())
    ->toHaveCount(10);
});


/*
trabalhando com tinker

php artisan tinker
Psy Shell v0.12.4 (PHP 8.1.29 — cli) by Justin Hileman
> \App\Models\Product::factory()->create(['code' => 'roger', 'title' => 'pequeno']);
= App\Models\Product {#5230
    title: "pequeno",
    owner_id: 2,
    code: "$2y$12$f7LHC499dGY3vp4YfInGaO9nj.75HTY5AbazdiSgHoi6oBVHrnrZu",
    updated_at: "2024-09-23 22:47:37",
    created_at: "2024-09-23 22:47:37",
    id: 2,
  }

➜ php artisan tinker
Psy Shell v0.12.4 (PHP 8.1.29 — cli) by Justin Hileman
> use \App\Models\Product;
> Product::latest();
= Illuminate\Database\Eloquent\Builder {#5167}

> latest()->get();

   Error  Call to undefined function latest().

> Product::latest()->get();
= Illuminate\Database\Eloquent\Collection {#6173
    all: [
      App\Models\Product {#6174
        id: 2,
        title: "pequeno",
        owner_id: 2,
        code: "$2y$12$f7LHC499dGY3vp4YfInGaO9nj.75HTY5AbazdiSgHoi6oBVHrnrZu",
        created_at: "2024-09-23 22:47:37",
        updated_at: "2024-09-23 22:47:37",
        deleted_at: null,
      },
      App\Models\Product {#6175
        id: 1,
        title: "Dr.",
        owner_id: 1,
        code: "$2y$12$vtkGgz9WmVEkT8frY.oVdOOaPXlhJDIp2iyLK3YvAQme1qTJTXSPC",
        created_at: "2024-09-23 22:42:07",
        updated_at: "2024-09-23 22:42:07",
        deleted_at: null,
      },
    ],
  }

> Product::latest()->first()->title();
= Illuminate\Database\Eloquent\Casts\Attribute {#5159
    +get: Closure($value) {#6141 …4},
    +set: null,
    +withCaching: false,
    +withObjectCaching: true,
  }

> Product::latest()->first()->title;
= "Pequeno"

> */
