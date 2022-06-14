@extends('layouts.master')
@section('title','Dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
@stop

@section('content')


    <h4 class="">Dashboard</h4>
    <!-- WEBSITE ANALYTICS -->
    <div class="dashboard-section">

        <!-- Orders -->
        <div class="dashboard-section no-margin">
            <div class="panel panel-default rounded-sm shadow-xs">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="number-chart rounded-sm">
                                <div class="mini-stat">
                                    <div id="number-chart1" class="inlinesparkline">
                                        <i class="fa fa-shopping-basket"></i>
                                    </div>
                                    <p class="text-muted">
                                    </p>
                                </div>
                                <div class="number">
                                    <span>{{ number_format(\App\MyFunc::counts("orders")) }}</span>
                                    <span>
                                    <a href="{{ route('orders.index') }}">
                                    Orders
                                    </a>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="number-chart rounded-sm">
                                <div class="mini-stat">
                                    <div class="inlinesparkline">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <p class="text-muted">
                                    </p>
                                </div>
                                <div class="number">
                                    <span>{{ number_format(\App\MyFunc::countOrdersByStatus("Pending")) }}</span>
                                    <span>
                                    <a href="{{ route('orders.index') }}">
                                    Pending Orders
                                    </a>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="number-chart rounded-sm">
                                <div class="mini-stat">
                                    <div class="inlinesparkline">
                                        <i class="fa fa-check-circle-o"></i>
                                    </div>
                                    <p class="text-muted">
                                    </p>
                                </div>
                                <div class="number">
                                    <span>{{ number_format(\App\MyFunc::countOrdersByStatus("Delivered")) }}</span>
                                    <span>
                                    <a href="{{ route('orders.index') }}">
                                    Delivered orders
                                    </a>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="number-chart rounded-sm">
                                <div class="mini-stat">
                                    <div>
                                        <i class="fa fa-spinner"></i>
                                    </div>
                                    <p class="text-muted">
                                    </p>
                                </div>
                                <div class="number">
                                    <span>{{ number_format(\App\MyFunc::countOrdersByStatus("Processing")) }}</span>
                                    <span>
                                    <a href="{{ route('orders.index') }}">
                                    Processing orders
                                    </a>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END  -->

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default  rounded-sm shadow-sm">
                    <div class="panel-heading  bg-white d-flex items-center justify-content-between">
                        <h4 class="panel-title"><i class="fa fa-area-chart"></i> Total revenue vs Year</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row margin-bottom-15">
                            <div class="col-sm-7 left">
                                <div id="demo-line-chart" class="ct-chart"></div>
                            </div>
                            <div class="col-sm-5 right">
                                <ul class="list-group">
                                    @foreach($revenues as $item)
                                        <li class="list-group-item">
                                            <span class="badge bg-info">{{ $item->year }}</span>
                                            <strong>{{ number_format($item->amount) }}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <div class="panel panel-default rounded-sm shadow-sm">
                    <div class="panel-heading bg-white">
                        <h2 class="panel-title">
                            <i class="fa fa-pie-chart"></i>
                            Orders status
                            <small class="text-muted">{{ date('M d Y') }}</small>
                        </h2>
                    </div>
                    <div class="panel-body">
                        <div id="demo-pie-chart" class="ct-chart"></div>
                        <ul class="list-unstyled">
                            <li>
                                <p>
                                    <span class="value"> {{ number_format(\App\MyFunc::countOrdersByStatus(\App\Order::PENDING)) }} </span>
                                    <span class="text-muted">Pending orders</span>
                                </p>
                                <div class="progress progress-xs progress-transparent custom-color-yellow">
                                    <div class="progress-bar" id="pending_status"
                                         data-transitiongoal="{{ \App\MyFunc::countOrdersByStatusPercentage(\App\Order::PENDING) }}"></div>
                                </div>
                            </li>
                            <li>
                                <p>
                                    <span class="value">  {{ number_format(\App\MyFunc::countOrdersByStatus(\App\Order::PROCESSING)) }}</span>
                                    <span class="text-muted">
                                    Processing orders
                                </span>
                                </p>
                                <div class="progress progress-xs progress-transparent custom-color-purple">
                                    <div id="processing_status" class="progress-bar"
                                         data-transitiongoal="{{ \App\MyFunc::countOrdersByStatusPercentage(\App\Order::PROCESSING) }}"></div>
                                </div>
                            </li>
                            <li>
                                <p>
                                    <span class="value"> {{ number_format(\App\MyFunc::countOrdersByStatus(\App\Order::ON_WAY)) }} </span>
                                    <span class="text-muted">On the way orders</span>
                                </p>
                                <div class="progress progress-xs progress-transparent custom-color-lightseagreen"
                                     style="color: #5CB85C">
                                    <div class="progress-bar" id="shipped_status"
                                         data-transitiongoal="{{ \App\MyFunc::countOrdersByStatusPercentage(\App\Order::ON_WAY) }}"></div>
                                </div>
                            </li>
                            <li>
                                <p>
                                    <span class="value"> {{ number_format(\App\MyFunc::countOrdersByStatus(\App\Order::DELIVERED)) }} </span>
                                    <span class="text-muted">Delivered orders</span>
                                </p>
                                <div class="progress progress-xs progress-transparent custom-color-green"
                                     style="color: #5CB85C">
                                    <div class="progress-bar" id="delivered_status"
                                         data-transitiongoal="{{ \App\MyFunc::countOrdersByStatusPercentage(\App\Order::DELIVERED) }}"></div>
                                </div>
                            </li>
                            <li>
                                <p>
                                    <span class="value"> {{ number_format(\App\MyFunc::countOrdersByStatus(\App\Order::CANCELLED)) }} </span>
                                    <span class="text-muted">Cancelled orders</span>
                                </p>
                                <div class="progress progress-xs progress-transparent custom-color-orange"
                                     style="color: #5CB85C">
                                    <div class="progress-bar" id="cancelled_status"
                                         data-transitiongoal="{{ \App\MyFunc::countOrdersByStatusPercentage(\App\Order::CANCELLED) }}"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- END WEBSITE ANALYTICS -->
    <!-- SALES SUMMARY -->
    <div class="dashboard-section">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default rounded-sm shadow-sm">
                    <div class="panel-heading bg-white">
                        <h3 class="panel-title"><i class="fa fa-square"></i> Recent orders</h3>
                    </div>
                    <div class="panel-body table-responsive p-0">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Date &amp; Time</th>
                                <th>Order No.</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\MyFunc::recentOrders() as $order)
                                <tr>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->clientName }}</td>
                                    <td>{{ number_format($order->orderItems()->sum('sub_total')+$order->shipping_amount) }}</td>
                                    <td>
                                        @if( $order->status==\App\Order::PENDING)
                                            <span class="label label-primary rounded-pill">
                                                <i class="fa fa-shopping-cart"></i>
                                                {{ $order->status }}
                                            </span>
                                        @elseif( $order->status==\App\Order::PROCESSING)
                                            <span class="label label-info rounded-pill"
                                                  style="background-color: #AB7DF6">
                                                <i class="fa fa-spinner"></i>
                                                {{ $order->status }}</span>
                                        @elseif( $order->status==\App\Order::CANCELLED)
                                            <span class="label label-danger rounded-pill">
                                                <i class="fa fa-times"></i>
                                                {{ $order->status }}</span>
                                        @elseif( $order->status==\App\Order::DELIVERED)
                                            <span class="label label-success rounded-pill">
                                                <i class="fa fa-check></i>
                                                {{ $order->status }}
                                            </span>
                                        @elseif( $order->status==\App\Order::PAID)
                                            <span class="label bg-green rounded-pill">
                                                <i class="fa fa-check-circle"></i>
                                                {{ $order->status }}
                                            </span>
                                        @elseif( $order->status==\App\Order::ON_WAY)
                                            <span class="label label-primary rounded-pill">
                                                <i class="fa fa-bicycle"></i>
                                                {{ $order->status }}
                                            </span>
                                        @else
                                            <span class="label label-warning rounded-pill">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('orders.index') }}" class="btn btn-default btn-xs rounded-sm my-2">
                            More info
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default rounded-sm shadow-sm">
                    <div class="panel-heading bg-white">
                        <h3 class="panel-title"><i class="fa fa-square"></i> Top Products</h3>
                    </div>
                    <div class="table-responsive panel-body p-0">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sold times#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\MyFunc::topSellingProducts() as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format($product->total) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('products.index') }}" class=" btn btn-default btn-xs rounded-sm my-2">
                            More info
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- END SALES SUMMARY -->

    <!-- Orders -->
    <div class="dashboard-section no-margin">
        <div class="panel panel-default rounded-sm shadow-sm">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><i class="fa fa-square"></i> Summary</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <p class="metric-inline">
                            <i class="fa fa-money"></i> {{ number_format(\App\MyFunc::toMoneyIncome()) }}
                            <span>Total revenue</span></p>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <p class="metric-inline">
                            <i class="fa fa-product-hunt"></i> {{ number_format(\App\MyFunc::counts("products")) }}
                            <span>Products</span>
                        </p>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <p class="metric-inline">
                            <i class="fa fa-list-ul"></i> {{ number_format(\App\MyFunc::counts("categories")) }}
                            <span>Categories</span>
                        </p>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <p class="metric-inline">
                            <i class="fa fa-users"></i> {{ number_format(\App\MyFunc::totalClients()) }}
                            <span>Clients</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END  -->




