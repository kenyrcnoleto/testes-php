<ul>
    <li>Produto A</li>
    <li>Produto B</li>
    <p>Keny</p>

    @foreach ($products as $product)
        <li> {{ $product->title }} </li>

    @endforeach
</ul>
