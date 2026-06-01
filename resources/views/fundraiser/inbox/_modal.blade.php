<div id="broadcastModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-slate-100">
            <h3 id="broadcastTitle" class="text-xl font-black text-slate-900 uppercase tracking-tight"></h3>
            <button onclick="closeBroadcastModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
            <!-- Meta Info -->
            <div class="flex items-center gap-6 pb-6 mb-6 border-b border-slate-100">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span class="font-bold">From:</span>
                    <span id="broadcastSender"></span>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    <span class="font-bold">Sent:</span>
                    <span id="broadcastDate"></span>
                </div>
            </div>

            <!-- Message Body -->
            <div class="prose max-w-none">
                <p id="broadcastMessage" class="text-slate-700 whitespace-pre-wrap leading-relaxed"></p>
            </div>
        </div>
    </div>
</div>

<script>
const broadcastsData = @json($broadcasts->items());

function openBroadcastModal(broadcastId) {
    const broadcast = broadcastsData.find(b => b.id === broadcastId);
    if (!broadcast) return;

    document.getElementById('broadcastTitle').textContent = broadcast.title;
    document.getElementById('broadcastSender').textContent = broadcast.user.name;
    document.getElementById('broadcastDate').textContent = new Date(broadcast.sent_at).toLocaleString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    document.getElementById('broadcastMessage').textContent = broadcast.message;

    document.getElementById('broadcastModal').classList.remove('hidden');
    lucide.createIcons();
}

function closeBroadcastModal() {
    document.getElementById('broadcastModal').classList.add('hidden');
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBroadcastModal();
    }
});
</script>
