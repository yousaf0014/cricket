<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $table = 'payment_history';

  /**
  * Update order table with invoice payment
  * @invoice_reference
  */
  public function updatePayment($reference,$amount){

    $currentAmount = DB::table('sales_orders')->where('reference',$reference)->select('paid_amount')->first();
    $sum = ($currentAmount->paid_amount + $amount);
    DB::table('sales_orders')->where('reference',$reference)->update(['paid_amount' => $sum]); 
    return true;
  }


}
