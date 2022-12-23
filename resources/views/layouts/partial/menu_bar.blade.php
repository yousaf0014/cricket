<ul class="nav navbar-nav">
  <li <?= isset($menu) && $menu == 'home' ? ' class="active"' : ''?> ><a href='{{url("customer/dashboard")}}'>{{ trans('message.customer_panel.home')}}</a></li>
  <?php  
  	$id = 1; //Auth::guard('customer')->user()->debtor_no;
  	if(Auth::guard('customer')->user()){
  ?>
  <li <?= isset($menu) && $menu == 'order' ? ' class="active"' : ''?> ><a href='{{url("customer-panel/order/")}}'>{{ trans('message.customer_panel.sales_order')}}</a></li>
  <li  <?=isset($menu) && $menu == 'invoice' ? ' class="active"' : ''?> ><a href="{{url("customer-panel/invoice/")}}">{{ trans('message.customer_panel.invoices')}}</a></li>
  <li  <?=isset($menu) && $menu == 'payment' ? ' class="active"' : ''?> ><a href="{{url("customer-panel/payment/$id")}}">{{ trans('message.customer_panel.payments')}}</a></li>
 <!-- <li  <?=isset($menu) && $menu == 'shipment' ? ' class="active"' : ''?> ><a href="{{url("customer-panel/shipment/")}}">{{ trans('message.customer_panel.shipments')}}</a></li>
  <li  <?=isset($menu) && $menu == 'branch' ? ' class="active"' : ''?> ><a href="{{url("customer-panel/branch/")}}">{{ trans('message.customer_panel.branches')}}</a></li>
  -->
  <?php } ?>

</ul>