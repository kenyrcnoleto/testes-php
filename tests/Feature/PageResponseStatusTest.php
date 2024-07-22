<?php

use function Pest\Laravel\get;

test('testando código 200')
    ->get('/')
    ->assertStatus(200);

test('1-testando código 404', function() {
    $response = get('/404');
    //dd($response->status());
});


test('testando código 404')
    ->get('/not-exists')
    ->assertStatus(404)
    ->assertNotFound();


//test('testando código 500');

test('testeando código 403:: não tem permissão de acesso')
    ->get('/403')
    ->assertStatus(403)
    ->assertForbidden();




