@extends('layouts.customer_panel')
@section('content')
    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.customer') }}</div>
          </div> 
        </div>
      </div>
    </div> 
        
        <div class="box">
          <div class="row">
                <!-- form start -->
            <div class="col-md-6">
              <h4 class="text-info text-center">Sign in to start your session</h4>
              <form action="{{url('customer/authenticate')}}" method="post" class="form-horizontal">
              <input name="_token" value="{{csrf_token()}}" type="hidden">

              <div class="form-group">
                <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.email') }}</label>
                <div class="col-sm-8">
                  <input class="form-control" placeholder="Email" name="email" value="" type="email">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.password') }}</label>
                <div class="col-sm-8">
                  <input class="form-control" placeholder="Password" name="password" type="password">
                </div>
              </div>                
                <div class="row">
                  <div class="col-xs-8">
                    <div class="checkbox icheck">
                      <label>
              
                      </label>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('message.form.signin') }}</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>

              
              <!-- /.social-auth-links -->

              <a href="{{url('password/reset')}}">I forgot my password</a><br>
            </div>
            <div class="col-md-5" style="border-left:2px solid;">           
              <form action="{{ url('customer-panel/save') }}" method="post" id="customerAdd" class="form-horizontal">
              <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
              <div class="box-body">
              <div class="row">
                <h4 class="text-info text-center">{{ trans('message.invoice.customer_info') }}</h4>
                <div class="form-group">
                  <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.name') }}</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="{{old('name')}}">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.email') }}</label>

                  <div class="col-sm-8">
                    <input type="email" value="{{old('email')}}" class="form-control" name="email">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.password') }}</label>

                  <div class="col-sm-8">
                    <input type="password" value="{{old('password')}}" class="form-control" name="password">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                  <div class="col-sm-8">
                    <input type="text" value="{{old('phone')}}" class="form-control" name="phone">
                  </div>
                </div>

                <div class="form-group">
                      <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="bill_street" value="{{old('bill_street')}}" id="bill_street">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="bill_city" value="{{old('bill_city')}}" id="bill_city">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="bill_state" value="{{old('bill_state')}}" id="bill_state">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="bill_zipCode" value="{{old('bill_zipCode')}}" id="bill_zipCode">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                      <div class="col-sm-8">
                        <select class="form-control select2" name="bill_country_id" id="bill_country_id">
                        <option value="">{{ trans('message.form.select_one') }}</option>
                        @foreach ($countries as $data)
                          <option value="{{$data->code}}">{{$data->country}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
              
            
              </div><br>
              </div>
                <!-- /.box-body -->
                
                <div class="box-footer">
                  <a href="{{ url('customer/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                  <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                </div>
                <!-- /.box-footer -->
              </form>
            </div>
          </div>
        </div>
        
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>
@endsection

@section('js')
    <script type="text/javascript">

    $(".select2").select2();
      // Item form validation
    $('#customerAdd').validate({
        rules: {
            name: {
                required: true
            },
            email:{
                required: true
            },

            bill_street: {
                required: true
            },
            bill_city:{
                required: true
            },
            bill_state:{
               required: true
            },
            bill_country_id:{
               required: true
            },
           
            ship_street: {
                required: true
            },
            ship_city:{
                required: true
            },
            ship_state:{
               required: true
            },
            ship_country_id:{
               required: true
            }

        }
    });

    $('#copy').on('click', function() {

        $('#ship_street').val($('#bill_street').val());
        $('#ship_city').val($('#bill_city').val());
        $('#ship_state').val($('#bill_state').val());
        $('#ship_zipCode').val($('#bill_zipCode').val());

       var bill_country = $('#bill_country_id').val();
       
       $("#ship_country_id").val(bill_country).change();;

    });
    </script>
@endsection