@extends( 'layout.main' )

@section('content')
    <div class="container">
        @include('productType.submenu')
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($productTypes as $key => $productType)
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $productType->name }}</td>
                    <td>
                        <form action="{{route('productTypes.destroy', $productType)}}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-primary" href="{{route('productTypes.edit', $productType)}}" role="button">Edit</a>
                                <a class="btn btn-secondary" href="{{route('productTypes.show', $productType)}}" role="button">Show</a>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $productTypes->links() }}

    </div>

@endsection