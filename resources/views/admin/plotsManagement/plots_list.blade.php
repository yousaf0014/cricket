@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
             <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.plots') }}</div>
            </div> 
             @if (!empty(Session::get('item_add')))
            <div class="col-md-2 top-left-btn">
                <a href="{{ URL::to('plotManagementimport') }}" class="btn btn-block btn-default btn-flat btn-border-purple"><span class="fa fa-upload"> &nbsp;</span>{{ trans('message.extra_text.import_new_plots') }}</a>
            </div>

            <div class="col-md-2 top-right-btn">
                <a href="{{ url('create-plotManagement/plot') }}" class="btn btn-block btn-default btn-flat btn-border-orange">{{ trans('message.extra_text.add_new_item') }}</a>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Top Box-->
      <div class="box">
        <div class="box-body">
          <div class="col-md-2 col-xs-6 border-right text-center">
              <h3 class="bold">{{count($plotsData)}}</h3>
              <span class="text-info bold">{{ trans('message.table.plots') }}</span>
          </div>

          <div class="col-md-3 col-xs-6 border-right text-center">
              <h3 class="bold">{{ Session::get('currency_symbol').number_format($costValueQtyOnHand,2,'.',',')}}</h3>
              <span class="text-info">{{ trans('message.report.on_hand_cost_value') }}</span>
          </div>
         


        </div>
        <br>
      </div><!--Top Box End-->

      <!-- Default box -->
      <div class="box">
      
            <div class="box-header">
              <a href="{{ URL::to('plotManagementdownloadcsv/csv') }}"><button class="btn btn-default btn-flat btn-border-info"><span class="fa fa-download"> &nbsp;</span>{{ trans('message.table.download_csv') }}</button></a>
            </div>
  
            <!-- /.box-header -->
            <div class="box-body">
              <table id="itemList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">{{ trans('message.table.picture') }}</th>
                  <th class="text-center">{{ trans('message.table.plots_id') }}</th>
                  <th class="text-center">{{ trans('message.table.plot_location') }}</th>
                  <th class="text-center">{{ trans('message.table.plot_size') }}</th>
                  <th class="text-center">{{ trans('message.table.plot_price') }}</th>
                  <th class="text-center">{{ trans('message.table.plots_access_passes') }}</th>
                  <th class="text-center">{{ trans('message.table.plots_customer') }}</th>
                  <th class="text-center">{{ trans('message.form.status') }}</th>
                  <th width="14%" class="text-center">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($plotsData as $data)
                <tr>
                  <td width="5%" class="text-center">
                  <a href="{{ url("edit-plotManagement/plots-info/$data->pid") }}">
                    @if (!empty($data->img))
                    <img src='{{url("public/uploads/itemPic/$data->img")}}' alt="" width="50" height="50">
                    @else
                    <img src='{{url("public/uploads/default-image.png")}}' alt="" width="50" height="50">
                    @endif
                    </a>
                  </td>
                  <td class="text-center"><a href="{{ url("edit-plotManagement/$data->pid") }}">{{ $data->plot_id}}</a></td>
                  <td class="text-center">{{ $data->plot_location }}</td>
                  <td class="text-center">{{ $data->plot_size }}</td>
                  <td class="text-center">{{ $data->plot_price }}</td>
                  <td class="text-center">{{ $data->access_passes }}</td>
                  <td class="text-center">{{ $data->cus_name }}</td>
                  <td class="text-center">
                  @if($data->is_hired == 1)
                    <span class='label label-success'>Not Available</span>
                  @else
                    <span class='label label-danger'>Available</span>
                  @endif
                  </td>
                  
                  <td class="text-center">
                  @if (!empty(Session::get('item_edit')))
                      <a title="edit" class="btn btn-xs btn-primary" href='{{ url("edit-plotManagement/$data->pid") }}'><span class="fa fa-edit"></span></a> &nbsp;
                  @endif
                  @if (!empty(Session::get('item_delete')))
                      <form method="POST" action="{{ url("plotManagement/delete/$data->pid") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button title="{{ trans('message.form.Edit') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.edit_plot_header') }}" data-message="{{ trans('message.table.edit_plot') }}">
                              <i class="glyphicon glyphicon-trash mr5"></i> 
                          </button> &nbsp;
                      </form>
                  @endif
                  </td>
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
    $("#itemList").DataTable({
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