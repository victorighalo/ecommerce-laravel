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
        @if(Auth::user()->hasAnyRole(['admin', 'editor']))
        <li class="nav-item {{ Request::path() == 'office/category' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/category')}}">
                <i class="fas fa-boxes menu-icon"></i><span class="menu-title">Category</span></a>
        </li>
                <li class="nav-item {{ Request::path() == 'office/properties' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/properties')}}">
                <i class="fas fa-boxes menu-icon"></i><span class="menu-title">Properties</span></a>
        </li>
            <li class="nav-item {{ Request::path() == 'office/products' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/products')}}">
               <i class="fas fa-store menu-icon"></i> <span class="menu-title">Products</span></a>
        </li>
                @if(Auth::user()->hasRole('admin'))
            <li class="nav-item {{ Request::path() == 'orders' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/orders')}}">
                    <i class="fas fa-money-check menu-icon"></i><span class="menu-title">Orders</span></a>
        </li>
                    <li class="nav-item {{ Request::path() == 'delivery' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/delivery')}}">
                    <i class="fas fa-icon-shopping-cart menu-icon"></i><span class="menu-title">Delivery Settings</span></a>
        </li>
                <li class="nav-item {{ Request::path() == 'settings' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/settings')}}">
                    <i class="fas fa-cogs menu-icon"></i><span class="menu-title">Settings</span></a>
        </li>
                <li class="nav-item {{ Request::path() == 'users' ? 'active' : '' }}"><a class="nav-link" href="{{url('office/users')}}">
                    <i class="fas fa-users menu-icon"></i><span class="menu-title">Users</span></a>
        </li>
                @endif
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