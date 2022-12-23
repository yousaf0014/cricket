<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Model\Orders;
use App\Http\Requests;
use App\Model\Sales;
use App\Model\Shipment;
use App\Model\Report;
use DB;
use Session;
use PDF;
use Excel;

class ReportController extends Controller {

    public function __construct(Orders $orders, Sales $sales, Shipment $shipment, EmailController $email, Report $report) {

        /**
         * Set the database connection. reference app\helper.php
         */
        //selectDatabase();
        $this->order = $orders;
        $this->sale = $sales;
        $this->shipment = $shipment;
        $this->email = $email;
        $this->report = $report;
    }

    /**
     * Return inventory Stock On Hand
     */
    public function inventoryStockOnHand() {

        $data['type'] = 'all';
        $data['location_id'] = 'all';
        $qtyOnHand = 0;
        $costValueQtyOnHand = 0;
        $retailValueOnHand = 0;
        $profitValueOnHand = 0;
        $mac = 0;
        $data['menu'] = 'report';
        $data['sub_menu'] = 'report/inventory-stock-on-hand';

        if (isset($_GET['btn'])) {
            $type = $_GET['type'];
            $location = $_GET['location'];

            $data['type'] = $type;
            $data['location_id'] = $location;

            $data['itemList'] = $itemList = $this->report->getInventoryStockOnHand($type, $location);
        } else {
            $data['itemList'] = $itemList = $this->report->getInventoryStockOnHand($data['type'], $data['location_id']);
        }

        foreach ($itemList as $key => $item) {

            $qtyOnHand += $item->available_qty;

            if ($item->received_qty != 0) {
                $mac = $item->cost_amount / $item->received_qty;
            }

            $costValueQtyOnHand += $item->available_qty * $mac;
            $retailValueOnHand += $item->available_qty * $item->retail_price;
            $profitValueOnHand += (($item->available_qty * $item->retail_price) - ($item->available_qty * $mac));
        }
        $data['qtyOnHand'] = $qtyOnHand;
        $data['costValueQtyOnHand'] = $costValueQtyOnHand;
        $data['retailValueOnHand'] = $retailValueOnHand;
        $data['profitValueOnHand'] = $profitValueOnHand;

        $data['locationList'] = DB::table('location')->get();
        $data['categoryList'] = DB::table('stock_category')->get();

        return view('admin.report.inventory_stock_on_hand', $data);
    }

    /**
     * Return inventory Stock On Hand with pdf format
     */
    public function inventoryStockOnHandPdf() {
        $data['type'] = 'all';
        $data['location_id'] = 'all';
        $qtyOnHand = 0;
        $costValueQtyOnHand = 0;
        $retailValueOnHand = 0;
        $profitValueOnHand = 0;
        $mac = 0;
        if (isset($_GET['btn'])) {
            $type = $_GET['type'];
            $location = $_GET['location'];

            $data['type'] = $type;
            $data['location_id'] = $location;

            $data['itemList'] = $itemList = $this->report->getInventoryStockOnHand($type, $location);
        } else {
            $data['itemList'] = $itemList = $this->report->getInventoryStockOnHand($data['type'], $data['location_id']);
        }

        foreach ($itemList as $key => $item) {

            $qtyOnHand += $item->available_qty;

            if ($item->received_qty != 0) {
                $mac = $item->cost_amount / $item->received_qty;
            }

            $costValueQtyOnHand += $item->available_qty * $mac;
            $retailValueOnHand += $item->available_qty * $item->retail_price;
            $profitValueOnHand += (($item->available_qty * $item->retail_price) - ($item->available_qty * $mac));
        }
        $data['qtyOnHand'] = $qtyOnHand;
        $data['costValueQtyOnHand'] = $costValueQtyOnHand;
        $data['retailValueOnHand'] = $retailValueOnHand;
        $data['profitValueOnHand'] = $profitValueOnHand;

        $data['locationList'] = DB::table('location')->get();
        $data['categoryList'] = DB::table('stock_category')->get();
        $data['menu'] = 'report';
        $data['sub_menu'] = 'report/inventory-stock-on-hand';
        //d($data,1);
        $pdf = PDF::loadView('admin.report.inventory_stock_on_hand_pdf', $data);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('inventory_stock_on_hand_' . time() . '.pdf', array("Attachment" => 0));
    }

