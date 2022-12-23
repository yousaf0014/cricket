<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Stock on hand report</title>
</head>
<style>
 body{ font-family:Arial, Helvetica, sans-serif; color:#121212; line-height:22px;}

.page-break {
    page-break-after: always;
}
</style>
<body>

  <div style="width:1040px; margin:15px auto; padding-bottom:40px;">
  <strong>Inventory Stock on Hand Report(<?php echo formatDate(date('d-m-Y'))?>)</strong> 
  <br> <br>
  <div style="clear:both"></div>
    <div style="background-color:#5f6060; padding:10px 20px;height:20px">
      <div style="width:200px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Product</div>
      <div style="width:80px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Stock Id</div>
      <div style="width:110px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">In Stock</div>
      <div style="width:110px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">MAC</div>
      <div style="width:110px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Retail Price</div>
      <div style="width:110px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">In Value</div>
      <div style="width:110px; color:#FFFFFF; float:left; font-weight:bold; text-align:right">Retail value</div>
      <div style="width:110px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Profit Value</div>
      <div style="width:50px; color:#FFFFFF; float:left; font-weight:bold; text-align:right">Profit</div>
      <div style="clear:both"></div>
    </div>
  <?php $counter = 0; ?>
  @foreach ($itemList as $item)
      <?php
        $mac = 0;
        $profit_margin = 0;
        if($item->received_qty !=0){
         $mac = $item->cost_amount/$item->received_qty;
        }
        $in_value = $item->available_qty*$mac;
        $retail_value = $item->available_qty*$item->retail_price;
        $profit_value = ($retail_value-$in_value);
        if($in_value !=0){
        $profit_margin = ($profit_value*100/$in_value); 
        }

        $counter++;
      ?>

    <div style="padding:0px;clear:both">
      <div style="width:200px; font-size:14px; float:left; text-align:center;border:1px solid #7f8184">{{ $item->description }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid #7f8184" >{{ $item->stock_id }}</div>
      <div style="width:90px; float:left; font-size:14px; text-align:center;border:1px solid #7f8184">{{ $item->available_qty }}</div>
      <div style="width:110px; float:left; font-size:14px; text-align:center;border:1px solid #7f8184">{{ Session::get('currency_symbol').number_format($mac,2,'.',',') }}</div>
      <div style="width:110px; float:left; font-size:14px; text-align:center;border:1px solid #7f8184">{{ Session::get('currency_symbol').number_format($item->retail_price,2,'.',',') }}</div>
      <div style="width:110px; float:left; font-size:14px; text-align:center;border:1px solid #7f8184">{{ Session::get('currency_symbol').number_format($in_value,2,'.',',') }}</div>
      <div style="width:110px; float:left; font-size:14px; text-align:right;border:1px solid #7f8184">{{ Session::get('currency_symbol').number_format($retail_value,2,'.',',') }}</div>
      <div style="width:110px; float:left; font-size:14px; text-align:center;border:1px solid #7f8184">{{ Session::get('currency_symbol').number_format($profit_value,2,'.',',') }}</div>
      <div style="width:82px; float:left; font-size:14px; text-align:right;border:1px solid #7f8184">{{ number_format($profit_margin,2,'.',',') }}%</div>    
    </div>
    @if($counter%10 == 0 )
    <div class="page-break"></div>
    @endif
    
  @endforeach  
    <div style="clear:both"></div>
    
  </div>
</body>
</html>