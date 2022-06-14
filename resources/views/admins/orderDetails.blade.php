<style>
    .billing-history tbody > tr > td {
        padding: 10px;
    }

</style>

{{--@if(\Illuminate\Support\Facades\Auth::user()->role==='Admin')--}}
@if(auth()->user()->role=='Admin' || auth()->user()->role=='Super admin')
    <div class="">
        <a target="_blank" href="{{ route('orders.printOrder',['id'=>$order->id]) }}"
           class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-print"></i>
            Print order
        </a>
    </div>
    <div class="clearfix"></div>
@endif

<h5>Client information</h5>

<div id="printOrder">
    <table class="table billing-history">
        <thead class="sr-only">
        <tr>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
            <span>
                <b>Oder date</b>
            </span>
            </td>
            <td> : {{ date('j M Y h:i a', strtotime($order->created_at)) }}</td>
        </tr>
        <tr>
            <td>
            <span>
                <b>Client</b>
            </span>
            </td>
            <td> : {{ $order->user===null ? $order->clientName:$order->user->name }}</td>
        </tr>
        <tr>
            <td>
            <span>
            <b>Client phone</b>
            </span>
            </td>
            <td> : {{ \App\MyFunc::format_phone_us($order->clientPhone) }}</td>
        </tr>
        <tr>
            <td>
            <span>
            <b>Email address</b>
            </span>
            </td>
            <td> : {{ $order->email }}</td>
        </tr>
        <tr>
            <td>
            <span>
            <b>Shipping address</b>
            </span>
            </td>
            <td> : {{ $order->shipping_address}}</td>
        </tr>
        <tr>
            <td>
            <span>
            <b>Status</b>
            </span>
            </td>
            <td> :
                @if($order->status==='Delivered')
                    <span class="label label-success">{{$order->status}}</span>
                @elseif($order->status==='Processing')
                    <span class="label label-info">{{$order->status}}</span>
                @else
                    <span class="label label-primary">{{$order->status}}</span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <h4 class="text-info">Products ordered</h4>
    <table class="table table-bordered table-responsive table-striped">
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderItems as $orderItem)
            <tr>
                <td>{{ $orderItem->product->name }}</td>
                <td>{{ number_format($orderItem->price) }}</td>
                <td>{{ $orderItem->qty }}</td>
                <td>{{ number_format($orderItem->sub_total) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3">
                                    <span>
                                        <b>Sub total:</b>
                                    </span>
            </td>
            <td>
                <b>{{ number_format($order->orderItems->sum('sub_total')) }} Rwf</b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                                    <span>
                                        <b>Shipping amount to Pay:</b>
                                    </span>
            </td>
            <td>
                <b>{{ number_format($order->shipping_amount) }} Rwf</b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                                    <span>
                                        <b>Grand total:</b>
                                    </span>
            </td>
            <td>
                <b>{{ number_format($order->getTotalAmountToPay()) }} Rwf</b>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
<div>
    <p>
        <strong>Note:</strong>
        <span> {{ $order->notes }}</span>
    </p>
</div>
@if(auth()->user()->role=='Admin' || auth()->user()->role=='Super admin')
    @csrf
    <input type="hidden" value="{{ $order->id }}" name="id">
    <div class="form-group">
        <label for="status" class="control-label col-sm-4">Status</label>
        <label for="status" class="control-label col-sm-1">:</label>
        <div class="col-sm-7">
            <select required class="form-control rounded-sm shadow-sm" name="status" id="status">
                <option value="">--Mark Order As--</option>
                @foreach(\App\Order::getStatuses() as $status)
                    <option value="{{ $status }}" {{ $order->status==$status? 'selected':'' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>

@endif

