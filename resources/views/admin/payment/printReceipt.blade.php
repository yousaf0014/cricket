<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Payment | Information</title>
</head>
<style>
 body{ font-family:Arial, Helvetica, sans-serif; color:#121212; line-height:22px;}
</style>
<body>

  <div style="width:900px; margin:15px auto; padding-bottom:40px;">
    <div style="font-weight:bold;font-size:30px;">Payment</div>
    <div style="width:300px; float:left;">
      <div style="margin-top:20px;">
        <div style="font-size:16px; color:#000000; font-weight:bold;">{{ Session::get('company_name') }}</div>
        <div style="font-size:16px;">{{ Session::get('company_street') }}</div>
        <div style="font-size:16px;">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
        <div style="font-size:16px;">{{ Session::get('company_country_id') }}, {{ Session::get('company_zipCode') }}</div>
      </div>
    </div>

    <div style="width:300px; float:left;">
      <div style="margin-top:20px;">
        <div style="font-size:16px;"><strong>{{ !empty($paymentInfo->name) ? $paymentInfo->name : '' }}</strong></div>
        <div style="font-size:16px;">{{ !empty($paymentInfo->billing_street) ? $paymentInfo->billing_street : '' }}</div>
        <div style="font-size:16px;">{{ !empty($paymentInfo->billing_city) ? $paymentInfo->billing_city : '' }}{{ !empty($paymentInfo->billing_state) ? ', '.$paymentInfo->billing_state : '' }}</div>
        <div style="font-size:16px;">{{ !empty($paymentInfo->billing_country_id) ? $paymentInfo->billing_country_id : '' }}{{ !empty($paymentInfo->billing_zip_code) ? ', '.$paymentInfo->billing_zip_code: '' }}</div>
      </div>
      <br/>
    </div>

    <div style="width:300px; float:left;">
      <div style="margin-top:20px;">
        <div style="font-size:16px;">{{ trans('message.invoice.payment_no').' # '.sprintf("%04d", $paymentInfo->id) }}</div>
      </div>
      <br/>
    </div>    
  
  <div style="clear:both"></div>
    <h3 style="text-align:center;margin:20px;0px;">PAYMENT RECEIPT</h3>
    <div>Payment Date : {{ formatDate($paymentInfo->payment_date) }}</div>
    <div>Payment Method : {{ $paymentInfo->payment_method }}</div>
    <br>
    <div style="height:100px;width:300px;background-color:#323a45;color:white;text-align:center;padding-top:30px">
      <strong>Total Amount</strong><br>
      <strong>{{ Session::get('currency_symbol').number_format($paymentInfo->amount,2,'.',',') }}</strong>
    </div>
    <div style="clear:both"></div>
    <br>
    <div style="background-color:#323a45; padding:10px 20px;height:20px">
      <div style="width:20%; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Order No</div>
      <div style="width:20%; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Invoice No</div>
      <div style="width:20%; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Invoce Date</div>
      <div style="width:20%; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Invoce Amount</div>
      <div style="width:20%; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Paid Amount</div>
      <div style="clear:both"></div>
    </div>
 
    <div style="padding:0px 20px; margin-top:15px;">
      <div style="width:20%; float:left; font-size:14px; text-align:center">{{ $paymentInfo->order_reference }}</div>
      <div style="width:20%; float:left; font-size:14px; text-align:center">{{$paymentInfo->invoice_reference}}</div>
      <div style="width:20%; float:left; font-size:14px; text-align:center">{{formatDate($paymentInfo->invoice_date)}}</div>
      <div style="width:20%; float:left; font-size:14px; text-align:center">{{ Session::get('currency_symbol').number_format($paymentInfo->invoice_amount,2,'.',',') }}</div>
      <div style="width:20%; float:left; font-size:14px; text-align:center">{{ Session::get('currency_symbol').number_format($paymentInfo->amount,2,'.',',') }}</div>
    </div>
   <br/>
<div style="clear:both"></div>
  </div>
  <script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>
</body>
</html>