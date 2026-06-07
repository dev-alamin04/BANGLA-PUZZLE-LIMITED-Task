    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dt = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                stateSave: true,
                ajax: '{{ route('products.index') }}',
                order: [[0, 'desc']],
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category' },
                    { data: 'subcategory', name: 'subcategory' },
                    { data: 'old_price', name: 'old_price' },
                    { data: 'new_price', name: 'new_price' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: {
                    paginate: {
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>'
                    },
                    processing: typeof dataTableLoader === 'function' ? dataTableLoader() : 'Loading...'
                },
                columnDefs: [
                    { targets: [0, 6], className: 'text-center' },
                ]
            });

            $(document).on('click', '.deletebtn', function (e) {
                e.preventDefault();
                $('#delete_id').val($(this).data('id'));
                $('#deletemodal').modal('show');
            });

            $('#delete_modal_clear').on('submit', function (e) {
                e.preventDefault();
                const id = $('#delete_id').val();

                $.ajax({
                    url: '{{ url('/admin/products') }}/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function () {
                        dt.ajax.reload(null, false);
                        successModal('Product deleted successfully.');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        errorModal();
                    }
                });
            });
        });
    </script>
