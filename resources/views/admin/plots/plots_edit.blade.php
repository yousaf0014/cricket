@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Top Box-->
      <div class="box">
        <div class="box-body">
          <strong>{{$plotInfo->plot_id}}</strong>
        </div>
      </div><!--Top Box End-->
      <!-- Default box -->
      <div class="box">

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" id="tabs">
            <ul class="nav nav-tabs">
              
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">{{ trans('message.table.general_settings') }}</a></li>
            
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center">{{ trans('message.table.item_info') }}</h4>
                  <form action="{{ url('update-plot-info') }}" method="post" id="itemEditForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                    <input type="hidden" value="{{$plotInfo->plot_id}}" name="plot_id">
                    <div class="box-body">

                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_id') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="plot_id" value="{{$plotInfo->plot_id}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_location') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="plot_location" value="{{$plotInfo->plot_location}}">
                        </div>
                      </div>
                        
                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_size') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="plot_size" value="{{$plotInfo->plot_size}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_price') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="plot_price" value="{{$plotInfo->plot_price}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_access_passes') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="access_passes" value="{{$plotInfo->access_passes}}">
                        </div>
                      </div>
                        
                        
                        <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_assigned_customer') }}</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="debtor_no">
                         
                          @foreach ($customers as $customer)
                            <option value="{{$customer->debtor_no}}" <?= ($customer->debtor_no==$plotInfo->debtor_no)?'selected':''?>>{{$customer->br_name}}</option>
                          @endforeach
                          </select>
                        </div>
                      </div>  

                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_amount_paid') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="amount_paid" value="{{$plotInfo->amount_paid}}">
                        </div>
                      </div> 
                        
                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_amount_remaining') }}</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="amount_remaining" value="{{$plotInfo->amount_remaining}}">
                        </div>
                      </div> 

                      <div class="form-group">
                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.plot_is_hired') }}</label>

                        <div class="col-sm-9">
                            <input type="radio" class="form-radio" name="is_hired" value="1" <?= ($plotInfo->is_hired==1)?'checked':''?>> Yes
                            <input type="radio" class="form-radio" name="is_hired" value="0" <?= ($plotInfo->is_hired==0)?'checked':''?>> No
                        </div>
                      </div>                         
                        
                        
                     

                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control input-file-field" name="plot_img">
                          <br>
                          @if (!empty($plotInfo->plot_img))
                          <img src='{{ url("public/uploads/plotsPic/$plotInfo->plot_img") }}' alt="Item Image" width="80" height="80">
                          @else
                          <img src='{{ url("public/uploads/default_product.jpg") }}' alt="Item Image" width="80" height="80">
                          @endif
                         <input type="hidden" name="plot_img" value="{{ $plotInfo->plot_img ? $plotInfo->plot_img : 'NULL' }}">
                            
                        </div>
                      </div>
                      
                    </div>
                    <!-- /.box-body -->
          
                    <div class="box-footer">
                      <a href="{{ url('plots/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                      <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                    </div>
           
                    <!-- /.box-footer -->
                  </form>
              </div>
              </div>
              </div>
             
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        
          </div>
        <div class="clearfix"></div>
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>

    @include('layouts.includes.message_boxes')


@endsection
@section('js')
    <script type="text/javascript">
$(document).ready(function () {
// Item form validation
    $('#itemEditForm').validate({
        rules: {
            stock_id: {
                required: true
            },
            description: {
                required: true
            },
            category_id:{
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
    // Sales form validation
    $('#salesInfoForm').validate({
        rules: {
            sales_type_id: {
                required: true
            },
            price: {
                required: true
            }                        
        }
    });

    // Purchse form validation
    $('#purchaseInfoForm').validate({
        rules: {
            supplier_id: {
                required: true
            },
            price: {
                required: true
            },
            suppliers_uom: {
                required: true
            }                                     
        }
    });

    $(".select2").select2({
       width: '100%'
    });


    $('.edit_type').on('click', function() {
      
        var id = $(this).attr("id");

        $.ajax({
            url: '{{ URL::to('edit-sale-price')}}',
            data:{  // data that will be sent
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              
                $('#sales_type_id').val(data.sales_type_id);
                $('#price').val(data.price);
                $('#type_id').val(data.id);

                $('#edit-type-modal').modal();
            }
        });

    });

});

    </script>
@endsection