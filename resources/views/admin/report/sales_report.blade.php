@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-body">
          <div class="col-md-6 col-xs-12">
              <div class="row">
            <form class="form-horizontal" action="{{ url('report/sales-report') }}" method="get">
              
              <div class="col-md-5">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" id="from" type="text" name="from">
                  </div>
              </div>

              <div class="col-md-5">
                  <label for="exampleInputEmail1">{{ trans('message.report.to') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="to" type="text" name="to">
                  </div>
              </div>

              <div class="col-md-2">
                <label for="btn">&nbsp;</label>
                <button type="submit" name="btn" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
              </div>
            </form>
          </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <br>
            <div class="btn-group pull-right">
              <a href="{{URL::to('/')}}/report/sales-report-csv" title="CSV" class="btn btn-default btn-flat">{{ trans('message.extra_text.csv') }}</a>
              <a href="{{URL::to('/')}}/report/sales-report-pdf" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
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
                  <th class="text-center">{{ trans('message.report.date') }}</th>
                  <th class="text-center">{{ trans('message.report.sales_volume') }}</th>
                  <th class="text-center">{{ trans('message.report.sales_value') }}({{Session::get('currency_symbol')}})</th>
                  <th class="text-center">{{ trans('message.report.no_of_orders') }}</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $qty = 0;
                  $price = 0;
                  $order = 0;
                ?>
                @foreach ($itemList as $item)
                <?php
                $qty += $item->qty; 
                $price += ($item->price-$item->discount); 
                $order += $item->no_of_order;
                ?>
                <tr>
                  <td class="text-center"><a href="{{URL::to('/')}}/report/sales-report-by-date/{{ strtotime($item->ord_date) }}">{{ formatDate($item->ord_date) }}</a></td>
                  <td class="text-center">{{ $item->qty }}</td>
                  <td class="text-center">{{ number_format(($item->price-$item->discount),2,'.',',') }}</td>
                  <td class="text-center">{{ $item->no_of_order }}</td>
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
  $(".select2").select2({});
    
    $('#from').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
    $('#from').datepicker('update', new Date());

    $('#to').datepicker({
        autoclose: true,
        todayHighlight: true,
        
        format: '{{Session::get('date_format_type')}}'
    });
    $('#to').datepicker('update', new Date());


    $("#salesList").DataTable({
      "order": [],

      "columnDefs": [ {
        "targets": 3,
        "orderable": true
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection