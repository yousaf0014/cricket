@extends('layouts.customer_panel')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                   <strong class="text-info">{{ trans('message.invoice.payment')}}</strong>
                  </div>
                </div>
              </div>

              <div class="box-body">
                <div class="row">
                    <form class="form-horizontal" id="payForm" action="<?php echo url('/'); ?>/payment-redirect.php" method="POST">
                      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                      <input type="hidden" name="invoice_reference" value="{{$saleDataInvoice->reference}}">
                      <input type="hidden" name="order_reference" value="{{$saleDataOrder->reference}}">
                      <input type="hidden" name="customer_id" value="{{$debtor->debtor_no}}">

                      <input type="hidden" name="order_no" value="{{$orderInfo->order_no}}">
                      <input type="hidden" name="invoice_no" value="{{$invoice_no}}">
                      
                      <div class="form-group">
                        <label for="payment_type_id" class="col-sm-3 control-label">{{ trans('message.form.payment_type') }} : </label>
                        <div class="col-sm-6">
                          <select style="width:100%" class="form-control" name="payment_type_id" id="payment_type_id">
                            
                            @foreach($payments as $payment)
                              <?php if($payment->defaults == '1'){?>
                              <option value="{{$payment->id}}">{{$payment->name}}</option>
                              <?php } ?>
                              @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label">{{ trans('message.invoice.total') }} : </label>
                        <div class="col-sm-6">
                          <input type="number" name="total" value="{{$orderInfo->total}}" class="form-control" id="amount" placeholder="Amount">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label">{{ trans('message.invoice.amount') }} : </label>
                        <div class="col-sm-6">
                          <input type="number" name="amount" readonly="readonly" value="{{$saleDataInvoice->total-$saleDataInvoice->paid_amount}}" class="form-control" id="amount" placeholder="Amount">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="payment_date" class="col-sm-3 control-label">{{ trans('message.invoice.paid_no') }} : </label>
                        <div class="col-sm-6">
                          <input type="text" name="payment_date" class="form-control" id="payment_date" placeholder="{{ trans('message.invoice.paid_on') }}" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="reference" class="col-sm-3 control-label">{{ trans('message.table.reference') }} : </label>
                        <div class="col-sm-6">                          
                          <input type="text" name="reference" class="form-control" id="reference" placeholder="{{ trans('message.table.reference') }}" value="{{$saleDataOrder->reference}}">
                        </div>
                      </div>
                      <input type="hidden" value="{{$debtor->name}}" name="cname">
                      <input type="hidden" value="{{$debtor->address}}" name="address">
                      <input type="hidden" value="{{$debtor_shipment->billing_city}}" name="city">
                      <input type="hidden" value="{{$debtor_shipment->billing_state}}" name="state">
                      <input type="hidden" value="{{$country->country}}" name="country">
                      <input type="hidden" value="{{$debtor_shipment->billing_zip_code}}" name="zip">
                      <input type="hidden" value="{{$debtor->email}}" name="email">
                      <input type="hidden" value="{{$debtor->phone}}" name="phone">
                      <input type="hidden" value="{{$debtor->name}}" name="cname">

                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                          <button type="submit" class="btn btn-primary btn-flat">Pay Now</button>
                        </div>
                      </div>
                    </form>                 
                </div>                
              </div>
            </div>
        </div>
      </div>
    </section>
@endsection

@section('js')
  <script type="text/javascript">
  </script>
@endsection