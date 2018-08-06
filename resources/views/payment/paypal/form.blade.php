@php /* @var \App\Order $order */ @endphp
<form style="display: none" id="payment" action="https://www.{{ (config('payment.sandbox_mode') ? 'sandbox.' : '') }}paypal.com/cgi-bin/webscr" method="post">
    <input type="text" name="cmd" value="_xclick">
    <input type="text" name="business" value="{{ config('payment.paypal.business_email') }}">
    <input type="text" name="item_name" value="{{ $order->getItemName() }}">
    <input type="text" name="amount" value="{{ $order->getAmount() }}">
    <input type="text" name="currency_code" value="{{ $order->getCurrencyCode() }}">
    <input type="text" name="button_subtype" value="products">
    <input type="text" name="invoice" value="{{ $order->getOrderNo() }}">
    <input type="text" name="return" value="{{ route('paypal.response', ['orderNo' => $order->getOrderNo()]) }}">
    <input type="text" name="notify_url" value="{{ route('paypal.ipnPost') }}">
    <input type="text" name='rm' value='1'>
    <input type="text" name="cancel_return" value="{{ url('/') }}">
    <input type="text" name="image_url" value="{{ url(get_logo()) }}">
    <input type="text" name="email" value="{{ $order->getEmail() }}">
    <input type="text" name="first_name" value="{{ $order->getUsername() }}">
    <input type="submit" name="Submit" value="" id="paypal">
</form>

<script>
    document.getElementById("payment").submit();
</script>