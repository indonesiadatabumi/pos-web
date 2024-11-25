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
    $(document).ready(function() {
        // Saat modal edit user ditampilkan, isi data pengguna ke dalam form
        $('#editUserModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            var username = button.data('username');
            var fullname = button.data('fullname');
            var email = button.data('email');
            var password = button.data('password');
            var roleId = button.data('role-id');
            var status = button.data('status');

            var modal = $(this);
            modal.find('#edit_user_id').val(userId);
            modal.find('#edit_username').val(username);
            modal.find('#edit_fullname').val(fullname);
            modal.find('#edit_email').val(email);
            modal.find('#edit_password').val(password);
            modal.find('#edit_role_id').val(roleId);
            modal.find('#edit_status_aktif').val(status);
        });

        // Tangani submit form edit user dengan AJAX
        $('#editUserForm').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ url('/users') }}/" + $('#edit_user_id').val(),
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editUserModal').modal('hide');
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

        // Tangani perubahan status aktif langsung dari tabel
        $('.toggle-status').on('click', function() {
            var userId = $(this).data('id');
            var newStatus = $(this).data('status');
            var actionText = newStatus === 1 ? 'aktifkan' : 'nonaktifkan'; // Teks berdasarkan status baru

            // Menggunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin ' + actionText + ' user ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Melakukan permintaan AJAX untuk mengubah status
                    $.ajax({
                        url: "{{ url('/users') }}/" + userId + "/toggle-status",
                        type: 'PUT',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            status_aktif: newStatus
                        },
                        success: function(response) {
                            // Menampilkan pesan sukses
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                                'success'
                            ).then(() => {
                                // Memuat ulang halaman setelah pengguna mengklik OK
                                location.reload(); // Memuat ulang halaman untuk mencerminkan perubahan
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat mengubah status.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        $('.delete-user-btn').on('click', function() {
            var userId = $(this).data('id');
            var form = $(this).closest('.delete-user-form'); // Ambil form yang sesuai

            // Menggunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus user ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, kirimkan form
                    form.submit(); // Mengirimkan form untuk menghapus user
                }
            });
        });
    });
</script>


@endpush

@section('content')

<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Setting</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Manajemen User</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">MANAJEMEN USER</h1>
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
        @can('create-manajemen-user')
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus"></i> Tambah User
        </button>
        @endcan
        <!-- Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="fullname" class="form-label">Nama Lengkap</label>
                                <select class="form-select" id="fullname" name="fullname" required>
                                    <option value="">Pilih Nama Lengkap</option>
                                    @foreach ($daftar_usaha as $usaha)
                                    <option value="{{ $usaha->id }}" data-email="{{ $usaha->email }}">{{ $usaha->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required readonly>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status_aktif" class="form-label">Status Aktif</label>
                                <select class="form-select" id="status_aktif" name="status_aktif" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                        <script>
                            // Saat nama lengkap dipilih, otomatis isi email
                            document.getElementById('fullname').addEventListener('change', function() {
                                var selectedOption = this.options[this.selectedIndex];
                                var email = selectedOption.getAttribute('data-email');
                                document.getElementById('email').value = email;
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="2%" class="text-nowrap">No.</th>
                        <th class="text-nowrap">Username</th>
                        <th class="text-nowrap">Fullname</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Level</th>
                        @can('edit-manajemen-user')
                        <th class="text-nowrap" width="10%">Status</th>
                        <th class="text-nowrap" width="12%">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                    <tr class="{{ $key % 2 == 0 ? 'odd' : 'even' }} gradeX">
                        <td class="fw-bold text-dark">{{ $key + 1 }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role_name ?? 'Tidak ada role' }}</td>
                        @can('edit-manajemen-user')
                        <td>
                            @if ($user->status_aktif == 1)
                            <button class="btn btn-success btn-sm toggle-status" data-id="{{ $user->id }}" data-status="0">
                                Aktif
                            </button>
                            @else
                            <button class="btn btn-danger btn-sm toggle-status" data-id="{{ $user->id }}" data-status="1">
                                Tidak Aktif
                            </button>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm me-2"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-id="{{ $user->id }}"
                                data-username="{{ $user->username }}"
                                data-fullname="{{ $user->fullname }}"
                                data-email="{{ $user->email }}"
                                data-password="{{ $user->password }}"
                                data-role-id="{{ $user->role_id }}"
                                data-status="{{ $user->status_aktif }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            @can('delete-manajemen-user')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" class="delete-user-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm me-2 delete-user-btn" data-id="{{ $user->id }}">
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
        <!-- Modal Edit -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            @csrf
                            @method('PUT') <!-- Pastikan ini ada -->
                            <input type="hidden" id="edit_user_id" name="user_id">
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username</label>
                                <input type="text" style="background-color: #DEE1E6;" class="form-control" id="edit_username" name="username" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit_fullname" class="form-label">Fullname</label>
                                <input type="text" style="background-color: #DEE1E6;" class="form-control" id="edit_fullname" name="fullname" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" style="background-color: #DEE1E6;" class="form-control" id="edit_email" name="email" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">password</label>
                                <input type="password" class="form-control" id="edit_password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_role_id" class="form-label">Level User</label>
                                <select class="form-select" id="edit_role_id" name="role_id" required>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status_aktif" class="form-label">Status Aktif</label>
                                <select class="form-select" id="edit_status_aktif" name="status_aktif" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
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


        </tbody>
        </table>
    </div>
    <!-- END panel-body -->
    <!-- BEGIN hljs-wrapper -->



</div>
<!-- END panel -->
@endsection