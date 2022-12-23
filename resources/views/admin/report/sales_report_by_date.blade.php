@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      
      <div class="box">
        <div class="box-body">
          <div class="col-md-12">
            <br>
            <a href="{{URL::to('/')}}/report/sales-report-by-date-pdf/{{$date}}" title="Pdf" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{URL::to('/')}}/report/sales-report-by-date-csv/{{$date}}" title="CSV" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
          </div>
        </div>
        <br>
      </div><!--Top Box End-->

      <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="salesList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">{{ trans('message.report.order_no') }}</th>
                  <th class="text-center">{{ trans('message.report.date') }}</th>
                  <th class="text-center">{{ trans('message.report.customer') }}</th>                  
                  <th class="text-center">{{ trans('message.report.qty') }}</th>
                  <th class="text-center">{{ trans('message.report.sales_value') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.cost') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.tax') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.profit') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.profit_margin') }}(%)</th>
                </tr>
                </thead>
                <tbody>
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
                if ($item->purch_price_amount != 0){
                $profit_margin = ($profit*100)/$item->purch_price_amount;
                } else {
                    $profit_margin = ($profit*100);
                }
                $qty += $item->qty;
                $sales_price += $item->sales_price_total;
                $purchase_price += $item->purch_price_amount;
                $tax += $item->tax; 
                $total_profit += $profit;
                if ($purchase_price == 0){ $purchase_price = 1; }         
                ?>
                <tr>
                  <td class="text-center">{{ $item->order_reference }}</td>
                  <td class="text-center">{{ formatDate($item->ord_date) }}</td>
                  <td class="text-center">{{ $item->name }}</td>
                  <td class="text-center">{{ $item->qty }}</td>
                  <td class="text-center">{{ number_format(($item->sales_price_total),2,'.',',') }}</td>
                  <td class="text-center">{{ number_format(($item->purch_price_amount),2,'.',',') }}</td>
                  <td class="text-center">{{ number_format(($item->tax),2,'.',',') }}</td>
                  <td class="text-center">{{ number_format(($profit),2,'.',',') }}</td>
                  <td class="text-center">{{ number_format(($profit_margin),2,'.',',') }}</td>
                </tr>
               @endforeach
               <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="text-right"><strong>Total</strong></td>
                <td class="text-center"><strong>{{$qty}}</strong></td>
                <td class="text-center"><strong>{{Session::get('currency_symbol').number_format(($sales_price),2,'.',',') }}</strong></td>
                <td class="text-center"><strong>{{Session::get('currency_symbol').number_format(($purchase_price),2,'.',',') }}</strong></td>
                <td class="text-center"><strong>{{Session::get('currency_symbol').number_format(($tax),2,'.',',') }}</strong></td>
                <td class="text-center"><strong>{{Session::get('currency_symbol').number_format(($total_profit),2,'.',',') }}</strong></td>               
                <td class="text-center"><strong>{{ number_format(($total_profit*100/$purchase_price),'2','.',',') }}%</strong></td>
               </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->
    </section>

@include('layouts.includes.message_boxes')
@endsection
@section('js')
<script type="text/javascript">
  $(function () {
    $("#salesList").DataTable({
      "order": [],

      "columnDefs": [ {
        "targets": 8,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection