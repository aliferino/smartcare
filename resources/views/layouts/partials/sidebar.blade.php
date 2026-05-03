
@if(Auth::user()->role === 'admin')
    @include('layouts.partials._sidebar-admin')
@elseif(Auth::user()->role === 'fundraiser')
    @include('layouts.partials._sidebar-fundraiser')
@endif