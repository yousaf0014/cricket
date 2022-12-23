<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>
Processing your donation...
</title>
<style media="screen" type="text/css">

body {
    background-color: #efefef;
}

h2 {
 color: #555;
 font-family: Arial, Sans-serif;
 font-weight: 400;
 text-align: center;
}

</style>
</head>
<body>

<form action="https://checkout.globalgatewaye4.firstdata.com/payment" method="POST" name="myForm" id="myForm"->
<input name="x_login" value="WSP-PROGR-eTvTIQBpMA" type="hidden">
<input name="x_amount" value="<?php echo $_POST['total'];?>" type="hidden">
<input name="x_fp_sequence" value="209179" type="hidden">
<input name="x_fp_timestamp" value="<?php echo  timestamp(); ?>" type="hidden">
<input name="x_fp_hash" value="adcb1fbebed0d54c3f5e8cde65c100f6" size="50" type="hidden">

<input name="x_currency_code" value="USD" type="hidden">
<input name="x_first_name" value="<?php echo $_POST['cname'];?>" type="hidden"> 
<input name="x_last_name" value="<?php echo $_POST['cname'];?>" type="hidden"> 
<input name="x_address" value="<?php echo $_POST['address'];?>" type="hidden"> 
<input name="x_city" value="<?php echo $_POST['city'];?>" type="hidden"> 
<input name="x_state" value="<?php echo $_POST['state'];?>" type="hidden"> 
<input name="x_country" value="<?php echo $_POST['country'];?>" type="hidden"> 
<input name="x_zip" value="<?php echo $_POST['zip'];?>" type="hidden"> 
<input name="x_email" value="<?php echo $_POST['email'];?>" type="hidden">
<input name="x_phone" value="<?php echo $_POST['phone'];?>" type="hidden">
<input name="x_invoice_num" value="<?php echo $_POST['invoice_no'];?>" type="hidden">

<input name="x_po_num" value="" type="hidden">
<input name="x_reference_3 " value="" type="hidden">
<input name="x_user1" value="" type="hidden">
<input name="x_user2" value="" type="hidden">
<input name="x_user3" value="" type="hidden">
<input name="x_recurring_billing" value="false" type="hidden">

<input name="x_recurring_billing_amount" value="<?php echo $_POST['total'];?>" type="hidden">
<input name="x_recurring_billing_start_date" value="<?php echo data('Y-m-d');?>" type="hidden">
<input name="x_recurring_billing_end_date" value="<?php echo  data('Y-m-d');?>" type="hidden">

<input name="x_recurring_billing_id" value="MB-PROGR-106-373280" type="hidden">
<input name="x_line_item" value="Payment<|>Payment<|>One-Time Donation<|>1<|><?php echo $_POST['total'];?><|>N<|><|><|><|><|><|>0<|><|><|><?php echo $_POST['total'];?>"type="hidden">
<input type="hidden" name="x_show_form" value="PAYMENT_FORM"/>
</form>
<h2>Processing your  <?php echo $_POST['total'];?> donation <?php echo $_POST['cname'];?>, please wait...</h2>
<script type='text/javascript'>document.myForm.submit();</script><!-- Automaticlly sends the final request to the Payeezy Gateway -->
</body>
</html>