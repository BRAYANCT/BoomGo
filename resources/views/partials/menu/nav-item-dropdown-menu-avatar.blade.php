<li class="nav-item dropdown nav-item-avatar">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if (Auth::check())
            {{ Auth::user()-> username }}
        @endif

        @if (Auth::user()-> profile_picture)
            <img data-src="{{ Auth::user()->getUrlImageResize('profile_picture',40,40,false,true) }}"  class="lazy rounded-circle">
        @else
            <img data-src="{{ asset(config('constant.icon.profile.svg'))  }}" width="35"  class="img-fluid lazy">
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-default" >

        <a class="dropdown-item" href="{{ route('index') }}">
            <i class="{{ config('constant.icon.home.class') }}"></i> Inicio
        </a>

        <a class="dropdown-item" href="{{ route('admin.users.profile.edit') }}">
            <i class="{{ config('constant.icon.profile.class') }}"></i> Mi perfil
        </a>

        @if(Auth::user()->business)
            <a class="dropdown-item" href="{{ route('businesses_admin.businesses.profile.create_edit') }}">
                {{--                                <i class="{{ config('constant.icon.profile.class') }}"></i>--}}
                <img data-src="{{ Auth::user()->business->getUrlImageResize('logo',30,30,false,true) }}"  class="lazy rounded-circle">
                Mi negocio
            </a>
        @else
            <a class="dropdown-item" href="{{ route('businesses_admin.businesses.profile.create_edit') }}">
                <i class="{{ config('constant.icon.business.class') }}"></i> Crear negocio
            </a>
        @endif

        <a class="dropdown-item logout-action"  >
            <i class="{{ config('constant.icon.log_out.class') }}"></i> Cerrar sesión
        </a>
    </div>
</li>
