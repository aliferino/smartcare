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
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Full Name</label>
                        <input type="text" name="name" id="editName" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Email Address</label>
                        <input type="email" name="email" id="editEmail" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Role</label>
                            <select name="role" id="editRole" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                <option value="fundraiser">Fundraiser</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div id="statusField">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Status</label>
                            <select name="status" id="editStatus" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label id="passwordLabel" class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Password</label>
                        <input type="password" name="password" id="editPassword" placeholder="Enter password" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <p class="text-[10px] text-slate-400 mt-1 italic">Minimum 8 characters</p>
                    </div>

                    <div id="confirmPasswordField" style="display: none;">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Re-enter password" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>

                    <div id="userDatesInfo" class="hidden pt-6 border-t border-slate-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Joined Date</label>
                                <p id="userCreatedAt" class="text-xs font-bold text-slate-700"></p>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Last Updated</label>
                                <p id="userUpdatedAt" class="text-xs font-bold text-slate-700"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
                    <div class="flex gap-3">
                        <button type="button" onclick="closeUserModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-3.5 rounded-xl text-xs font-black uppercase tracking-wider transition-colors">
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

    function formatDate(dateString) {
        return new Date(dateString).toLocaleString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    $(document).ready(function() {
        // Detail button - show citizen info
        $(document).on('click', '.btn-detail', function(e) {
            e.stopImmediatePropagation();
            const userId = $(this).data('id');

            $.get(`/admin/users/list/${userId}/detail`, function(data) {
                if(data.citizen && data.citizen.id) {
                    // User has citizen - open citizen modal with data
                    if(typeof openCitizenModal === 'function') {
                        openCitizenModal(data.citizen.id);
                    } else {
                        alert('Citizen information available. Please ensure citizen modal is loaded.');
                    }
                } else {
                    // User has no citizen
                    alert('This user has not submitted KYC information yet.');
                }
            }).fail(function() {
                alert('Failed to load user information.');
            });
        });

        // Edit button - open user edit modal
        $(document).on('click', '.btn-edit', function() {
            const userId = $(this).data('id');
            openUserEdit(userId);
        });

        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const isCreate = currentUserId === null;
            const url = isCreate ? '/admin/users/create' : `/admin/users/${currentUserId}/update`;

            $.ajax({
                url: url,
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
                        alert(isCreate ? 'Failed to create user.' : 'Failed to update user.');
                    }
                }
            });
        });
    });

    function openUserEdit(id) {
        currentUserId = id;
        $.get(`/admin/users/list/${id}/detail`, function(data) {
            currentUserData = data;
            $('#modalTitle').text('Edit User');
            $('#detUserRole').text(data.role || 'User');
            $('#detUserAvatar').text(data.name ? data.name.charAt(0).toUpperCase() : '?');

            $('#editName').val(data.name);
            $('#editEmail').val(data.email);
            $('#editRole').val(data.role);
            $('#editStatus').val(data.status);
            $('#statusField').show();
            $('#editPassword').val('').attr('placeholder', 'Leave blank to keep current password').removeAttr('required');
            $('#confirmPassword').val('');
            $('#confirmPasswordField').hide();
            $('#passwordLabel').text('New Password (Optional)');
            $('#formMethod').val('PUT');

            // Show and populate date info
            $('#userDatesInfo').removeClass('hidden');
            $('#userCreatedAt').text(formatDate(data.created_at));
            $('#userUpdatedAt').text(formatDate(data.updated_at));

            $('#userModal').removeClass('hidden');
            $('body').css('overflow', 'hidden');
        }).fail(function() {
            alert('Failed to load user data.');
        });
    }

    function closeUserModal() {
        $('#userModal').addClass('hidden');
        $('body').css('overflow', '');
        currentUserId = null;
        currentUserData = null;
        $('#userForm')[0].reset();
    }

    function openCreateUserModal() {
        currentUserId = null;
        $('#modalTitle').text('Create New User');
        $('#detUserRole').text('New User');
        $('#detUserAvatar').text('?');
        $('#formMethod').val('');
        $('#userForm')[0].reset();
        $('#statusField').hide();
        $('#userDatesInfo').addClass('hidden');
        $('#editPassword').attr('placeholder', 'Enter password').attr('required', 'required');
        $('#confirmPassword').attr('required', 'required');
        $('#confirmPasswordField').show();
        $('#passwordLabel').text('Password');
        $('#userModal').removeClass('hidden');
        $('body').css('overflow', 'hidden');
    }
</script>