    /**
     * Return inventory Stock On Hand with csv format
     */
    public function inventoryStockOnHandCsv() {
        $itemList = $this->report->getInventoryStockOnHand('all', 'all');
        foreach ($itemList as $key => $value) {
            $mac = 0;
            $profit_margin = 0;
            if ($value->received_qty != 0) {
                $mac = $value->cost_amount / $value->received_qty;
            }
            $in_value = $value->available_qty * $mac;
            $retail_value = $value->available_qty * $value->retail_price;
            $profit_value = ($retail_value - $in_value);
            if ($in_value != 0) {
                $profit_margin = ($profit_value * 100 / $in_value);
            }

            $data[$key]['Product'] = $value->description;
            $data[$key]['Stock Id'] = $value->stock_id;
            $data[$key]['In Stock'] = $value->available_qty;
            $data[$key]['MAC'] = Session::get('currency_symbol') . number_format($mac, 2, '.', ',');
            $data[$key]['Retail Price'] = Session::get('currency_symbol') . number_format($value->retail_price, 2, '.', ',');
            $data[$key]['In Value'] = Session::get('currency_symbol') . number_format($in_value, 2, '.', ',');
            $data[$key]['Retail value'] = Session::get('currency_symbol') . number_format($retail_value, 2, '.', ',');
            $data[$key]['Profit Value'] = Session::get('currency_symbol') . number_format($profit_value, 2, '.', ',');
            $data[$key]['Profit margin'] = number_format($profit_margin, 2, '.', ',');
        }

        return Excel::create('inventory_stock_on_hand_' . time() . '', function($excel) use ($data) {
                    $excel->sheet('mySheet', function($sheet) use ($data) {
                        $sheet->fromArray($data);
                    });
                })->download();
    }

    /**
     * Sales history report by plot
     */
    public function salesReport() {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'report/sales-report';
        if (isset($_GET['btn'])) {
            $to = DbDateFormat($_GET['to']);
            $from = DbDateFormat($_GET['from']);
            $data['itemList'] = $this->report->getSalesReport($to, $from);
        } else {
            $to = 'all';
            $from = 'all';
            $data['itemList'] = $this->report->getSalesReport($to, $from);
        }
        //d($data,1);
        return view('admin.report.sales_report', $data);
    }

    /**
     * Sales report on csv
     */
    public function salesReportCsv() {
        if (isset($_GET['btn'])) {
            $to = DbDateFormat($_GET['to']);
            $from = DbDateFormat($_GET['from']);
            $itemList = $this->report->getSalesReport($to, $from);
        } else {
            $to = 'all';
            $from = 'all';
            $itemList = $this->report->getSalesReport($to, $from);
        }

        foreach ($itemList as $key => $value) {

            $data[$key]['Date'] = $value->ord_date;
            $data[$key]['Sales Volume'] = $value->qty;
            $data[$key]['Sales Value'] = $value->price - $value->discount;
            $data[$key]['No Of Order'] = $value->no_of_order;
        }

        return Excel::create('sales_report_' . time() . '', function($excel) use ($data) {
                    $excel->sheet('mySheet', function($sheet) use ($data) {
                        $sheet->fromArray($data);
                    });
                })->download();
    }

