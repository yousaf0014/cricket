<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Model\Orders;
use App\Model\Sales;
use App\Model\Shipment;
use DB;
use PDF;
use  Route;

class CustomerPanelController extends Controller
{
	public function __construct(Orders $orders,Sales $sales,Shipment $shipment) {  
       list(, $action) = explode('@', Route::getCurrentRoute()->getActionName());
       $allowed = array('index','salesOrder','signin','store','confirmation');
       if(!in_array($action,$allowed) || Auth::guard('customer')->user()){            
           $this->middleware('customer');
           $this->order = $orders;
           $this->sale = $sales;
           $this->shipment = $shipment;
        } 
        if(\Session::get('redirect') == 1 &&  !empty(Auth::guard('customer')->user()->debtor_no) && $action != 'viewPayment'){
            return redirect()->intended("customer-panel/viewPayment")->send();
            exit;
        }
    }
    public function confirmation(request $request){
        $parameters = $request->all();
        $order_no = $parameters['order_no'];
        
        $order = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->where('id',$order_no)->first();
        $invoice = DB::table('sales_orders')->where('order_reference_id', $order_no)->first();
        $payments   = DB::table('payment_terms')->where('defaults',1)->first();

        $payment['invoice_reference'] = $invoice->reference;
        $payment['order_reference'] = $order->reference;
        $payment['payment_type_id'] = $payments->id;
        $payment['amount'] =  $order->total;
        $payment['payment_date'] = date('Y-m-d');
        $payment['reference'] =  ''; 
        $payment['person_id'] = 1; 
        $payment['customer_id'] = $order->debtor_no; 
        
        $payment = DB::table('payment_history')->insertGetId($payment);
        return view('admin.customerPanel.thanks');

    }

    public function signin(){
        $data['countries'] = DB::table('countries')->get();
        return view('admin.customerPanel.customer_signin',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:debtors_master,email',
            'password' => 'required|min:5',
            'bill_street'=>'required',
            'bill_city'=>'required',
            'bill_state'=>'required',
            'bill_country_id'=>'required'
        ]);
        
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['password'] = \Hash::make($request->password);
        //$data['sales_type'] = $request->sales_type;
        $data['created_at'] = date('Y-m-d H:i:s');

        $id = DB::table('debtors_master')->insertGetId($data);

