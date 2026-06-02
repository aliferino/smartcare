@extends('layouts.panel', ['title' => 'KYC Verification'])

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">KYC Verification</h1>
    <p class="mt-2 text-sm text-slate-500">Complete your identity verification to activate your account</p>
</div>

{{-- Alert Messages --}}
@if(session('success'))
    <div class="p-4 mb-6 border-l-4 border-green-500 rounded-lg bg-green-50">
        <div class="flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-green-600"></i>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="p-4 mb-6 border-l-4 border-red-500 rounded-lg bg-red-50">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-red-600"></i>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
@endif

{{-- Status Card --}}
@if($citizen)
    <div class="p-6 mb-6 bg-white border rounded-xl border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Verification Status</h3>
                <p class="mt-1 text-sm text-slate-500">Your KYC submission status</p>
            </div>
            <div class="px-4 py-2 rounded-lg
                {{ $citizen->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                {{ $citizen->status === 'approved' ? 'bg-green-50 text-green-700 border border-green-200' : '' }}
                {{ $citizen->status === 'rejected' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                <span class="text-sm font-bold uppercase tracking-wider">{{ $citizen->status }}</span>
            </div>
        </div>

        @if($citizen->status === 'rejected' && $citizen->reject_reason)
            <div class="p-4 mt-4 border-l-4 border-red-500 rounded-lg bg-red-50">
                <p class="text-sm font-medium text-red-800">Rejection Reason:</p>
                <p class="mt-1 text-sm text-red-700">{{ $citizen->reject_reason }}</p>
            </div>
        @endif
    </div>
@endif

{{-- Pending Status Card (with icon) --}}
@if($citizen && $citizen->status === 'pending')
<div class="p-8 mb-6 bg-white border rounded-xl border-slate-200">
    <div class="flex items-start gap-4 mb-6">
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 flex-shrink-0">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-slate-900">Verification In Progress</h2>
            <p class="mt-2 text-slate-600">Your KYC data has been submitted successfully and is currently being reviewed by our admin team.</p>
        </div>
    </div>

    <div class="p-4 border-l-4 rounded-lg bg-amber-50 border-amber-500">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
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
@endif

{{-- KYC Form --}}
<div class="p-8 bg-white border rounded-xl border-slate-200">
    <form action="{{ $citizen ? route('fundraiser.citizen.update') : route('fundraiser.citizen.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if($citizen)
            @method('PUT')
        @endif

        {{-- Personal Information Section --}}
        <div>
            <h3 class="mb-4 text-lg font-semibold text-slate-900">Personal Information</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Full Name --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Full Name <span class="text-red-500">*</span></label>
                    <input type="text"
                           name="full_name"
                           value="{{ old('full_name', $citizen->full_name ?? '') }}"
                           class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                           placeholder="Enter your full name"
                           required>
                    @error('full_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ID Number --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">ID Number (KTP) <span class="text-red-500">*</span></label>
                    <input type="text"
                           name="id_number"
                           value="{{ old('id_number', $citizen->id_number ?? '') }}"
                           class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                           placeholder="Enter your ID number (numbers only)"
                           maxlength="20"
                           pattern="[0-9]*"
                           inputmode="numeric"
                           required>
                    @error('id_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Birth Date --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Birth Date <span class="text-red-500">*</span></label>
                    <input type="date"
                           name="birth_date"
                           value="{{ old('birth_date', $citizen?->birth_date?->format('Y-m-d') ?? '') }}"
                           class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                           required>
                    @error('birth_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Gender <span class="text-red-500">*</span></label>
                    <select name="gender"
                            class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                            required>
                        <option value="">Select gender</option>
                        <option value="male" {{ old('gender', $citizen->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $citizen->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone Number --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text"
                           name="phone_number"
                           value="{{ old('phone_number', $citizen->phone_number ?? '') }}"
                           class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                           placeholder="e.g., 08123456789"
                           maxlength="15"
                           pattern="[0-9]*"
                           inputmode="numeric"
                           required>
                    @error('phone_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-700">Address <span class="text-red-500">*</span></label>
                    <textarea name="address"
                              rows="3"
                              class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                              placeholder="Enter your complete address"
                              required>{{ old('address', $citizen->address ?? '') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Document Upload Section --}}
        <div class="pt-6 border-t border-slate-200">
            <h3 class="mb-4 text-lg font-semibold text-slate-900">Document Upload</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- ID Card --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        ID Card (KTP) Photo <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="id_card_path"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                           {{ $citizen ? '' : 'required' }}>
                    <p class="mt-1 text-xs text-slate-500">Max 5MB. Formats: JPG, PNG</p>
                    @if($citizen && $citizen->id_card_path)
                        <p class="mt-2 text-xs text-slate-500">Current file uploaded</p>
                    @endif
                    @error('id_card_path')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Selfie --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Selfie with ID Card <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="selfie_path"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                           {{ $citizen ? '' : 'required' }}>
                    <p class="mt-1 text-xs text-slate-500">Max 5MB. Formats: JPG, PNG</p>
                    @if($citizen && $citizen->selfie_path)
                        <p class="mt-2 text-xs text-slate-500">Current file uploaded</p>
                    @endif
                    @error('selfie_path')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Profile Picture --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Profile Picture (Optional)
                    </label>
                    <input type="file"
                           name="profile_picture"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 transition-colors border rounded-lg border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                    <p class="mt-1 text-xs text-slate-500">Max 5MB. Formats: JPG, PNG</p>
                    @if($citizen && $citizen->profile_picture)
                        <p class="mt-2 text-xs text-slate-500">Current file uploaded</p>
                    @endif
                    @error('profile_picture')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end pt-6 border-t border-slate-200">
            <button type="submit"
                    class="px-6 py-2.5 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                {{ $citizen ? 'Update KYC Data' : 'Submit KYC Data' }}
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    // Enforce numeric-only input for ID Number and Phone Number
    document.addEventListener('DOMContentLoaded', function() {
        const idNumberInput = document.querySelector('input[name="id_number"]');
        const phoneNumberInput = document.querySelector('input[name="phone_number"]');

        // Function to allow only numbers
        function enforceNumericInput(event) {
            const input = event.target;
            const value = input.value;

            // Remove any non-numeric characters
            const numericValue = value.replace(/[^0-9]/g, '');

            // Update input value if it changed
            if (value !== numericValue) {
                input.value = numericValue;
            }
        }

        // Add event listeners
        if (idNumberInput) {
            idNumberInput.addEventListener('input', enforceNumericInput);
            idNumberInput.addEventListener('keypress', function(event) {
                // Prevent non-numeric key presses
                if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete' && event.key !== 'Tab' && event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
                    event.preventDefault();
                }
            });
        }

        if (phoneNumberInput) {
            phoneNumberInput.addEventListener('input', enforceNumericInput);
            phoneNumberInput.addEventListener('keypress', function(event) {
                // Prevent non-numeric key presses
                if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete' && event.key !== 'Tab' && event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
                    event.preventDefault();
                }
            });
        }
    });
</script>
@endpush
