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
        <form enctype="multipart/form-data" method="POST" action="{{ route('products.store') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Product name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
            </div>
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="{{old('sku')}}" required>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary" name='publish' value="publish">Create</button>
            </div>
        </form>
    </div>

@endsection