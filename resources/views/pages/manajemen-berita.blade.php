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
        // Menangani Pengiriman Formulir Tambah
        $('#addBeritaForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman formulir default

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'), // URL untuk atribut action formulir
                type: 'POST', // Gunakan POST untuk mengirim data
                data: formData,
                processData: false, // Penting untuk unggahan file
                contentType: false, // Penting untuk unggahan file
                success: function(response) {
                    // Tutup modal
                    $('#addBeritaModal').modal('hide');
                    // Muat ulang halaman atau segarkan tabel data
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal menambahkan berita: ' + xhr.responseText);
                }
            });
        });
    });

    $(document).ready(function() {
        // Open Edit Modal and fill in the form with existing data
        $('#editBeritaModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var title = button.data('title');
            var content = button.data('content');
            var image = button.data('image');
            var status = button.data('status');

            var modal = $(this);
            modal.find('#edit_berita_id').val(id);
            modal.find('#edit_title').val(title);
            modal.find('#edit_content').val(content);
            modal.find('#edit_status_aktif').val(status);
            // Set image field for display in modal
            if (image) {
                var imageUrl = '{{ asset("storage/image/") }}/' + image; // Atur URL gambar
                modal.find('#currentImage').attr('src', imageUrl).show(); // Tampilkan gambar
                modal.find('#noImageMessage').hide(); // Sembunyikan pesan tidak ada gambar
            } else {
                modal.find('#currentImage').hide(); // Sembunyikan gambar
                modal.find('#noImageMessage').show(); // Tampilkan pesan tidak ada gambar
            }
        });

        // Handle Edit Form Submission
        $('#editBeritaForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);
            var id = $('#edit_berita_id').val(); // Get the id of the news

            $.ajax({
                url: '/news/' + id, // Set the URL for updating the news
                type: 'POST', // Use POST for updating data
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Close the modal
                    $('#editBeritaModal').modal('hide');
                    // Reload the page or refresh the data table
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal mengupdate berita: ' + xhr.responseText);
                }
            });
        });
    });

    $(document).ready(function() {
        $('.toggle-status').on('click', function() {
            var id = $(this).data('id');
            var newStatus = $(this).data('status');
            var actionText = newStatus === 1 ? 'aktifkan' : 'nonaktifkan'; // Teks berdasarkan status baru

            // Menggunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin ' + actionText + ' berita ini?',
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
                        url: "{{ url('/news') }}/" + id + "/toggle-status",
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
    });

    $('.delete-news-btn').on('click', function() {
        var id = $(this).data('id');
        var form = $(this).closest('.delete-news-form'); // Ambil form yang sesuai

        // Menggunakan SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus berita ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {

                form.submit();
            }
        });
    });
</script>



@endpush

@section('content')

<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Setting</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Manajemen Berita</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">MANAJEMEN BERITA</h1>
<!-- END page-header -->
<!-- BEGIN panel -->
<div class="panel panel-default">
    <!-- BEGIN panel-heading -->
    <div class="panel-heading">
        <i class="fas fa-sign-in-alt icon"></i>
        <div class="title">Daftar Berita</div>
    </div>
    <!-- END panel-heading -->

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <!-- BEGIN panel-body -->
    <div class="panel-body table-responsive">
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addBeritaModal">
            <i class="fas fa-plus"></i> Tambah Berita
        </button>
        <!-- Modal -->
        <div class="modal fade" id="addBeritaModal" tabindex="-1" aria-labelledby="addBeritaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBeritaModalLabel">Tambah Berita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBeritaForm" action="{{ route('news.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Konten</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status_aktif" class="form-label">Status Aktif</label>
                                <select class="form-select" id="status_aktif" name="status_aktif" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar (opsional)</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <table id="data-table-default" class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="1%">No.</th>
                    <th class="text-nowrap">Judul</th>
                    <th class="text-nowrap">Isi Konten</th>
                    <th class="text-nowrap">Gambar</th>
                    <th class="text-nowrap" width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($news as $key => $item)
                <tr class="{{ $key % 2 == 0 ? 'odd' : 'even' }} gradeX">
                    <td class="fw-bold text-dark">{{ $key + 1 }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{!! nl2br(e($item->content)) !!}
                    </td>
                    <td>
                        @if($item->image)
                        <img src="{{ asset('storage/image/' . $item->image) }}" width="50" alt="Gambar Berita">
                        @else
                        <span>Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm me-2"
                            data-bs-toggle="modal"
                            data-bs-target="#editBeritaModal"
                            data-id="{{ $item->id }}"
                            data-title="{{ $item->title }}"
                            data-content="{{ $item->content }}"
                            data-image="{{ $item->image }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('news.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm me-2">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <!-- Modal Edit -->
                <div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editBeritaModalLabel">Edit Berita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editBeritaForm">
                                    @csrf
                                    @method('PUT') <!-- Pastikan ini ada -->
                                    <input type="hidden" id="edit_berita_id" name="berita_id">
                                    <div class="mb-3">
                                        <label for="edit_title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="edit_title" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_content" class="form-label">Content</label>
                                        <textarea class="form-control" id="edit_content" name="content" rows="5" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_image" class="form-label">Gambar (opsional)</label>
                                        <input type="file" class="form-control-file" id="edit_image" name="image" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <img id="currentImage" src="" alt="Gambar Berita" style="max-width: 100%; height: auto; display: none;">
                                        <span id="noImageMessage" style="display: none;">Tidak ada gambar</span>
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
</div>
<!-- END panel-body -->
<!-- BEGIN hljs-wrapper -->


<script>
    $('#data-table-default').DataTable({});
</script>
</div>
<!-- END panel -->
@endsection