@endsection

@section('scripts')
    <script src="{{ asset('vendor/jquery-sparkline/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-progressbar/js/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('vendor/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('vendor/chartist-plugin-axistitle/chartist-plugin-axistitle.min.js') }}"></script>
    <script src="{{ asset('vendor/chartist-plugin-legend-latest/chartist-plugin-legend.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.js') }}"></script>


    <script>
        $(function () {
            $('.nav-dahboard').addClass('active');

            /*
                        var n1 = parseInt($('#pending_status').attr('data-transitiongoal'));
                        var n2 = parseInt($('#processing_status').attr('data-transitiongoal'));
                        var n3 = parseInt($('#delivered_status').attr('data-transitiongoal'));
                        var n4 = parseInt($('#shipped_status').attr('data-transitiongoal'));
                        // traffic sources
                        var dataPie = {
                            series: [n1, n2, n3, n4]
                        };

                        var labels = ['Pending', 'Processing', 'Delivered', 'Shipped'];
                        var sum = function (a, b) {
                            return a + b;
                        };
                        var responsiveOptions = [
                            ['screen and (min-width: 640px)', {
                                chartPadding: 30,
                                labelOffset: 100,
                                labelDirection: 'explode',
                                labelInterpolationFnc: function(value) {
                                    return value;
                                }
                            }],
                            ['screen and (min-width: 1024px)', {
                                labelOffset: 80,
                                chartPadding: 20
                            }]
                        ];

                        new Chartist.Pie('#demo-pie-chart', dataPie, {
                            donut:true,
                            height: "180px",
                            labelInterpolationFnc: function (value, idx) {
                                return labels[idx];
                                var percentage = Math.round(value / dataPie.series.reduce(sum) * 100) + '%';
                                return labels[idx] + ' (' + percentage + ')';
                            }
                        });*/

            // progress bars
            $('.progress .progress-bar').progressbar({
                display_text: 'none'
            });


            // notification popup
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.options.showDuration = 1000;
            toastr['info']('Hello, Garden of Eden, the dashboard summary.');


            // line chart
            var data = {
                labels: {{ $revenues->pluck('year') }},
                series: [{!! $revenues->pluck('amount') !!} ]
            };

            var options = {
                height: "260px",
                showPoint: true,
                showArea: true,
                axisX: {
                    showGrid: true
                },
                axisY: {
                    labelInterpolationFnc: function (value, idx) {
                        return Math.ceil(value).toLocaleString();
                    },
                    showGrid: true
                },
                lineSmooth: true,
                chartPadding: {
                    top: 30,
                    right: 30,
                    bottom: 30,
                    left: 50
                },

                plugins: [
                    Chartist.plugins.tooltip({
                        appendToBody: false,
                        // currency: ' ',
                        transformTooltipTextFnc: function (tooltip) {
                            return Math.ceil(tooltip).toLocaleString();
                        }
                    }),

                    Chartist.plugins.ctAxisTitle({
                        axisX: {
                            type: Chartist.AutoScaleAxis,
                            axisTitle: 'Year',
                            axisClass: 'ct-axis-title',
                            offset: {
                                x: 0,
                                y: 50
                            },
                            textAnchor: 'middle'
                        },
                        axisY: {
                            axisTitle: 'Amount',
                            axisClass: 'ct-axis-title',
                            offset: {
                                x: 0,
                                y: -10
                            },

                        }
                    })
                ]
            };

            new Chartist.Line('#demo-line-chart', data, options);

        });
    </script>
@stop


