<?php
use App\MyFunc;
$mail = $defaultSetting->email1;
$whatsapp = MyFunc::format_phone_us($defaultSetting->whatsapp);
$email2 = $defaultSetting->email2;
$phone = MyFunc::format_phone_us($defaultSetting->phoneNumber1);
$phone2 = MyFunc::format_phone_us($defaultSetting->phoneNumber2);
$phone1 = MyFunc::format_phone_us($defaultSetting->phoneNumber1);
$address = $defaultSetting->address;
?>

<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li>
                    <a href="tel:{{$whatsapp }}">
                        <i class="fa fa-whatsapp"></i>{{$whatsapp }}
                    </a>
                </li>
                <li>
                    <a href="tel:{{$phone1 }}">
                        <i class="fa fa-mobile-phone"></i>{{$phone1 }}
                    </a>
                </li>
                <li>
                    <a href="tel:{{$phone2 }}">
                        <i class="fa fa-phone"></i>{{$phone2 }}
                    </a>
                </li>
                <li>

                    <a href="mailto:{{ $mail }}">
                        <i class="fa fa-envelope-o"></i>
                        {{ $mail }}
                    </a>
                </li>
                <li>

                    <a href="mailto:{{ $email2 }}">
                        <i class="fa fa-envelope-o"></i>
                        <?php print $email2;?>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="fa fa-map-marker"></i>
                        {{ $address }}
                    </a>
                </li>
                <li><a href="{{ route('dashboard') }}" target="_blank">ADMIN</a></li>
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->
    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-sm-3 hidden-xs">
                    <div class="header-logo">
                        <a href="{{ route('home') }}" class="logo" style="color: #F0FFDF;">
                            <img src="{{ asset('img/GARDEN_LOGO.png') }}" class="img-responsive flat"
                                 alt="Garden Of Eden Produce"
                                 style="width: 80px;background-color: whitesmoke">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-sm-6">
                    <div class="header-search">
                        <form action="{{ route('buy.products') }}" class="form-inline" autocomplete="off">
                            <div class="input-group input-group-lg w-100">
                                <input type="search" autocomplete="off"
                                       value="{{ request('search') }}"
                                       class="form-control flat" name="search"
                                       placeholder="What are your looking for?">
                                <span class="input-group-btn">
                                <button class="btn btn-danger flat" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                              </span>
                            </div><!-- /input-group -->
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-sm-3 clearfix">
                    <livewire:cart-counter/>
                </div>

                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
</header>
