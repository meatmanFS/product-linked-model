@extends( 'layout.main' )

@section('content')
    <div class="container">
        @include('product.submenu')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form enctype="multipart/form-data" method="POST" action="{{ route('products.update', $product) }}">
            {{ csrf_field() }}
            @method('PATCH')
            <div class="form-group">
                <label for="name">Product name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}" required>
            </div>
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="{{$product->sku}}" required>
            </div>

            <product-attributes :product-id="{{$product->id}}"></product-attributes>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name='publish' value="publish">Update</button>
            </div>
        </form>
    </div>

@endsection