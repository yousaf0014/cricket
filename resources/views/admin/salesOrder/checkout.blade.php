@extends('layouts.customer_panel')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.extra_text.checkout') }}</div>
            </div>
            <div class="col-md-2">
              @if(!empty(Session::get('order_add')))
                <a href="{{ url("order/add") }}" class="btn btn-block btn-default btn-flat btn-border-orange">{{ trans('message.extra_text.new_sales_order') }}</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      <!---Top Section End-->
      <form action="{{ url('customer-panel/order/finalCart') }}" method="POST" id="salesForm">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <div class="row">
            <div class="col-md-12 right-padding-col12">
                <div class="box box-default">
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                          <div class="table-responsive">
                            
                              <table class="table table-bordered" id="purchaseInvoice">
                                <tbody>

                                <tr class="tbl_header_color dynamicRows">
                                  <th class="text-left" width="65%">Description</th>
                                  <th class="text-center" width="10%">Quantity</th>
                                  <th class="text-center" width="10%">Rate($)</th>
                                  <th class="text-center" width="10%">Amount($)</th>
                                  <th class="text-center" width="5%">Action</th>
                                </tr>
                                <?php $total = 0; ?>
                                @foreach ($itemsDetails as $item)
                                  <?php 
                                  $cartData = array();
                                  $cartData =  isset($items[$item->id][0]) ? $items[$item->id][0]:array(); 
                                  $total += $cartData['quantity'] * $cartData['price'];
                                  ?>
                                  <tr id="tr_{{$item->id}}">
                                    <td class="text-left">{{$item->description}}</td>
                                    <td class="text-center">
                                        <input class="form-control text-center no_units valid" min="0" name="item[{{$item->id}}][id]" value="{{$item->id}}" type="hidden">
                                        <input id="{{$item->id}}" onchange="adjustValue()" class="qty form-control text-center no_units valid" min="0" name="item[{{$item->id}}][quantity]" value="{{$cartData['quantity']}}" type="text">

                                    </td>
                                    <td class="text-center" id="{{$item->id}}_price">{{$cartData['price']}}</td>
                                    <th class="text-center" id="{{$item->id}}_total">{{$cartData['quantity'] * $cartData['price']}}
                                    <th class="text-center"><a href="javascript:;" onclick="$('#tr_{{$item->id}}').remove();"><span class="glyphicon glyphicon-trash"></span></a></th>
                                  </tr>
                                @endforeach


                                <tr class="tableInfo"><td colspan="3" align="right"><strong >Sub Total($)</strong></td><td class="text-center"><strong id="subTotal">{{$total}}</strong></td><td>&nbsp;</td></tr>
                                
                                <tr class="tableInfo"><td colspan="3" align="right"><strong >Grand Total($)</strong></td><td class="text-center" id="grand_total"><strong>{{$total}}</strong></td><td>&nbsp;</td></tr>

                                </tbody>
                              </table>
                            
                          </div>
                          <br><br>
                          <a href="{{url('/customer-panel/order/add')}}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                         <button type="submit" class="btn btn-primary btn-flat pull-right" id="btnSubmit">{{ trans('message.form.submit') }}</button>
     
                        </div>
                      </div>                    
                    </div>              
                  </div>
                </div>
            </div>
          <!--Modal start-->
            <!--Modal end -->        
            
          </div>
      </form>
    </section>
@endsection
@section('js')
<script type="text/javascript">
  function adjustValue(){
    var total = 0;
    $('input.qty').each(function(){
      var id = $(this).attr('id');
      var qty = $(this).val();
      var subTotal = $('#'+id+'_price').text();
      var subValue = subTotal * qty;
      $('#'+id+'_total').text(subValue);
      total += subValue;
    });
    $('#subTotal').text(total);
    $('#grand_total').text(total);
  }

      $(function () {        
        $(".editor").wysihtml5();
      });

    $('#sendOrderInfo').validate({
        rules: {
            email: {
                required: true
            },
            subject:{
               required: true,
            },
            message:{
               required: true,
            }                   
        }
    }); 

</script>
@endsection