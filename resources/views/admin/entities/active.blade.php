@extends('layouts.panel', ['title' => 'Active Entities'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Active Entities</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">List of all verified and approved organizations.</p>
</div>

<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.entities._table', ['entities' => $entities, 'context' => 'approved'])
</div>

@include('admin.entities._modal')

@push('scripts')
<script>
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        
        $.get(url, function(data) {
            $('#table-container').html(data);
        });
    });
</script>
@endpush
@endsection