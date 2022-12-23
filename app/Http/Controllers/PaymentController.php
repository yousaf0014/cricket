<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Payment;
use App\Model\Shipment;
use Validator;
use DB;
use Session;
use Auth;
use PDF;

class PaymentController extends Controller
{

    public function __construct(Auth $auth, Payment $payment,Shipment $shipment,EmailController $email){
     /**
     * Set the database connection. reference app\helper.php
     */     
          //selectDatabase();
          $this->auth = $auth::user(); 
          $this->payment = $payment; 
          $this->shipment = $shipment;
          $this->email = $email;
    }

   /**
    * Payment list
    */
    public function index(){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'payment/list';
       $data['paymentList'] = DB::table('payment_history')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                             ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                             ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                             ->select('payment_history.*','debtors_master.name','payment_terms.name as pay_type','sales_orders.order_no as invoice_id','sales_orders.order_reference_id as order_id')
                             ->orderBy('payment_history.id','DESC')
                             ->get();

       // d($data['paymentList'],1);
        return view('admin.payment.paymentList', $data);     
    }

    /**
     * Create new payment.
     *
     */
    public function createPayment(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'payment_type_id' => 'required',
            'payment_date'=>'required'
        ]);

        $payment['invoice_reference'] = $request->invoice_reference;
        $payment['order_reference'] = $request->order_reference;
        $payment['payment_type_id'] = $request->payment_type_id;
        $payment['amount'] =  $request->amount;
        $payment['payment_date'] = DbDateFormat($request->payment_date);
        $payment['reference'] =  $request->reference; 
        $payment['person_id'] = $this->auth->id; 
        $payment['customer_id'] = $request->customer_id; 
        
        $orderNo = $request->order_no;
        $invoiceNo = $request->invoice_no; 
        $payment = DB::table('payment_history')->insertGetId($payment);
        
        if (!empty($payment)) {
            $paidAmount = $this->payment->updatePayment($request->invoice_reference,$request->amount);
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('invoice/view-detail-invoice/'.$orderNo.'/'.$invoiceNo);
        }
    }

    /**
    * Delete payment by id 
    **/
    public function delete(Request $request){
        $id = $request['id'];
        $paymentInfo = DB::table('payment_history')
                     ->where('id',$id)
                     ->select('id','order_reference','invoice_reference','amount')
                     ->first();
        $totalPaidAmount = DB::table('sales_orders')
                     ->where(['order_reference'=>$paymentInfo->order_reference,'reference'=>$paymentInfo->invoice_reference])
                     ->sum('paid_amount');
        $newAmount   = ($totalPaidAmount-$paymentInfo->amount);
        $update      = DB::table('sales_orders')
                     ->where(['order_reference'=>$paymentInfo->order_reference,'reference'=>$paymentInfo->invoice_reference])
                     ->update(['paid_amount'=>$newAmount]);

        DB::table('payment_history')->where('id',$id)->delete();
        \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended('payment/list');
    }

    /**
    * Display receipt of payment
    */

    public function viewReceipt($id){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'payment/list';        
        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.email','debtors_master.phone','debtors_master.name')      
                     ->first();
       //d($data['paymentInfo'],1);
        //Right part start
        $data['invoiceList'] = DB::table('sales_orders')
                        ->where('order_reference',$data['paymentInfo']->order_reference)
                        ->select('order_no','reference','order_reference','total','paid_amount')
                        ->orderBy('created_at','DESC')
                        ->get();
       
        $data['invoiceQty'] = DB::table('stock_moves')->where(['order_no'=>$data['paymentInfo']->order_reference_id,'trans_type'=>SALESINVOICE])->sum('qty');
        $data['orderQty'] = DB::table('sales_order_details')->where(['order_no'=>$data['paymentInfo']->order_reference_id,'trans_type'=>SALESORDER])->sum('quantity');

        $data['paymentsList'] = DB::table('payment_history')
                            ->where(['order_reference'=>$data['paymentInfo']->order_reference])
                            ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                            ->select('payment_history.*','payment_terms.name')
                            ->orderBy('payment_date','DESC')
                            ->get();
        $data['shipmentList'] = DB::table('shipment_details')
                            ->select('shipment_details.shipment_id',DB::raw('sum(quantity) as total'))->where(['order_no'=>$data['paymentInfo']->order_reference_id])
                            ->groupBy('shipment_id')
                            ->orderBy('shipment_id','DESC')
                            ->get();
        $shipmentTotal = $this->shipment->getTotalShipmentByOrderNo($data['paymentInfo']->order_reference_id);
        $invoicedTotal = $this->shipment->getTotalInvoicedByOrderNo($data['paymentInfo']->order_reference_id);
        $shipment = (int)abs($invoicedTotal)-$shipmentTotal;      
        $data['shipmentStatus'] = ($shipment>0) ? 'available' : 'notAvailable';
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$data['paymentInfo']->order_reference_id)->select('reference','order_no')->first();
         //Right part end
       $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>1,'lang'=>$lang])->select('subject','body')->first();

        return view('admin.payment.viewReceipt', $data); 
    }

    /**
    * Create receipt of payment
    */

    public function createReceiptPdf($id){        
        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.email','debtors_master.phone','debtors_master.name')      
                     ->first();

        $pdf = PDF::loadView('admin.payment.paymentReceiptPdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('payment_'.time().'.pdf',array("Attachment"=>0));

    }

    /**
    * Print receipt of payment
    */

    public function printReceipt($id){        

        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.email','debtors_master.phone','debtors_master.name')      
                     ->first();                    
       
        //return view('admin.payment.printReceipt', $data); 
        $pdf = PDF::loadView('admin.payment.printReceipt', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->stream('payment_'.time().'.pdf',array("Attachment"=>0));

    }

    /**
    * Send email to customer for payment information
    */
    public function sendPaymentInformationByEmail(Request $request){
        $this->email->sendEmail($request['email'],$request['subject'],$request['message']);
        \Session::flash('success',trans('message.email.email_send_success'));
        return redirect()->intended('payment/view-receipt/'.$request['id']);
    }
}