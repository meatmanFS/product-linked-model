@extends( 'layout.main' )

@section('content')
    <div class="container">
        @include('productType.submenu')
        <p>{{ $productType->name }}</p>
    </div>

@endsection