    /**
     * Sales report on pdf
     */
    public function salesReportPdf() {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'sales-report';
        if (isset($_GET['btn'])) {
            $to = DbDateFormat($_GET['to']);
            $from = DbDateFormat($_GET['from']);
            $data['itemList'] = $this->report->getSalesReport($to, $from);
        } else {
            $to = 'all';
            $from = 'all';
            $data['itemList'] = $this->report->getSalesReport($to, $from);
        }

        $pdf = PDF::loadView('admin.report.sales_report_pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('sales_report_' . time() . '.pdf', array("Attachment" => 0));
    }

    /**
     * Sales report by date
     */
    public function salesReportByDate($date) {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'report/sales-report';
        $data['itemList'] = $this->report->getSalesReportByDate(date('Y-m-d', $date));
        $data['date'] = $date;
        return view('admin.report.sales_report_by_date', $data);
    }

    /**
     * Sales report by date on csv
     */
    public function salesReportByDateCsv($date) {
        $itemList = $this->report->getSalesReportByDate(date('Y-m-d', $date));

        foreach ($itemList as $key => $item) {

            $profit = ($item->sales_price_total - $item->purch_price_amount);
            $profit_margin = ($profit * 100) / $item->purch_price_amount;

            $data[$key]['Order No'] = $item->order_reference;
            $data[$key]['Date'] = formatDate($item->ord_date);
            $data[$key]['Customer'] = $item->name;
            $data[$key]['Qty'] = $item->qty;
            $data[$key]['Sales Value(' . Session::get('currency_symbol') . ')'] = $item->sales_price_total;
            $data[$key]['Cost Value(' . Session::get('currency_symbol') . ')'] = $item->purch_price_amount;
            $data[$key]['Tax(' . Session::get('currency_symbol') . ')'] = $item->tax;
            $data[$key]['Profit(' . Session::get('currency_symbol') . ')'] = $profit;
            $data[$key]['Profit Margin(%)'] = number_format(($profit_margin), 2, '.', ',');
        }

        return Excel::create('sales_report_by_date_' . time() . '', function($excel) use ($data) {
                    $excel->sheet('mySheet', function($sheet) use ($data) {
                        $sheet->fromArray($data);
                    });
                })->download();
    }

    /**
     * Sales report by date on pdf
     */
    public function salesReportByDatePdf($date) {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'sales-report';
        $data['itemList'] = $this->report->getSalesReportByDate(date('Y-m-d', $date));
        $pdf = PDF::loadView('admin.report.sales_report_by_date_pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('sales_report_by_date_' . time() . '.pdf', array("Attachment" => 0));
    }

    /**
     * Sales history report
     */
    public function salesHistoryReport() {

        $data['customerList'] = DB::table('debtors_master')->where(['inactive' => 0])->get();
        $data['menu'] = 'report';
        $data['sub_menu'] = 'sales-history-report';

        if (isset($_GET['btn'])) {
            $user = $_GET['customer'];
            $from = date('Y-m-d', strtotime($_GET['from']));
            $to = date('Y-m-d', strtotime($_GET['to']));
            $data['from'] = $_GET['from'];
            $data['to'] = $_GET['to'];
            $data['user'] = $user;
            $data['itemList'] = $this->report->getSalesHistoryReport($from, $to, $user);
        } else {
            $data['user'] = 'all';
            $data['itemList'] = $this->report->getSalesHistoryReport($from = NULL, $to = NULL, $user = NULL);
        }
        return view('admin.report.sales_history_report', $data);
    }

    /**
     * Sales history report on pdf
     */
    public function salesHistoryReportPdf() {

        $data['itemList'] = $this->report->getSalesHistoryReport($from = NULL, $to = NULL, $user = NULL);
        $pdf = PDF::loadView('admin.report.sales_history_report_pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('sales_history_report_' . time() . '.pdf', array("Attachment" => 0));
    }

    /**
     * Sales history report on csv
     */
    public function salesHistoryReportCsv() {

        $itemList = $this->report->getSalesHistoryReport($from = NULL, $to = NULL, $user = NULL);

        foreach ($itemList as $key => $item) {

            $profit = ($item->sales_price_total - $item->purch_price_amount);
            $profit_margin = ($profit * 100) / $item->purch_price_amount;

            $data[$key]['Order No'] = $item->order_reference;
            $data[$key]['Date'] = formatDate($item->ord_date);
            $data[$key]['Customer'] = $item->name;
            $data[$key]['Qty'] = $item->qty;
            $data[$key]['Sales Value(' . Session::get('currency_symbol') . ')'] = $item->sales_price_total;
            $data[$key]['Cost Value(' . Session::get('currency_symbol') . ')'] = $item->purch_price_amount;
            $data[$key]['Tax(' . Session::get('currency_symbol') . ')'] = $item->tax;
            $data[$key]['Profit(' . Session::get('currency_symbol') . ')'] = $profit;
            $data[$key]['Profit Margin(%)'] = number_format(($profit_margin), 2, '.', ',');
        }

        return Excel::create('sales_history_report_' . time() . '', function($excel) use ($data) {
                    $excel->sheet('mySheet', function($sheet) use ($data) {
                        $sheet->fromArray($data);
                    });
                })->download();
    }

    /**
     * Purchases history report by plot
     */
    public function purchasesOrderReport() {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'report/purchases-order-report';
        if (isset($_GET['btn'])) {
            $to = DbDateFormat($_GET['to']);
            $from = DbDateFormat($_GET['from']);
            $data['itemList'] = $this->report->getPurchasesReport($to, $from);
        } else {
            $to = 'all';
            $from = 'all';
            $data['itemList'] = $this->report->getPurchasesReport($to, $from);
        }
        //d($data,1);
        return view('admin.report.purchases_order', $data);
    }

    /**
     * Purchases report on pdf
     */
    public function purchasesOrderReportPdf() {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'report/purchases-order-report-pdf';
        if (isset($_GET['btn'])) {
            $to = DbDateFormat($_GET['to']);
            $from = DbDateFormat($_GET['from']);
            $data['itemList'] = $this->report->getPurchasesReport($to, $from);
        } else {
            $to = 'all';
            $from = 'all';
            $data['itemList'] = $this->report->getPurchasesReport($to, $from);
        }

        $pdf = PDF::loadView('admin.report.purchases_report_pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('purchases_report_' . time() . '.pdf', array("Attachment" => 0));
    }

    /**
     * Sales report on csv
     */
    public function purchasesOrderReportCsv() {
        if (isset($_GET['btn'])) {
            $to = DbDateFormat($_GET['to']);
            $from = DbDateFormat($_GET['from']);
            $itemList = $this->report->getPurchasesReport($to, $from);
        } else {
            $to = 'all';
            $from = 'all';
            $itemList = $this->report->getPurchasesReport($to, $from);
        }

        foreach ($itemList as $key => $value) {
            if ($value->sales_stock_id) {
                $data[$key]['Date'] = $value->ord_date;
                $data[$key]['Purchases Item'] = $value->sales_stock_id;
                $data[$key]['Purchases Item Description'] = $value->sales_description;
                $data[$key]['No Of Order'] = $value->no_of_order;
            }
        }

        return Excel::create('purchases_order_report_' . time() . '', function($excel) use ($data) {
                    $excel->sheet('mySheet', function($sheet) use ($data) {
                        $sheet->fromArray($data);
                    });
                })->download();
    }

}
