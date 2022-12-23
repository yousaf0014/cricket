@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Top Box-->
      <div class="box">
        <div class="box-body">
          <strong>
           {{ trans('message.table.plot_info') }}
          </strong>
        </div>
      </div><!--Top Box End-->
      <!-- Default box -->
            <div class="box">
            
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" id="tabs">

            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center">{{ trans('message.table.plot_info') }}</h4>
                <form action="{{ url('save-plotManagement') }}" method="post" id="plotAddForm" class="form-horizontal" enctype="multipart/form-data">
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_id') }}</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.plot_id') }}" class="form-control" name="plot_id" value="{{old('plot_id')}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_location') }}</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.plot_location') }}" class="form-control valdation_check" name="plot_location" value="{{old('plot_location')}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_size') }}</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.plot_size') }}" class="form-control valdation_check" name="plot_size" value="{{old('plot_size')}}">
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_price') }}</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.plot_price') }}" class="form-control valdation_check" name="plot_price" value="{{old('plot_price')}}">
                      </div>
                    </div>                    

 
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.item_tax_type') }}</label>
                      <div class="col-sm-9">
                        <select class="form-control select2" name="tax_type_id">
                       
                        @foreach ($taxTypes as $taxType)
                          <option value="{{$taxType->id}}" >{{$taxType->name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                    

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control input-file-field" name="plot_img">
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <a href="{{ url('plotsManagement') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                    <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                  </div>
                  <!-- /.box-footer -->
                </form>
              </div>
              </div>
              </div>
             
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        
          </div>
        <div class="clearfix"></div>
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>
@endsection
@section('js')
    <script type="text/javascript">
$(document).ready(function () {

    $(".select2").select2({
       width: '100%'
    });

    $(document).on('change','#cat', function() {
      var option = $('option:selected', this).attr('data');
      $("#unit").val(option);
    });

// Item form validation
    $('#plotAddForm').validate({
        rules: {
            plot_id: {
                required: true
            },
            plot_location: {
                required: true
            },
            plot_size:{
               required: true
            },
            tax_type_id:{
               required: true
            }, 
            units:{
               required: true
            }                        
        }
    });
  
});

    </script>
@endsection