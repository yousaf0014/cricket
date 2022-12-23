<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
	protected $table = 'purch_orders';

    public function getAllPurchOrder()
    { 
        return $this->leftJoin('suppliers', 'purch_orders.supplier_id', '=', 'suppliers.supplier_id')
                    ->leftJoin('location', 'purch_orders.into_stock_location', '=', 'location.loc_code')
                    ->select('purch_orders.*', 'suppliers.supp_name','location.location_name as loc_name')
                    ->orderBy('purch_orders.order_no', 'desc')
                    ->get();
    }

    public function getAllPurchOrderById($sid)
    { 
        return $this->leftJoin('suppliers', 'purch_orders.supplier_id', '=', 'suppliers.supplier_id')
                    ->leftJoin('location', 'purch_orders.into_stock_location', '=', 'location.loc_code')
                    ->select('purch_orders.*', 'suppliers.supp_name','location.location_name as loc_name')
                    ->orderBy('purch_orders.order_no', 'desc')
                    ->where('purch_orders.supplier_id',$sid)
                    ->get();
    }

    public function getPurchaseInvoiceByID($id)
    {
          $data = DB::table('purch_order_details')
                ->where(['order_no'=>$id])
                ->leftJoin('item_code', 'purch_order_details.item_code', '=', 'item_code.stock_id')
                ->leftjoin('item_tax_types','item_tax_types.id','=','purch_order_details.tax_type_id')
                ->leftJoin('purchase_prices', 'purch_order_details.item_code', '=', 'purchase_prices.stock_id')
                ->select('purch_order_details.*', 'item_code.id as item_id','item_tax_types.tax_rate','item_tax_types.id as tax_id','purchase_prices.id')
                ->get();
        return $data;
    }

    public function getSalseInvoicePdf($id)
    { 
        return $this->where(['sales_orders.order_no'=>$id])
                    ->leftJoin('debtors_master', 'sales_orders.debtor_no', '=', 'debtors_master.debtor_no')
                    ->leftJoin('purch_order_details', 'sales_orders.order_no', '=', 'purch_order_details.order_no')
                    ->select('sales_orders.*', 'debtors_master.*')
                    ->first();
    }

    public function calculateTaxRow($order_no){
        $tax_rows = DB::table('purch_order_details')
                ->join('item_tax_types', 'item_tax_types.id', '=', 'purch_order_details.tax_type_id')
                ->select(DB::raw('(purch_order_details.qty_invoiced*purch_order_details.unit_price*item_tax_types.tax_rate)/100 AS tax_amount,item_tax_types.tax_rate'))
                ->where('order_no', $order_no)
                ->get();

        $tax_amount = [];
        $tax_rate   =[];
        $i=0;
        foreach ($tax_rows as $key => $value) {
           if(isset($tax_amount[$value->tax_rate])){
                $tax_amount[strval($value->tax_rate)] +=$value->tax_amount;
           }else{
             $tax_amount[strval($value->tax_rate)] =$value->tax_amount;
           }
        }
        return $tax_amount;
    }
}
