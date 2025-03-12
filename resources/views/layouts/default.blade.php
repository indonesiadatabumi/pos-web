<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
	<!-- PWA  -->
	<meta name="theme-color" content="#6777ef"/>
	<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
	<link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
@php
	$bodyClass = (!empty($appBoxedLayout)) ? 'boxed-layout ' : '';
	$bodyClass .= (!empty($paceTop)) ? 'pace-top ' : $bodyClass;
	$bodyClass .= (!empty($bodyClass)) ? $bodyClass . ' ' : $bodyClass;
	$appSidebarHide = (!empty($appSidebarHide)) ? $appSidebarHide : '';
	$appHeaderHide = (!empty($appHeaderHide)) ? $appHeaderHide : '';
	$appSidebarTwo = (!empty($appSidebarTwo)) ? $appSidebarTwo : '';
	$appSidebarSearch = (!empty($appSidebarSearch)) ? $appSidebarSearch : '';
	$appTopMenu = (!empty($appTopMenu)) ? $appTopMenu : '';
	
	$appClass = (!empty($appTopMenu)) ? 'app-with-top-menu ' : '';
	$appClass .= (!empty($appHeaderHide)) ? 'app-without-header ' : ' app-header-fixed ';
	$appClass .= (!empty($appSidebarEnd)) ? 'app-with-end-sidebar ' : '';
	$appClass .= (!empty($appSidebarLight)) ? 'app-with-light-sidebar ' : '';
	$appClass .= (!empty($appSidebarWide)) ? 'app-with-wide-sidebar ' : '';
	$appClass .= (!empty($appSidebarHide)) ? 'app-without-sidebar ' : '';
	$appClass .= (!empty($appSidebarMinified)) ? 'app-sidebar-minified ' : '';
	$appClass .= (!empty($appSidebarTwo)) ? 'app-with-two-sidebar app-sidebar-end-toggled ' : '';
	$appClass .= (!empty($appSidebarHover)) ? 'app-with-hover-sidebar ' : '';
	$appClass .= (!empty($appContentFullHeight)) ? 'app-content-full-height ' : '';
	
	$appContentClass = (!empty($appContentClass)) ? $appContentClass : '';
@endphp
<body class="{{ $bodyClass }}">
	@include('includes.component.page-loader')
	
	<div id="app" class="app app-sidebar-fixed {{ $appClass }}">
		
		@includeWhen(!$appHeaderHide, 'includes.header')
		
		@includeWhen($appTopMenu, 'includes.top-menu')
		
		@includeWhen(!$appSidebarHide, 'includes.sidebar')
		
		@includeWhen($appSidebarTwo, 'includes.sidebar-right')
		
		<div id="content" class="app-content {{ $appContentClass }}">
			@yield('content')
		</div>
		
		@include('includes.component.scroll-top-btn')
		
		{{-- @include('includes.component.theme-panel') --}}
		
	</div>
	@yield('outside-content')
	@include('includes.page-js')
	@stack('scripts')

	<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('/sw.js') }}"></script>
<script>
   if ("serviceWorker" in navigator) {
      // Register a service worker hosted at the root of the
      // site using the default scope.
      navigator.serviceWorker.register("/sw.js").then(
      (registration) => {
         console.log("Service worker registration succeeded:", registration);
      },
      (error) => {
         console.error(`Service worker registration failed: ${error}`);
      },
    );
  } else {
     console.error("Service workers are not supported.");
  }
</script>

</body>
</html>
