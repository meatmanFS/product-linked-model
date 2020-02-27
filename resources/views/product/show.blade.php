@extends( 'layout.main' )

@section('content')
    <div class="container">
        @include('product.submenu')
        <p>{{ $product->name }}</p>
        <p>{{ $product->sku }}</p>
    </div>

@endsection