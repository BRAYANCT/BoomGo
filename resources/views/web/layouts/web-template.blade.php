<!DOCTYPE html>
<html lang="es">
@php
    if(!isset($urlImgPage)){
        $urlImgPage = config('app.logo.md');
    }

    if(!isset($imgWidth)){
       $imgWidth = 500;
    }

    if(!isset($imgHeight)){
       $imgHeight = 500;
    }

@endphp
<head>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta http-equiv="x-ua-compatible" content="ie=edge">
  	<meta content="ie=edge" http-equiv="x-ua-compatible"/>
  	<meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta content="index,follow,snippet,archive" name="googlebot"/>
    <meta content="index,follow" name="robots"/>

    @if (Auth::check())
        <meta content="{{ Auth::user()-> api_token }}" name="api-token"/>
    @endif

	<title>@yield('title')</title>

    <meta content="@yield('description')" name="description"/>

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="@yield('title')" />
    <meta itemprop="description" content="@yield('description')" />
    <meta itemprop="image" content="{{ $urlImgPage }}" />

    <!-- facebook -->
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />

    <meta property="og:image" content="{{ $urlImgPage }}" />
    <meta property="og:image:width" content="{{ $imgWidth }}" />
    <meta property="og:image:height" content="{{ $imgHeight }}" />

    <meta property="og:locale" content="es_PE" />
    <meta property="og:site_name" content="{{config('app.name')}}" />
{{--    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />--}}

<!-- Twitter Card data -->
    <!-- <meta name="twitter:card" content="product">-->
    <meta name="twitter:site" content="{{ Request::url() }}" />
    <meta name="twitter:title" content="@yield('title')" />
    <meta name="twitter:description" content="@yield('description')" />
{{--    <meta name="twitter:creator" content="{{ $autor }}" />--}}
    <meta name="twitter:image" content="{{ $urlImgPage }}" />

    @laravelPWA



	<style type="text/css">

		#spin-loader{display:flex;flex-direction: column;position:fixed;width:100vw;height:100vh;align-items:center;justify-content:center}

		.sk-three-bounce{margin:40px auto;width:80px;text-align:center}.sk-three-bounce .sk-child{width:20px;height:20px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:sk-three-bounce 1.4s ease-in-out 0s infinite both;animation:sk-three-bounce 1.4s ease-in-out 0s infinite both}.sk-three-bounce .sk-bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.sk-three-bounce .sk-bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes sk-three-bounce{0%,100%,80%{-webkit-transform:scale(0);transform:scale(0)}40%{-webkit-transform:scale(1);transform:scale(1)}}@keyframes sk-three-bounce{0%,100%,80%{-webkit-transform:scale(0);transform:scale(0)}40%{-webkit-transform:scale(1);transform:scale(1)}}

	</style>

	<script src="{!! asset('plugins/loadCSS/load-onload-css.min.js') !!}" ></script>

	<script id="loadCss" >

        const authCheck = new Boolean("{{ auth()->check() }}").valueOf();
        const configRoles = @json( auth()->check() ? config('constant.role') : null );
        const authRole = @json(  auth()->check() ? auth()->user()->getRole() : null );

        const configAttributes = @json( config('constant.attribute') );
        const configButtons = @json( config('constant.button') );
        const configIcons = @json( config('constant.icon') );
        const langButtons = @json( __('button') );
        const langHelpers = @json( __('helper') );

		let urlPagina = "{{ url('/')}}";
		let elementLoadCss = document.getElementById("loadCss");


		let webCSS = loadCSS('{{ mix("css/web.css") }}',elementLoadCss);
      	onloadCSS(webCSS,function(){
            setTimeout(function(){
                document.onreadystatechange = loaderPage();
                  // document.getElementsByTagName("app").onload = loaderPage();
            },300);
      	});

      	//fontawesome
   		loadCSS(urlPagina+"/plugins/fontawesome-free-5.11.2-web/css/all.css",elementLoadCss);

   		@if(isset($loadSelect2))
            loadCSS(urlPagina+"/css/select2.css",elementLoadCss);
        @endif

        loadCSS(urlPagina+"/fonts/biotif.css",elementLoadCss);

    </script>

	<script type="text/javascript">
	    function loaderPage(){
	          let preload = document.getElementById("spin-loader");
	          preload.style.display = "none";
	          preload.style.opacity = "0";
	          let app =  document.getElementById("app");

	          app.style.opacity = "1";
	   }
	</script>

	@yield('css')

</head>
<body class="web {{ isset($classTagBody) ? $classTagBody : '' }}" >

    <form id="form-logout" action="{{ route('logout') }}" style="display: none" method="POST">
        {{ csrf_field() }}
    </form>

	<div id="spin-loader">
		<img src="{{ asset(config('app.logo.spinner')) }}" alt="logo spinner" width="150"  >

		<div class="sk-three-bounce">
        	<div class="sk-child sk-bounce1"></div>
        	<div class="sk-child sk-bounce2"></div>
        	<div class="sk-child sk-bounce3"></div>
      	</div>
  	</div>
  	<div id="app" style="opacity:0">
  		<header id="header" class="">

            <div id="content-btn-menu-fixed" class="fixed-bottom" >
                @if(isset($isPageBusiness))
                    @if($business->whatsapp)
                        <a href="https://api.whatsapp.com/send?phone=51{{ $business->whatsapp }}" target="_blank"  title="Escríbenos al WhatsApp."  class="btn-floating btn-success btn-lg "  >
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif
                @else
                    <a href="{{ config('app.social_media.whatsapp') }}" target="_blank"  title="Escríbenos al WhatsApp."  class="btn-floating btn-success btn-lg "  >
                        <i class="fab fa-whatsapp"></i>
                    </a>
                @endif
            </div>


  			{{-- navbar --}}
  			@include('web.partials.navbar-mdb')
  		</header>

        @include('web.partials.sidebar-bootstrapious')

  		<main class="{{ isset($classTagMain) ? $classTagMain : '' }}">
  			@yield('content')
  		</main>

  		@include('partials.footer.main-footer')

        <auth-login-modal></auth-login-modal>

        <web-product-detail-modal></web-product-detail-modal>

        <web-business-filter-modal></web-business-filter-modal>

    </div><!--/app-->



  	<script id="web-js" defer src="{{ mix('js/web.js') }}"  ></script>
  	 {{-- <script defer src="{{ asset('js/datatables.js') }}" id="datatables-js" ></script> --}}

  	@yield('script')

  	@include('partials.modal-message')

  	<script type="text/javascript">

  	 	let webjs = document.getElementById('web-js');

  	 	webjs.addEventListener('load',e => {
  	 		if(typeof inicializar === 'function') {
			    inicializar();
			}
  	 		mensajeModal();
  	 	});

        window.addEventListener("scroll", (event) => {
            let scroll = this.scrollY;
            var body = document.body;
            if(scroll>10){
                body.classList.add("has-scroll-y");
            }else{
                body.classList.remove('has-scroll-y')
            }
            // console.log(scroll)

            fg.btnFilterFixedToggleDisplay(scroll);
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
