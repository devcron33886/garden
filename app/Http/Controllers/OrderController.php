<?php

namespace App\Http\Controllers;

use App\Jobs\OrderStatusUpdated;
use App\Order;
use App\Payment;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use function response;

class OrderController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = Order::with(['payment', 'orderItems.product']);
            return $this->formatData($query);
        }
        return view('admins.orders');
    }

    /**
     * @throws Exception
     */
    protected function formatData(Builder $builder)
    {
        return DataTables::of($builder)
            ->addIndexColumn()
            ->editColumn('created_at', function ($item) {
                return optional($item->created_at)->format('d M Y - H:i:s');
            })
            ->editColumn('amount_to_pay', function ($item) {
                return number_format($item->amount_to_pay);
            })
            ->editColumn('payment_type', function (Order $item) {
                $color = "primary";
                if ($item->payment_type == Payment::CARD_MOBILE_MONEY)
                {
                    $color = "success";
                }
                return "<span class='label label-$color rounded-pill'>$item->payment_type</span>";
            })
            ->addColumn('payment_status', function (Order $item) {
                $color = "danger";
                $status = optional($item->payment)->status;
                if ($item->payment_type == Payment::CARD_MOBILE_MONEY)
                {
                    if ($status == Payment::Successful)
                    {
                        $color = "success";
                    }
                    else
                    {
                        $status = 'failed';
                    }
                }
                elseif ($item->status == Order::PAID)
                {
                    $status = 'Paid';
                    $color = "success";
                }
                else
                {
                    $status = 'N/A';
                    $color = "default";
                }

                $status = ucfirst($status);
                return "<span class='label label-$color rounded-pill'>$status</span>";
            })
            ->editColumn('status', function (Order $item) {
                $status = $item->status;
                if ($status === Order::PENDING)
                    return "<a class='label label-warning'>$status</a>";
                else if ($status === Order::PROCESSING)
                    return "<a class='label label-info'><i class='fa fa-spinner'></i> $status</a>";
                else if ($status === Order::CANCELLED)
                    return "<a class='label label-danger '><i class='fa fa-close'></i> $status</a>";
                else if ($status === Order::ON_WAY)
                    return "<a class='label label-primary '><i class='fa fa-bicycle'></i> $status</a>";
                else if ($status === Order::DELIVERED)
                    return "<a class='label label-success'><i class='fa fa-check'></i> $status</a>";
                else if ($status === Order::PAID)
                    return "<a class='label bg-green'><i class='fa fa-check-circle'></i> $status</a>";
                return "<a class='label label-default '><i class='fa fa-check-circle-o'></i> $status</a>";
            })
            ->editColumn('description', function ($item) {
                return Str::of($item->description)->limit(50);
            })
            ->addColumn('action', function (Order $item) {
                $verify = '';
                if ($item->payment_type == Payment::CARD_MOBILE_MONEY)
                {
                    $txId = optional($item->payment)->transaction_id ?? 0;
                    $verify = "<button data-url='" . route('verify.payment', $txId) . "' class='btn btn-danger btn-sm  js-verify'>Verify</button>";
                }
                return "<div class='btn-group btn-group-sm'>
                           <button data-url='" . route('orders.show', $item->id) . "' class='btn btn-primary btn-sm js-details'>Details</button>
                           $verify
                        </div>";
            })
            ->rawColumns(['action', 'status', 'payment_type', 'payment_status'])
            ->make(true);
    }


    public function show($id)
    {
        $obj = Order::with("orderItems.product")->find($id);
        if (!$obj)
            return response()->json(["message" => "Not found"], 404);
        return view("admins.orderDetails", ['order' => $obj]);
    }

    public function printOrder($id)
    {
        //
        $obj = Order::with("orderItems.product")->find($id);
        if (!$obj)
            return response()->json(["message" => "Not found"], 404);
        return view("admins.printOrder", ['order' => $obj]);
    }


    public function mark(Request $request): JsonResponse
    {
        $order = Order::query()->find($request->input('id'));
        $prevStatus = $order->status;
        if (!$order)
            return response()->json(["message" => "Not found"], 404);
        $order->status = $request->input('status');
        $order->update();

        if ($order->status != $prevStatus)
            OrderStatusUpdated::dispatch($order, auth()->user());

        return response()->json(["data" => $order], 204);
    }

    public function orderSuccess($id)
    {
        $order = Order::find(decryptId($id));
        if (!$order) abort(404);
        return view('clients.order-success', ['order' => $order])
            ->with('message', " You successfully placed orders");
    }

    public function verifyPayment($transaction_id)
    {
        $SEC_KEY = config('app.FW_SECRET');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$transaction_id/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer $SEC_KEY"
            ],
        ]);

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return view('admins._verify_transaction', compact('response'));
    }

}
