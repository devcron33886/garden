<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li class="">
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('buy.products') }}">
                        Products
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="true">
                        Categories
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('buy.products',['cat'=>$category->name]) }}">
                                    <strong>{{ ucfirst(strtolower($category->name)) }}</strong>
                                    <span class="label label-danger pull-right">{{$category->products_count}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
