@extends('layouts.default', [
'paceTop' => true,
'appSidebarHide' => true,
'appHeaderHide' => true,
'appContentClass' => 'p-0'
])
<style>
	.news-image {
		background-size: cover;
		background-position: center;
		width: 100%;
		height: 100%;
		position: absolute;
		filter: blur(8px);
		opacity: 0.8;
	}
</style>

@section('title', 'Login Page')

@section('content')
<!-- BEGIN login -->
<div class="login login-with-news-feed">
	<!-- BEGIN news-feed -->
	<div class="news-feed">
		<div class="news-image" style="background-image: url(/assets/img/login-bg/pajak-kutai.jpg);"></div>
		<div class="news-caption text-left position-absolute w-100 h-75 d-flex flex-column justify-content-center align-items-left">
			<h1 class="caption-text text-white" style="font-size: 55px; font-family: 'Poppins', sans-serif; font-weight: 900;">
				Badan <br>Pendapatan <br>Daerah <br>Kota<br>Kutai<br>Kartanegara
			</h1>
			<div class="text-white mt-auto mb-3" style="font-size: 12px;">&copy; Copyright@Databumi</div>
		</div>
	</div>
	<!-- END news-feed -->

	<!-- BEGIN login-container -->
	<div class="login-container">
		<!-- BEGIN login-header -->
		<div class="login-header mb-30px">
			<div class="brand">
				<div class="d-flex justify-content-center align-items-center">
					<strong>Sistem <span class="spasi"></span> <span class="text-primary">e-Porporasi</span></strong>
				</div>
			</div>
		</div>
		<!-- END login-header -->

		<!-- BEGIN Alert Messages -->
		@if ($errors->any())
		<div class="alert alert-danger custom-alert">
			<strong>Error!</strong>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if (session('success'))
		<div class="alert alert-success custom-alert">
			<strong>Success!</strong> {{ session('success') }}
		</div>
		@endif
		<!-- END Alert Messages -->

		<!-- BEGIN login-content -->
		<div class="login-content">
			<form action="{{ route('login') }}" method="POST" class="fs-13px">
				@csrf
				<div class="form-floating mb-15px">
					<p class="custom-font">Username</p>
					<input type="text" class="form-control-login h-50px fs-15px" name="username" id="username" placeholder="Username" style="height: 100px; font-size: 20px; padding: 5px;" required />
				</div>
				<div class="form-floating mb-15px">
					<p class="custom-font">Password</p>
					<input type="password" class="form-control-login h-50px fs-15px" name="password" id="password" placeholder="Password" style="height: 100px; font-size: 20px; padding: 5px;" required />
				</div>

				<div class="mb-15px">
					<button type="submit" class="btn btn-primary d-block h-45px w-100 btn-lg fs-14px">Sign in</button>
				</div>
				<div class="text-gray-600 text-center text-gray-500-darker mb-0 spasi-bawah">
					&copy; Copyright@Databumi
				</div>
			</form>
		</div>
		<!-- END login-content -->
	</div>
	<!-- END login-container -->
</div>
<!-- END login -->
@endsection