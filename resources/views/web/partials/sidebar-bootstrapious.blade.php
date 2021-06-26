
<!-- Sidebar  -->
<nav id="sidebar" class="sidebar-hidden scrollbar scrollbar-near-moon thin">
    <div class="force-overflow">

        <div id="dismiss" >
            <i class="fas fa-arrow-left"></i>
        </div>

        <div class="sidebar-header">
            <a href="{{ route('index') }}" class="mx-auto" title="Página de inicio" >
                <img data-src="{{ asset(config('app.logo.md')) }}" class="img-fluid lazy" >
            </a>
        </div>

        <ul class="list-unstyled components">

            <p class="pt-0 mt-0 text-center">
                @if(!Auth::check())
                    @if(Request::url() != route('login') )
                        <a title="Login" href="{{ route('login') }}" class="btn btn-secondary-custom btn-rounded btn-sm " >
                            Iniciar sesión
                        </a>
                    @endif
                    @if(Request::url() != route('register') )
                        <a title="Registrar cuenta" href="{{ route('register') }}" class="btn btn-secondary-custom btn-rounded btn-sm " >
                            Crea tu tienda virtual
                        </a>
                    @endif
                @endif

                @if (Auth::check() && !Auth::user()->business)
                    <a title="Registrar negocio" href="{{ route('businesses_admin.businesses.profile.create_edit') }}" class="btn btn-secondary-custom btn-rounded btn-sm " >
                        Crea tu tienda virtual
                    </a>
                @endif


                <span class="d-block mb-3">Síguenos en:</span>
                <a href="{{ config('app.social_media.facebook')  }}" target="_blank" >
                    <span class="icon-social-custom">
                        <i class="{{ config('constant.icon.facebook.class') }}"></i>
                    </span>
                </a>
                <a href="{{ config('app.social_media.instagram')  }}" target="_blank">
                    <span class="icon-social-custom">
                        <i class="{{ config('constant.icon.instagram.class') }}"></i>
                    </span>
                </a>
            </p>
            <div class="mx-3 mb-3">
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
            </div>

            @if(Auth::check())
                <p  class="user-profile" >
                    <a href="{{ route('admin.users.profile.edit') }}" title="Ir a mi perfil">
                        @if (Auth::user()-> profile_picture)
                            <img data-src="{{ Auth::user()->getUrlImageResize('profile_picture',35,35,false,true) }}"  class="lazy rounded-circle">
                        @else
                            {{-- <i class="fas fa-user"></i> --}}
                            <img data-src="{{ asset(config('constant.icon.profile.svg'))  }}" width="35"  class="img-fluid lazy">
                        @endif

                        {{ Auth::user()-> first_name }}
                    </a>
                </p>
                @if(Auth::user()->business)
                    <p  class="user-profile" >
                        <a href="{{ route('businesses_admin.businesses.profile.create_edit') }}" title="Ir al administrador de mi negocio">
                            <img data-src="{{ Auth::user()->business->getUrlImageResize('logo',35,35,false,true) }}"  class="lazy rounded-circle">              
                            Mi negocio
                        </a>
                    </p>
                @endif

            @endif

            <li class="{{ MenuHelper::isCurrentUrl(route('index')) }}" >
                <a href="{{ route('index') }}" class="waves-effect" >
                    <i class="{{ config('constant.icon.home.class') }}"></i>
                    Inicio
                </a>
            </li>

            <web-category-list-business-item-side-bar>
            </web-category-list-business-item-side-bar>

            @if(Auth::check())

                <li class="{{ MenuHelper::isCurrentUrl(route('admin.users.profile.edit')) }}" >
                    <a href="{{ route('admin.users.profile.edit') }}" class="waves-effect" >
                        <i class="{{ config('constant.icon.profile.class') }}"></i>
                        Mi Perfil
                    </a>
                </li>

                <li>
                    <a href="#" class="waves-effect logout-action" >
                        <i class="{{ config('constant.icon.log_out.class') }}"></i>
                        Cerrar sesión
                    </a>
                </li>
            @endif
        </ul>
    </div><!--/force-overflow-->
</nav>

<div class="side-bar-overlay"></div>
