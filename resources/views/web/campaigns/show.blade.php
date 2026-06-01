@extends('layouts.web')

@section('content')
    @include('web.campaigns._detail', ['campaign' => $campaign])
@endsection
