@extends('layouts.layout')

@section('body')

    @include('layouts.partials.navbar')

    @yield('content')

    @include('layouts.partials.footer')

@endsection
