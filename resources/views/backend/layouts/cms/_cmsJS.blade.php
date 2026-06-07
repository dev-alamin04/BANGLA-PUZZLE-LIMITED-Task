<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dt = $('#cms-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            responsive: true,
            ajax: '{{ route("admin.cms_contents.index") }}',
            order: [[0, 'desc']],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'page', name: 'page' },
                { data: 'section', name: 'section' },
                { data: 'main_title', name: 'main_title' },
                { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            language: { paginate: { previous: '<i class="fas fa-angle-left"></i>', next: '<i class="fas fa-angle-right"></i>' }, processing: dataTableLoader() }
        });

        // Account status toggle
        $(document).on('click', '.change_cms_status', function (e) {
            e.preventDefault();
            $('#cms_status_id').val($(this).data('id'));
            $('#cms_enabled').val($(this).data('enabled'));
            $('#cms_status_title').text($(this).data('title'));
            $('#cms_status_description').text($(this).data('description'));
        });

        $('#cms_status_modal_clear').on('submit', function (e) {
            e.preventDefault();
            const id = $('#cms_status_id').val();
            const isEnabled = $('#cms_enabled').val();
            $.ajax({
                url: '/admin/cms-contents/' + id + '/status',
                type: 'PATCH',
                data: { is_active: isEnabled },
                success: function () {
                    dt.ajax.reload(null, false);
                    successModal('STATUS UPDATED SUCCESSFULLY');
                },
                error: function (xhr) {
                    errorModal();
                    console.error(xhr.responseText);
                }
            });
        });

        // Delete CMS
        $(document).on('click', '.deletebtn', function (e) {
            e.preventDefault();
            $('#delete_id').val($(this).data('id'));
            $('#deletemodal').modal('show');
        });

        $('#delete_modal_clear').on('submit', function (e) {
            e.preventDefault();
            let id = $('#delete_id').val();
            $.ajax({
                url: '{{ url("/admin/cms-contents") }}/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function () {
                    dt.ajax.reload(null, false);
                    successModal('CONTENT DELETED SUCCESSFULLY');
                },
                error: function (xhr) {
                    errorModal();
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>