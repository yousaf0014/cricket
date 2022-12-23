<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="pull-left">Add To Cart</h4>
        <a href="javascript:;" onclick="jQuery('#myModal').modal('hide');" class="glyphicon glyphicon-remove-circle pull-right text-primary f20"></a>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <form action="{{url('customer-panel/order/saveCart')}}" method="POST" id="salesForm">  
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">

            <!-- <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ trans('message.extra_text.payment_method') }}</label>
                        <select class="form-control select2" name="payment_id">

                            @foreach($payments as $payment)
                            <option value="{{$payment->id}}" <?= ($payment->defaults == "1" ? 'selected' : '') ?>>{{$payment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div> -->        
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input class="form-control text-center no_units valid" min="0" data-id="4" data-rate="925" id="qty_4" name="item_quantity" value="1" aria-invalid="false" type="text">
                    </div>
                </div>

            </div>        
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $itemData->purchase_price }}</h3>
                            <p>{{ $itemData->description }}</p>
                        </div>
                        <div class="icon">
                            @if (!empty($itemData->img))
                            <img src='{{url("public/uploads/itemPic/$itemData->img")}}' alt="" width="50" height="50">
                            @else
                            <img src='{{url("public/uploads/default-image.png")}}' alt="" width="50" height="50">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- /.box-body -->
                <input type="hidden" name="item_id" value="{{$itemData->item_id}}">
                <input type="hidden" name="unit_price" value="{{$itemData->retail_sale_price}}">
                <input type="hidden" name="stock_id" value="{{$itemData->stock_id}}">
                <input type="hidden" name="description" value="{{$itemData->description}}">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ trans('message.table.note') }}</label>
                        <textarea placeholder="{{ trans('message.table.description') }} ..." rows="3" class="form-control" name="comments"></textarea>
                    </div>
                    <a href="{{url('/customer-panel/order/add')}}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                    <button type="submit" class="btn btn-primary btn-flat pull-right" id="btnSubmit">{{ trans('message.form.submit') }}</button>
                </div>
            </div>
        </form>      
    </div>
</div>

<script type="text/javascript" src="{{asset('plugins/form/jquery.form.js?v=1')}}"></script>
<script type="text/javascript" src="{{asset('plugins/form/jquery.validate.min.js?v=1')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {   
    // Item form validation
        $('#salesForm').validate({
            rules: {
                payment_id: {
                    required: true
                },
                item_quantity: {
                    required: true
                }                        
            }
        });
      
    });
</script>