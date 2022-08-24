<div>
    <div class="profile-section">
        <div class="payment-info">
            <h4 class="payment-name">
                Status :
                <small>{{$response['status']}}</small>
            </h4>
        </div>
    </div>

    @if($response['status']=='success')
        <table class="table billing-history table-bordered">
            <tbody>
            <tr>
                <td>
                    <h4 class="billing-title">Amount</h4>
                    <span class="text-muted">{{ number_format($response['data']['amount']) }} {{ $response['data']['currency'] }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="billing-title">Charged amount</h4>
                    <span class="text-muted">{{ number_format($response['data']['charged_amount']) }} {{ $response['data']['currency'] }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="billing-title">App fee</h4>
                    <span class="text-muted">{{ number_format($response['data']['app_fee']) }} {{ $response['data']['currency'] }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="billing-title">Merchant fee</h4>
                    <span class="text-muted">{{ number_format($response['data']['merchant_fee']) }} {{ $response['data']['currency'] }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="billing-title">Amount settled</h4>
                    <span class="text-muted">{{ number_format($response['data']['amount_settled']) }} {{ $response['data']['currency'] }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="billing-title">Processor response</h4>
                    <span class="text-muted">{{ $response['data']['processor_response'] }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="billing-title">Payment type</h4>
                    <span class="text-muted">{{ $response['data']['payment_type'] }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="billing-title">Customer </h4>
                    <span class="text-muted">
                        {{ $response['data']['customer']['name'] }} <br>
                        <a href="tel:{{ $response['data']['customer']['phone_number'] }}">{{ $response['data']['customer']['phone_number'] }}</a> <br>
                        <a href="mailto:{{ $response['data']['customer']['email'] }}">{{ $response['data']['customer']['email'] }}</a>
                    </span>
                </td>
            </tr>

            </tbody>
        </table>
    @else
        <div class="alert alert-danger" role="alert">
            {{ $response['message'] }}
        </div>
    @endif
</div>
