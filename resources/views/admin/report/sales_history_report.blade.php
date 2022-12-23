@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      
      <div class="box">
        <div class="box-body">
          <div class="col-md-7 col-xs-12">
              <div class="row">
            <form class="form-horizontal" action="{{ url('report/sales-history-report') }}" method="GET" id='salesHistoryReport'>
              
              <div class="col-md-4">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" id="from" type="text" name="from" value="<?= isset($from) ? $from : '' ?>" required>
                  </div>
              </div>

              <div class="col-md-4">
                  <label for="exampleInputEmail1">{{ trans('message.report.to') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="to" type="text" name="to" value="<?= isset($to) ? $to : '' ?>" required>
                  </div>
              </div>

              <div class="col-md-3">
                <label for="exampleInputEmail1">{{ trans('message.form.customer') }}</label>
                <select class="form-control select2" name="customer" id="customer" required>
                <option value="all" <?= ($user=='all') ? 'selected' : ''?>>All</option>
                @foreach($customerList as $data)
                  <option value="{{$data->debtor_no}}" <?= ($data->debtor_no == $user) ? 'selected' : ''?>>{{$data->name}}</option>
                @endforeach
                </select>
              </div>

              <div class="col-md-1">
                <label for="btn">&nbsp;</label>
                <button type="submit" name="btn" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
              </div>
            </form>
          </div>
          </div>
          <div class="col-md-5 col-xs-12">
            <br>
            <div class="btn-group pull-right">
              <a href="{{URL::to('/')}}/report/sales-history-report-csv" title="CSV" class="btn btn-default btn-flat">{{ trans('message.extra_text.csv') }}</a>
              <a href="{{URL::to('/')}}/report/sales-history-report-pdf" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
            </div>

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
                
                if($item->purch_price_amount == 0){
                  $profit_margin = 0;
                }else{
                $profit_margin = ($profit*100)/$item->purch_price_amount;
                }

                $qty += $item->qty;
                $sales_price += $item->sales_price_total;
                $purchase_price += $item->purch_price_amount;
                $tax += $item->tax;
                $total_profit += $profit 
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
    
  $(".select2").select2({});
    
    $('#from').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
    //$('#from').datepicker('update', new Date());

    $('#to').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
    //$('#to').datepicker('update', new Date());

  });

// Item form validation
    $('#salesHistoryReports').validate({
        rules: {
            from: {
                required: true
            },
            to: {
                required: true
            }                  
        }
    });

    </script>
@endsection