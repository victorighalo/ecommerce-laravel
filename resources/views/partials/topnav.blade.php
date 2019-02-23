<nav class="navbar col-lg-12 col-12 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center" style="background: transparent;">
        <a class="navbar-brand brand-logo" href="{{url('/')}}">Logo</a>
        <a class="navbar-brand brand-logo-mini" href="{{url('/')}}"><i class="fab fa-lyft" style="font-size: 50px; color: #fff"></i></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">

        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link dropdown-toggle" id="accountDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-user-circle" style="font-size: 30px; color: #fff"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="accountDropdown">
                    <a class="dropdown-item"> Profile </a>
                    <a class="dropdown-item"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"
                    > Sign Out </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>