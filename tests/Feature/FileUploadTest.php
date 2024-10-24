<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

test('it should be able to upload an image', function () {

    Storage::fake('avatar');

    $user = User::factory()->create();

    $file = UploadedFile::fake()->image('image.jpg');

    actingAs($user);

    post(route('upload-avatar'), [
        'file' => $file
    ])->assertOk();


    //Assert

    Storage::disk('avatar')->assertExists($file->hashName());
    //assertExists($file->hasName());
});
