<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sales History Report</title>
</head>
<style>
 body{ font-family:Arial, Helvetica, sans-serif; color:#121212; line-height:22px;}

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

  <div style="width:1040px; margin:0px auto;">
  <h3>{{ Session::get('company_name') }}</h3>
  <strong>Sales History Report({{formatDate(date('d-m-Y'))}})</strong> 
  <br> <br>

 <table width="100%">
 <tr>
   <th>Order No</th>
   <th width="10%">Date</th>
   <th>Customer</th>
   <th>Quantity</th>
   <th>Sales({{Session::get('currency_symbol')}})</th>
   <th>Cost({{Session::get('currency_symbol')}})</th>
   <th>Tax({{Session::get('currency_symbol')}})</th>
   <th>Profit({{Session::get('currency_symbol')}})</th>
   <th>Profit(%)</th>
 </tr>

      <?php
        $qty = 0;
        $sales_price = 0;
        $purchase_price = 0;
        $tax = 0;
        $total_profit = 0;
        $count = 0;
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

  <tr>
  
  <td>{{ $item->order_reference }}</td>
  <td>{{ formatDate($item->ord_date) }}</td>
  <td>{{ $item->name }}</td>
  <td>{{ $item->qty }}</td>
  <td>{{ number_format(($item->sales_price_total),2,'.',',') }}</td>

  <td>{{ number_format(($item->purch_price_amount),2,'.',',') }}</td>
  <td>{{ number_format(($item->tax),2,'.',',') }}</td>

  <td>{{ number_format(($profit),2,'.',',') }}</td>
  <td>{{ number_format(($profit_margin),2,'.',',') }}</td>
 </tr>
  @endforeach 

</table>

  </div>
</body>
</html>