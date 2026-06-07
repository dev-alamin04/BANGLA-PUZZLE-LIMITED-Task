<script>

    // Escape HTML safely
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return text.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    const sectionConfig = @json($sectionConfig);
    const oldValues = @json(old());
    const existingContent = @json($cms_content->content ?? []);
    const existingItems = @json($cms_content->items ?? []);
    const validationErrors = @json($errors->toArray());


    // Generate Section Fields and Items
    function generateFields(page, section) {
        $('#dynamicFields').empty();
        $('#itemSection').hide();
        $('#dynamicItems').empty();

        if (!page || !section) return;

        const sectionData = sectionConfig[page]?.[section];
        if (!sectionData) return;

        const fields = sectionData.fields || [];
        const items = sectionData.items || [];

        // === Section Fields ===
        let html = '';
        fields.forEach(field => {
            const value = oldValues[field] ?? existingContent[field] ?? '';
            const errMsg = validationErrors[field]?.[0] ?? '';

            if (['description', 'subtitle'].includes(field)) {
                html += `
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">${field.replace('_', ' ').toUpperCase()}</label>
                <textarea name="${field}" class="form-control" rows="3">${escapeHtml(value)}</textarea>
                ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
            </div>`;
            } else if (['background_image', 'image'].includes(field)) {
                const preview = value ? `<img src="${value}" width="100" class="mt-2 rounded border" />` : '';
                html += `
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">${field.replace('_', ' ').toUpperCase()}</label>
                <input type="file" name="${field}" class="form-control">
                ${preview}
                ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
            </div>`;
            }
            else if (['video'].includes(field)) {
                const preview = value ? `<video width="150" height="100" class="mt-2 rounded border d-block" controls><source src="${value}" type="video/mp4">Your browser does not support the video tag.</video>` : '';
                html += `
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">${field.replace('_', ' ').toUpperCase()}</label>
                        <input type="file" name="${field}" class="form-control">
                        ${preview}
                        ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
                    </div>`;

            }     
            else {
                html += `
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">${field.replace('_', ' ').toUpperCase()}</label>
                <input type="text" name="${field}" class="form-control" value="${escapeHtml(value)}">
                ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
            </div>`;
            }
        });

        $('#dynamicFields').html(html);

        // === Items ===
        if (items.length) {
            $('#itemSection').show();
            const rows = existingItems.length ? existingItems : [{}];
            rows.forEach((it, idx) => {
                addItemRow(items, it, idx);
            });
        }
    }

    // Add Single Item Row        

    function addItemRow(fields, itemData = {}, index = null) {
        const i = index ?? $('#dynamicItems .item-row').length;

        let html = `
                        <div class="card mb-3 item-row p-3 border rounded position-relative">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 mt-2 me-2 removeItemBtn">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="row mt-4">
                                ${itemData.id ? `<input type="hidden" name="items[${i}][id]" value="${itemData.id}">` : ''}`;

        fields.forEach(field => {
            const val = itemData[field] ?? '';
            const errKey = `items.${i}.${field}`;
            const errMsg = validationErrors[errKey]?.[0] ?? '';

            if (field === 'description') {
                html += `
                                <div class="col-md-12 mb-2">
                                    <label class="form-label fw-bold">${field.toUpperCase()}</label>
                                    <textarea name="items[${i}][${field}]" class="form-control" rows="2">${escapeHtml(val)}</textarea>
                                    ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
                                </div>`;
            } else if (field === 'image' || field === 'icon') {
                const preview = val ? `<img src="${val}" width="100" height="80" class="mt-2 rounded border d-block object-fit-cover" />` : '';
                html += `
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold">${field.toUpperCase()}</label>
                                    <input type="file" name="items[${i}][${field}]" class="form-control">
                                    ${preview}
                                    ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
                                </div>`;
            } else if (field === 'hover_video') {
                const preview = val ? `<video width="150" height="100" class="mt-2 rounded border d-block" controls><source src="${val}" type="video/mp4">Your browser does not support the video tag.</video>` : '';
                html += `
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold">${field.toUpperCase()}</label>
                                    <input type="file" name="items[${i}][${field}]" class="form-control">
                                    ${preview}
                                    ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
                                </div>`;
            }
            // backgorund_color
            else if (field === 'background_color') {
                html += `
                                <div class="col-1 mb-2">
                                    <label class="form-label fw-bold">${field.toUpperCase()}</label>
                                    <input type="color" name="items[${i}][${field}]"  value="${escapeHtml(val)}">
                                    ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
                                </div>`;
            }

            else {
                html += `
                                <div class="col-md-12 mb-2">
                                    <label class="form-label fw-bold">${field.toUpperCase()}</label>
                                    <input type="text" name="items[${i}][${field}]" class="form-control" value="${escapeHtml(val)}">
                                    ${errMsg ? `<small class="text-danger">${escapeHtml(errMsg)}</small>` : ''}
                                </div>`;
            }
        });

        html += `</div></div>`;
        $('#dynamicItems').append(html);
    }



    // Populate Section Dropdown based on Page
    function populateSections(page, selectedSection = null) {
        $('#section').html('<option value="">-- Select Section --</option>').prop('disabled', true);
        $('#dynamicFields').empty();
        $('#itemSection').hide();
        $('#dynamicItems').empty();

        if (!page) return;

        const sections = Object.keys(sectionConfig[page] || {});
        sections.forEach(sec => {
            const selected = sec === selectedSection ? 'selected' : '';
            $('#section').append(`<option value="${sec}" ${selected}>${sec.replace('_', ' ').toUpperCase()}</option>`);
        });

        if (sections.length) $('#section').prop('disabled', false);
    }

    // Document Ready
    $(document).ready(function () {
        const oldPage = '{{ old('page', $cms_content->page ?? '') }}';
        const oldSection = '{{ old('section', $cms_content->section ?? '') }}';

        // Load old or existing data
        if (oldPage && oldSection) generateFields(oldPage, oldSection);
        else if ('{{ isset($cms_content) }}') {
            const page = '{{ $cms_content->page ?? '' }}';
            const section = '{{ $cms_content->section ?? '' }}';
            if (page && section) {
                populateSections(page, section);
                generateFields(page, section);
            }
        }

        // Page change
        $('#page').on('change', function () {
            const page = $(this).val();
            populateSections(page);
        });

        // Section change
        $('#section').on('change', function () {
            const page = $('#page').val();
            const section = $(this).val();
            generateFields(page, section);
        });

        // Add new item
        $('#addItemBtn').on('click', function () {
            const page = $('#page').val();
            const section = $('#section').val();
            const sectionData = sectionConfig[page]?.[section];
            if (!sectionData?.items?.length) return;
            addItemRow(sectionData.items);
        });

        // Remove item row
        $(document).on('click', '.removeItemBtn', function () {
            $(this).closest('.item-row').remove();
        });
    });
</script>