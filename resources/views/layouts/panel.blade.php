@extends('layouts.layout')

@section('body')
<div class="flex h-screen w-full overflow-hidden">
    @include('layouts.partials.sidebar')

    <main class="flex-1 overflow-y-auto">
        <div class="p-8">
            @yield('content')
        </div>
    </main>
</div>
@endsection