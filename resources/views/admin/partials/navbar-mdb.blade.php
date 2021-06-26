
<nav id="navbar-top" class="navbar  fixed-top navbar-expand-lg scrolling-navbar double-nav">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand  mx-auto d-lg-none" href="{{ auth()->user()->getFirstPageAuth() }}" title="Página de inicio" >
            <img data-src="{{ asset(config('app.logo.md')) }}" class="lazy" height="60" alt="logo"   >
        </a>

        <button class="navbar-toggler button-collapse sidebarCollapse" type="button" >
            <i class="fas fa-bars text-white"></i>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" >

            <ul class="navbar-nav mr-auto">
                <li class="nav-item  active">
                    <a class="nav-link" href="{{ route('index') }}">
                        Ir a inicio
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto nav-flex-icons">

                @include('partials.menu.nav-item-dropdown-menu-avatar')

            </ul>

        </div><!--/ collapse navbar-collapse -->

    </div><!--/ container -->

</nav><!-- Navbar -->
