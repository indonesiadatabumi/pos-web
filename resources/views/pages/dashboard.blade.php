@extends('layouts.default')

@section('title', 'Dashboard V1')

@push('css')
<link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

@endpush

@push('scripts')
<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="/assets/plugins/flot/source/jquery.canvaswrapper.js"></script>
<script src="/assets/plugins/flot/source/jquery.colorhelpers.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.saturated.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.browser.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.drawSeries.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.uiConstants.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.time.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script src="/assets/plugins/flot/source/jquery.flot.resize.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.pie.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.crosshair.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.categories.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.navigate.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.touchNavigate.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.hover.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.touch.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.selection.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.symbol.js"></script>
<script src="/assets/plugins/flot/source/jquery.flot.legend.js"></script>
<script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="/assets/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
<script src="/assets/plugins/jvectormap-content/world-mill.js"></script>
<script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="/assets/js/demo/dashboard.js"></script>
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="/assets/js/demo/table-manage-default.demo.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
@endpush

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
	<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
	<li class="breadcrumb-item active">Dashboard</li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1>Dashboard</h1>
<!-- END page-header -->

<!-- BEGIN row -->

<!-- BEGIN col-3 -->
<div class="dashboard-container mt-4">
	<div class="row">
		<div class="col-md-3 mb-4">
			<a href="/laporan/permohonan" class="stat-card-link">
				<div class="stat-card bg-skyblue">
					<div class="stat-card-content">
						<div class="stat-icon-background">
							<i class="fas fa-file-invoice"></i>
						</div>
						<div class="stat-text">
							<h6>Jumlah Pengajuan</h6>
							<h2>{{$jumlahPengajuan}}</h2>
						</div>
					</div>
					<div class="stat-graph">
					</div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-4">
			<a href="/verifikasi/permohonan" class="stat-card-link">
				<div class="stat-card bg-lavender">
					<div class="stat-card-content">
						<div class="stat-icon-background">
							<i class="fas fa-circle-check"></i>
						</div>
						<div class="stat-text">
							<h6>Proses Pengajuan</h6>
							<h2>{{$pengajuanProses}}</h2>
						</div>
					</div>
					<div class="stat-graph">
					</div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-4">
			<a href="/laporan/stok/struk" class="stat-card-link">
				<div class="stat-card bg-mintgreen">
					<div class="stat-card-content">
						<div class="stat-icon-background">
							<i class="fas fa-ticket"></i>
						</div>
						<div class="stat-text">
							<h6>Pengembalian Karcis</h6>
							<h2>{{ number_format($totalJmlLembar) }}</h2>
						</div>
					</div>
					<div class="stat-graph">
					</div>
				</div>
			</a>
		</div>

		<div class="col-md-3 mb-4">
			<a href="/laporan/penerimaan" class="stat-card-link">
				<div class="stat-card bg-rosepink">
					<div class="stat-card-content">
						<div class="stat-icon-background">
							<i class="fas fa-dollar-sign"></i>
						</div>
						<div class="stat-text">
							<h6>Penerimaan Retribusi</h6>
							<h2>{{$formattedTotalSetor}}</h2>
						</div>
					</div>
					<div class="stat-graph">
					</div>
				</div>
			</a>
		</div>
	</div>
	<!-- END col-3 -->
</div>
<!-- END row -->

<!-- BEGIN row -->
<!-- BAGIAN berita -->

<div class="container-fluid mt-3">
@if ($news->isNotEmpty())
    <h1 class="mb-4">News</h1>
@endif
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
	<div class="row">
		@foreach ($news as $items)
		<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
			<div class="card border-0 shadow-sm rounded-3 h-100 w-100">
				@if($items->image)
				<img src="{{ asset('storage/image/' . $items->image) }}" style="height: 200px; object-fit: cover;" alt="Gambar Berita" class="card-img-top">
				@else
				<span class="p-3 text-muted">Tidak ada gambar</span>
				@endif
				<div class="card-body">
					<h5 class="card-title">{{ $items->title }}</h5>
					<p class="text-muted">{{ $items->created_at->format('M d, Y') }}</p>
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newsModal{{ $items->id }}">
						Selengkapnya
					</button>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="newsModal{{ $items->id }}" tabindex="-1" aria-labelledby="newsModalLabel{{ $items->id }}" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="newsModalLabel{{ $items->id }}">{{ $items->title }}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						@if($items->image)
						<img src="{{ asset('storage/image/' . $items->image) }}" alt="Gambar Berita" class="img-fluid w-100 mb-3" style="height: auto; max-height: 400px; object-fit: cover;">
						@else
						<span class="text-muted">Tidak ada gambar</span>
						@endif
						<p>{!! nl2br(e($items->content)) !!}</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection