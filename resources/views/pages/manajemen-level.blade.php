@extends('layouts.default')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Managed Tables')

@push('css')
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="/assets/js/demo/table-manage-default.demo.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Setting CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Function to handle checkbox state and update value to 1 or 0
    function handleCheck(checkbox) {
        if (checkbox.checked) {
            checkbox.value = "1"; // Set value to 1 when checked
        } else {
            checkbox.value = "0"; // Set value to 0 when unchecked
        }
        // console.log(checkbox.id + " value: " + checkbox.value);
    }


    $(document).ready(function() {
        // Saat modal edit role ditampilkan, isi data role ke dalam form
        $('#editRoleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var roleId = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#edit_role_id').val(roleId);
            modal.find('#edit_name').val(name);
        });

        // Tangani submit form edit role dengan AJAX
        $('#editRoleForm').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $('[data-bs-toggle="tooltip"]').tooltip();

            $.ajax({
                url: "{{ url('/roles') }}/" + $('#edit_role_id').val(),
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editRoleModal').modal('hide');
                    location.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        alert(value[0]);
                    });
                }
            });
        });

        // Saat modal akses role ditampilkan, load data permission melalui AJAX
        $('#accessRoleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var roleId = button.data('role-id');
            var roleName = button.data('role-name');

            var modal = $(this);
            modal.find('#roleName').text(roleName);

            // Mengambil data hak akses menu dengan AJAX
            $.ajax({
                url: "{{ url('/roles') }}/" + roleId + "/permissions",
                type: 'GET',
                success: function(response) {
                    modal.find('tbody').empty();
                    $.each(response, function(index, RHMP) {
                        var row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${RHMP.menu.name}</td>
                                    <td><input type="checkbox" name="permissions[${RHMP.role_id}][${RHMP.menu_id}][read]" ${RHMP.read ? 'checked value=1' : ''} onchange=handleCheck(this)></td>
                                    <td><input type="checkbox" name="permissions[${RHMP.role_id}][${RHMP.menu_id}][edit]" ${RHMP.edit ? 'checked value=1' : ''} onchange=handleCheck(this)></td>
                                    <td><input type="checkbox" name="permissions[${RHMP.role_id}][${RHMP.menu_id}][create]" ${RHMP.create ? 'checked value=1' : ''} onchange=handleCheck(this)></td>
                                    <td><input type="checkbox" name="permissions[${RHMP.role_id}][${RHMP.menu_id}][delete]" ${RHMP.delete ? 'checked value=1' : ''} onchange=handleCheck(this)></td>
                                    <td><input type="checkbox" name="permissions[${RHMP.role_id}][${RHMP.menu_id}][print]" ${RHMP.print ? 'checked value=1' : ''} onchange=handleCheck(this)></td>
                                    <td><input type="checkbox" name="permissions[${RHMP.role_id}][${RHMP.menu_id}][upload]" ${RHMP.upload ? 'checked value=1' : ''} onchange=handleCheck(this)></td>
                                </tr>
                            `;
                        modal.find('tbody').append(row);
                    });
                },
                error: function(xhr) {
                    alert('Gagal mengambil data: ' + xhr.responseText);
                }
            });

            $('#savePermissionsBtn').click(function() {
                var formData = $('#accessRoleForm').serialize();
                // console.log(formData);

                $.ajax({
                    url: "/roles/" + roleId + "/save-permissions",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#accessRoleModal').modal('hide');
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menyimpan data: ' + xhr.responseText);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('.delete-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                const form = this; // Get the form reference
                Swal.fire({
                    title: 'Hapus Role Ini?',
                    text: 'Role yang dihapus tidak dapat dipulihkan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // If confirmed, submit the form
                    }
                });
            });
        });
    });
</script>
@endpush

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Setting</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Manajemen Level</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">MANAJEMEN LEVEL</h1>
<!-- END page-header -->
<!-- BEGIN panel -->
<div class="panel panel-default">
    <!-- BEGIN panel-heading -->
    <div class="panel-heading">
        <i class="fas fa-sign-in-alt icon"></i>
        <div class="title">Daftar User</div>
    </div>
    <!-- END panel-heading -->

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- BEGIN panel-body -->
    <div class="panel-body">
        @can('create-manajemen-level')
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
            data-bs-target="#addRoleModal">
            <i class="fas fa-plus"></i> Tambah Role
        </button>
        @endcan
        <!-- Modal Tambah Role -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Tambah Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addRoleForm" action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="role_name" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role_name" name="name" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
        <div class="table-responsive">
        <table id="data-table-default" class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="3%">No.</th>
                    <th class="text-nowrap" width="33%">Role</th>
                    @can('edit-manajemen-level')
                    <th class="text-nowrap" width="33%">Akses</th>
                    <th class="text-nowrap" width="33%">Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $key => $role)
                <tr class="{{ $key % 2 == 0 ? 'odd' : 'even' }} gradeX">
                    <td class="fw-bold text-dark">{{ $key + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    @can('edit-manajemen-level')
                    <td>
                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#accessRoleModal" data-role-id="{{ $role->id }}"
                            data-role-name="{{ $role->name }}">
                            <i class="fas fa-lock"></i> Hak Akses Menu
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#editRoleModal" data-id="{{ $role->id }}"
                            data-name="{{ $role->name }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        @can('delete-manajemen-level')
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm me-2">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                        @endcan
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    <!-- END panel-body -->

    <script>
        $('#data-table-default').DataTable();
    </script>
</div>
<!-- END panel -->

<!-- Modal Edit Role -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_role_id" name="role_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Role</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Hak Akses Menu -->
<div class="modal fade" id="accessRoleModal" tabindex="-1" aria-labelledby="accessRoleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accessRoleModalLabel">Hak Akses Menu - <span id="roleName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accessRoleForm">
                    <table class="simple-permission-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Read</th>
                                <th>Edit</th>
                                <th>Create</th>
                                <th>Delete</th>
                                <th>Print</th>
                                <th>Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="savePermissionsBtn">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

@endsection