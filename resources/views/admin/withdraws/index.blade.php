@extends('layouts.panel', ['title' => 'Withdraws Dashboard'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-slate-900 uppercase">Withdraws Dashboard</h1>
    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest opacity-70">Review and manage all withdrawal requests from fundraisers.</p>
</div>

<!-- Status Boxes -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <a href="{{ route('admin.withdraws.pending') }}" class="bg-white border border-slate-100 rounded-xl p-6 hover:shadow-lg transition-all group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Pending</p>
                <p class="text-4xl font-black text-slate-900">{{ $pendingCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.withdraws.approved') }}" class="bg-white border border-slate-100 rounded-xl p-6 hover:shadow-lg transition-all group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Approved</p>
                <p class="text-4xl font-black text-slate-900">{{ $approvedCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.withdraws.rejected') }}" class="bg-white border border-slate-100 rounded-xl p-6 hover:shadow-lg transition-all group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-2">Rejected</p>
                <p class="text-4xl font-black text-slate-900">{{ $rejectedCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center group-hover:bg-rose-100 transition-colors">
                <i data-lucide="x-circle" class="w-6 h-6 text-rose-600"></i>
            </div>
        </div>
    </a>
</div>

<!-- Recently Added Section -->
<div class="mb-6">
    <h2 class="text-lg font-black text-slate-900 uppercase mb-4">Recently Added</h2>
</div>

<!-- Table Container -->
<div id="table-container" class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    @include('admin.withdraws._table', ['withdraws' => $withdraws])
</div>

@include('admin.withdraws._modal')

@push('scripts')
<script>
    $(document).on('click', '.pagination-link', function (e) {
        e.preventDefault();
        let page = $(this).data('page');

        $.ajax({
            url: window.location.href.split('?')[0],
            type: 'GET',
            data: { page: page },
            success: function (data) {
                $('#table-container').html(data);
                lucide.createIcons();
                $('html, body').animate({ scrollTop: 0 }, 'fast');
                history.replaceState(null, '', window.location.href.split('?')[0]);
            }
        });
    });
</script>
@endpush
@endsection
