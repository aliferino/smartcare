<div id="userModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-10">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeUserModal()"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl overflow-hidden border border-slate-100 transition-all">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div id="detUserAvatar" class="w-12 h-12 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-xs font-black text-blue-600 uppercase"></div>
                    <div>
                        <h3 id="modalTitle" class="text-lg font-black text-slate-900 uppercase tracking-tight leading-none">User Details</h3>
                        <p id="detUserRole" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"></p>
                    </div>
                </div>
                <button onclick="closeUserModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl font-bold">&times;</button>
            </div>

            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="PUT">

                <div class="px-8 py-8 space-y-6">
                    <!-- Detail View -->
                    <div id="detailView">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Full Name</label>
                                <p id="detUserName" class="text-xs font-bold text-slate-900"></p>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Email Address</label>
                                <p id="detUserEmail" class="text-xs font-bold text-slate-900 lowercase"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Role</label>
                                <p id="detUserRoleText" class="text-xs font-bold text-slate-900 uppercase"></p>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1.5">Account Status</label>
                                <div id="detStatusBadge"></div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100 mt-6">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-[8px] font-black text-slate-300 uppercase italic">Created:</span>
                                    <span id="detCreatedAt" class="text-[10px] font-bold text-slate-500 font-mono"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-[8px] font-black text-slate-300 uppercase italic">Updated:</span>
                                    <span id="detUpdatedAt" class="text-[10px] font-bold text-slate-500 font-mono"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit View -->
                    <div id="editView" class="hidden">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Full Name</label>
                            <input type="text" name="name" id="editName" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>

                        <div class="mt-4">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Email Address</label>
                            <input type="email" name="email" id="editEmail" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>

                        <div class="mt-4">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Role</label>
                            <select name="role" id="editRole" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                <option value="fundraiser">Fundraiser</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">New Password (Optional)</label>
                            <input type="password" name="password" id="editPassword" placeholder="Leave blank to keep current password" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <p class="text-[10px] text-slate-400 mt-1 italic">Minimum 8 characters</p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
                    <div id="detailActions" class="flex gap-3">
                        <button type="button" onclick="switchToEditMode()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-wider transition-colors shadow-lg shadow-blue-200">
                            Edit User
                        </button>
                    </div>

                    <div id="editActions" class="hidden flex gap-3">
                        <button type="button" onclick="switchToDetailMode()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-3.5 rounded-xl text-xs font-black uppercase tracking-wider transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-wider transition-colors shadow-lg shadow-blue-200">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentUserId = null;
    let currentUserData = null;

    $(document).ready(function() {
        $.modalUtils.setupDetailButton('.btn-detail', function(id) {
            openUserDetail(id);
        });

        $(document).on('click', '.btn-edit', function() {
            const userId = $(this).data('id');
            openUserEdit(userId);
        });

        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: `/admin/users/${currentUserId}/update`,
                method: 'POST',
                data: formData,
                success: function(response) {
                    closeUserModal();
                    location.reload();
                },
                error: function(xhr) {
                    if(xhr.responseJSON && xhr.responseJSON.errors) {
                        let errorMsg = '';
                        Object.values(xhr.responseJSON.errors).forEach(err => {
                            errorMsg += err[0] + '\n';
                        });
                        alert(errorMsg);
                    } else {
                        alert('Failed to update user.');
                    }
                }
            });
        });
    });

    function openUserDetail(id) {
        currentUserId = id;
        $.get(`/admin/users/list/${id}/detail`, function(data) {
            currentUserData = data;
            populateUserData(data);
            switchToDetailMode();
            $('#userModal').openModal();
        });
    }

    function openUserEdit(id) {
        currentUserId = id;
        $.get(`/admin/users/list/${id}/detail`, function(data) {
            currentUserData = data;
            populateUserData(data);
            switchToEditMode();
            $('#userModal').openModal();
        });
    }

    function populateUserData(data) {
        $('#detUserName').text(data.name);
        $('#detUserEmail').text(data.email);
        $('#detUserRoleText').text(data.role || 'User');
        $('#detUserRole').text(data.role || 'User');
        $('#detUserAvatar').text(data.name ? data.name.charAt(0).toUpperCase() : '?');

        $('#editName').val(data.name);
        $('#editEmail').val(data.email);
        $('#editRole').val(data.role);
        $('#editPassword').val('');

        let statusBadge = '';
        if(data.status === 'active') {
            statusBadge = '<span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Active</span>';
        } else if(data.status === 'inactive') {
            statusBadge = '<span class="px-2 py-1 rounded bg-slate-50 text-slate-600 text-[10px] font-black uppercase tracking-tighter">Inactive</span>';
        } else if(data.status === 'suspended') {
            statusBadge = '<span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Suspended</span>';
        } else {
            statusBadge = '<span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Banned</span>';
        }
        $('#detStatusBadge').html(statusBadge);

        $('#detCreatedAt').text($.modalUtils.formatDate(data.created_at));
        $('#detUpdatedAt').text($.modalUtils.formatDate(data.updated_at));
    }

    function switchToDetailMode() {
        $('#modalTitle').text('User Details');
        $('#detailView').removeClass('hidden');
        $('#editView').addClass('hidden');
        $('#detailActions').removeClass('hidden');
        $('#editActions').addClass('hidden');
    }

    function switchToEditMode() {
        $('#modalTitle').text('Edit User');
        $('#detailView').addClass('hidden');
        $('#editView').removeClass('hidden');
        $('#detailActions').addClass('hidden');
        $('#editActions').removeClass('hidden');
    }

    function closeUserModal() {
        $('#userModal').closeModal();
        currentUserId = null;
        currentUserData = null;
        $('#userForm')[0].reset();
    }
</script>
