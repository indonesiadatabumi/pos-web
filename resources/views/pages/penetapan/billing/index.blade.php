@extends('layouts.default')

@section('title', 'Tabel Terkelola')

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
<script src="/assets/js/demo/table-manage-default.demo.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
@endpush

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
	<li class="breadcrumb-item"><a href="javascript:;">Penetapan</a></li>
	<li class="breadcrumb-item"><a href="javascript:;">Daftar Penetapan Biling</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1>DAFTAR PENETAPAN</h1>
<!-- END page-header -->
<!-- BEGIN panel -->
<div class="panel panel-default">
	<!-- BEGIN panel-heading -->
	<div class="panel-heading">
		<i class="fas fa-sign-in-alt icon"></i>
		<div class="title">Daftar Billing</div>
	</div>
	<!-- END panel-heading -->
	<!-- BEGIN panel-body -->
	@php
	$userRoleId = auth()->user()->role_id;
	@endphp
	<div class="panel-body table-responsive">
		<table id="data-table-default" class="table table-striped table-bordered align-middle">
			<thead>
				<tr>
					<th width="1%">No.</th>
					<th class="text-nowrap">NPWRD</th>
					<th class="text-nowrap">NAMA</th>
					<th class="text-nowrap">ID BILLING</th>
					<th class="text-nowrap">TAHUN PAJAK</th>
					<th class="text-nowrap">TANGGAL REKAM</th>
					<th class="text-nowrap">STATUS</th>
					<th class="text-nowrap" width="1%">AKSI</th>

				</tr>
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
					<td>
						@php
						$npwrd = $billing->daftarUsaha->npwrd ?? '-';
						$formattedNpwr = $npwrd !== '-' ? substr($npwrd, 0, 1) . '.' . substr($npwrd, 1) : '-';
						@endphp
						{{ $formattedNpwr }}
					</td>

					<td>{{ $billing->daftarUsaha->nama ?? '-' }}</td>
					<td>{{ $billing->id_billing }}</td>
					<td>{{ \Carbon\Carbon::parse($billing->created_at)->format('Y') }}</td>
					<td>{{ $billing->tanggal_rekam }}</td>
					<td>{{ $billing->status }}</td>
					<td>
						<a href="{{ route('billing.cetak', $billing->id) }}" class="btn btn-success btn-sm">
							<i class="fas fa-edit"></i>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<script>
		$('#data-table-default').DataTable({});
	</script>
	<!-- END panel-body -->
</div>
<!-- END panel -->
@endsection