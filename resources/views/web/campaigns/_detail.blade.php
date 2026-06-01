<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Campaign Details -->
            <div class="lg:col-span-2">
                <!-- Campaign Image -->
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $campaign->image_path) }}"
                         alt="{{ $campaign->title }}"
                         class="w-full h-96 object-cover">
                </div>

                <!-- Campaign Title -->
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $campaign->title }}</h1>

                <!-- Campaign Meta Info -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-600">Kategori:</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            {{ $campaign->campaignCategory->name ?? 'N/A' }}
                        </span>
                    </div>
                    @if($campaign->is_urgent)
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-bold">
                            🔴 URGENT
                        </span>
                    @endif
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-700">Progress Penggalangan Dana</span>
                        <span class="text-sm font-bold text-blue-600">{{ $campaign->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="h-3 rounded-full transition-all duration-300 {{ $campaign->is_urgent ? 'bg-red-600' : 'bg-blue-600' }}"
                             style="width: {{ $campaign->progress_percentage }}%"></div>
                    </div>
                    <div class="flex justify-between items-center mt-3 text-sm text-gray-600">
                        <span>Rp {{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                        <span>Target: Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Campaign Description -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi Kampanye</h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $campaign->description }}
                    </div>
                </div>

                <!-- Recent Donors -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Donasi Terbaru</h2>
                    <div id="donorsList" class="space-y-4">
                        @forelse($campaign->donations()->where('status', 'paid')->latest()->take(5)->get() as $donation)
                            <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $donation->is_anonymous ? 'Someone' : $donation->name }}
                                        </p>
                                        @if($donation->message)
                                            <p class="text-sm text-gray-600 mt-1 italic">
                                                "{{ $donation->message }}"
                                            </p>
                                        @endif
                                    </div>
                                    <p class="font-bold text-blue-600 text-lg">
                                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-50 p-6 rounded-lg text-center text-gray-500">
                                <p>Belum ada donasi. Jadilah yang pertama untuk mendukung kampanye ini!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Donation Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Berikan Donasi</h3>

                    <form id="donationForm" class="space-y-4">
                        @csrf

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama
                            </label>
                            <input type="text"
                                   id="donorName"
                                   name="name"
                                   placeholder="Masukkan nama Anda"
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-sm">
                            <label class="flex items-center mt-2 cursor-pointer">
                                <input type="checkbox"
                                       id="isAnonymous"
                                       name="is_anonymous"
                                       class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Donasi secara anonim</span>
                            </label>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   id="donorEmail"
                                   name="email"
                                   placeholder="email@example.com"
                                   required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-sm">
                            <span class="text-red-500 text-sm hidden" id="emailError"></span>
                        </div>

                        <!-- No Telp -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                No. Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel"
                                   id="donorPhone"
                                   name="phone_number"
                                   placeholder="08xxxxxxxxxx"
                                   required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-sm">
                            <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                        </div>

                        <!-- Nominal Donasi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nominal Donasi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-600 font-semibold pointer-events-none">Rp</span>
                                <input type="number"
                                       id="donationAmount"
                                       name="amount"
                                       placeholder="100000"
                                       min="1000"
                                       required
                                       class="w-full pl-10 pr-4 py-3 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-sm [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                        </div>

                        <!-- Payment Method (Hidden) -->
                        <input type="hidden" name="payment_method" value="qris">

                        <!-- Pesan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Pesan (Opsional)
                            </label>
                            <textarea id="donationMessage"
                                      name="message"
                                      placeholder="Tulis pesan dukungan Anda..."
                                      rows="3"
                                      class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none text-sm"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                id="submitBtn"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-colors duration-200">
                            Donasi Sekarang
                        </button>

                        <!-- Status Message -->
                        <div id="statusMessage" class="hidden p-4 rounded-lg text-center font-semibold"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Disable scroll wheel on number input
document.getElementById('donationAmount').addEventListener('wheel', function(e) {
    e.preventDefault();
});

// Handle anonymous donation checkbox
document.getElementById('isAnonymous').addEventListener('change', function() {
    const donorNameInput = document.getElementById('donorName');
    if (this.checked) {
        donorNameInput.value = 'Someone';
        donorNameInput.readOnly = true;
        donorNameInput.classList.add('bg-gray-100', 'cursor-not-allowed');
    } else {
        donorNameInput.value = '';
        donorNameInput.readOnly = false;
        donorNameInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
    }
});

document.getElementById('donationForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    let name = document.getElementById('donorName').value;
    const email = document.getElementById('donorEmail').value;
    const phone = document.getElementById('donorPhone').value;
    const amount = document.getElementById('donationAmount').value;
    const message = document.getElementById('donationMessage').value;
    const isAnonymous = document.getElementById('isAnonymous').checked;

    // If name is empty and not anonymous, set to "Someone"
    if (!name && !isAnonymous) {
        name = 'Someone';
    }

    if (!email) {
        showError('emailError', 'Email harus diisi');
        return;
    }
    if (!phone) {
        showError('phoneError', 'No. Telepon harus diisi');
        return;
    }
    if (!amount || amount < 1000) {
        alert('Nominal donasi minimal Rp 1.000');
        return;
    }

    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Memproses...';

    try {
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const response = await fetch('{{ route("donation.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                campaign_id: {{ $campaign->id }},
                name: isAnonymous ? null : name,
                email: email,
                phone_number: phone,
                amount: parseInt(amount),
                message: message,
                is_anonymous: isAnonymous,
                payment_method: 'qris'
            })
        });

        const data = await response.json();

        if (response.ok) {
            showStatus('Donasi berhasil! Status: Pending', 'success');
            document.getElementById('donationForm').reset();

            setTimeout(async () => {
                try {
                    const updateResponse = await fetch(`/api/donations/${data.donation_id}/update-status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ status: 'paid' })
                    });

                    if (updateResponse.ok) {
                        showStatus('Status berubah menjadi Paid! ✓', 'success');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        console.error('Update failed:', updateResponse.status);
                    }
                } catch (error) {
                    console.error('Error updating status:', error);
                }
            }, 10000);
        } else {
            showStatus(data.message || 'Terjadi kesalahan', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showStatus('Terjadi kesalahan. Silakan coba lagi.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Donasi Sekarang';
    }
});

function showError(elementId, message) {
    const element = document.getElementById(elementId);
    element.textContent = message;
    element.classList.remove('hidden');
}

function showStatus(message, type) {
    const statusDiv = document.getElementById('statusMessage');
    statusDiv.textContent = message;
    statusDiv.classList.remove('hidden', 'bg-red-100', 'text-red-800', 'bg-green-100', 'text-green-800');

    if (type === 'success') {
        statusDiv.classList.add('bg-green-100', 'text-green-800');
    } else {
        statusDiv.classList.add('bg-red-100', 'text-red-800');
    }
}

document.getElementById('donorEmail').addEventListener('input', function() {
    document.getElementById('emailError').classList.add('hidden');
});

document.getElementById('donorPhone').addEventListener('input', function() {
    document.getElementById('phoneError').classList.add('hidden');
});
</script>
