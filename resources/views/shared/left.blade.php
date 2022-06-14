<div id="left-sidebar" class="sidebar shadow-sm">
    <button type="button" class="btn btn-xs btn-link btn-toggle-fullwidth">
        <span class="sr-only">Toggle Fullwidth</span>
        <i class="fa fa-angle-left"></i>
    </button>
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{{ asset('img/GARDEN_LOGO.png') }}" class="img-responsive  user-photo img-circle shadow-sm"
                 alt="Garden Of Eden Produce" style="width: 100px;height: 100px">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle user-name" data-toggle="dropdown">
                    Hello, <strong>{{ \Illuminate\Support\Facades\Auth::user()->name  }}
                    </strong> <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ route('admin.logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="nav-dahboard">
                    <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                </li>
                <li class="nav-categories">
                    <a href="{{ route('category.index') }}">
                        <i class="fa fa-list-ol"></i> <span>Categories</span>
                    </a>
                </li>
                <li class="nav-products">
                    <a href="{{ route('products.index') }}">
                        <i class="fa fa-list-ul"></i> <span>Products</span>
                    </a>
                </li>
                <li class="nav-orders">
                    <a href="{{ route('orders.index') }}">
                        <i class="fa fa-shopping-bag"></i> <span>Orders</span>
                    </a>
                </li>
                <li class="nav-users">
                    <a href="{{ route('users.index') }}">
                        <i class="fa fa-cog"></i> <span>Users</span>
                    </a>
                </li>
                <li class="nav-events">
                    <a href="{{ route('events.index') }}">
                        <i class="fa fa-clock-o"></i> <span>Event</span>
                    </a>
                </li>
                <li class="nav-newsletters">
                    <a href="{{ route('newsletters.index') }}">
                        <i class="fa fa-envelope"></i> <span>Newsletters</span>
                    </a>
                </li>
                <li class="nav-settings">
                    <a href="#uiElements" class="has-arrow" aria-expanded="false"><i class="lnr lnr-magic-wand"></i>
                        <span>Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li class=""><a href="{{ route('admin.settings') }}">System settings</a></li>
                        <li class=""><a href="{{ route('slides.index') }}">Home slides</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
