<?php

use App\Console\Commands\CreateProductCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\artisan;

test('it should be able to guarantee that the user exists', function () {

    artisan(
        CreateProductCommand::class,
        ['title'  => 'Roger', 'user' => 99]
    );

// Uma outra forma de testar para verificar se possui o findOrFail ModelNotFoundException
})->throws(ValidationException::class);
