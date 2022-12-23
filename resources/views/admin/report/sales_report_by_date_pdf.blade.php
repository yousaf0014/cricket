<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sales report</title>
</head>
<style>
 body{ font-family:Arial, Helvetica, sans-serif; color:#121212; line-height:22px;}
</style>
<body>

  <div style="width:940px; margin:0px auto;">
  <h3>{{ Session::get('company_name') }}</h3>
  <strong>Sales History Report(<?php echo formatDate(date('d-m-Y'))?>)</strong> 
  <br> <br>
  <div style="clear:both"></div>
    <div style="background-color:#323a45; padding:10px 10px;height:20px">
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Order No</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Date</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Customer</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Qty</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Sales({{Session::get('currency_symbol')}})</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Cost({{Session::get('currency_symbol')}})</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Tax({{Session::get('currency_symbol')}})</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:right">Profit({{Session::get('currency_symbol')}})</div> 
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:right">Profit(%)</div>
      <div style="clear:both"></div>
    </div>
      <?php
        $qty = 0;
        $sales_price = 0;
        $purchase_price = 0;
        $tax = 0;
        $total_profit = 0;
      ?>
      @foreach ($itemList as $item)
      <?php
     
      $profit = ($item->sales_price_total-$item->purch_price_amount);
      $profit_margin = ($profit*100)/$item->purch_price_amount;

      $qty += $item->qty;
      $sales_price += $item->sales_price_total;
      $purchase_price += $item->purch_price_amount;
      $tax += $item->tax;
      $total_profit += $profit;

      ?>
    <div style="padding:0px;height:15px">
      <div style="width:100px; font-size:14px; float:left; text-align:center;border:1px solid black">{{ $item->order_reference }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid black" >{{ formatDate($item->ord_date) }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid black">{{ $item->name }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid black">{{ $item->qty }}</div> 

      <div style="width:100px; font-size:14px; float:left; text-align:center;border:1px solid black">{{ number_format(($item->sales_price_total),2,'.',',') }}</div>
      <div style="width:101px; float:left; font-size:14px; text-align:center;border:1px solid black" >{{ number_format(($item->purch_price_amount),2,'.',',') }}</div>
      <div style="width:110px; float:left; font-size:14px; text-align:center;border:1px solid black">{{ number_format(($item->tax),2,'.',',') }}</div>
      <div style="width:111px; float:left; font-size:14px; text-align:center;border:1px solid black">{{ number_format(($profit),2,'.',',') }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid black">{{ number_format(($profit_margin),2,'.',',') }}</div> 

    </div>
    <div style="clear:both"></div>
  @endforeach  
    <div style="padding:0px; height:15px;">
      <div style="width:304px; font-size:14px; float:left; text-align:right;border:1px solid black;font-weight:bold;">Total&nbsp;&nbsp;</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid black;font-weight:bold" >{{ $qty }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid black;font-weight:bold">{{ Session::get('currency_symbol').number_format($sales_price,2,'.',',') }}</div>
      <div style="width:101px; float:left; font-size:14px; text-align:center;border:1px solid black;font-weight:bold">{{ Session::get('currency_symbol').number_format($purchase_price,2,'.',',') }}</div>   
      <div style="width:110px; float:left; font-size:14px; text-align:center;border:1px solid black;font-weight:bold">{{ Session::get('currency_symbol').number_format($tax,2,'.',',') }}</div>
      <div style="width:111px; float:left; font-size:14px; text-align:center;border:1px solid black;font-weight:bold">{{ Session::get('currency_symbol').number_format($total_profit,2,'.',',') }}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center;border:1px solid black;font-weight:bold">{{ number_format(($total_profit*100/$purchase_price),'2','.',',') }}%</div>
    </div>
    <div style="clear:both"></div>
  </div>
</body>
</html>