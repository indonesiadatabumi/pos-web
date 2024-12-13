@extends('layouts.default')

@section('title', 'Form SSRD')

@push('scripts')
<script src="/assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
@endpush
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    /* Custom CSS for better alignment */
    .form-control[readonly] {
        background-color: #e9ecef;
    }

    .form-group label {
        font-weight: bold;
    }

    .card-header {
        font-size: 1.1rem;
    }

    .row {
        margin-bottom: 1rem;
    }
</style>

@section('content')
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Pelayanan</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">SSRD</a></li>
</ol>

<h1>Form SSRD</h1>
<div class="row">
    <div class="col-xl-12">
        <div class="panel panel-default" data-sortable-id="form-validation-1">
            <div class="panel-heading">
                <i class="fas fa-file-alt icon"></i>
                <div class="title">Input Data SSRD</div>
            </div>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('billing.store') }}" method="POST" data-parsley-validate>
                @csrf

                <body>
                    <div class="container mt-5">
                        <!-- <div class="card">
            <div class="card-header bg-danger text-white">
                <strong>1. Kendaraan Bermotor Roda 2</strong>
            </div> -->
                        <div class="card-body">
                            <form action="{{ route('ssrd.store') }}" method="POST">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ssrd_no_seri"> Pilih No. Seri Karcis</label>
                                            <select class="form-control" name="ssrd_no_seri" id="ssrd_no_seri">
                                                <option value="">-- Seri Karcis --</option>
                                                @foreach($validatedSerialNumbers as $noSeri)
                                                <option value="{{ $noSeri }}">{{ $noSeri }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="ssrd_sisa">Sisa Karcis Belum Setor</label>
                                            <input type="number" class="form-control" id="ssrd_sisa" name="ssrd_sisa" placeholder="0" readonly value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ssrd_no_awal">No Awal Karcis</label>
                                            <input type="number" class="form-control" id="ssrd_no_awal" name="ssrd_no_awal">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ssrd_no_akhir">No Akhir Karcis</label>
                                            <input type="number" class="form-control" id="ssrd_no_akhir" name="ssrd_no_akhir">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ssrd_jml_lembar">Jumlah Lembar Disetor</label>
                                            <input type="number" class="form-control" id="ssrd_jml_lembar" name="ssrd_jml_lembar" value="0">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ssrd_tarif">Tarif</label>
                                            <input type="number" class="form-control" id="ssrd_tarif" name="ssrd_tarif" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ssrd_nilai_setor">Nilai Setor</label>
                                            <input type="number" class="form-control" id="ssrd_nilai_setor" name="ssrd_nilai_setor" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="metode_bayar"> Pilih Metode Pembayaran</label>
                                            <select class="form-control" name="metode_bayar" id="metode_bayar">
                                                <option value="">-- Metode Pembayaran --</option>
                                                <option value="Qris">QRIS</option>
                                            </select>
                                        </div>
                                    </div> -->


                                <div class="text-right">
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
                        </div>
                    </div>
        </div>
        </form>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('#ssrd_no_awal, #ssrd_no_akhir').on('input', function() {
            var noAwal = parseInt($('#ssrd_no_awal').val());
            var noAkhir = parseInt($('#ssrd_no_akhir').val());
            var noSeri = $('#ssrd_no_seri').val();
            var tarif = parseFloat($('#ssrd_tarif').val().replace(/\./g, '').replace(',', '.'));
            var sisaLembar = parseInt($('#ssrd_sisa').val());

            if (noAwal && noAkhir && noAkhir >= noAwal) {
                var jumlahLembar = noAkhir - noAwal + 1;
                $('#ssrd_jml_lembar').val(jumlahLembar);


                var nilaiSetor = jumlahLembar * tarif;
                $('#ssrd_nilai_setor').html(formatRibuan(nilaiSetor));
                $('#ssrd_nilai_setor').val(nilaiSetor);

            } else {
                $('#ssrd_jml_lembar').val('0');
                $('#ssrd_nilai_setor').val(0);
            }


            if (noSeri && noAwal && noAkhir) {
                $.ajax({
                    url: '/get-tarif',
                    type: 'GET',
                    data: {
                        no_seri: noSeri,
                        no_awal: noAwal,
                        no_akhir: noAkhir
                    },
                    success: function(response) {
                        if (response.tarif) {
                            $('#ssrd_tarif').html(formatRibuan(response.tarif));
                            $('#ssrd_tarif').val(response.tarif);


                            tarif = parseFloat(response.tarif);
                            var jumlahLembar = parseInt($('#ssrd_jml_lembar').val());
                            var nilaiSetor = jumlahLembar * tarif;

                            sisaLembar = response.jml_lembar - jumlahLembar;

                            $('#ssrd_sisa').val(sisaLembar);

                            $('#ssrd_nilai_setor').html(formatRibuan(nilaiSetor));
                            $('#ssrd_nilai_setor').val(nilaiSetor);

                        } else {
                            $('#ssrd_tarif').val(0);
                            $('#ssrd_nilai_setor').val(0);
                            alert('Tarif tidak ditemukan untuk data ini.');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengambil tarif.');
                    }
                });
            }
        });


        $('#ssrd_tarif').on('input', function() {
            var tarif = parseFloat($(this).val().replace(/\./g, '').replace(',', '.'));
            var jumlahLembar = parseInt($('#ssrd_jml_lembar').val());
            var nilaiSetor = jumlahLembar * tarif;
            $('#ssrd_nilai_setor').html(formatRibuan(nilaiSetor));
            $('#ssrd_nilai_setor').val(nilaiSetor);
        });
    });

    function formatRibuan(nilai) {
        return nilai.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>

@endsection