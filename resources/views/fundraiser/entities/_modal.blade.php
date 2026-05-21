<div id="entityModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">

            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black text-slate-900 uppercase tracking-tight">Create Entity</h3>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">Fill in the details below</p>
                </div>
                <button onclick="Modal.close('entityModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>

            <form id="entityForm" class="p-8" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="entityId" name="entity_id">
                <input type="hidden" id="formMethod" value="create">

                <div class="space-y-6">

                    {{-- Entity Category --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="entity_category_id" id="entityCategoryId" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-xs text-red-600 hidden" id="error-entity_category_id"></span>
                    </div>

                    {{-- Entity Name --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Entity Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="entityName" required
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                               placeholder="Enter entity name">
                        <span class="text-xs text-red-600 hidden" id="error-name"></span>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="entityEmail" required
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                               placeholder="entity@example.com">
                        <span class="text-xs text-red-600 hidden" id="error-email"></span>
                    </div>

                    {{-- Address --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Address <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" id="entityAddress" required rows="3"
                                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                  placeholder="Enter complete address"></textarea>
                        <span class="text-xs text-red-600 hidden" id="error-address"></span>
                    </div>

                    {{-- Logo Upload --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Logo (Optional)
                        </label>
                        <input type="file" name="logo_path" id="entityLogo" accept="image/jpeg,image/png,image/jpg"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <p class="mt-1 text-xs text-slate-500">Max 2MB. Formats: JPG, PNG</p>
                        <span class="text-xs text-red-600 hidden" id="error-logo_path"></span>
                    </div>

                    {{-- Legal Document Upload --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Legal Document (Optional)
                        </label>
                        <input type="file" name="legal_document_path" id="entityDocument" accept="application/pdf"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <p class="mt-1 text-xs text-slate-500">Max 5MB. Format: PDF</p>
                        <span class="text-xs text-red-600 hidden" id="error-legal_document_path"></span>
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="Modal.close('entityModal')"
                            class="flex-1 px-6 py-3 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                            class="flex-1 px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <span id="submitBtnText">Create Entity</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Setup CSRF token
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Modal open handler
    window.Modal = window.Modal || {};
    const originalOpen = window.Modal.open;
    window.Modal.open = function(modalId, options = {}) {
        if (modalId === 'entityModal') {
            resetForm();

            if (options.mode === 'edit' && options.entity) {
                populateForm(options.entity);
            }
        }

        if (originalOpen) {
            originalOpen(modalId, options);
        } else {
            // Fallback modal open
            $('#' + modalId).removeClass('hidden');
            $('body').css('overflow', 'hidden');
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    $('#' + modalId).removeClass('opacity-0');
                    $('#' + modalId + ' .transform').removeClass('opacity-0 scale-95').addClass('scale-100 opacity-100');
                });
            });
        }
    };

    // Modal close handler
    const originalClose = window.Modal.close;
    window.Modal.close = function(modalId) {
        if (originalClose) {
            originalClose(modalId);
        } else {
            // Fallback modal close
            $('#' + modalId).addClass('opacity-0');
            $('#' + modalId + ' .transform').removeClass('scale-100 opacity-100').addClass('opacity-0 scale-95');
            setTimeout(() => {
                $('#' + modalId).addClass('hidden');
                $('body').css('overflow', '');
            }, 300);
        }
    };

    function resetForm() {
        $('#entityForm')[0].reset();
        $('#entityId').val('');
        $('#formMethod').val('create');
        $('#modalTitle').text('Create Entity');
        $('#submitBtnText').text('Create Entity');
        $('.text-red-600').addClass('hidden').text('');
    }

    function populateForm(entity) {
        $('#entityId').val(entity.id);
        $('#formMethod').val('edit');
        $('#modalTitle').text('Edit Entity');
        $('#submitBtnText').text('Update Entity');

        $('#entityCategoryId').val(entity.entity_category_id);
        $('#entityName').val(entity.name);
        $('#entityEmail').val(entity.email);
        $('#entityAddress').val(entity.address);
    }

    // Form submission
    $('#entityForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const method = $('#formMethod').val();
        const entityId = $('#entityId').val();

        let url = method === 'edit'
            ? `/fundraiser/entities/${entityId}/update`
            : '/fundraiser/entities/store';

        if (method === 'edit') {
            formData.append('_method', 'PUT');
        }

        // Clear previous errors
        $('.text-red-600').addClass('hidden').text('');

        // Disable submit button
        $('#submitBtn').prop('disabled', true).addClass('opacity-50');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Modal.close('entityModal');
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`#error-${field}`).removeClass('hidden').text(errors[field][0]);
                    }
                } else {
                    alert(xhr.responseJSON?.message || 'An error occurred');
                }
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false).removeClass('opacity-50');
            }
        });
    });

    // Backdrop click handler
    $(document).on('click', '[data-modal-backdrop]', function() {
        Modal.close('entityModal');
    });

    // ESC key handler
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$('#entityModal').hasClass('hidden')) {
            Modal.close('entityModal');
        }
    });
</script>
@endpush
