<div>


    <div class="section">
        <!-- container -->
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    @if(Session::has('message'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success flat">
                                    <p>
                                        <i class="fa fa-check-circle"></i>
                                        {{ Session::get('message') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="section">
                <!-- container -->
                <div class="container">
                    @if(count($slides)>0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="carousel-image div-hide">
                                    @foreach($slides as $item)
                                        <div style="height: 350px;overflow-y: hidden;background-image: url({{ $item->image_url }});display: flex;align-items: center;justify-content: center;flex-direction: column;background-size: cover;background-repeat: no-repeat">
                                            {{-- <img class="lozad"
                                                  data-src=""
                                                  alt="First slide"
                                                  style=";width: 100%" src="">--}}
                                            @if($item->show_text)
                                                <h2>{{$item->header}}</h2>
                                                <div class="">
                                                    <p>
                                                        {{$item->description}}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <div class="carousel-image div-hide">
                                    <div>
                                        <img class="lozad"
                                             data-src="https://www.gardenofedenrwanda.com/carousel/1533157040.jpg"
                                             alt="First slide"
                                             style="max-height: 350px;" src="">
                                    </div>
                                    <div>
                                        <img class="lozad"
                                             data-src="https://www.gardenofedenrwanda.com/carousel/1533153168.jpg"
                                             alt="First slide"
                                             style="max-height: 350px;" src="">
                                    </div>
                                    <div>
                                        <img class="lozad"
                                             data-src="https://www.gardenofedenrwanda.com/carousel/1541062003.jpg"
                                             alt="First slide"
                                             style="max-height: 350px;" src="">
                                    </div>
                                    <div>
                                        <img class="lozad"
                                             data-src="https://www.gardenofedenrwanda.com/carousel/WhatsApp Image 2018-11-19 at 12.16.59 PM (1).jpeg"
                                             alt="Second slide" style="max-height: 350px;" src="">
                                    </div>
                                    <div>
                                        <img class="lozad"
                                             data-src="https://www.gardenofedenrwanda.com/carousel/WhatsApp Image 2018-11-19 at 12.16.58 PM (1).jpeg"
                                             alt="Third slide" style="max-height: 350px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="padding-30-not-sm">
                                    <h3 class="text-uppercase text-center header">Garden Of Eden Produce</h3>
                                    <div class="h2 text-left animate">
                                        <div class="your-class div-hide">
                                            <div>
                                                Garden of Eden Produce provides Organic Rwandan fruit and vegetables at
                                                affordable prices.
                                            </div>
                                            <div>
                                                With more than 26 years of organic farming experience,we specialize in
                                                high
                                                quality,great tasting produce.
                                            </div>
                                            <div>
                                                We serve and deliver to residential homes,business,restaurant and
                                                hotels.
                                            </div>
                                            <div>
                                                Check out our online market and start enjoying Organic Rwandan produce
                                                today.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
                <!-- /container -->
            </div>

        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


    <div class="container">

    </div>


    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Products</h3>
                        <div class="section-nav">
                        </div>
                    </div>
                </div>
                <!-- /section title -->
                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        @foreach(\App\Product::with('category')->where('status','=','available')->limit(4)->get()->take(10) as $item)
                            <div class="col-md-3 col-xs-6">
                                <livewire:card-product
                                        :product="$item"
                                        label="NEW"/>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>
                    </div>
                    <div class="row">
                        <!-- /section title -->
                        <!-- Products tab & slick -->
                        @foreach(\App\Product::with('category')->orderBy('id','desc')->limit(4)->get() as $item)
                            <div class="col-md-3 col-sm-6">
                                <livewire:card-product
                                        :product="$item"
                                        label=""/>
                            </div>
                        @endforeach
                    </div>
                    <!-- Products tab & slick -->
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <?php
                $i = 0;
                ?>
                @foreach($categories as $category)
                    @if($category->products->count()>=4)
                        <?php $i++; ?>
                        <div class="col-md-4 col-xs-6">
                            <div class="section-title">
                                <h4 class="title">{{ $category->name }}
                                </h4>
                                <div class="section-nav">
                                    <div id="slick-nav-3" class="products-slick-nav"></div>
                                    <span class="pull-right">
                                        <a href="{{ route('buy.products',['cat'=>$category->name]) }}">
                                            More
                                        <i class="fa fa-arrow-circle-o-right"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>

                            <div class="products-widget-slick category-info" data-nav="#slick-nav-3">
                                <div>
                                    @foreach($category->products->take(4) as $product)
                                        <livewire:small-card-product :product="$product"/>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{--<div class="clearfix visible-sm visible-xs"></div>--}}
                        <?php
                        if ($i == 3)
                        {
                            goto label;
                        }
                        ?>
                    @endif
                @endforeach
                <?php
                label:
                ?>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <!-- container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Card accepted</h3>
                    <div class="center" data-slick='{"slidesToShow": 4, "slidesToScroll": 4}'>
                        <div class="card-container">
                            <img data-src="{{ asset('Cards/visa-2623015_960_720.png') }}" class="lozadimg-responsive "
                                 alt="" src="">
                        </div>
                        <div class="card-container">
                            <img data-src="{{ asset('Cards/1280px-UnionPay_logo.svg.png') }}"
                                 class="lozadimg-responsive " alt="" src="">
                        </div>
                        <div class="card-container">
                            <img data-src="{{ asset('Cards/mtn-mobile-money-logo-AD1D8B5CE4-seeklogo.com.jpg') }}"
                                 class="lozadimg-responsive " alt="" src="">
                        </div>
                        <div class="card-container">
                            <img data-src="{{ asset('Cards/2000px-Mastercard-logo.png') }}"
                                 class="lozad img-responsive " alt="" src="">
                        </div>

                        <div class="card-container">
                            <img data-src="{{ asset('Cards/Diners_Club_Logo3.svg.png') }}" class="lozad img-responsive "
                                 alt="" src="">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>

        </div>
        <!-- /container -->
    </div>
    <!-- /NEWSLETTER -->
</div>
