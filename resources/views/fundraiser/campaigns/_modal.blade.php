<div id="campaignModal" class="fixed inset-0 z-50 hidden overflow-y-auto opacity-0 transition-opacity duration-300">
    <div class="flex min-h-full items-center justify-center p-4">
        <div data-modal-backdrop class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white rounded-3xl shadow-2xl z-50 w-full max-w-2xl relative my-8 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-in-out">

            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 id="modalTitle" class="text-lg font-black text-slate-900 uppercase tracking-tight">Create Campaign</h3>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">Fill in the details below</p>
                </div>
                <button onclick="Modal.close('campaignModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 transition-colors text-xl">&times;</button>
            </div>

            <form id="campaignForm" class="p-8">
                @csrf
                <input type="hidden" id="campaignId" name="campaign_id">
                <input type="hidden" id="formMethod" value="create">

                <div class="space-y-6">

                    {{-- Entity Selection --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Entity <span class="text-red-500">*</span>
                        </label>
                        <select name="entity_id" id="entityId" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select entity</option>
                            @foreach($entities as $entity)
                                <option value="{{ $entity->id }}">{{ $entity->name }}</option>
                            @endforeach
                        </select>
                        @if($entities->isEmpty())
                            <p class="mt-1 text-xs text-amber-600">You need at least one approved entity to create a campaign.</p>
                        @endif
                        <span class="text-xs text-red-600 hidden" id="error-entity_id"></span>
                    </div>

                    {{-- Campaign Category --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="categoryId" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-xs text-red-600 hidden" id="error-category_id"></span>
                    </div>

                    {{-- Campaign Title --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Campaign Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="campaignTitle" required
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                               placeholder="Enter campaign title">
                        <span class="text-xs text-red-600 hidden" id="error-title"></span>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="campaignDescription" required rows="4"
                                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                  placeholder="Describe your campaign..."></textarea>
                        <span class="text-xs text-red-600 hidden" id="error-description"></span>
                    </div>

                    {{-- Goal Amount --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Goal Amount (IDR) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="goal_amount" id="goalAmount" required min="1" step="0.01"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                               placeholder="1000000">
                        <span class="text-xs text-red-600 hidden" id="error-goal_amount"></span>
                    </div>

                    {{-- Start Date --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="start_at" id="startAt" required
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <span class="text-xs text-red-600 hidden" id="error-start_at"></span>
                    </div>

                    {{-- End Date --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="end_at" id="endAt" required
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <span class="text-xs text-red-600 hidden" id="error-end_at"></span>
                    </div>

                    {{-- Is Urgent Checkbox --}}
                    <div class="flex items-center">
                        <input type="checkbox" name="is_urgent" id="isUrgent" value="1"
                               class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500">
                        <label for="isUrgent" class="ml-2 text-sm font-medium text-slate-700">
                            Mark as urgent campaign
                        </label>
                    </div>

                    {{-- Campaign Image Upload --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">
                            Campaign Image <span class="text-red-500">*</span>
                        </label>

                        {{-- Current Image Preview (shown in edit mode) --}}
                        <div id="currentImagePreview" class="hidden mb-3">
                            <p class="text-xs text-slate-500 mb-2">Current Image:</p>
                            <img id="currentImageDisplay" src="" alt="Current Campaign Image" class="w-full h-48 object-cover rounded-lg border border-slate-200">
                            <p class="text-xs text-slate-500 mt-2">Upload a new image to replace the current one</p>
                        </div>

                        <input type="file" name="image" id="campaignImage" accept="image/jpeg,image/png,image/jpg"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <p class="mt-1 text-xs text-slate-500">Max 2MB. Formats: JPG, PNG</p>
                        <span class="text-xs text-red-600 hidden" id="error-image"></span>
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="Modal.close('campaignModal')"
                            class="flex-1 px-6 py-3 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                            class="flex-1 px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <span id="submitBtnText">Create Campaign</span>
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
        if (modalId === 'campaignModal') {
            resetForm();

            if (options.mode === 'edit' && options.campaign) {
                populateForm(options.campaign);
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
        $('#campaignForm')[0].reset();
        $('#campaignId').val('');
        $('#formMethod').val('create');
        $('#modalTitle').text('Create Campaign');
        $('#submitBtnText').text('Create Campaign');
        $('.text-red-600').addClass('hidden').text('');
        $('#currentImagePreview').addClass('hidden');
        $('#campaignImage').prop('required', true);
    }

    function populateForm(campaign) {
        $('#campaignId').val(campaign.id);
        $('#formMethod').val('edit');
        $('#modalTitle').text('Edit Campaign');
        $('#submitBtnText').text('Update Campaign');

        $('#entityId').val(campaign.entity_id);
        $('#categoryId').val(campaign.category_id);
        $('#campaignTitle').val(campaign.title);
        $('#campaignDescription').val(campaign.description);
        $('#goalAmount').val(campaign.goal_amount);

        // Format dates for datetime-local input
        if (campaign.start_at) {
            const startDate = new Date(campaign.start_at);
            $('#startAt').val(startDate.toISOString().slice(0, 16));
        }
        if (campaign.end_at) {
            const endDate = new Date(campaign.end_at);
            $('#endAt').val(endDate.toISOString().slice(0, 16));
        }

        $('#isUrgent').prop('checked', campaign.is_urgent);

        // Show current image if exists
        if (campaign.primary_image && campaign.primary_image.image_path) {
            $('#currentImageDisplay').attr('src', '/storage/' + campaign.primary_image.image_path);
            $('#currentImagePreview').removeClass('hidden');
            $('#campaignImage').prop('required', false);
        }
    }

    // Form submission
    $('#campaignForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const method = $('#formMethod').val();
        const campaignId = $('#campaignId').val();

        let url = method === 'edit'
            ? `/fundraiser/campaigns/${campaignId}/update`
            : '/fundraiser/campaigns/store';

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
                    Modal.close('campaignModal');
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
        Modal.close('campaignModal');
    });

    // ESC key handler
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$('#campaignModal').hasClass('hidden')) {
            Modal.close('campaignModal');
        }
    });
</script>
@endpush
