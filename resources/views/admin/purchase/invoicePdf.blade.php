<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Purchase Invoice</title>
</head>
<style>
 body{ font-family:Arial, Helvetica, sans-serif; color:#121212; line-height:22px;}
</style>
<body>

  <div style="width:900px; margin:15px auto; padding-bottom:40px;">
  <div style="font-size:30px; font-weight:bold;clear:both">Purchase</div>
  <div style="width:300px; float:left;">
    <div style="margin-top:10px; margin-bottom:15px;">
      <div style="font-size:16px; color:#000000; font-weight:bold;">{{ Session::get('company_name') }}</div>
      <div style="font-size:16px;">{{ Session::get('company_street') }}</div>
      <div style="font-size:16px;">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
      <div style="font-size:16px;">{{ Session::get('company_country_id') }}, {{ Session::get('company_zipCode') }}</div>
    </div>
  </div>

  <div style="width:300px; float:left;">
    <div style="margin-top:10px;margin-bottom:15px;">
      <div style="font-size:16px; color:#000000; font-weight:bold;">{{!empty($purchData->supp_name) ? $purchData->supp_name : ''}}</div>
      <div style="font-size:16px;">{{!empty($purchData->address) ? $purchData->address : ''}}</div>
      <div style="font-size:16px;">{{!empty($purchData->city) ? $purchData->city : ''}}{{!empty($purchData->state) ? ', '.$purchData->state : ''}}</div>
      <div style="font-size:16px;">{{!empty($purchData->country) ? $purchData->country : ''}}{{!empty($purchData->zipcode) ? ', '.$purchData->zipcode : ''}}</div>
    </div>
    <br />
  </div>
  
  <div style="width:300px; float:left;">
    <div style="margin-top:10px;">
      <div style="font-size:16px; font-weight:bold;">Invoice No # {{$purchData->reference}}</div>
      <div style="font-size:16px;">Date : {{formatDate($purchData->ord_date)}}</div>
    </div>
    <br />
  </div>

  <div style="clear:both"></div>
    <div style="background-color:#323a45; padding:10px 20px;height:20px">
      <div style="width:50px;  color:#FFFFFF; float:left; font-weight:bold; text-align:center">S/N</div>
      <div style="width:310px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Description</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Quantity</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Price({{ Session::get('currency_symbol')}})</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Tax(%)</div>
      <div style="width:200px; color:#FFFFFF; float:left; font-weight:bold; text-align:right">Amount({{ Session::get('currency_symbol')}})</div>
      <div style="clear:both"></div>
    </div>
  <?php
    $taxAmount      = 0;
    $subTotal = 0;
    $qtyTotal       = 0;
    $priceAmount    = 0;
    $sum = 0;
    $i=0;
    $units = 0;
  ?>
  @foreach ($invoiceItems as $item)
       <?php
            $priceAmount = ($item->quantity_received*$item->unit_price);
            $subTotal += $priceAmount;
            $units += $item->quantity_received;
       ?> 
    <div style="padding:0px 20px; margin-top:15px;">
      <div style="width:50px; font-size:14px; float:left; text-align:center">{{++$i}}</div>
      <div style="width:310px; float:left; font-size:14px; text-align:center">{{$item->description}}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center">{{$item->quantity_received}}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center">{{number_format($item->unit_price,2,'.',',') }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center">{{ $item->tax_rate}}</div>
      <div style="width:200px; float:left; font-size:14px; text-align:right">{{number_format($priceAmount,2,'.',',') }}</div>
    </div>
   <br/>
<div style="clear:both"></div>
  <?php
    $sum = ($item->quantity_received+$sum);
  ?>
  @endforeach  
    <div style="clear:both"></div>
    <br/>
     <hr />
    <div style="padding:0px 20px; ">
      <div style="width:460px; float:left; font-size:14px; text-align:right;">&nbsp;</div>
      <div style="width:250px; float:left; text-align:right; font-size:14px;">Total Quantity</div>
      <div style="width:150px; float:left; text-align:right; font-size:14px;">{{$sum}}</div>
    </div>
    
    <div style="clear:both"></div>
    <div style="padding:0px 20px; ">
      <div style="width:460px; float:left; font-size:14px; text-align:right;">&nbsp;</div>
      <div style="width:250px; text-align:right; font-size:14px; float:left; font-weight:bold;">SubTotal</div>
      <div style="width:150px; text-align:right; font-size:14px; float:left;font-weight:bold;">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</div>
    </div>
    @foreach($taxType as $rate=>$tax_amount)
    @if($rate != 0)
    <div style="clear:both"></div>
    <div style="padding:0px 20px; ">
      <div style="width:460px; float:left; font-size:14px; text-align:right;">&nbsp;</div>
      <div style="width:250px; text-align:right; font-size:14px; float:left;">Plus Tax({{$rate}}%)</div>
      <div style="width:150px; text-align:right; font-size:14px; float:left; ">{{ Session::get('currency_symbol').number_format($tax_amount,2,'.',',') }}</div>
    </div>
    <?php
      $taxAmount += $tax_amount;
    ?>   
    @endif 
    @endforeach
    <br /><br />
    <div style="clear:both"></div>
    <hr />
    <div style="padding:0px 20px; ">
      <div style="width:460px; float:left; font-size:14px; text-align:right;">&nbsp;</div>
      <div style="width:250px; text-align:right; font-size:14px; float:left; font-weight:bold;">Grand Total</div>
      <div style="width:150px; text-align:right; font-size:14px; float:left; font-weight:bold;">{{ Session::get('currency_symbol').number_format(($subTotal+$taxAmount),2,'.',',') }}</div>
    </div>
  </div>
</body>
</html>