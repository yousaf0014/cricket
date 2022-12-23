<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Shipment | Invoice</title>
</head>
<style>
 body{ font-family:Arial, Helvetica, sans-serif; color:#121212; line-height:22px;}
</style>
<body>

  <div style="width:900px; margin:15px auto; padding-bottom:40px;">
    <div style="font-weight:bold;font-size:30px;">Shipment</div>
  <div style="width:300px; float:left;">
    <div style="margin-top:10px;">
      <div style="font-size:16px; color:#000000; font-weight:bold;">{{ Session::get('company_name') }}</div>
      <div style="font-size:16px;">{{ Session::get('company_street') }}</div>
      <div style="font-size:16px;">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</div>
      <div style="font-size:16px;">{{ Session::get('company_country_id') }}, {{ Session::get('company_zipCode') }}</div>
    </div>
  </div>

  <div style="width:300px; float:left;">
    <div style="margin-top:10px; margin-bottom:15px;">
      <div style="font-size:16px; color:#000000; font-weight:bold;">Shipt To</div>
      <div style="font-size:16px;">{{ !empty($customerInfo->br_name) ? $customerInfo->br_name : ''}}</div>
      <div style="font-size:16px;">{{ !empty($customerInfo->shipping_street) ? $customerInfo->shipping_street :'' }}</div>
      <div style="font-size:16px;">{{ !empty($customerInfo->shipping_city) ? $customerInfo->shipping_city : ''}}{{ !empty($customerInfo->shipping_state) ? ', '.$customerInfo->shipping_state : ''}}</div>
      <div style="font-size:16px;">{{ !empty($customerInfo->shipping_country_id) ? $customerInfo->shipping_country_id :''}}{{ !empty($customerInfo->shipping_zip_code) ? ', '.$customerInfo->shipping_zip_code : ''}}</div>
    </div>
  </div>
  
  <div style="width:300px; float:left;">
    <div style="margin-top:10px;">
      
      <div style="font-size:16px; font-weight:bold;">Shipment No # {{ sprintf("%04d", $shipment->id)}}</div>
      @if($shipment->status == 1)
      <div style="font-size:16px;">Status : Delivered</div>
      <div style="font-size:16px;">Date : {{formatDate($shipment->delivery_date)}}</div>   
      @else
      <div style="font-size:16px;">Status : Packed</div>
      @endif
    </div>
    <br />
  </div>

  <div style="clear:both"></div>
    <div style="background-color:#323a45; padding:10px 20px;height:20px">
      <div style="width:50px;  color:#FFFFFF; float:left; font-weight:bold; text-align:center">S/N</div>
      <div style="width:210px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Item Name</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Quantity</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Price({{Session::get('currency_symbol')}})</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Tax(%)</div>
      <div style="width:100px; color:#FFFFFF; float:left; font-weight:bold; text-align:center">Discount(%)</div>
      <div style="width:200px; color:#FFFFFF; float:left; font-weight:bold; text-align:right">Amount({{Session::get('currency_symbol')}})</div>
      <div style="clear:both"></div>
    </div>
  <?php
    $taxAmount      = 0;
    $subTotalAmount = 0;
    $qtyTotal       = 0;
    $priceAmount    = 0;
    $discount       = 0;
    $discountPriceAmount = 0;  
    $sum = 0;
    $i=0;
  ?>
  @foreach ($shipmentItem as $item)
       <?php
        $price = ($item->quantity*$item->unit_price);
        $discount =  ($item->discount_percent*$price)/100;
        $discountPriceAmount = ($price-$discount);
        $qtyTotal +=$item->quantity; 
        $subTotalAmount += $discountPriceAmount; 
       ?> 
       @if($item->quantity>0)
    <div style="padding:0px 20px; margin-top:15px;">
      <div style="width:50px; font-size:14px; float:left; text-align:center">{{++$i}}</div>
      <div style="width:210px; float:left; font-size:14px; text-align:center">{{$item->description}}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center">{{$item->quantity}}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center">{{number_format($item->unit_price,2,'.',',')}}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center">{{number_format($item->tax_rate,2,'.',',')}}</div>
      <div style="width:100px; float:left; font-size:14px; text-align:center">{{number_format($item->discount_percent,2,'.',',')}}</div>
      <div style="width:200px; float:left; font-size:14px; text-align:right">{{number_format($discountPriceAmount,2,'.',',')}}</div>
    </div>
   <br/>
   <div style="clear:both"></div>
   @endif
  <?php
    $sum = $item->quantity+$sum;
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
      <div style="width:150px; text-align:right; font-size:14px; float:left;font-weight:bold;">{{ Session::get('currency_symbol').number_format($subTotalAmount,2,'.',',') }}</div>
    </div>
    @foreach($taxInfo as $rate=>$tax_amount)
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
      <div style="width:150px; text-align:right; font-size:14px; float:left; font-weight:bold;">{{ Session::get('currency_symbol').number_format(($subTotalAmount+$taxAmount),2,'.',',') }}</div>
    </div>

  </div>
</body>
</html>