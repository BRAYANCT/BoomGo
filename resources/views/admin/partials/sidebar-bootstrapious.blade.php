
   <!-- Sidebar  -->
    <nav id="sidebar" class="sidebar-display-lg scrollbar scrollbar-near-moon thin">
        <div class="force-overflow">

            <div id="dismiss" class="d-lg-none">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                {{-- <h3>Bootstrap Sidebar</h3> --}}
                <a href="{{ Auth::user()->getFirstPageAuth() }}" class="mx-auto" title="Página de inicio" >
                    <img data-src="{{ asset(config('app.logo.md')) }}" class="img-fluid lazy" >
                </a>
            </div>

            <ul class="list-unstyled components">

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

     {{--            @if(Auth::user()->business)
                    <p  class="user-profile" >
                        <a href="{{ route('businesses_admin.businesses.profile.create_edit') }}" title="Ir al administrador de mi negocio">
                            <img data-src="{{ Auth::user()->business->getUrlImageResize('logo',35,35,false,true) }}"  class="lazy rounded-circle">
                            Mi negocio
                        </a>
                    </p>
                @endif --}}

                <li>
                    <a href="{{ route('index') }}" class="waves-effect" >
                        <i class="{{ config('constant.icon.home.class') }}"></i>
                        Inicio
                    </a>
                </li>

                @if(MenuHelper::isPatternUrl('businesses-admin/*'))

                    <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.businesses.profile.create_edit')) }}" >
                        <a href="{{ route('businesses_admin.businesses.profile.create_edit') }}" class="waves-effect" >
                            <i class="{{ config('constant.icon.business.class') }}"></i>
                            Mi Negocio
                        </a>
                    </li>
                    @if(auth()->user()->business)

                        @php
                            $currentArrayUrl = [
                                route('businesses_admin.products.index'),
                                route('businesses_admin.products.create'),
                            ];
                        @endphp

                        <li class="{{ MenuHelper::isCurrentArrayUrl($currentArrayUrl) }}">
                            <a href="#menu-products" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" >
                                <i class="{{ config('constant.icon.products.class') }}"></i>
                                Productos
                            </a>

                            <ul class="collapse list-unstyled {{ MenuHelper::isCurrentArrayUrl($currentArrayUrl,'show') }}" id="menu-products">
                                <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.products.index')) }}">
                                    <a href="{{ route('businesses_admin.products.index') }}" class="waves-effect" >
                                        Lista de productos
                                    </a>
                                </li>
                                <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.products.create')) }}">
                                    <a href="{{ route('businesses_admin.products.create') }}" class="waves-effect" >
                                        Registrar Producto
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.orders.auth_user_business.index')) }}" >
                            <a href="{{ route('businesses_admin.orders.auth_user_business.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.orders.class') }}"></i>
                                Mis Pedidos
                            </a>
                        </li>

                        <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.shipping.index')) }}" >
                            <a href="{{ route('businesses_admin.shipping.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.shipping.class') }}"></i>
                                Envíos
                            </a>
                        </li>

                        <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.business_payment_method.index')) }}" >
                            <a href="{{ route('businesses_admin.business_payment_method.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.payment_methods.class') }}"></i>
                                Métodos de pago
                            </a>
                        </li>

                    @endif

                @else

                    @if (Auth::user()-> isAdminSys() || Auth::user()-> isAdmin() )

                        @php
                            $currentArrayUrl = [route('admin.users.index'),route('admin.users.create')];
                        @endphp

                        <li class="{{ MenuHelper::isCurrentArrayUrl($currentArrayUrl) }}">
                            <a href="#menu-users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" >
                                <i class="{{ config('constant.icon.users.class') }}"></i>
                                Usuarios
                            </a>

                            <ul class="collapse list-unstyled {{ MenuHelper::isCurrentArrayUrl($currentArrayUrl,'show') }}" id="menu-users">
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.users.index')) }}">
                                    <a href="{{ route('admin.users.index') }}" class="waves-effect" >
                                        Lista de usuarios
                                    </a>
                                </li>
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.users.create')) }}">
                                    <a href="{{ route('admin.users.create') }}" class="waves-effect" >
                                        Registrar Usuario
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @php
                            $currentArrayUrl = [
                                route('admin.businesses.index'),
                                route('admin.businesses.create'),
                                route('admin.categories.category_type_slug.index',config('constant.categorytype.business_slug')),
                            ];
                        @endphp


                        <li class="{{ MenuHelper::isCurrentArrayUrl($currentArrayUrl) }}">
                            <a href="#menu-businesses" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" >
                                <i class="{{ config('constant.icon.businesses.class') }}"></i>
                                Negocios
                            </a>

                            <ul class="collapse list-unstyled {{ MenuHelper::isCurrentArrayUrl($currentArrayUrl,'show') }}" id="menu-businesses">
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.businesses.index')) }}">
                                    <a href="{{ route('admin.businesses.index') }}" class="waves-effect" >
                                        Lista de negocios
                                    </a>
                                </li>
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.businesses.create')) }}">
                                    <a href="{{ route('admin.businesses.create') }}" class="waves-effect" >
                                        Registrar Negocio
                                    </a>
                                </li>
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.categories.category_type_slug.index',config('constant.categorytype.business_slug'))) }}">
                                    <a href="{{ route('admin.categories.category_type_slug.index',config('constant.categorytype.business_slug')) }}" class="waves-effect" >
                                        Categorías
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @php
                            $currentArrayUrl = [
                                route('admin.products.index'),
                                route('admin.products.create'),
                                route('admin.categories.category_type_slug.index',config('constant.categorytype.product_slug')),
                            ];
                        @endphp

                        <li class="{{ MenuHelper::isCurrentArrayUrl($currentArrayUrl) }}">
                            <a href="#menu-products" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" >
                                <i class="{{ config('constant.icon.products.class') }}"></i>
                                Productos
                            </a>

                            <ul class="collapse list-unstyled {{ MenuHelper::isCurrentArrayUrl($currentArrayUrl,'show') }}" id="menu-products">
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.products.index')) }}">
                                    <a href="{{ route('admin.products.index') }}" class="waves-effect" >
                                        Lista de productos
                                    </a>
                                </li>
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.products.create')) }}">
                                    <a href="{{ route('admin.products.create') }}" class="waves-effect" >
                                        Registrar Producto
                                    </a>
                                </li>
                                <li class="{{ MenuHelper::isCurrentUrl(route('admin.categories.category_type_slug.index',config('constant.categorytype.product_slug'))) }}">
                                    <a href="{{ route('admin.categories.category_type_slug.index',config('constant.categorytype.product_slug')) }}" class="waves-effect" >
                                        Categorías
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="{{ MenuHelper::isCurrentUrl(route('admin.orders.index')) }}" >
                            <a href="{{ route('admin.orders.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.orders.class') }}"></i>
                                Pedidos
                            </a>
                        </li>

                        <li class="{{ MenuHelper::isCurrentUrl(route('admin.shipping.index')) }}" >
                            <a href="{{ route('admin.shipping.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.shipping.class') }}"></i>
                                Envíos
                            </a>
                        </li>

                        <li class="{{ MenuHelper::isCurrentUrl(route('admin.business_payment_method.index')) }}" >
                            <a href="{{ route('admin.business_payment_method.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.payment_methods.class') }}"></i>
                                Métodos de pago
                            </a>
                        </li>

                    @endif

                    @if(Auth::user()->business)
                        <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.businesses.profile.create_edit')) }}" >
                            <a href="{{ route('businesses_admin.businesses.profile.create_edit') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.business.class') }}"></i>
                                Mi Negocio
                            </a>
                        </li>
                    @else
                        <li class="{{ MenuHelper::isCurrentUrl(route('businesses_admin.businesses.profile.create_edit')) }}" >
                            <a href="{{ route('businesses_admin.businesses.profile.create_edit') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.business.class') }}"></i>
                                Crear negocio
                            </a>
                        </li>
                    @endif

                    <li class="{{ MenuHelper::isCurrentUrl(route('admin.orders.menu_auth_user.index')) }}" >
                        <a href="{{ route('admin.orders.menu_auth_user.index') }}" class="waves-effect" >
                            <i class="{{ config('constant.icon.orders.class') }}"></i>
                            Mis compras
                        </a>
                    </li>



                    @can('admin_claims_index')
                        <li class="{{ MenuHelper::isCurrentUrl(route('admin.claims.index')) }}" >
                            <a href="{{ route('admin.claims.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.claim.class') }}"></i>
                                Libro de reclamos
                            </a>
                        </li>
                    @endcan

                    @can('admin_contacts_index')
                        <li class="{{ MenuHelper::isCurrentUrl(route('admin.contacts.index')) }}" >
                            <a href="{{ route('admin.contacts.index') }}" class="waves-effect" >
                                <i class="{{ config('constant.icon.contact.class') }}"></i>
                                Contactos
                            </a>
                        </li>
                    @endcan



                @endif




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
            </ul>
        </div><!--/force-overflow-->
    </nav>

    <div class="side-bar-overlay"></div>
