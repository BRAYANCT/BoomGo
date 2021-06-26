<footer class="page-footer ">

    <div class="container text-center text-md-left py-5">
        <div class="row" style="margin-bottom: -1.5rem !important;">

            <div class="col-md-3 mb-4 pr-3">

                <img data-src="{{ asset(config('app.logo.md')) }}" class="lazy mb-4" width="100" >

                <p class="mb-4">
                    <a href="" class="btn btn-secondary-custom text-white px-3 py-2 m-0">
                        Quiénes somos
                    </a>
                </p>

                <p>
                    <a href="{{ config('app.contact_info.email') }}" class="text-white">
                        {{ config('app.contact_info.email') }}
                    </a>
                </p>

                <p>
                    <a href="{{ config('app.contact_info.cellphone.href') }}" class="text-white">
                        {{ config('app.contact_info.cellphone.display') }}
                    </a>
                </p>

                <p>
                    <a href="{{ config('app.social_media.whatsapp') }}" target="_blank" class="text-white mr-3">
                        <i class="{{ config('constant.icon.whatsapp.class') }}"></i>
                    </a>
                    <a href="{{ config('app.social_media.facebook') }}"  target="_blank"class="text-white mr-3">
                        <i class="{{ config('constant.icon.facebook.class') }}"></i>
                    </a>
                    <a href="{{ config('app.social_media.instagram') }}" target="_blank" class="text-white">
                        <i class="{{ config('constant.icon.instagram.class') }}"></i>
                    </a>
                </p>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase font-weight-bold mb-4 text-secondary-custom">
                    Información
                </h5>

                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="">Términos y condiciones de uso</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('privacy.policies') }}">
                            Políticas de privacidad
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('cookie.policies') }}">
                            Políticas de cookies
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('claims.create') }}">
                            Libro de reclamaciones
                        </a>
                    </li>
                </ul>

                <h5 class="text-uppercase font-weight-bold my-4 text-secondary-custom">
                    Enlaces
                </h5>
                <ul class="list-unstyled">
                    @if(!auth()->check())
                        <li class="mb-2">
                            <a href="{{ route('login') }}" >Iniciar sesión</a>
                        </li>
                        <li class="mb-2" >
                            <a href="{{ route('register') }}"   >Registrarme</a>
                        </li>
                    @endif
                    <li class="mb-2" >
                        <a href="{{ route('products.index') }}" >Tienda</a>
                    </li>

                    <li>
                        <a href="{{ route('products.index',['offer'=>1]) }}"  >Ofertas</a>
                    </li>
                </ul>

            </div>


            <div class="col-md-5 mb-4">
                <web-contact-create-form></web-contact-create-form>
            </div>


        </div><!--/row-->
    </div><!--/container-->

    <!--Copyright-->
    <div class="footer-copyright py-3 text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-md-left">
                    @php
                        $anioInicio = 2020;
                    @endphp
                    @if ($anioInicio < date('Y'))
                        © {{ $anioInicio }} - {{ date('Y') }}
                    @else
                        ©  {{ date('Y') }}
                    @endif
                    Boom Go
                </div>

                <div class="col-sm-6 text-md-right">
                    Desarrollado por <a href="https://waspsoluciones.com/" class="font-weight-bold" target="_blank" >
                        Wasp soluciones
                    </a>
                </div>
            </div>
        </div>
    </div><!--/ footer-copyright -->
</footer>
