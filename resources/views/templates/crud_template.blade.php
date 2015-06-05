@extends('master_full')

@section('content')

    <div class="container">
        @include('flash::message')
        @yield('crud_form')
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('div.alert').not('.alert-important').delay(3000).slideUp();
    </script>
@endsection