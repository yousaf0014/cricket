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

table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    text-align: center;
    padding: 3px;
}

</style>
<body>

  <div style="width:1040px; margin:15px auto; padding-bottom:40px;">
    <h3>{{ Session::get('company_name') }}</h3>
  <strong>Inventory Stock on Hand Report(<?php echo formatDate(date('d-m-Y'))?>)</strong> 
  <br> <br>
  <div style="clear:both"></div>
 <table>
 <tr>
   <th>Product</th>
   <th>Stock Id</th>
   <th>In Stock</th>
   <th>MAC</th>
   <th>Retail Price</th>
   <th>In Value</th>
   <th>Retail value</th>
   <th>Profit Value</th>
   <th>Profit</th>
 </tr>
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
        
      ?>

 <tr>
  <td>{{ $item->description }}</td>
  <td>{{ $item->stock_id }}</td>
  <td>{{ $item->available_qty }}</td>
  <td>{{ Session::get('currency_symbol').number_format($mac,2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format($item->retail_price,2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format($in_value,2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format($retail_value,2,'.',',') }}</td>
  <td>{{ Session::get('currency_symbol').number_format($profit_value,2,'.',',') }}</td>
  <td>{{ number_format($profit_margin,2,'.',',') }}%</td>
 </tr>
  @endforeach 

</table> 
    
  </div>
</body>
</html>