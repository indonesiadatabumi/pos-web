@extends('layouts.default')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> --}}
<style>
    .toggle-status {
        width: 40px;
        height: 20px;
        appearance: none;
        background: #ddd;
        border-radius: 20px;
        position: relative;
        cursor: pointer;
        outline: none;
    }
    
    .toggle-status:checked {
        background: #28a745;
    }
    
    .toggle-status::before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: 0.3s;
    }
    
    .toggle-status:checked::before {
        left: 22px;
    }
</style>

@endpush

@section('title', 'Daftar Produk')

@section('content')
<div class="d-flex align-items-center mb-3">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Daftar Produk</li>
        </ol>
        <h1 class="page-header mb-0">Manage Produk</h1>
    </div>
    <div class="ms-auto">
        <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-rounded px-4 rounded-pill">
            <i class="fa fa-plus fa-lg me-2 ms-n2 text-success-900"></i> Tambah Produk
        </button>
        {{-- <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-rounded px-4 rounded-pill">
            <i class="fa fa-trash fa-lg me-2 ms-n2"></i> Hapus
        </button> --}}
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card border-0 mb-4">
    <div class="card-header h6 mb-0 bg-none p-3">
        <i class="fa fa-list fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Daftar Produk
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="" method="post" class="form-produk">
                @csrf
                <table class="table table-hover table-striped table-bordered text-nowrap align-middle">
                    <thead class="table-light">
                        <tr>
                            {{-- <th class="text-center" style="width: 5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th> --}}
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Foto Produk</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            {{-- <th>Pajak</th> --}}
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</i></th>
                        </tr>
                    </thead>
                </table>
            </form>
        </div>
    </div>
</div>

@includeIf('produk.form')
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                // {data: 'select_all', searchable: false, sortable: false, className: 'text-center'},
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
                {data: 'foto',searchable: false, sortable: false, className: 'text-center'},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'deskripsi'},
                {data: 'nama_kategori'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                // {data: 'pajak'},
                {data: 'stok'},
                {data: 'status_tampil', searchable: false, sortable: false, className: 'text-center'},
                {data: 'aksi', searchable: false, sortable: false, className: 'text-center'},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (!e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Produk');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form [name=nama_produk]').focus();

    $.get(url)
        .done((response) => {
            $('#modal-form [name=nama_produk]').val(response.nama_produk);
            $('#modal-form [name=deskripsi]').val(response.deskripsi);
            $('#modal-form [name=id_kategori]').val(response.id_kategori);
            $('#modal-form [name=harga_beli]').val(response.harga_beli);
            $('#modal-form [name=harga_jual]').val(response.harga_jual);
            // $('#modal-form [name=pajak]').val(response.pajak);
            $('#modal-form [name=stok]').val(response.stok);
            
            // Set foto produk yang ada
            if(response.foto) {
                $('#current-foto').attr('src', response.foto).show();
            } else {
                $('#current-foto').hide(); // Sembunyikan jika tidak ada foto
            }
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token':`{{ csrf_token() }}`,
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }

    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, $('.form-produk').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        } else {
            alert('Pilih data yang akan dihapus');
            return;
        }
    }

    //     // Event listener untuk checkbox "select all"
    //     $('#select_all').on('click', function () {
    //     const checked = this.checked;
    //     $('.table tbody input[type="checkbox"]').prop('checked', checked);
    // });

    // // Event listener untuk checkbox individual
    // $('.table tbody').on('change', 'input[type="checkbox"]', function() {
    //     const totalCheckboxes = $('.table tbody input[type="checkbox"]').length;
    //     const totalCheckedCheckboxes = $('.table tbody input[type="checkbox"]:checked').length;
    //     $('#select_all').prop('checked', totalCheckboxes === totalCheckedCheckboxes);
    // });

    $(function () {
    // table = $('.table').DataTable({
    //     responsive: true,
    //     processing: true,
    //     serverSide: true,
    //     autoWidth: false,
    //     ajax: {
    //         url: '{{ route('produk.data') }}',
    //     },
    //     columns: [
    //         {data: 'select_all', searchable: false, sortable: false, className: 'text-center'},
    //         {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
    //         {data: 'foto', searchable: false, sortable: false, className: 'text-center'},
    //         {data: 'kode_produk'},
    //         {data: 'nama_produk'},
    //         {data: 'nama_kategori'},
    //         {data: 'harga_beli'},
    //         {data: 'harga_jual'},
    //         {data: 'pajak'},
    //         {data: 'stok'},
    //         {data: 'aksi', searchable: false, sortable: false, className: 'text-center'},
    //     ]
    // });


});
$(document).on('click', '.btn-status', function() {
    let button = $(this);
    let id = button.data('id');

    $.ajax({
        url: '{{ route("produk.update_status_tampil") }}', // Pastikan route benar
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            if (response.success) {
                let newStatus = response.status_tampil ? 'Aktif' : 'Nonaktif';
                let newClass = response.status_tampil ? 'btn-success' : 'btn-danger';

                button.text(newStatus);
                button.removeClass('btn-success btn-danger').addClass(newClass);
            } else {
                alert('Gagal memperbarui status.');
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan: ' + xhr.responseText);
        }
    });
});


</script>
@endpush
