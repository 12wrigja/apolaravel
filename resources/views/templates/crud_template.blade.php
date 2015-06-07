@extends('master_full')

@section('content')

    <div class="container" id="crud_form_container">
        @include('flash::message')
        @yield('crud_form')
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('div.alert').not('.alert-important').delay(5000).slideUp();
    </script>
@endsection