<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta http-equiv="x-ua-compatible" content="ie=edge">
  	<meta content="ie=edge" http-equiv="x-ua-compatible"/>
  	<meta content="{{ csrf_token() }}" name="csrf-token"/>

	@if (Auth::check())
		<meta content="{{ Auth::user()-> api_token }}" name="api-token"/>
	@endif

	<title>Admin - @yield('title')</title>

    @laravelPWA

	<meta name="googlebot" content="noindex,nofollow">
	<meta name="robots" content="noindex,nofollow">

	<style type="text/css">

		#spin-loader{display:flex;flex-direction: column;position:fixed;width:100vw;height:100vh;align-items:center;justify-content:center}

		.sk-three-bounce{margin:40px auto;width:80px;text-align:center}.sk-three-bounce .sk-child{width:20px;height:20px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:sk-three-bounce 1.4s ease-in-out 0s infinite both;animation:sk-three-bounce 1.4s ease-in-out 0s infinite both}.sk-three-bounce .sk-bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.sk-three-bounce .sk-bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes sk-three-bounce{0%,100%,80%{-webkit-transform:scale(0);transform:scale(0)}40%{-webkit-transform:scale(1);transform:scale(1)}}@keyframes sk-three-bounce{0%,100%,80%{-webkit-transform:scale(0);transform:scale(0)}40%{-webkit-transform:scale(1);transform:scale(1)}}

	</style>

	<script src="{!! asset('plugins/loadCSS/load-onload-css.min.js') !!}" ></script>

	<script id="loadCss" >

        const authCheck = new Boolean("{{ auth()->check() }}").valueOf();
        const configRoles = @json( config('constant.role') );
        const authRole = @json(  auth()->check() ? auth()->user()->getRole() : null );

        const configAttributes = @json( config('constant.attribute') );
        const configButtons = @json( config('constant.button') );
        const configIcons = @json( config('constant.icon') );
        const configImage = @json( config('constant.image') );
        const langButtons = @json( __('button') );
        const langHelpers = @json( __('helper') );

        let urlPagina = "{{ url('/')}}";
		let elementLoadCss = document.getElementById("loadCss");


		let adminCSS = loadCSS( '{{ mix("css/admin.css") }}',elementLoadCss);
      	onloadCSS(adminCSS,function(){
            setTimeout(function(){
                document.onreadystatechange = loaderPage();
                  // document.getElementsByTagName("app").onload = loaderPage();
            },300);
      	});

      	//datatables
   		loadCSS(urlPagina+"/css/datatables.css",elementLoadCss);

   		// //fileinput
   		loadCSS(urlPagina+"/css/bootstrap-fileinput.css",elementLoadCss);

   		// //select2
   		loadCSS(urlPagina+"/css/select2.css",elementLoadCss);

      	//fontawesome
   		loadCSS(urlPagina+"/plugins/fontawesome-free-5.11.2-web/css/all.css",elementLoadCss);

   		// //fancybox
   		// loadCSS(urlPagina+"/plugins/fancybox-master/dist/jquery.fancybox.min.css",elementLoadCss);

   		// datepicker
        @if(isset($datepicker))
   		    loadCSS(urlPagina+"/css/bootstrap-datepicker.css",elementLoadCss);
        @endif

        loadCSS(urlPagina+"/fonts/biotif.css",elementLoadCss);
	</script>

	<script type="text/javascript">
	    function loaderPage(){

	       // setTimeout(function(){
	          let preload = document.getElementById("spin-loader");
	          preload.style.display = "none";
	          preload.style.opacity = "0";
	          let app =  document.getElementById("app");

	          app.style.opacity = "1";

	      // }, 0);

	   }
	</script>

	@yield('css')

</head>
<body class="fixed-sn admin">
	<form id="form-logout" action="{{ route('logout') }}" style="display: none" method="POST">
		{{ csrf_field() }}
	</form>

	<div id="spin-loader">
		<img src="{{ asset(config('app.logo.spinner')) }}" alt="logo spinner"  width="150"  >

		<div class="sk-three-bounce">
        	<div class="sk-child sk-bounce1"></div>
        	<div class="sk-child sk-bounce2"></div>
        	<div class="sk-child sk-bounce3"></div>
      	</div>
  	</div>
  	<div id="app" style="opacity:0">
  		<header id="header" class="">

  			{{-- navbar --}}
  			@include('admin.partials.navbar-mdb')


  		</header>
  		@include('admin.partials.sidebar-bootstrapious')

  		<main>
  			@yield('content')
  		</main>

  		@include('partials.footer.main-footer')

  	</div><!--/app-->

  	<script id="admin-js" defer src="{{ mix('js/admin.js') }}"  ></script>
  	 {{-- <script defer src="{{ asset('js/datatables.js') }}" id="datatables-js" ></script> --}}

  	@yield('script')

  	@include('partials.modal-message')

  	<script type="text/javascript">

  	 	let adminjs = document.getElementById('admin-js');

  	 	adminjs.addEventListener('load',e => {
  	 		if(typeof inicializar === 'function') {
			    inicializar();
			}

  	 		mensajeModal();
  	 	});

   	</script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '227916178899232');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=227916178899232&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
</body>
</html>
