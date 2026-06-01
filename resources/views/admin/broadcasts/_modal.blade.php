<div id="broadcastModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-slate-100">
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Create Broadcast</h3>
            <button onclick="closeBroadcastModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
            <form method="POST" action="{{ route('admin.broadcasts.store') }}" id="broadcastForm">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-600 outline-none transition-all @error('title') border-red-500 @enderror"
                        placeholder="Enter broadcast title">
                    @error('title')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Message</label>
                    <textarea name="message" rows="10" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-600 outline-none transition-all @error('message') border-red-500 @enderror"
                        placeholder="Enter your message...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-colors">
                        Send Broadcast
                    </button>
                    <button type="button" onclick="closeBroadcastModal()" class="px-8 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-bold transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openBroadcastModal() {
    document.getElementById('broadcastModal').classList.remove('hidden');
    lucide.createIcons();
}

function closeBroadcastModal() {
    document.getElementById('broadcastModal').classList.add('hidden');
}
</script>
