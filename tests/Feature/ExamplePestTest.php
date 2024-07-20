<?php

use function Pest\Laravel\get;

/*test('the application returns a successful response', function() {
    //$response = $this->get('/');
    //$response = get('/');
    get('/')->assertStatus(200);
});*/

test('the application returns a successful response')
    ->get('/')
    ->assertSuccessful();

