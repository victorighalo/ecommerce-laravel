<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image"><i class="far fa-user-circle" style="font-size: 70px; color: #333"></i> <span
                            class="online-status online"></span></div>
                <div class="profile-name">
                    @if(Auth::check())
                        <p class="name">{{Auth::user()->name}}</p>
                        <p class="designation">{{ucfirst(Auth::user()->getRoleNames()[0])}}</p>
                    @endif
                    {{--<div class="badge badge-teal mx-auto mt-3">Online</div>--}}
                </div>
            </div>
        </li>
        <li class="nav-item {{ Request::path() == '/' ? 'active' : '' }}"><a class="nav-link" href="{{url('/')}}">
                <i class="fas fa-chart-bar menu-icon"></i><span class="menu-title">Dashboard</span></a>
        </li>
        @if(Auth::check())
        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item {{ Request::path() == 'office/category' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/category')}}">
                <i class="fas fa-users menu-icon"></i><span class="menu-title">Category</span></a>
        </li>
            <li class="nav-item {{ Request::path() == 'office/products' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/products')}}">
               <i class="fas fa-people-carry menu-icon"></i> <span class="menu-title">Products</span></a>
        </li>
            <li class="nav-item {{ Request::path() == 'superagents' ? 'active' : '' }}"><a class="nav-link" href="{{url('superagents')}}">
                    <i class="fas fa-user-cog menu-icon"></i><span class="menu-title">Super Agents</span></a>
        </li>
        <li class="nav-item purchase-button  d-xs-block d-sm-none" >
            <a class="nav-link" href="{{ route('logout') }}"
               style="background: #553d67;"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
            @endif
            @endif
    </ul>
</nav>