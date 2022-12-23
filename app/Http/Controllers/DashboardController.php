<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use session;
use App\Model\Report;

class DashboardController extends Controller
{
    public function __construct(Report $report){
     /**
     * Set the database connection. reference app\helper.php
     */   
        //selectDatabase();
        $this->report = $report;
    }
    
	protected $data = [];

    /**
     * Display a listing of the Over All Information on Dashboard.
     *
     * @return Dashboard page view
     */
	
    public function index()
    {
        $sale['sale'] = array();
        $cost['cost'] = array();
        $profit['profit'] = array();
        $sale['sale'] = array();
        $data['startDate'] = date('j M Y'); 
        $startDate = date('j M Y');
        // Report on graph chart
        $str = '[';
        $i=0;
        $count = 0;
        $scp = $this->report->getSalesCostProfit();

        foreach ($scp as $key => $value) {
         if($count==0){
            $startDate =  date('j M Y',strtotime($value->ord_date));
         }
          $day = date('j',strtotime($value->ord_date));
          $month = date('n',strtotime($value->ord_date));
          $year = date('Y',strtotime($value->ord_date));
          $sale['sale'][$key] = round($value->sale,2);
          $cost['cost'][$key] = round($value->cost,2);
          $profit['profit'][$key] = round($value->profit,2);
         
         if($i==0)
                $str .= $day.'.'.$month;
            else
                $str .= ', '.$day.'.'.$month;
            $i++;
            $count++;
        }
        $str .=']';
        // Get total revenue and profit
        $salesHistory = $this->report->getSalesHistoryReport($from=NULL,$to=NULL,$user=NULL);
        //d($salesHistory,1);
        $totalSale = 0;
        $totalCost = 0;
        $totalSoldQty = 0;
        foreach ($salesHistory as $key => $history) {
            $totalSale += $history->sales_price_total;
            $totalCost += $history->purch_price_amount;
            $totalSoldQty += $history->qty;
        }
        
        // Get list of order to invoice
        $data['orderToInvoiceList'] = $this->report->orderToInvoiceList();
        $data['orderToshipmentList'] = $this->report->orderToshipmentList();
        $data['latestInvoicesList'] = $this->report->latestInvoicesList();
        $data['latestPaymentList'] = $this->report->latestPaymentList();
        //d($data['latestPaymentList'],1);
       // d($sale['sale'],1);
        $data['sale'] = json_encode($sale['sale']);
        $data['cost'] = json_encode($cost['cost']);
        $data['profit'] = json_encode($profit['profit']);
        $data['date']   =  $str;	
        $data['startDate'] = $startDate;
        $data['endDate']   = date('j M Y');
        $data['totalSoldQty']   = $totalSoldQty; 
        $data['revenueTotal']   = $totalSale;
        $data['profitTotal']    = ($totalSale-$totalCost);
        $data['stockOnHandTotal']    = $totalSoldQty;  
        $data['menu'] = 'dashboard';       
        return view('admin.dashboard', $data);
    }

    /**
     * Change Language function
     *
     * @return true or false
     */

    public function switchLanguage(Request $request)
    {
        
        if ($request->lang) {
            \Session::put('dflt_lang', $request->lang);
            //\DB::table('preference')->where('id', 1)->update(['value' => $request->lang]);
            \App::setLocale($request->lang);
            echo 1;
        } else {
            echo 0;
        }

    }
}
