<nav id="navbar-top" class="navbar  fixed-top navbar-expand-lg scrolling-navbar ">
    <div class="container">
      <!-- Brand -->
        <a href="{{ route('index') }}" class="navbar-brand  mr-auto mx-md-auto pl-md-0 pl-4" href="{{ route('index') }}" title="Página de inicio">
        	<img src="{{ asset(config('app.logo.md')) }}" class="lazy" height="60" alt="logo" >
        </a>

        <a  class="icon-shopping-cart text-white d-block d-lg-none" href="{{ route('shopping_carts.index') }}" title="Ir a carrito de compras">
            <i class="{{ config('constant.icon.shopping_cart.class') }}"></i>
            <span class="counter shopping-cart-total-quantity" style="display:none"></span>
        </a>

        <a class="text-white d-block d-lg-none"  data-toggle="modal" data-target="#search-business-modal">
            <i class="fas fa-search "></i>
        </a>

        <button class="navbar-toggler button-collapse sidebarCollapse" type="button" >
            <i class="fas fa-bars text-white"></i>
        </button>

        <!-- Links -->
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto container-options-top ">
                @if(!Auth::check())
                    @if(Request::url() != route('login') )
                        <li class="nav-item text-center">
                            <a title="Login" href="{{ route('login') }}" class="btn btn-secondary-custom btn-rounded btn-sm " >
                                Iniciar sesión
                            </a>
                        </li>
                    @endif

                    @if(Request::url() != route('register') )
                        <li class="nav-item text-center">
                            <a title="Registrar cuenta" href="{{ route('register') }}" class="btn btn-secondary-custom btn-rounded btn-sm " >
                                Crea tu tienda virtual
                            </a>
                        </li>
                    @endif
                @endif

                @if (Auth::check() && !Auth::user()->business)
                    <li class="nav-item text-center">
                        <a title="Registrar negocio" href="{{ route('businesses_admin.businesses.profile.create_edit') }}" class="btn btn-secondary-custom btn-rounded btn-sm " >
                            Crea tu tienda virtual
                        </a>
                    </li>
                @endif

                <li class="nav-item ml-3">
                    <span class="nav-link text-white">Síguenos en:</span>
                </li>
                <li class="nav-item">
                    <a href="{{ config('app.social_media.facebook') }}" target="_blank" class="nav-link waves-effect waves-light">
                        <span class="icon-social">
                            <i class="{{ config('constant.icon.facebook.class') }}"></i>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ config('app.social_media.instagram') }}" target="_blank" class="nav-link waves-effect waves-light">
                        <span class="icon-social">
                            <i class="{{ config('constant.icon.instagram.class') }}"></i>
                        </span>
                    </a>
                </li>

                <li class="nav-item d-flex align-items-center nav-item-shopping-cart">
                    <a  class="nav-link text-white py-0" href="{{ route('shopping_carts.index') }}" title="Ir a carrito de compras">
                        <i class="{{ config('constant.icon.shopping_cart.class') }}"></i>
                        <span class="counter shopping-cart-total-quantity" style="display:none"></span>
                    </a>
                </li>

                @if (Auth::check())
                    @include('partials.menu.nav-item-dropdown-menu-avatar')
                @endif
            </ul>

             <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a title="Ir a inicio" href="{{ route('index') }}" class="btn btn-tertiary-custom btn-rounded btn-sm mb-0 " >
                        Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a title="Negocio cercanos" class="btn btn-tertiary-custom btn-rounded btn-sm mb-0 nearby-businesses" >
                       Negocio cercanos
                    </a>
                </li>

                <li class="nav-item dropdown mega-dropdown dropdown-hover">
{{--                            <a title="Ir a inicio" href="{{ route('index') }}" class="btn btn-tertiary-custom btn-rounded btn-sm " >--}}
{{--                                Categorías--}}
{{--                            </a>--}}
                    <a class="dropdown-toggle btn btn-tertiary-custom btn-rounded btn-sm mb-0"  data-toggle="dropdown">
                        Proveedores
                    </a>
                    <div class="dropdown-menu mega-menu py-5 px-3" >
                        <web-category-list-business-mega-menu></web-category-list-business-mega-menu>
                    </div>
                </li>


                <li class="nav-item nav-item-search">
                    <form action="{{ route('businesses.index') }}"  >
                        <div class="input-group input-icon-custom">
                            <div class="input-group-prepend click-action" >
                                <span class="input-group-text h-100" >
                                    <i class="fas fa-search text-grey"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Buscar restaurantes, barberías ..." name="search_text" required  />
                        </div>
                    </form>
                </li>
            </ul>

	    </div> <!--collapse navbar-collapse -->

    </div> <!-- container -->

{{--    <img data-src="{{ asset('images/menu-curve.svg')  }}" class="menu-curve lazy">--}}
    <svg class="menu-curve"  xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 1200 120" preserveAspectRatio="none" width="calc(248% + 1.3px)" height="161px" >
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
    </svg>
</nav><!-- Navbar -->
