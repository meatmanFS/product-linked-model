@extends( 'layout.main' )

@section('content')
    <div class="container">
        @include('product.submenu')
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Sku</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $key => $product)
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>
                        <form action="{{route('products.destroy', $product)}}" method="POST" class="form-inline">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-primary" href="{{route('products.edit', $product)}}" role="button">Edit</a>
                                <a class="btn btn-secondary" href="{{route('products.show', $product)}}" role="button">Show</a>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links() }}

    </div>

@endsection