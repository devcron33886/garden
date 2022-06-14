<?php
$mail = $defaultSetting->email1;
$whatsapp = \App\MyFunc::format_phone_us($defaultSetting->whatsapp);
$phone = \App\MyFunc::format_phone_us($defaultSetting->phoneNumber1);
$phone2 = \App\MyFunc::format_phone_us($defaultSetting->phoneNumber2);
$address = $defaultSetting->address;
$about = $defaultSetting->about;
?>
<!-- row -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="newsletter" style="margin-top: 50px;">
                <p>Subscribe to our <strong>NEWSLETTER</strong></p>
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <i class="fa fa-check-circle-o"></i>
                        {{  session()->get('success') }}
                    </div>
                @endif
                <form action="{{ route('newsletters.subscribe') }}" method="post">
                    @csrf
                    <label for="email" class="sr-only"></label>
                    <input class="input" name="email" id="email" type="email" placeholder="Enter Your Email">
                    <button class="newsletter-btn" type="submit"><i class="fa fa-envelope"></i> Subscribe
                    </button>
                </form>


                <h3>Get in touch with us</h3>


                <ul class="newsletter-follow">
                    <li>
                        <a href="https://www.facebook.com/EdenofGardenProducer" target="_blank"><i
                                    class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="https://twitter.com/" target="_blank"><i
                                    class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/garden_of_eden_produce/" target="_blank"><i
                                    class="fa fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/" target="_blank"><i
                                    class="fa fa-youtube-play"></i></a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<!-- /row -->
<!-- top footer -->
<footer id="footer">
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">About Us</h3>
                        <p>
                            {{ $about }}
                        </p>

                        <ul class="footer-links">
                            <li>
                                <a href="">
                                    <i class="fa fa-map-marker"></i>
                                    {{ $address }}
                                </a>
                            </li>
                            <li><a href="tel:{{ $phone2 }}"><i class="fa fa-phone"></i> {{ $phone2 }}</a></li>
                            <li><a href="mailto:{{ $mail }}"><i class="fa fa-envelope-o"></i>
                                    {{ $mail }}
                                </a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Categories</h3>
                        <ul class="footer-links">
                            @foreach(\App\Category::query()->whereHas('products')->limit(10)->get() as $item)
                            <li>
                                <a href="{{ route('buy.products',['cat'=>$item->name]) }}">{{ $item->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="clearfix visible-xs"></div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Information</h3>
                        <ul class="footer-links">
                            <li><a href="{{ route('cart.shoppingCart') }}">View Basket</a></li>
                            <li><a href="javascript:void(0)">Contact Us</a></li>
                            <li><a href="javascript:void(0)">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- /row -->
        </div>
    </div>
    <!-- /container -->
    <!-- bottom footer -->
    <div id="bottom-footer">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <span class="copyright" style="margin: 20px 0">
							Copyright &copy; {{ now()->format('Y') }} All rights reserved  | This website made by
                        <a style="color: whitesmoke"
                           href="mailto:jeanpaulbyiringiro9764@gmail.com">Jean Paul Byiringiro</a>,
                    </span>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bottom footer -->
</footer>
