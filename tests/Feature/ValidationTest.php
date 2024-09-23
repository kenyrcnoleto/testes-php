<?php

use function Pest\Laravel\post;
use function Pest\Laravel\postJson;


test('procuct:: title should be required', function() {

    postJson(route('product.store'), ['title' => ''])
    ->assertInvalid(['title' => 'required']);


    post(route('product.store'), ['title' => ''])
    ->assertInvalid(['title' => 'required']);

})->todo();


test('product:: title should have a max of 255 characters', function () {
    postJson(route('product.store'), ['title' => str_repeat('*',256)])
    ->assertInvalid(
        ['title' => trans('validation.max.string', ['attribute' => 'title', 'max' => 255])]);
});

//passar conjunto de dados parâmetros
test('create procuct validations', function ($data, $error) {
    postJson(route('product.store'), $data)
    ->assertInvalid($error);
})->with([
    //forma de passar um conjunto de dados
    'title:required' => [['title' => ''],['title' => 'required']],
    'title:max:255' => [['title' => str_repeat('*',256)],['title' => 'The title field must not be greater than 255 characters.']],
    //'title:max:255'
    //existe uma limitação do framework pest quando popula o with que não consegue chamar o método trans
]);
