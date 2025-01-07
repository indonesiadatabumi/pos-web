@extends('layouts.default')

@section('title', 'Managed Tables - Buttons')

@push('css')
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
<script src="/assets/js/demo/table-manage-default.demo.js"></script>
<script src="/assets/plugins/jszip/dist/jszip.min.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
<script>
	$(document).ready(function() {
		function fetchBillings() {
			// Ambil nilai nama dan rentang tanggal
			var nama = $('#wajibRetribusi').val();
			var startDate = $('#StartDate').val();
			var endDate = $('#EndDate').val();

			$.ajax({
				url: "{{ route('pages.sts.index') }}",
				type: "GET",
				data: {
					nama: nama,
					start_date: startDate,
					end_date: endDate
				},
				success: function(response) {
					// Kosongkan isi tabel
					$('#data-table-buttons tbody').empty();

					// Tambahkan data baru dari response
					if (response.length > 0) {
						$.each(response, function(index, billing) {
							$('#data-table-buttons tbody').append(`
                                <tr class="${index % 2 === 0 ? 'even' : 'odd'} gradeX">
                                    <td width="1%" class="fw-bold text-dark">${index + 1}</td>
                                    <td>${billing.npwrd}</td>
                                    <td>${billing.daftarUsaha_nama}</td>
                                    <td>${billing.daftarUsaha_alamat}</td>
                                    <td>${billing.id_billing}</td>
                                    <td>${billing.ssrd_nilai_setor}</td>
                                    <td>${billing.formatted_created_at}</td>
                                </tr>
                            `);
						});
					} else {
						$('#data-table-buttons tbody').append(`
                            <tr>
                                <td colspan="7" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        `);
					}
				},
				error: function() {
					alert('Terjadi kesalahan, data tidak dapat dimuat.');
				}
			});
		}

		// Event listener untuk dropdown nama dan input tanggal
		$('#wajibRetribusi, #StartDate, #EndDate').on('change', fetchBillings);
		$('#resetFilters').on('click', function() {
			// Kosongkan nilai dropdown dan tanggal
			$('#wajibRetribusi').val('');
			$('#StartDate').val('');
			$('#EndDate').val('');

			// Panggil fetchBillings untuk menampilkan semua data
			fetchBillings();
		});
	});
</script>



@endpush

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
	<li class="breadcrumb-item"><a href="javascript:;">Laporan</a></li>
	<li class="breadcrumb-item"><a href="javascript:;">Rekap Setor</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1>Rekap Setor</h1>
<!-- END page-header -->
<!-- BEGIN row -->
<div class="row">
	<!-- BEGIN col-2 -->
	<!-- END col-2 -->
	<!-- BEGIN col-10 -->
	<div class="col-xl-12">
		<!-- BEGIN panel -->
		<div class="panel panel-default">
			<!-- BEGIN panel-heading -->
			<div class="panel-heading">
				<i class="fas fa-sign-in-alt icon"></i>
				<div class="title">Daftar Setoran Pajak</div>
			</div>
			<div class="container-fluid mt-3">
				<div class="row mb-3">
					<div class="col-md-6">
						<div class="d-flex align-items-center">
							<label for="wajibRetribusi" class="form-label me-2 mb-0">Nama : </label>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-6">
						<div class="d-flex align-items-center"></div>
						<select value="" id="wajibRetribusi" class="form-select w-auto">
							<option selected>-- Pilih Nama Wajib Pajak--</option>
							@foreach($billings as $billing)
							<option value="{{ $billing->daftarUsaha_nama }}">{{ $billing->daftarUsaha_nama }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-3">
				<div class="row mb-3">
					<div class="col-xs-6 col-sm-2">
						<div class="d-flex flex-column align-items-start">
							<label for="wajibRetribusi" class="form-label me-2 mb-3">Tanggal Awal :</label>
							<div>
								<div class="input-group-date" id="searchStartDate" data-target-input="nearest">
									<input type="date" class="form-control datetimepicker-input StartDate" id="StartDate" maxlength="10" placeholder="yyyy-mm-dd" data-target="#searchStartDate">
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-sm-3">
						<div class="d-flex flex-column align-items-start">
							<label for="wajibRetribusi" class="form-label me-1 mb-3">Tanggal Akhir :</label>
							<div>
								<div class="input-group-date" id="searchEndDate" data-target-input="nearest">
									<input type="date" class="form-control datetimepicker-input Endate" id="EndDate" maxlength="10" placeholder="yyyy-mm-dd" data-target="#searchEndDate">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-3 text-start">
				<button id="resetFilters" class="btn btn-secondary btn-sm">
					<i class="fa fa-refresh"></i> Reset Filter
				</button>
				<a href="{{ url('prn-ba-sts') }}" target="_blank" class="btn btn-warning btn-sm">
					<i class="fa fa-print"></i> Cetak
				</a>
			</div>


			<!-- BEGIN panel-heading -->
			<!-- BEGIN panel-body -->
			<div class="panel-body">
				<table id="data-table-buttons" class="table table-striped table-bordered align-middle">
					<thead>
						<tr>
							<th width="1%">No.</th>
							<th class="text-nowrap">NPWRD</th>
							<th class="text-nowrap">NAMA</th>
							<th class="text-nowrap">ALAMAT USAHA</th>
							<th class="text-nowrap">ID BILLING</th>
							<th class="text-nowrap">JUMLAH SETORAN</th>
							<th class="text-nowrap">TGL SETOR</th>
					</thead>
					<tbody>
					@php
				$userRoleId = auth()->user()->role_id; // Mengambil role_id pengguna yang sedang login

				if ($userRoleId === 3) {
				$filteredBillings = $billings->filter(function($billing) {
				return $billing->daftarUsaha->nama === auth()->user()->fullname;
				});
				} else {
				$filteredBillings = $billings;
				}

				@endphp
				@php
				$no = 1;
				@endphp

				@foreach ($filteredBillings as $billing)
						<tr class="{{ $loop->even ? 'even' : 'odd' }} gradeX">
							<td width="1%" class="fw-bold text-dark">{{ $no++ }}</td>
							<td>{{ $billing->npwrd}}</td>
							<td>{{ $billing->daftarUsaha_nama}}</td>
							<td>{{ $billing->daftarUsaha_alamat}}</td>
							<td>{{ $billing->id_billing }}</td>
							<td>{{ $billing->ssrd_nilai_setor}}</td>
							<td>{{ $billing->formatted_created_at}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<!-- END panel-body -->
			<!-- BEGIN hljs-wrapper -->

		</div>
		<!-- END hljs-wrapper -->
	</div>
	<!-- END panel -->
</div>
<!-- END col-10 -->
</div>
<!-- END row -->
<script>
</script>
@endsection