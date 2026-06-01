@extends('layouts.panel', ['title' => 'KYC Verification - Pending'])

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">KYC Verification</h1>
    <p class="mt-2 text-sm text-slate-500">Your identity verification is being reviewed</p>
</div>

{{-- Status Card --}}
<div class="p-8 mb-6 bg-white border rounded-xl border-slate-200">
    <div class="flex items-start gap-4 mb-6">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-amber-100">
            <i data-lucide="clock" class="w-8 h-8 text-amber-600"></i>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-slate-900">Verification In Progress</h2>
            <p class="mt-2 text-slate-600">Your KYC data has been submitted successfully and is currently being reviewed by our admin team.</p>
        </div>
    </div>

    <div class="p-4 border-l-4 rounded-lg bg-amber-50 border-amber-500">
        <div class="flex items-center gap-2 mb-2">
            <i data-lucide="info" class="w-5 h-5 text-amber-600"></i>
            <h3 class="font-semibold text-amber-900">What happens next?</h3>
        </div>
        <ul class="ml-7 space-y-1 text-sm text-amber-800">
            <li>• Our team will review your submitted documents</li>
            <li>• Verification typically takes 1-3 business days</li>
            <li>• You'll receive a notification once your account is verified</li>
            <li>• If any issues are found, we'll notify you with details</li>
        </ul>
    </div>
</div>

{{-- Submitted Data Card --}}
<div class="p-8 bg-white border rounded-xl border-slate-200">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-slate-900">Submitted Information</h3>
        <span class="px-4 py-2 text-sm font-bold tracking-wider uppercase rounded-lg bg-amber-50 text-amber-700 border border-amber-200">
            Pending Review
        </span>
    </div>

    {{-- Personal Information --}}
    <div class="mb-8">
        <h4 class="mb-4 text-lg font-semibold text-slate-900">Personal Information</h4>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <div>
                <label class="block mb-1 text-xs font-medium text-slate-500 uppercase tracking-wider">Full Name</label>
                <p class="text-base font-medium text-slate-900">{{ $citizen->full_name }}</p>
            </div>

            <div>
                <label class="block mb-1 text-xs font-medium text-slate-500 uppercase tracking-wider">ID Number (KTP)</label>
                <p class="text-base font-medium text-slate-900">{{ $citizen->id_number }}</p>
            </div>

            @if($citizen->birth_date)
            <div>
                <label class="block mb-1 text-xs font-medium text-slate-500 uppercase tracking-wider">Birth Date</label>
                <p class="text-base font-medium text-slate-900">{{ $citizen->birth_date->format('d F Y') }}</p>
            </div>
            @endif

            <div>
                <label class="block mb-1 text-xs font-medium text-slate-500 uppercase tracking-wider">Gender</label>
                <p class="text-base font-medium text-slate-900">{{ ucfirst($citizen->gender) }}</p>
            </div>

            <div>
                <label class="block mb-1 text-xs font-medium text-slate-500 uppercase tracking-wider">Phone Number</label>
                <p class="text-base font-medium text-slate-900">{{ $citizen->phone_number }}</p>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1 text-xs font-medium text-slate-500 uppercase tracking-wider">Address</label>
                <p class="text-base font-medium text-slate-900">{{ $citizen->address }}</p>
            </div>

        </div>
    </div>

    {{-- Uploaded Documents --}}
    <div class="pt-6 border-t border-slate-200">
        <h4 class="mb-4 text-lg font-semibold text-slate-900">Uploaded Documents</h4>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            {{-- ID Card --}}
            <div>
                <label class="block mb-2 text-xs font-medium text-slate-500 uppercase tracking-wider">ID Card (KTP)</label>
                <div class="relative overflow-hidden border-2 border-dashed rounded-lg aspect-video border-slate-200 bg-slate-50">
                    @if($citizen->id_card_path)
                        <img src="{{ asset('storage/' . $citizen->id_card_path) }}"
                             alt="ID Card"
                             class="object-cover w-full h-full cursor-pointer hover:opacity-90 transition-opacity"
                             onclick="viewImage('{{ asset('storage/' . $citizen->id_card_path) }}', 'ID Card')">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <p class="text-xs text-slate-400">No file uploaded</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Selfie --}}
            <div>
                <label class="block mb-2 text-xs font-medium text-slate-500 uppercase tracking-wider">Selfie with ID Card</label>
                <div class="relative overflow-hidden border-2 border-dashed rounded-lg aspect-video border-slate-200 bg-slate-50">
                    @if($citizen->selfie_path)
                        <img src="{{ asset('storage/' . $citizen->selfie_path) }}"
                             alt="Selfie"
                             class="object-cover w-full h-full cursor-pointer hover:opacity-90 transition-opacity"
                             onclick="viewImage('{{ asset('storage/' . $citizen->selfie_path) }}', 'Selfie with ID Card')">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <p class="text-xs text-slate-400">No file uploaded</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Profile Picture --}}
            <div>
                <label class="block mb-2 text-xs font-medium text-slate-500 uppercase tracking-wider">Profile Picture</label>
                <div class="relative overflow-hidden border-2 border-dashed rounded-lg aspect-video border-slate-200 bg-slate-50">
                    @if($citizen->profile_picture)
                        <img src="{{ asset('storage/' . $citizen->profile_picture) }}"
                             alt="Profile Picture"
                             class="object-cover w-full h-full cursor-pointer hover:opacity-90 transition-opacity"
                             onclick="viewImage('{{ asset('storage/' . $citizen->profile_picture) }}', 'Profile Picture')">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <p class="text-xs text-slate-400">No file uploaded</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Submission Info --}}
    <div class="pt-6 mt-6 border-t border-slate-200">
        <div class="flex items-center justify-between text-sm text-slate-500">
            <div>
                <span class="font-medium">Submitted on:</span>
                <span class="ml-2">{{ $citizen->created_at->format('d F Y, H:i') }}</span>
            </div>
            @if($citizen->updated_at != $citizen->created_at)
                <div>
                    <span class="font-medium">Last updated:</span>
                    <span class="ml-2">{{ $citizen->updated_at->format('d F Y, H:i') }}</span>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Image Preview Modal --}}
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-slate-900/95 backdrop-blur-md">
    <button onclick="closeImageModal()" class="absolute text-4xl text-white transition-transform top-6 right-6 hover:scale-110">
        &times;
    </button>
    <div class="flex items-center justify-center w-full h-full p-10">
        <div class="max-w-4xl">
            <h3 id="imageTitle" class="mb-4 text-xl font-bold text-center text-white"></h3>
            <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-[80vh] rounded-lg shadow-2xl">
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function viewImage(src, title) {
        document.getElementById('previewImage').src = src;
        document.getElementById('imageTitle').textContent = title;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endpush
