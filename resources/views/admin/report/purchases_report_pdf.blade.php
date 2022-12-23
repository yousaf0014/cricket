<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Purchases Order report</title>
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
            <strong>Purchases Order Report(<?php echo formatDate(date('d-m-Y')) ?>)</strong> 
            <br> <br>
                    <div style="clear:both"></div>

                    <table width="100%">
                        <tr>
                            <th>Date</th>
                            <th>Purchases Item</th>
                            <th>Purchases Item Description</th>
                            <th>No Of Order</th>
                        </tr>
                        <?php
                        $qty = 0;
                        $price = 0;
                        $order = 0;
                        $count = 0;
                        ?>
                        @foreach ($itemList as $item)                        
                        @if($item->sales_stock_id)
                        <?php
                        $qty += $item->qty;
                        $price += ($item->price - $item->discount);
                        $order += $item->no_of_order;
                        $count ++;
                        ?>
                        <tr>

                            <td>{{ $item->ord_date }}</td>
                            <td>{{ $item->sales_stock_id }}</td>
                            <td>{{ $item->sales_description }}</td>
                            <td>{{ $item->no_of_order }}</td>

                        </tr>
                        @endif
                        @endforeach  

                        <tr>

                            <th align="right">Total</th>
                            <th>{{ $count }}</th>
                            <th>Purchases Value {{ Session::get('currency_symbol').number_format($price,2,'.',',') }}</td>
                                <th>{{ $order }}</th>

                        </tr>

                        </div>
                        </body>
                        </html>