        if(!empty($id)) {

            $data2['debtor_no'] = $id;
            $data2['br_name'] = $request->name;
            $data2['billing_street'] = $request->bill_street;
            $data2['billing_city'] = $request->bill_city;
            $data2['billing_state'] = $request->bill_state;
            $data2['billing_zip_code'] = $request->bill_zipCode;
            $data2['billing_country_id'] = $request->bill_country_id;
            DB::table('cust_branch')->insert($data2);

            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended("customer/");
        } else {
            return back()->withInput()->withErrors(['email' => "Invalid Request !"]);
        }
    }

    public function viewPayment(){
        \Session::pull('redirect','default');
        
        $debtor_no = Auth::guard('customer')->user()->debtor_no;
        $finalizeItems = \Session::pull('cart','default');
        $invoice_count = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->count();
        $total = 0;
        foreach($finalizeItems as $item){
            $total += $item[0]['quantity'] * $item[0]['price'];
        }
        $from_stk_loc = 1;
        $ord_date = date('Y-m-d');
        $reference = 'SO-' . sprintf("%04d", $invoice_count + 1);
        $branch_id = 1;
        $customer = $debtor_no;

        // create salesOrder 
        $salesOrder['debtor_no'] =  $debtor_no;
        $salesOrder['branch_id'] = $branch_id;
        $salesOrder['payment_id'] = '';
        $salesOrder['reference'] = $reference;
        $salesOrder['comments'] = $item[0]['description'];
        $salesOrder['trans_type'] = SALESORDER;
        $salesOrder['ord_date'] = $ord_date;
        $salesOrder['from_stk_loc'] = $from_stk_loc;
        $salesOrder['total'] = $total;
        $salesOrder['created_at'] = date('Y-m-d H:i:s');
        // d($salesOrder,1);
        $salesOrderId = \DB::table('sales_orders')->insertGetId($salesOrder);            

        foreach($finalizeItems as $item){
            
            // create salesOrderDetail 
            $salesOrderDetail[0]['order_no'] = $salesOrderId;
            $salesOrderDetail[0]['stock_id'] = $item[0]['stock_id'];
            $salesOrderDetail[0]['description'] = $item[0]['description'];
            $salesOrderDetail[0]['qty_sent'] = 0;
            $salesOrderDetail[0]['quantity'] = $item[0]['quantity'];
            $salesOrderDetail[0]['trans_type'] = SALESORDER;
            $salesOrderDetail[0]['discount_percent'] = 0;
            $salesOrderDetail[0]['tax_type_id'] = $item[0]['tax_id'];
            $salesOrderDetail[0]['unit_price'] = $item[0]['price'];

            DB::table('sales_order_details')->insertGetId($salesOrderDetail[0]);

        }
        $invoiceno = $this->__autoInvoiceCreate($salesOrderId,$debtor_no);

        return redirect()->intended("customer-panel/invoicePay/".$salesOrderId.'/'.$invoiceno);
        exit;
    }

    public function invoicePay($orderNo,$invoiceNo){
        $data['invoice_no'] = $invoiceNo;
        $data['saleDataOrder'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();

        $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();  
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('total','reference','order_no')->first();
        $data['paymentsList'] = DB::table('payment_history')
                                ->where(['order_reference'=>$data['orderInfo']->reference])
                                ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                                ->select('payment_history.*','payment_terms.name')
                                ->orderBy('payment_date','DESC')
                                ->get();
        $data['debtor'] = $debtor =Auth::guard('customer')->user();
        $data['debtor_shipment'] = DB::table('cust_branch')->where('debtor_no',$debtor->debtor_no)->first();
        $data['country'] = DB::table('countries')->where('code',$data['debtor_shipment']->billing_country_id)->select('country')->first();
        $data['payments']   = DB::table('payment_terms')->get();

        return view('admin.customerPanel.invoice_pay',$data);
    }
    private function __autoInvoiceCreate($orderNo,$debtor_no) {
        $userId = 1;
        $invoiceCount = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->count();
        if ($invoiceCount > 0) {
            $invoiceReference = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->select('reference')->orderBy('order_no', 'DESC')->first();

            $ref = explode("-", $invoiceReference->reference);
            $invoice_count = (int) $ref[1];
        } else {
            $invoice_count = 0;
        }



        $invoiceInfos = $this->order->getRestOrderItemsByOrderID($orderNo);
        $orderInfo = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();
        $payment_term = DB::table('invoice_payment_terms')->where('defaults', 1)->select('id')->first();
        $total = 0;
        $price = 0;
        $discountAmount = 0;
        $priceWithDiscount = 0;
        $taxAmount = 0;
        $priceWithTax = 0;
        foreach ($invoiceInfos as $key => $info) {
            $price = ($info->unit_price * $info->item_rest);
            $discountAmount = (($price * $info->discount_percent) / 100);
            $priceWithDiscount = ($price - $discountAmount);
            $taxAmount = (($priceWithDiscount * $info->tax_rate) / 100);
            $priceWithTax = ($priceWithDiscount + $taxAmount);
            $total +=$priceWithTax;
        }

        // Create salesOrder Invoice start
        $salesOrderInvoice['order_reference_id'] = $orderNo;
        $salesOrderInvoice['order_reference'] = $orderInfo->reference;
        $salesOrderInvoice['trans_type'] = SALESINVOICE;
        $salesOrderInvoice['reference'] = 'INV-' . sprintf("%04d", $invoice_count + 1);
        $salesOrderInvoice['debtor_no'] = $orderInfo->debtor_no;
        $salesOrderInvoice['branch_id'] = $orderInfo->branch_id;
        $salesOrderInvoice['payment_id'] = $orderInfo->payment_id;
        $salesOrderInvoice['comments'] = $orderInfo->comments;
        $salesOrderInvoice['ord_date'] = $orderInfo->ord_date;
        $salesOrderInvoice['from_stk_loc'] = $orderInfo->from_stk_loc;
        $salesOrderInvoice['total'] = $total;
        $salesOrderInvoice['payment_term'] = $payment_term->id;
        $salesOrderInvoice['created_at'] = date('Y-m-d H:i:s');


        $orderInvoiceId = DB::table('sales_orders')->insertGetId($salesOrderInvoice);

        foreach ($invoiceInfos as $i => $invoiceInfo) {
            if ($invoiceInfo->item_rest > 0) {
                $salesOrderDetailInvoice['order_no'] = $orderInvoiceId;
                $salesOrderDetailInvoice['stock_id'] = $invoiceInfo->stock_id;
                $salesOrderDetailInvoice['description'] = $invoiceInfo->description;
                $salesOrderDetailInvoice['qty_sent'] = $invoiceInfo->item_rest;
                $salesOrderDetailInvoice['quantity'] = $invoiceInfo->item_rest;
                $salesOrderDetailInvoice['trans_type'] = SALESINVOICE;
                $salesOrderDetailInvoice['discount_percent'] = $invoiceInfo->discount_percent;
                $salesOrderDetailInvoice['tax_type_id'] = $invoiceInfo->tax_type_id;
                $salesOrderDetailInvoice['unit_price'] = $invoiceInfo->unit_price;
                // Create salesOrderDetailInvoice End
                // create stockMove 
                $stockMove['stock_id'] = $invoiceInfo->stock_id;
                $stockMove['order_no'] = $orderNo;
                $stockMove['loc_code'] = $orderInfo->from_stk_loc;
                $stockMove['tran_date'] = date('Y-m-d');
                $stockMove['person_id'] = $userId;
                $stockMove['reference'] = 'store_out_' . $orderInvoiceId;
                $stockMove['transaction_reference_id'] = $orderInvoiceId;
                $stockMove['qty'] = '-' . $invoiceInfo->item_rest;
                $stockMove['price'] = $invoiceInfo->unit_price;
                $stockMove['trans_type'] = SALESINVOICE;
                $stockMove['order_reference'] = $orderInfo->reference;

                DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice);
                DB::table('stock_moves')->insertGetId($stockMove);
            }
        }
        return $orderInvoiceId;
    }
    
    public function index()
    {
       // $userStatus = Auth::guard('customer')->user()->inactive;
        $data['menu'] = 'home';
        $uid = Auth::guard('customer')->user() ? Auth::guard('customer')->user()->debtor_no:'';

        $data['totalOrder'] = DB::table('sales_orders')->where(['trans_type'=>SALESORDER,'debtor_no'=>$uid])->count();
        $data['totalInvoice'] = DB::table('sales_orders')->where(['trans_type'=>SALESINVOICE,'debtor_no'=>$uid])->count();
        $data['totalShipment'] = DB::table('shipment')
                ->leftJoin('shipment_details', 'shipment.id', '=', 'shipment_details.shipment_id')
                ->leftJoin('sales_orders','sales_orders.order_no','=','shipment_details.order_no')
                ->leftJoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                ->where('debtors_master.debtor_no', $uid)
                ->select('shipment_details.shipment_id','sales_orders.reference','sales_orders.order_no as order_id','debtors_master.name','shipment.packed_date','shipment.status', DB::raw('sum(shipment_details.quantity) as total_shipment'))
                ->groupBy('shipment_details.shipment_id')
                ->orderBy('shipment.packed_date','DESC')
                ->count();
        $data['totalBranch'] = DB::table('cust_branch')->where(['debtor_no'=>$uid])->count();
        //d($data['totalBranch'],1);
        $data['uid'] = $uid;
        return view('admin.customer.customer_panel',$data);
    }

    public function profile()
    {
        $id = Auth::guard('customer')->user()->debtor_no;
        $data['userData'] = DB::table('debtors_master')->where('debtor_no', '=', $id)->first();
        
        return view('admin.customerPanel.editProfile', $data);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'min:5|confirmed',
            'password_confirmation' => 'min:5'
        ]);

        $id = Auth::guard('customer')->user()->debtor_no;

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if($request->password) {
            $data['password'] = \Hash::make($request->password);
        }
        
        
        DB::table('debtors_master')->where('debtor_no', $id)->update($data);
        \Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended("customer/profile");
    }


    public function salesOrder()
    {
        $data['menu'] = 'order';
        $data['salesOrderData'] =  array();
        if(Auth::guard('customer')->user()){
            $data['salesOrderData'] = $this->order->getAllSalseOrderByCustomer(Auth::guard('customer')->user()->debtor_no);
        }
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();

        return view('admin.customerPanel.customer_sales_order', $data);
    }

    public function invoice()
    {
        $customerID = Auth::guard('customer')->user()->debtor_no;
        $data['menu'] = 'invoice';
        $data['salesOrderData'] = $this->order->getAllSalseInvoiceByCustomer($customerID);
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();
        return view('admin.customerPanel.customer_invoice', $data);
    }

    public function payment($id)
    {
        $data['menu'] = 'payment';

        
        $data['paymentList'] = DB::table('payment_history')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                             ->leftjoin('payment_terms',

                                'payment_terms.id','=','payment_history.payment_type_id')
                             ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                             ->where('sales_orders.debtor_no',$id)
                             ->select('payment_history.*','debtors_master.name','payment_terms.name as pay_type','sales_orders.order_no as invoice_id','sales_orders.order_reference_id as order_id')
                             ->orderBy('payment_date','DESC')
                             ->get();
        //d($data['paymentList'],1);
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();

        return view('admin.customerPanel.customer_payment', $data);
    }

    public function shipment($id)
    {
        $data['menu'] = 'shipment';
        
        $data['shipmentList'] = DB::table('shipment')
                ->leftJoin('shipment_details', 'shipment.id', '=', 'shipment_details.shipment_id')
                ->leftJoin('sales_orders','sales_orders.order_no','=','shipment_details.order_no')
                ->leftJoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                ->where('debtors_master.debtor_no', $id)
                ->select('shipment_details.shipment_id','sales_orders.reference','sales_orders.order_no as order_id','debtors_master.name','shipment.packed_date','shipment.status', DB::raw('sum(shipment_details.quantity) as total_shipment'))
                ->groupBy('shipment_details.shipment_id')
                //->orderBy('shipment_details.delivery_date','DESC')
                ->orderBy('shipment.packed_date','DESC')
                ->get();
        //d($data,1);

        return view('admin.customerPanel.customer_shipment', $data);
    }

    public function branch($id)
    {
        $data['menu'] = 'branch';
        $data['cusBranchData'] = DB::table('cust_branch')->where('debtor_no', $id)->get();

        return view('admin.customerPanel.customer_branch', $data);
        //d($data['branchList'],1);
    }

    public function branchEdit($id)
    {
        $data['menu'] = 'branch';
        $data['countries'] = DB::table('countries')->get();
        $data['branchData'] = DB::table('cust_branch')->where('branch_code', $id)->first();
        //d($data['branchData'],1);

        return view('admin.customerPanel.customer_branch_edit', $data);
    }

    public function branchUpdate($id)
    {
        //dd($_POST);
        $data['br_name'] = $_POST['br_name'];
        $data['br_contact'] = $_POST['br_contact'];
        //$data['br_address'] = $_POST['br_address'];
        $data['billing_street'] = $_POST['bill_street'];
        $data['billing_city'] = $_POST['bill_city'];
        $data['billing_state'] = $_POST['bill_state'];
        $data['billing_zip_code'] = $_POST['bill_zipCode'];
        $data['billing_country_id'] = $_POST['bill_country_id'];
        $data['shipping_street'] = $_POST['ship_street'];
        $data['shipping_city'] = $_POST['ship_city'];
        $data['shipping_state'] = $_POST['ship_state'];
        $data['shipping_zip_code'] = $_POST['ship_zipCode'];
        $data['shipping_country_id'] = $_POST['ship_country_id'];
        //d($data,1);
        DB::table('cust_branch')->where('branch_code', $id)->update($data);

        \Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended("customer-panel/branch/edit/$id");
    }


    /**
    * Preview of order details
    * @params order_no
    **/

    public function viewOrderDetails($orderNo){
        $data['menu'] = 'order';
        $data['taxType'] = $this->sale->calculateTaxRow($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();

        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();   
        $data['orderInfo']    = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no','ord_date')->first();                     
        $data['paymentsList'] = DB::table('payment_history')
                                ->where(['order_reference'=>$data['orderInfo']->reference])
                                ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                                ->select('payment_history.*','payment_terms.name')
                                ->orderBy('payment_date','DESC')
                                ->get();  
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();                        
      
        return view('admin.customerPanel.viewOrderDetails', $data);

    }

        /**
    * Preview of order details
    * @params order_no
    **/

    public function orderPdf($orderNo){
        $data['taxInfo'] = $this->sale->calculateTaxRow($orderNo);
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first(); 
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();
        
        $pdf = PDF::loadView('admin.customerPanel.orderPdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('order_'.time().'.pdf',array("Attachment"=>0));
    }


        /**
    * Preview of order details
    * @params order_no
    **/

    public function orderPrint($orderNo){
        $data['taxInfo'] = $this->sale->calculateTaxRow($orderNo);
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first(); 
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();
        
        $pdf = PDF::loadView('admin.customerPanel.orderPrint', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('order_'.time().'.pdf',array("Attachment"=>0));
    }



    /**
    * Preview of Invoice details
    * @params order_no, invoice_no
    **/

    public function viewInvoiceDetails($orderNo,$invoiceNo){
        $data['menu'] = 'invoice';

        $data['taxType'] = $this->sale->calculateTaxRow($invoiceNo);

        $data['saleDataOrder'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();

        $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($invoiceNo,$data['saleDataInvoice']->from_stk_loc);

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();

        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['paymentsList'] = DB::table('payment_history')
                                ->where(['order_reference'=>$data['orderInfo']->reference])
                                ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                                ->select('payment_history.*','payment_terms.name')
                                ->orderBy('payment_date','DESC')
                                ->get();

        $data['due_date']  = formatDate(date('Y-m-d', strtotime("+".$data['saleDataInvoice']->days_before_due."days")));
        //d( $data['saleDataInvoice'] ,1);
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first(); 
        return view('admin.customerPanel.viewInvoiceDetails', $data);
    }

   /**
    * Generate pdf for invoice
    */
    public function invoicePdf($orderNo,$invoiceNo){

        $data['taxInfo'] = $this->sale->calculateTaxRow($invoiceNo);
        $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($invoiceNo,$data['saleDataInvoice']->from_stk_loc);

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['due_date']  = formatDate(date('Y-m-d', strtotime("+".$data['saleDataInvoice']->days_before_due."days")));
        
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();
        
        $pdf = PDF::loadView('admin.customerPanel.invoicePdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('invoice_'.time().'.pdf',array("Attachment"=>0));        
    }


   /**
    * Generate pdf for invoice
    */
    public function invoicePrint($orderNo,$invoiceNo){

        $data['taxInfo'] = $this->sale->calculateTaxRow($invoiceNo);
        $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($invoiceNo,$data['saleDataInvoice']->from_stk_loc);

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['due_date']  = formatDate(date('Y-m-d', strtotime("+".$data['saleDataInvoice']->days_before_due."days")));
        
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();
        
        $pdf = PDF::loadView('admin.customerPanel.invoicePrint', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('invoice_'.time().'.pdf',array("Attachment"=>0));        
    }

    /**
    * Display receipt of payment
    */

    public function viewReceipt($id){
        $data['menu'] = 'payment';
                
        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name as branch_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.email','debtors_master.phone','debtors_master.name')      
                     ->first();
        $data['settings'] = DB::table('preference')->get();
        $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();
        
        return view('admin.customerPanel.viewReceipt', $data); 
    }

    /**
    * Details shipment by shipment id
    * @params shipment_id
    */
    public function shipmentDetails($order_no,$shipment_id){
      $data = array();
      $data['menu'] = 'shipment';
     
      $data['taxInfo'] = $this->shipment->calculateTaxForDetail($shipment_id);
      $data['shipmentItem'] = DB::table('shipment')
                             ->where('shipment.id',$shipment_id)
                             ->leftjoin('shipment_details','shipment_details.shipment_id','=','shipment.id')
                             ->leftjoin('item_code','shipment_details.stock_id','=','item_code.stock_id')
                             ->leftjoin('item_tax_types','item_tax_types.id','=','shipment_details.tax_type_id')
                             ->select('shipment_details.*','item_code.description','item_tax_types.tax_rate')
                             ->orderBy('shipment_details.quantity','DESC')
                             ->get();

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$order_no)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();

      $data['shipment']   = DB::table('shipment')
                          ->where('id',$shipment_id)
                          ->first();


      $shipmentTotal = $this->shipment->getTotalShipmentByOrderNo($order_no);
      $invoicedTotal = $this->shipment->getTotalInvoicedByOrderNo($order_no);
      $shipment = (int)abs($invoicedTotal)-$shipmentTotal;
      
      $data['shipmentStatus'] = ($shipment>0) ? 'available' : 'notAvailable';
      
      $data['settings'] = DB::table('preference')->get();
      $data['currency'] = DB::table('currency')->where('id',$data['settings'][17]->value)->first();
        
      return view('admin.customerPanel.shipmentDetails', $data);
    }    


}