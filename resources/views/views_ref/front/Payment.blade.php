<?php
$email = 'mahikanani229@gmail.com';
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypal_id = 'anand.patel@inexture.in'; //Business Email
?>



<form action='<?php echo $paypal_url; ?>' method='post' id='myForm' name='myForm'><!-- found on top -->
    <h2>Please wait while page redirecting to paypal.... </h2>
    <input type='hidden' name='business' value='<?php echo $paypal_id; ?>'> <!-- found on top -->
    <input type='hidden' name='cmd' value="_xclick">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type='hidden' name='image_url' value='http://websyntax.blogspot.com/skin/../images/logo.png'> <!-- logo of your website -->
    <input type="hidden" name="rm" value="2" /> <!--1-get 0-get 2-POST -->
    <?php
    if ($type == "voucher") {
        $itemName = 1;
        $price = $buyProductDetails->v_price;
    } elseif ($type == "coin") {
        $itemName = 2;
        $price = $buyProductDetails->c_price;
    } else {
        $itemName = '';
        $price = '';
    }
    ?>
    <input type='hidden' class="name" name='item_name' value='{{$itemName}}'>
    <input type='hidden' name='item_number' value="{{$buyProductDetails->id}}">
    <input type='hidden' class="price" name='amount' value="{{$price}}">
    <input type='hidden' name='no_shipping' value='1'>
    <input type='hidden' name='no_note' value='1'>
    <input type='hidden' name='handling' value='0'>
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="cbt" value="Return to the hub">
    <input type="hidden" name="bn" value="PP-BuyNowBF">
    <input type='hidden' name='cancel_return' value="{{ url('/cancel')}}">
    <input type='hidden' name='return' value="{{ url('/success') }}">
    <input type="hidden" name="custom" value="{{ Auth::front()->get()->id }}"><!-- custom field -->
</form>


<script>document.getElementById('myForm').submit();</script>

