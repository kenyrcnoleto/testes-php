<?php

test('a rota products está utilizando a view products')
    ->get('/products')
    ->assertViewIs('products');

    //verifica se tem essa view nessa rota


    test('a rota products está passando uma lista de produtos para a view products')
        ->get('/products')
        ->assertViewIs('products')
        ->assertViewHas('products');


        //verifica se nessa view está passando a variável products

