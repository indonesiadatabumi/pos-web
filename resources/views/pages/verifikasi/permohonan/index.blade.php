@extends('layouts.default')

@section('title', 'Daftar Permohonan')

@push('css')
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }

    .panel-heading .title {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
    }

    table {
        font-family: 'Poppins', sans-serif;
        font-size: 11px;
    }
</style>

@endpush

@push('scripts')
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@push('scripts')
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var table = $('#data-table-default').DataTable({
            "order": [
                [5, 'des']
            ]
        });

        table.on('xhr', function() {
            table.order([5, 'asc']).draw();
        });


        $(document).on('click', '.validate-btn', function() {
            var status = $(this).data('status');
            if (status === 'Diterima') {
                Swal.fire('Status Diterima!', 'Permohonan ini sudah diterima.', 'info');
                return;
            }

            var permohonanId = $(this).data('id');
            var no_permohonan = $(this).data('no_permohonan');
            var no_seri = $(this).data('no_seri');
            var nm_wr = $(this).data('nm_wr');
            var nm_retribusi = $(this).data('nm_retribusi');
            var no_awal = $(this).data('no_awal');
            var no_akhir = $(this).data('no_akhir');
            var jml_lembar = $(this).data('jml_lembar');
            var tarif = $(this).data('tarif');
            var total = $(this).data('total');

            Swal.fire({
                title: 'Validasi Permohonan',
                html: `
            <p><strong>No. Permohonan:</strong> ${no_permohonan}</p>
            <p><strong>No. Seri:</strong> ${no_seri}</p>
            <p><strong>Nama WR:</strong> ${nm_wr}</p>
            <p><strong>Jenis Retribusi:</strong> ${nm_retribusi}</p>
            <p><strong>No. Awal:</strong> ${no_awal}</p>
            <p><strong>No. Akhir:</strong> ${no_akhir}</p>
            <p><strong>Jumlah Lembar:</strong> ${jml_lembar}</p>
            <p><strong>Tarif:</strong> ${tarif}</p>
            <p><strong>Total:</strong> ${total}</p>
        `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Diterima',
                // cancelButtonText: 'Ditolak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(permohonanId, 'Diterima');
                    // } else if (result.dismiss === Swal.DismissReason.cancel) {
                    //     updateStatus(permohonanId, 'Ditolak');
                }
            });
        });

        function updateStatus(id, status) {
            $.ajax({
                url: '/permohonan/update-status',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', 'Status permohonan berhasil diubah.', 'success')
                            .then(() => {
                                location.reload();
                            });
                    } else {
                        Swal.fire('Error!', 'Gagal mengubah status permohonan.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                }
            });
        }
    });
</script>

@endpush


@section('content')
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Pelayanan</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Verifikasi Permohonan</a></li>
</ol>

<h1>Daftar Permohonan</h1>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    {{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger">
    {{ $message }}
</div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fas fa-sign-in-alt icon"></i>
        <div class="title">Daftar Pemohon Wajib Pajak</div>
    </div>

    <div class="panel-body">
        <table id="data-table-default" class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="1%">NO.</th>
                    <th class="text-nowrap">NPWRD</th>
                    <th class="text-nowrap">NAMA WR</th>
                    <th class="text-nowrap">ALAMAT USAHA</th>
                    <th class="text-nowrap">TANGGAL PERMOHONAN</th>
                    <th class="text-nowrap">STATUS</th>
                    <th class="text-nowrap" width="10%">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permohonan as $key => $item)
                <tr>
                    <td class="fw-bold text-dark">{{ $key + 1 }}.</td>
                    <td>
                        @php
                        $npwrd = $item->npwrd;
                        $formattedNpwr = substr($npwrd, 0, 1) . '.' . substr($npwrd, 1);
                        @endphp
                        {{ $formattedNpwr }}
                    </td>
                    <td>{{ $item->nm_wr }}</td>
                    <td>{{ $item->alamat_usaha }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        @if($item->status === 'Menunggu')
                        <span class="badge bg-warning">Menunggu</span>
                        @elseif($item->status === 'Diterima')
                        <span class="badge bg-success">Diterima</span>
                        @elseif($item->status === 'Ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td width="15%">
                        <button
                            class="btn btn-success btn-sm me-1 validate-btn"
                            data-id="{{ $item->id }}"
                            data-no_permohonan="{{ $item->no_permohonan }}"
                            data-no_seri="{{ $item->no_seri }}"
                            data-nm_wr="{{ $item->nm_wr }}"
                            data-nm_retribusi="{{ $item->nm_retribusi }}"
                            data-no_awal="{{ $item->no_awal }}"
                            data-no_akhir="{{ $item->no_akhir }}"
                            data-jml_lembar="{{ $item->jml_lembar }}"
                            data-tarif="{{ $item->tarif }}"
                            data-total="{{ $item->total }}"
                            data-status="{{ $item->status }}">
                            <i class="fas fa-check-circle"></i> Validas
                        </button>

                        <a href="{{ url('prn-ba-karcis?sid=' . $item->id) }}" target="_blank" class="btn btn-warning btn-sm">
                            <i class="fa fa-print"></i> Cetak
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection