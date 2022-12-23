<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Report extends Model {

    public function getInventoryStockOnHand($type, $location) {

        if ($type == 'all' && $location == 'all') {
            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        } else if ($type == 'all' && $location != 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves WHERE loc_code = '$location' GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        } else if ($type != 'all' && $location == 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE category_id='$type' AND inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        } else if ($type != 'all' && $location != 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE category_id='$type' AND inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves WHERE loc_code = '$location' GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        }

        return $data;
    }

    public function getInventoryStockOnHandByCat($type, $location, $cat) {

        if ($type == 'all' && $location == 'all') {
            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
                        
                        LEFT JOIN stock_category as sc 
               ON sc.category_id = item.category_id
               
                        WHERE sc.category_id = " . $cat . "
    		"));
        } else if ($type == 'all' && $location != 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves WHERE loc_code = '$location' GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
                        
                        LEFT JOIN stock_category as sc 
               ON sc.category_id = item.category_id
                        
                        WHERE sc.category_id = " . $cat . "
    		"));
        } else if ($type != 'all' && $location == 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE category_id='$type' AND inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
                        
                        LEFT JOIN stock_category as sc 
               ON sc.category_id = item.category_id
                        
                        WHERE sc.category_id = " . $cat . "
    		"));
        } else if ($type != 'all' && $location != 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE category_id='$type' AND inactive=0 AND deleted_status = 0)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves WHERE loc_code = '$location' GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
                        
LEFT JOIN stock_category as sc 
               ON sc.category_id = item.category_id
                        
                        WHERE sc.category_id = " . $cat . "
    		"));
        }

        return $data;
    }

    public function getPlotsStockOnHand() {

        $data = DB::select(DB::raw("SELECT * From plots ORDER By plots.pid ASC"));
        return $data;
    }

    public function getInventoryStockOnHandPdf($type, $location) {

        if ($type == 'all' && $location == 'all') {
            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        } else if ($type == 'all' && $location != 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master)item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves WHERE loc_code = '$location' GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        } else if ($type != 'all' && $location == 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE category_id='$type')item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        } else if ($type != 'all' && $location != 'all') {

            $data = DB::select(DB::raw("SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
			FROM(SELECT * FROM stock_master WHERE category_id='$type')item

			LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
			ON sp.stock_id = item.stock_id

			LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves WHERE loc_code = '$location' GROUP BY stock_id)sm
			ON sm.stock_id = item.stock_id

			LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
			ON pod.stock_id = item.stock_id
    		"));
        }

        return $data;
    }

    public function getSalesReport($to, $from) {
        if ($to == 'all' && $from == 'all') {

            $data = DB::select(DB::raw("SELECT sh.ord_date, SUM(sh.sales_qty) as qty,SUM(sh.sales_price)as price,SUM(sh.sales_discount)as discount,count(sh.ord_date) as no_of_order FROM(SELECT so.order_no,so.ord_date,sod.quantity as sales_qty,sod.price as sales_price,sod.discount as sales_discount FROM (SELECT `order_no`,`ord_date` FROM `sales_orders` WHERE `trans_type`=202)so
        LEFT JOIN(SELECT sp.order_no,SUM(sp.quantity) as quantity, SUM(sp.sales_value)as price,SUM(sp.discount)as discount FROM(SELECT sales_order_details.order_no, sales_order_details.unit_price,sales_order_details.discount_percent,sales_order_details.quantity ,(sales_order_details.unit_price*sales_order_details.quantity) as sales_value,(sales_order_details.unit_price*sales_order_details.quantity*sales_order_details.discount_percent/100) as discount FROM `sales_order_details` WHERE `trans_type`=202)sp GROUP BY sp.order_no)sod
        ON sod.order_no = so.order_no)sh
        GROUP BY sh.ord_date"));
        } else {
            //echo $to; 
            //echo $from;
            //exit;
            $data = DB::select(DB::raw("SELECT sh.ord_date, SUM(sh.sales_qty) as qty,SUM(sh.sales_price)as price,SUM(sh.sales_discount)as discount,count(sh.ord_date) as no_of_order FROM(SELECT so.order_no,so.ord_date,sod.quantity as sales_qty,sod.price as sales_price,sod.discount as sales_discount FROM (SELECT `order_no`,`ord_date` FROM `sales_orders` WHERE `trans_type`=202)so
        LEFT JOIN(SELECT sp.order_no,SUM(sp.quantity) as quantity, SUM(sp.sales_value)as price,SUM(sp.discount)as discount FROM(SELECT sales_order_details.order_no, sales_order_details.unit_price,sales_order_details.discount_percent,sales_order_details.quantity ,(sales_order_details.unit_price*sales_order_details.quantity) as sales_value,(sales_order_details.unit_price*sales_order_details.quantity*sales_order_details.discount_percent/100) as discount FROM `sales_order_details` WHERE `trans_type`=202)sp GROUP BY sp.order_no)sod
        ON sod.order_no = so.order_no)sh
        WHERE sh.ord_date BETWEEN '$from' AND '$to'  
        GROUP BY sh.ord_date"));
        }
        return $data;
    }

    public function getPurchasesReport($to, $from) {
        if ($to == 'all' && $from == 'all') {
            $data = DB::select(DB::raw("SELECT
  sh.ord_date,
  SUM(sh.sales_qty) AS qty,
  SUM(sh.sales_price) AS price,
  SUM(sh.sales_discount) AS discount,
  COUNT(sh.ord_date) AS no_of_order,
  sh.sales_stock_id,
  sh.sales_description
FROM
  (
  SELECT
    so.order_no,
    so.ord_date,
    sod.quantity AS sales_qty,
    sod.price AS sales_price,
    sod.discount AS sales_discount,
    sod.stock_id AS sales_stock_id,
    sod.description AS sales_description
  FROM
    (
    SELECT
      `order_no`,
      `ord_date`
    FROM
      `sales_orders`
    WHERE
      `trans_type` = 202
  ) so
LEFT JOIN
  (
  SELECT
    sp.order_no,
    SUM(sp.quantity) AS quantity,
    SUM(sp.sales_value) AS price,
    SUM(sp.discount) AS discount,
    sp.stock_id,
      sp.description
  FROM
    (
    SELECT
      sales_order_details.order_no,
      sales_order_details.unit_price,
      sales_order_details.discount_percent,
      sales_order_details.quantity,
      (
        sales_order_details.unit_price * sales_order_details.quantity
      ) AS sales_value,
      (
        sales_order_details.unit_price * sales_order_details.quantity * sales_order_details.discount_percent / 100
      ) AS discount,
      sales_order_details.stock_id,
      sales_order_details.description
    FROM
      `sales_order_details`
    WHERE
      `trans_type` = 202
  ) sp
 INNER JOIN item_code as ic 
     ON sp.stock_id = ic.stock_id
INNER JOIN stock_category as sc 
     ON sc.category_id = ic.category_id
               
    WHERE sc.category_id != 3

GROUP BY
  sp.order_no
) sod ON sod.order_no = so.order_no
) sh
GROUP BY
  sh.ord_date"));
//            $data = DB::select(DB::raw("SELECT sh.ord_date, SUM(sh.sales_qty) as qty,SUM(sh.sales_price)as price,SUM(sh.sales_discount)as discount,count(sh.ord_date) as no_of_order FROM(SELECT so.order_no,so.ord_date,sod.quantity as sales_qty,sod.price as sales_price,sod.discount as sales_discount FROM (SELECT `order_no`,`ord_date` FROM `sales_orders` WHERE `trans_type`=202)so
//        LEFT JOIN(SELECT sp.order_no,SUM(sp.quantity) as quantity, SUM(sp.sales_value)as price,SUM(sp.discount)as discount FROM(SELECT sales_order_details.order_no, sales_order_details.unit_price,sales_order_details.discount_percent,sales_order_details.quantity ,(sales_order_details.unit_price*sales_order_details.quantity) as sales_value,(sales_order_details.unit_price*sales_order_details.quantity*sales_order_details.discount_percent/100) as discount , sales_order_details.stock_id as item_id, sales_order_details.description as item_desc FROM `sales_order_details` WHERE `trans_type`=202)sp GROUP BY sp.order_no)sod
//        ON sod.order_no = so.order_no)sh
//        GROUP BY sh.ord_date"));
//            d($data);
        } else {
            //echo $to; 
            //echo $from;
            //exit;
            $data = DB::select(DB::raw("SELECT
  sh.ord_date,
  SUM(sh.sales_qty) AS qty,
  SUM(sh.sales_price) AS price,
  SUM(sh.sales_discount) AS discount,
  COUNT(sh.ord_date) AS no_of_order,
  sh.sales_stock_id,
  sh.sales_description
FROM
  (
  SELECT
    so.order_no,
    so.ord_date,
    sod.quantity AS sales_qty,
    sod.price AS sales_price,
    sod.discount AS sales_discount,
    sod.stock_id AS sales_stock_id,
    sod.description AS sales_description
  FROM
    (
    SELECT
      `order_no`,
      `ord_date`
    FROM
      `sales_orders`
    WHERE
      `trans_type` = 202
  ) so
LEFT JOIN
  (
  SELECT
    sp.order_no,
    SUM(sp.quantity) AS quantity,
    SUM(sp.sales_value) AS price,
    SUM(sp.discount) AS discount,
    sp.stock_id,
      sp.description
  FROM
    (
    SELECT
      sales_order_details.order_no,
      sales_order_details.unit_price,
      sales_order_details.discount_percent,
      sales_order_details.quantity,
      (
        sales_order_details.unit_price * sales_order_details.quantity
      ) AS sales_value,
      (
        sales_order_details.unit_price * sales_order_details.quantity * sales_order_details.discount_percent / 100
      ) AS discount,
      sales_order_details.stock_id,
      sales_order_details.description
    FROM
      `sales_order_details`
    WHERE
      `trans_type` = 202
  ) sp
 INNER JOIN item_code as ic 
     ON sp.stock_id = ic.stock_id
INNER JOIN stock_category as sc 
     ON sc.category_id = ic.category_id
               
    WHERE sc.category_id != 3

GROUP BY
  sp.order_no
) sod ON sod.order_no = so.order_no
) sh
        WHERE sh.ord_date BETWEEN '$from' AND '$to'  
        GROUP BY sh.ord_date"));
        }
        return $data;
    }

    public function getPlotSalesReport($to, $from) {
        if ($to == 'all' && $from == 'all') {

            $data = DB::select(DB::raw("SELECT sh.ord_date, SUM(sh.sales_qty) as qty,SUM(sh.sales_price)as price,SUM(sh.sales_discount)as discount,count(sh.ord_date) as no_of_order FROM(SELECT so.order_no,so.ord_date,sod.quantity as sales_qty,sod.price as sales_price,sod.discount as sales_discount FROM (SELECT `order_no`,`ord_date` FROM `sales_orders` WHERE `trans_type`=202)so
        LEFT JOIN(SELECT sp.order_no,SUM(sp.quantity) as quantity, SUM(sp.sales_value)as price,SUM(sp.discount)as discount FROM(SELECT sales_order_details.order_no, sales_order_details.unit_price,sales_order_details.discount_percent,sales_order_details.quantity ,(sales_order_details.unit_price*sales_order_details.quantity) as sales_value,(sales_order_details.unit_price*sales_order_details.quantity*sales_order_details.discount_percent/100) as discount FROM `sales_order_details` WHERE `trans_type`=202)sp GROUP BY sp.order_no)sod
        ON sod.order_no = so.order_no)sh
        GROUP BY sh.ord_date"));
        } else {
            //echo $to; 
            //echo $from;
            //exit;
            $data = DB::select(DB::raw("SELECT sh.ord_date, SUM(sh.sales_qty) as qty,SUM(sh.sales_price)as price,SUM(sh.sales_discount)as discount,count(sh.ord_date) as no_of_order FROM(SELECT so.order_no,so.ord_date,sod.quantity as sales_qty,sod.price as sales_price,sod.discount as sales_discount FROM (SELECT `order_no`,`ord_date` FROM `sales_orders` WHERE `trans_type`=202)so
        LEFT JOIN(SELECT sp.order_no,SUM(sp.quantity) as quantity, SUM(sp.sales_value)as price,SUM(sp.discount)as discount FROM(SELECT sales_order_details.order_no, sales_order_details.unit_price,sales_order_details.discount_percent,sales_order_details.quantity ,(sales_order_details.unit_price*sales_order_details.quantity) as sales_value,(sales_order_details.unit_price*sales_order_details.quantity*sales_order_details.discount_percent/100) as discount FROM `sales_order_details` WHERE `trans_type`=202)sp GROUP BY sp.order_no)sod
        ON sod.order_no = so.order_no)sh
        WHERE sh.ord_date BETWEEN '$from' AND '$to'  
        GROUP BY sh.ord_date"));
        }
        return $data;
    }

    public function getSalesReportByDate($date) {
        $data = DB::select(DB::raw("SELECT info_tbl.*,dm.name FROM(SELECT final_tbl.ord_date,final_tbl.order_reference,final_tbl.debtor_no, SUM(final_tbl.quantity) as qty,SUM(final_tbl.sales_price) as sales_price_total,SUM(final_tbl.tax_amount)as tax,SUM(final_tbl.purchase_price) as purch_price_amount FROM(SELECT sod.*,so.ord_date,so.order_reference,so.debtor_no,(sod.quantity*sod.unit_price-sod.quantity*sod.unit_price*sod.discount_percent/100) as sales_price,(sod.quantity*sod.unit_price*tax.tax_rate/100) as tax_amount,purchase_table.rate as purchase_unit_price,(sod.quantity*purchase_table.rate) as purchase_price FROM(SELECT sales_order_details.order_no,sales_order_details.stock_id,sales_order_details.`quantity`,sales_order_details.`unit_price`,sales_order_details.`discount_percent`,sales_order_details.`tax_type_id` as tax_id FROM `sales_order_details` WHERE `trans_type`=202)sod
				LEFT JOIN item_tax_types as tax
				ON tax.id = sod.tax_id

				LEFT JOIN(SELECT purchase_info.*,(purchase_info.price/purchase_info.purchase_qty) as rate FROM(SELECT purch_tbl.item_code as stock_id,SUM(purch_tbl.quantity_received) as purchase_qty,SUM(purch_tbl.price) as price FROM(SELECT pod.`item_code`,pod.`quantity_received`,pod.`unit_price`,(pod.`unit_price`*pod.`quantity_received`) as price FROM `purch_order_details` as pod)purch_tbl GROUP BY purch_tbl.item_code)purchase_info)purchase_table
				ON purchase_table.stock_id = sod.stock_id

				LEFT JOIN (SELECT * FROM sales_orders) as so
				ON so.order_no = sod.order_no
				WHERE so.ord_date = '$date')final_tbl
				GROUP BY final_tbl.order_no)info_tbl

				LEFT JOIN debtors_master as dm
				ON dm.debtor_no = info_tbl.debtor_no
				"));
        return $data;
    }

    public function getSalesHistoryReport($from, $to, $user) {
        if ($from == NULL || $to == NULL || $user == NULL) {
            $data = DB::select(DB::raw("SELECT info_tbl.*,dm.name FROM(SELECT final_tbl.ord_date,final_tbl.order_reference,final_tbl.debtor_no, SUM(final_tbl.quantity) as qty,SUM(final_tbl.sales_price) as sales_price_total,SUM(final_tbl.tax_amount)as tax,SUM(final_tbl.purchase_price) as purch_price_amount FROM(SELECT sod.*,so.ord_date,so.order_reference,so.debtor_no,(sod.quantity*sod.unit_price-sod.quantity*sod.unit_price*sod.discount_percent/100) as sales_price,(sod.quantity*sod.unit_price*tax.tax_rate/100) as tax_amount,purchase_table.rate as purchase_unit_price,(sod.quantity*purchase_table.rate) as purchase_price FROM(SELECT sales_order_details.order_no,sales_order_details.stock_id,sales_order_details.`quantity`,sales_order_details.`unit_price`,sales_order_details.`discount_percent`,sales_order_details.`tax_type_id` as tax_id FROM `sales_order_details` WHERE `trans_type`=202)sod
				LEFT JOIN item_tax_types as tax
				ON tax.id = sod.tax_id

				LEFT JOIN(SELECT purchase_info.*,(purchase_info.price/purchase_info.purchase_qty) as rate FROM(SELECT purch_tbl.item_code as stock_id,SUM(purch_tbl.quantity_received) as purchase_qty,SUM(purch_tbl.price) as price FROM(SELECT pod.`item_code`,pod.`quantity_received`,pod.`unit_price`,(pod.`unit_price`*pod.`quantity_received`) as price FROM `purch_order_details` as pod)purch_tbl GROUP BY purch_tbl.item_code)purchase_info)purchase_table
				ON purchase_table.stock_id = sod.stock_id

				LEFT JOIN (SELECT * FROM sales_orders) as so
				ON so.order_no = sod.order_no)final_tbl
				GROUP BY final_tbl.order_no)info_tbl

				LEFT JOIN debtors_master as dm
				ON dm.debtor_no = info_tbl.debtor_no
				ORDER BY info_tbl.ord_date DESC

				"));
        } else if ($user == 'all' && $from != NULL && $to != NULL) {
            $data = DB::select(DB::raw("SELECT info_tbl.*,dm.name FROM(SELECT final_tbl.ord_date,final_tbl.order_reference,final_tbl.debtor_no, SUM(final_tbl.quantity) as qty,SUM(final_tbl.sales_price) as sales_price_total,SUM(final_tbl.tax_amount)as tax,SUM(final_tbl.purchase_price) as purch_price_amount FROM(SELECT sod.*,so.ord_date,so.order_reference,so.debtor_no,(sod.quantity*sod.unit_price-sod.quantity*sod.unit_price*sod.discount_percent/100) as sales_price,(sod.quantity*sod.unit_price*tax.tax_rate/100) as tax_amount,purchase_table.rate as purchase_unit_price,(sod.quantity*purchase_table.rate) as purchase_price FROM(SELECT sales_order_details.order_no,sales_order_details.stock_id,sales_order_details.`quantity`,sales_order_details.`unit_price`,sales_order_details.`discount_percent`,sales_order_details.`tax_type_id` as tax_id FROM `sales_order_details` WHERE `trans_type`=202)sod
				LEFT JOIN item_tax_types as tax
				ON tax.id = sod.tax_id

				LEFT JOIN(SELECT purchase_info.*,(purchase_info.price/purchase_info.purchase_qty) as rate FROM(SELECT purch_tbl.item_code as stock_id,SUM(purch_tbl.quantity_received) as purchase_qty,SUM(purch_tbl.price) as price FROM(SELECT pod.`item_code`,pod.`quantity_received`,pod.`unit_price`,(pod.`unit_price`*pod.`quantity_received`) as price FROM `purch_order_details` as pod)purch_tbl GROUP BY purch_tbl.item_code)purchase_info)purchase_table
				ON purchase_table.stock_id = sod.stock_id

				LEFT JOIN (SELECT * FROM sales_orders) as so
				ON so.order_no = sod.order_no)final_tbl
				GROUP BY final_tbl.order_no)info_tbl

				LEFT JOIN debtors_master as dm
				ON dm.debtor_no = info_tbl.debtor_no

				WHERE info_tbl.ord_date BETWEEN '$from' AND '$to'
				ORDER BY info_tbl.ord_date DESC

				"));
        } else if ($user != 'all' && $from != NULL && $to != NULL) {
            $data = DB::select(DB::raw("SELECT info_tbl.*,dm.name FROM(SELECT final_tbl.ord_date,final_tbl.order_reference,final_tbl.debtor_no, SUM(final_tbl.quantity) as qty,SUM(final_tbl.sales_price) as sales_price_total,SUM(final_tbl.tax_amount)as tax,SUM(final_tbl.purchase_price) as purch_price_amount FROM(SELECT sod.*,so.ord_date,so.order_reference,so.debtor_no,(sod.quantity*sod.unit_price-sod.quantity*sod.unit_price*sod.discount_percent/100) as sales_price,(sod.quantity*sod.unit_price*tax.tax_rate/100) as tax_amount,purchase_table.rate as purchase_unit_price,(sod.quantity*purchase_table.rate) as purchase_price FROM(SELECT sales_order_details.order_no,sales_order_details.stock_id,sales_order_details.`quantity`,sales_order_details.`unit_price`,sales_order_details.`discount_percent`,sales_order_details.`tax_type_id` as tax_id FROM `sales_order_details` WHERE `trans_type`=202)sod
				LEFT JOIN item_tax_types as tax
				ON tax.id = sod.tax_id

				LEFT JOIN(SELECT purchase_info.*,(purchase_info.price/purchase_info.purchase_qty) as rate FROM(SELECT purch_tbl.item_code as stock_id,SUM(purch_tbl.quantity_received) as purchase_qty,SUM(purch_tbl.price) as price FROM(SELECT pod.`item_code`,pod.`quantity_received`,pod.`unit_price`,(pod.`unit_price`*pod.`quantity_received`) as price FROM `purch_order_details` as pod)purch_tbl GROUP BY purch_tbl.item_code)purchase_info)purchase_table
				ON purchase_table.stock_id = sod.stock_id

				LEFT JOIN (SELECT * FROM sales_orders) as so
				ON so.order_no = sod.order_no)final_tbl
				GROUP BY final_tbl.order_no)info_tbl

				LEFT JOIN debtors_master as dm
				ON dm.debtor_no = info_tbl.debtor_no

				WHERE info_tbl.ord_date BETWEEN '$from' AND '$to'
				AND info_tbl.debtor_no = '$user'
				ORDER BY info_tbl.ord_date DESC

				"));
        }
        return $data;
    }

    // Get profit and sale and cost for last 30 days
    public function getSalesCostProfit() {
        $from = date('Y-m-d', strtotime('-30 days'));
        $to = date('Y-m-d');

        $data = DB::select(DB::raw("SELECT scp.* FROM(SELECT info_tbl.ord_date, SUM(info_tbl.sales_price_total) as sale ,SUM(info_tbl.purch_price_amount) as cost,SUM(info_tbl.sales_price_total-info_tbl.purch_price_amount)as profit FROM(SELECT final_tbl.ord_date,SUM(final_tbl.sales_price) as sales_price_total,SUM(final_tbl.purchase_price) as purch_price_amount FROM(SELECT sod.*,so.ord_date,so.order_reference,so.debtor_no,(sod.quantity*sod.unit_price-sod.quantity*sod.unit_price*sod.discount_percent/100) as sales_price,(sod.quantity*sod.unit_price*tax.tax_rate/100) as tax_amount,purchase_table.rate as purchase_unit_price,(sod.quantity*purchase_table.rate) as purchase_price FROM(SELECT sales_order_details.order_no,sales_order_details.stock_id,sales_order_details.`quantity`,sales_order_details.`unit_price`,sales_order_details.`discount_percent`,sales_order_details.`tax_type_id` as tax_id FROM `sales_order_details` WHERE `trans_type`=202)sod
		LEFT JOIN item_tax_types as tax
		ON tax.id = sod.tax_id

		LEFT JOIN(SELECT purchase_info.*,(purchase_info.price/purchase_info.purchase_qty) as rate FROM(SELECT purch_tbl.item_code as stock_id,SUM(purch_tbl.quantity_received) as purchase_qty,SUM(purch_tbl.price) as price FROM(SELECT pod.`item_code`,pod.`quantity_received`,pod.`unit_price`,(pod.`unit_price`*pod.`quantity_received`) as price FROM `purch_order_details` as pod)purch_tbl GROUP BY purch_tbl.item_code)purchase_info)purchase_table
		ON purchase_table.stock_id = sod.stock_id

		LEFT JOIN (SELECT * FROM sales_orders) as so
		ON so.order_no = sod.order_no)final_tbl
		GROUP BY final_tbl.order_no)info_tbl
        GROUP BY info_tbl.ord_date)scp

	    WHERE scp.ord_date BETWEEN '$from' AND '$to'
		"));
        return $data;
    }

    public function orderToInvoiceList() {
        $data = DB::select(DB::raw("SELECT so.*,dm.name FROM(SELECT order_no,reference,ord_date,debtor_no FROM `sales_orders` WHERE `trans_type`=201 AND `order_reference_id` = 0)so LEFT JOIN(SELECT `order_no` FROM `stock_moves` WHERE `trans_type`=202 GROUP BY `order_no`)sm ON sm.order_no = so.order_no LEFT JOIN debtors_master as dm ON dm.`debtor_no` = so.`debtor_no` WHERE sm.order_no IS NULL"));
        return $data;
    }

    public function orderToshipmentList() {
        $data = DB::select(DB::raw("SELECT so.*,dm.name FROM(SELECT order_no,reference,ord_date,debtor_no FROM `sales_orders` WHERE `trans_type`=201 AND `order_reference_id` = 0)so LEFT JOIN(SELECT * FROM `shipment` WHERE status=1 GROUP BY order_no)sp ON sp.order_no = so.order_no LEFT JOIN debtors_master as dm ON dm.`debtor_no` = so.`debtor_no` WHERE sp.order_no IS NULL ORDER BY so.ord_date ASC"));
        return $data;
    }

    public function latestInvoicesList() {
        $data = DB::table('sales_orders')
                ->leftjoin("debtors_master", 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
                ->where('sales_orders.trans_type', SALESINVOICE)
                ->orderBy('sales_orders.ord_date', 'desc')
                ->select('sales_orders.order_reference_id as order_no', 'sales_orders.order_no as invoice_no', 'sales_orders.order_reference', 'sales_orders.reference', 'debtors_master.name', 'sales_orders.total', 'sales_orders.ord_date')
                ->take(5)
                ->get();

        return $data;
    }

    public function latestPaymentList() {
        $data = DB::table('payment_history')
                ->leftjoin('debtors_master', 'debtors_master.debtor_no', '=', 'payment_history.customer_id')
                ->leftjoin('payment_terms', 'payment_terms.id', '=', 'payment_history.payment_type_id')
                ->leftjoin('sales_orders', 'sales_orders.reference', '=', 'payment_history.invoice_reference')
                ->select('payment_history.*', 'debtors_master.name', 'payment_terms.name as pay_type', 'sales_orders.order_no as invoice_id', 'sales_orders.order_reference_id as order_id')
                ->orderBy('payment_date', 'DESC')
                ->take(5)
                ->get();
        return $data;
    }

}
