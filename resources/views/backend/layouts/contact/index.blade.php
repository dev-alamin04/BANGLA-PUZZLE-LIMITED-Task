@extends('backend.layouts.app')
@section('title') Contact Submissions || Admin @endsection

@section('content')
    <x-breadcrumbs title="Contact Submissions" :breadcrumbs="[['text' => 'Contacts', 'url' => route('admin.contacts.index')]]" />

    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Contact Submissions</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="contacts-table">
                        <thead>
                            <tr>
                                <th>S/L</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modal._delete_confirm')
@endsection

@section('script')
    <script>
        $(function () {
            const table = $('#contacts-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route("admin.contacts.index") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'message', name: 'message' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                language: { paginate: { previous: '<i class="fas fa-angle-left"></i>', next: '<i class="fas fa-angle-right"></i>' }, processing: dataTableLoader() }
            });

            window.showDeleteConfirm = function (id) {
                $('#delete_id').val(id);
                $('#deletemodal').modal('show');
            }

            $('#delete_modal_clear').on('submit', function (e) {
                e.preventDefault();
                const id = $('#delete_id').val();
                $.ajax({
                    url: '/admin/contacts/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (res) {
                        $('#deletemodal').modal('hide');
                        table.ajax.reload(null, false);
                        successModal(res.message);
                    },
                    error: function () { errorModal('Unable to delete!'); }
                });
            });

            window.markRead = function (id) {
                $.ajax({
                    url: '/admin/contacts/' + id,
                    type: 'PUT',
                    success: function (res) {
                        table.ajax.reload(null, false);
                        successModal(res.message);
                    },
                    error: function (xhr) {
                        errorModal(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            }
        });
    </script>
@endsection