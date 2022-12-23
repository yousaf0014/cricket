@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.purchase') }}</div>
            </div> 
            <div class="col-md-2">
              @if(!empty(Session::get('purchese_add')))
                <a href="{{ url('purchase/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange">{{ trans('message.extra_text.new_purchase') }}</a>
              @endif
            </div>

          </div>
        </div>
      </div>

        <!-- Default box -->
        <div class="box">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table id="purchaseList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="10%">{{ trans('message.table.invoice') }} #</th>
                    <th>{{ trans('message.table.supp_name') }}</th>
                    <th>{{ trans('message.table.ord_date') }}</th>
                    <th>{{ trans('message.invoice.total') }}</th>
                    <th width="5%" class="hideColumn">{{ trans('message.table.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($purchData as $data)
                  <tr>
                    <td><a href="{{URL::to('/')}}/purchase/view-purchase-details/{{$data->order_no}}" >{{ $data->reference }}</a></td>
                    <td><a href="{{ url("edit-supplier/$data->supplier_id") }}">{{ $data->supp_name }}</a></td>
                    <td>{{ formatDate($data->ord_date)}}</td>
                    <td>{{ Session::get('currency_symbol').number_format($data->total,2,'.',',') }}</td>
                    
                    <td class="hideColumn">
                    @if(!empty(Session::get('purchese_edit')))
                        <a  title="edit" class="btn btn-xs btn-primary" href='{{ url("purchase/edit/$data->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;
                    @endif
                    @if(!empty(Session::get('purchese_delete')))
                        <form method="POST" action="{{ url("purchase/delete/$data->order_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_invoice_header') }}" data-message="{{ trans('message.table.delete_invoice') }}">
                                <i class="glyphicon glyphicon-trash"></i> 
                            </button>
                        </form>
                    @endif
                    </td>
                  </tr>
                 @endforeach
                  </tfoot>
                 </table>
            </div>
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
    $("#purchaseList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 4,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
  });
    </script>
@endsection