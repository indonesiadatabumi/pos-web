@extends('layouts.default')

@section('title', 'Form Validation')

@push('scripts')
<script src="/assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
@endpush

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Pelayanan</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Pendaftaran Wajib Retribusi Pajak</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1>Pendaftaran Wajib Retribusi Pajak</h1>
<!-- END page-header -->
<!-- BEGIN row -->
<div class="row">
    <!-- BEGIN col-6 -->
    <div class="col-xl-20">
        <!-- BEGIN panel -->
        <div class="panel panel-default" data-sortable-id="form-validation-1">
            <!-- BEGIN panel-heading -->
            <div class="panel-heading">
                <i class="fas fa-sign-in-alt icon"></i>
                <div class="title">Input Data</div>
            </div>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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
            <form class="form-horizontal" action="{{ route('daftar.usaha.store') }}" method="POST" name="demo-form" enctype="multipart/form-data"
                {{-- data-parsley-validate --}}>
                @csrf

                <div class="card-header"></div>
                <div class="container-fluid mt-3">

                    <div class="form-group row mb-3">
                        <label class="col-lg-4 col-form-label form-label" for="no_registrasi">No. Registrasi</label>
                        <div class="col-lg-8">
                            <input type="text" id="no_registrasi" name="no_registrasi" class="form-control-registrasi" value="{{ $noRegistrasi }}" readonly required />

                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-lg-4 col-form-label form-label">Jenis</label>
                        <div class="col-lg-8 d-flex align-items-center">
                            <!-- <input type="radio" id="pajak" name="jenis" value="pajak" required>
                            <label for="pajak" style="margin-right: 20px;">Pajak</label> -->
                            <input type="radio" id="retribusi" name="jenis" value="retribusi" required>
                            <label for="retribusi">Retribusi</label>
                        </div>
                    </div>

                    <!-- <div class="form-group row mb-3" id="jenisWajibPajakRow" style="display: none;">
                        <label class="col-lg-4 col-form-label form-label">Jenis Wajib Pajak</label>
                        <div class="col-lg-8 d-flex align-items-center">
                            <input type="radio" id="hotel" name="jenis_wajib_pajak" value="hotel" required>
                            <label for="hotel" style="margin-right: 20px;">Hotel</label>

                            <input type="radio" id="resto" name="jenis_wajib_pajak" value="resto" required>
                            <label for="resto" style="margin-right: 20px;">Resto</label>

                            <input type="radio" id="hiburan" name="jenis_wajib_pajak" value="hiburan" required>
                            <label for="hiburan">Hiburan</label>
                        </div>
                    </div> -->

                    <div class="form-group row mb-3" id="pemilikRow" style="display: none;">
                        <label class="col-lg-4 col-form-label form-label">Pemilik</label>
                        <div class="col-lg-8 d-flex align-items-center">
                            <input type="radio" id="perorangan" name="pemilik" value="perorangan" required>
                            <label for="perorangan" style="margin-right: 20px;">Perorangan</label>

                            <input type="radio" id="instansi" name="pemilik" value="instansi" required>
                            <label for="instansi">Instansi</label>
                        </div>
                    </div>


                    <div class="panel-body">
                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="nm_wr">Nama WR</label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" id="nm_wr" name="nm_wr"
                                    placeholder="Nama WR" data-parsley-required="true" required />
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="kota">Kota</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control-registrasi" id="kota" name="kota" value="Bekasi" readonly />
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="id_kecamatan">Kecamatan</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="id_kecamatan" name="id_kecamatan" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->kd_kecamatan }}">{{ $kecamatan->kd_kecamatan }} | {{ $kecamatan->nm_kecamatan }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="id_kelurahan">Kelurahan</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="id_kelurahan" name="id_kelurahan" required disabled>
                                    <option value="">-- Pilih Kelurahan --</option>
                                    @foreach($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->kd_kelurahan }}">{{ $kelurahan->kd_kelurahan }} | {{ $kelurahan->nm_kelurahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="npwrd">NPWRD</label>
                            <div class="col-lg-8 d-flex">
                                <div class="col-sm-1 me-3"><input class="form-control-1 text-center" type="text"
                                        id="npwrd1" name="npwrd1" maxlength="1" required readonly /></div>
                                <div class="col-sm-1 me-3"><input class="form-control-1 text-center" type="text"
                                        id="npwrd2" name="npwrd2" maxlength="2" required readonly /></div>
                                <div class="col-sm-2 me-3"><input class="form-control-2 text-center" type="text"
                                        id="npwrd3" name="npwrd3" maxlength="4" required readonly /></div>
                                <!-- <div class="col-sm-2 me-3"><input class="form-control-2 text-center" type="text"
                                        id="npwrd4" name="npwrd4" maxlength="2" required /></div>
                                <div class="col-sm-2 me-3"><input class="form-control-2 text-center" type="text"
                                        id="npwrd5" name="npwrd5" size="7" maxlength="7" required /></div> -->
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="nama">Nama Pengelola/Nama Usaha/Nama OPD</label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" id="nama" name="nama"
                                    placeholder="Nama Lengkap" required />
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="no_handphone">No. Handphone</label>
                            <div class="col-lg-8">
                                <input class="form-control" type="text" id="no_handphone"
                                    data-parsley-minlength="11" data-parsley-maxlength="13" name="no_handphone"
                                    required placeholder="Nomor Handphone" />
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-lg-4 col-form-label form-label" for="alamat_usaha">Alamat Usaha</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" id="alamat_usaha" name="alamat_usaha" rows="4" data-parsley-minlength="1"
                                    data-parsley-maxlength="1000" required placeholder="Alamat Usaha"></textarea>
                            </div>
                        </div>


                        <div class="container-fluid mt-3">

                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="email">Email</label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control" id="email" name="email" required
                                        placeholder="Email Pengelola" data-parsley-type="email" />
                                </div>
                            </div>

                            <!-- Upload Foto -->
                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="foto">Upload Identitas</label>
                                <div class="col-lg-8">
                                    <input type="file" class="form-control" id="foto" name="foto" required />
                                    <small class="form-text text-muted">Maksimal ukuran 2MB, format gambar(png,jpg,jpeg).</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-danger me-2" id="resetButton">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
            </form>
        </div>
        <!-- END panel-body -->
        <!-- BEGIN hljs-wrapper -->
        <div class="hljs-wrapper"></div>
        <!-- END hljs-wrapper -->
    </div>
</div>
<!-- END col-6 -->

<script>
    // let lastUsedNumber = "{{ $daftarUsaha->npwrd ?? '' }}";
    $(document).ready(function() {
        $('form[name="demo-form"]').parsley();

        $('input[name="jenis"]').change(function() {
            if ($('#retribusi').is(':checked')) {
                $('#npwrd1').val('R');
                $('#jenisWajibPajakRow').hide();
                $('#pemilikRow').show();
            } else {
                $('#npwrd1').val('');
                $('#jenisWajibPajakRow').show();
                $('#pemilikRow').hide();
            }
        });


        $('#id_kecamatan').change(function() {
            var kd_kecamatan = $(this).val();
            if (kd_kecamatan) {
                $('#npwrd2').val(kd_kecamatan);


                $.ajax({
                    url: '/get-npwrd-sequence/' + kd_kecamatan,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        $('#npwrd3').val(data.sequence.padStart(4, '0'));
                    }
                });
            } else {
                $('#npwrd2').val('');
                $('#npwrd3').val('');
            }


            // if ($('#nik').val().length === 16) {
            //     generateNPWRD($('#nik').val());
            // }
        });
    });




    $('form').on('submit', function(e) {
        e.preventDefault();

        let form = this;

        if ($(form).parsley().isValid()) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin mengirimkan data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Data Anda berhasil dikirim.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        form.submit();
                    });
                }
            });
        } else {
            Swal.fire({
                title: 'Kesalahan!',
                text: 'Tolong periksa kembali data yang Anda masukkan.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    // function generateNPWRD(nik) {
    //     const currentDate = new Date();
    //     const year = currentDate.getFullYear().toString().slice(-2);
    //     const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');

    //     let numericPart;


    //     if (!lastUsedNumber || lastUsedNumber.length < 6) {
    //         lastUsedNumber = "000000";
    //         numericPart = 1;
    //     } else {

    //         numericPart = parseInt(lastUsedNumber.slice(-6), 10);
    //         numericPart++;
    //     }


    //     const npwrd = ($('#pajak').is(':checked') ? `R` : `S`) + year + month + numericPart.toString().padStart(6, '0');


    //     $('#npwrd1').val(npwrd.substring(0, 1));
    //     $('#npwrd2').val(1);
    //     $('#npwrd3').val(year);
    //     $('#npwrd4').val(nik.substring(4, 6));
    //     $('#npwrd5').val(npwrd.substring(npwrd.length - 5));


    // }

    function resetNPWRD() {
        $('#npwrd1, #npwrd2, #npwrd3, #npwrd4, #npwrd5').val('');
    }

    $('#resetButton').click(function() {
        $('form[name="demo-form"]')[0].reset();
        resetNPWRD();
    });

    $('#id_kecamatan').change(function() {
        var kd_kecamatan = $(this).val();
        if (kd_kecamatan) {
            $.ajax({
                url: '/get-kelurahan/' + kd_kecamatan,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#id_kelurahan').empty();
                    $('#id_kelurahan').append('<option value="">-- Pilih Kelurahan --</option>');
                    $.each(data, function(key, value) {
                        $('#id_kelurahan').append('<option value="' + value.kd_kelurahan + '">' + value.kd_kelurahan + ' | ' + value.nm_kelurahan + '</option>');
                    });

                    $('#id_kelurahan').prop('disabled', false);
                }
            });
        } else {
            $('#id_kelurahan').empty();
            $('#id_kelurahan').append('<option value="">-- Pilih Kelurahan --</option>');
            $('#id_kelurahan').prop('disabled', true);
        }
    });
</script>


@endsection