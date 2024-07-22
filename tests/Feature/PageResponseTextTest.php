<?php
use App\Models\Product;
use function Pest\Laravel\get;

it('listar produtos')
 //it should list products
    ->get('/products')
    ->assertOk()
    ->assertSee('Keny')
    ->assertSeeTextInOrder([
        'Produto A',
        'Produto B'
    ]);

    //AssertSee śempre é relacionado ao html

    test('deve listar produtos do banco de dados', function() {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();


        \Pest\Laravel\get('products')
            ->assertOk()
            ->assertSeeTextInOrder([
                'Produto A',
                'Produto B',
                $product1->title,
                $product2->title
            ]);
    });
