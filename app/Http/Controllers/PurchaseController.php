<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Purchase;
use App\Http\Requests;
use DB;
use PDF;

class PurchaseController extends Controller {

    public function __construct() {
        /**
         * Set the database connection. reference app\helper.php
         */
        //selectDatabase();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['menu'] = 'purchase';
        $data['purchData'] = (new Purchase)->getAllPurchOrder();
        //d($data['purchData'],1);
        return view('admin.purchase.purch_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $item = $request->get('item');
        $desc = $request->get('desc');
        $rate = $request->get('rate');
        $qty = $request->get('qty');

        $data['menu'] = 'purchase';
        $data['suppData'] = DB::table('suppliers')->where(['inactive' => 0])->get();
        $data['locData'] = DB::table('location')->get();
        $data['order'] = DB::table('purch_orders')->select('order_no')->orderBy('order_no', 'desc')->limit(1)->first();
        $order_count = DB::table('purch_orders')->count();

        if ($order_count > 0) {
            $orderReference = DB::table('purch_orders')->select('reference')->orderBy('order_no', 'DESC')->first();

            $ref = explode("-", $orderReference->reference);
            $data['order_count'] = (int) $ref[1];
        } else {
            $data['order_count'] = 0;
        }

        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id[]'>";
        $selectEnd = "</select>";

        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='" . $value->id . "' taxrate='" . $value->tax_rate . "'>" . $value->name . '(' . $value->tax_rate . ')' . "</option>";
        }
        $data['tax_type'] = $selectStart . $taxOptions . $selectEnd;
        $data['row'] = [
            'html' => NULL,
            'subTotal' => NULL,
            'totalTax' => NULL,
            'grandTotal' => NULL
        ];
        if (trim($item)) {
            $row = $this->getItemByID(trim($item));
            $data['row'] = $this->createRowWithCalc($row, $qty, $data['tax_type']);
        }
        return view('admin.purchase.purch_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user_id = \Auth::user()->id;

        $this->validate($request, [
            'reference' => 'required|unique:purch_orders',
            'into_stock_location' => 'required',
            'ord_date' => 'required',
            'supplier_id' => 'required',
            'item_quantity' => 'required',
        ]);


        $itemQty = $request->item_quantity;
        $itemIds = $request->item_id;
        $taxIds = $request->tax_id;
        $itemPrice = $request->item_price;
        $stock_id = $request->stock_id;
        $description = $request->description;
        $unitPrice = $request->unit_price;

        foreach ($itemQty as $key => $value) {
            $product[$itemIds[$key]] = $value;
        }

        $orderReferenceNo = DB::table('purch_orders')->count();
        $data['ord_date'] = DbDateFormat($request->ord_date);
        $data['supplier_id'] = $request->supplier_id;
        $data['reference'] = 'PO-' . sprintf("%04d", $orderReferenceNo + 1);
        $data['total'] = $request->total;
        $data['into_stock_location'] = $request->into_stock_location;
        $data['comments'] = $request->comments;
        $data['created_at'] = date('Y-m-d H:i:s');
        $order_id = DB::table('purch_orders')->insertGetId($data);

        for ($i = 0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $value) {
                if ($itemIds[$i] == $key) {
                    // purchOrderdetail information
                    // $itemPriceRate = DB::table('purchase_prices')->select('price')->where('stock_id',$stock_id[$i])->first();
                    $purchOrderdetail[$i]['order_no'] = $order_id;
                    $purchOrderdetail[$i]['item_code'] = $stock_id[$i];
                    $purchOrderdetail[$i]['description'] = $description[$i];
                    $purchOrderdetail[$i]['quantity_ordered'] = $value;
                    $purchOrderdetail[$i]['quantity_received'] = $value;
                    $purchOrderdetail[$i]['qty_invoiced'] = $value;
                    $purchOrderdetail[$i]['unit_price'] = $unitPrice[$i];
                    $purchOrderdetail[$i]['tax_type_id'] = $taxIds[$i];
                    // stockMove information
                    $stockMove[$i]['stock_id'] = $stock_id[$i];
                    $stockMove[$i]['trans_type'] = PURCHINVOICE;
                    $stockMove[$i]['loc_code'] = $request->into_stock_location;
                    $stockMove[$i]['tran_date'] = DbDateFormat($request->ord_date);
                    $stockMove[$i]['person_id'] = $user_id;
                    $stockMove[$i]['reference'] = 'store_in_' . $order_id;
                    $stockMove[$i]['transaction_reference_id'] = $order_id;
                    $stockMove[$i]['qty'] = $value;
                    $stockMove[$i]['price'] = $unitPrice[$i];
                }

                $purchaseDataInfo = DB::table('purchase_prices')->where('stock_id', $stock_id[$i])->count();

                //d($purchaseDataInfo,1);
                if ($purchaseDataInfo == false) {
                    $purchaseData['supplier_id'] = $request->supplier_id;
                    $purchaseData['stock_id'] = $stock_id[$i];
                    $purchaseData['price'] = $itemPrice[$i];
                    DB::table('purchase_prices')->insert($purchaseData);
                }
            }
        }

        for ($i = 0; $i < count($purchOrderdetail); $i++) {
            DB::table('purch_order_details')->insertGetId($purchOrderdetail[$i]);
            DB::table('stock_moves')->insertGetId($stockMove[$i]);
        }

        if (!empty($order_id)) {
            \Session::flash('success', trans('message.success.save_success'));
            return redirect()->intended('purchase/list');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['menu'] = 'purchase';
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['supplierData'] = DB::table('suppliers')->get();
        $data['locData'] = DB::table('location')->get();
        $data['invoiceData'] = (new Purchase)->getPurchaseInvoiceByID($id);
        $data['purchData'] = DB::table('purch_orders')->where('order_no', '=', $id)->first();

        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id_new[]'>";
        $selectEnd = "</select>";

        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='" . $value->id . "' taxrate='" . $value->tax_rate . "'>" . $value->name . '(' . $value->tax_rate . ')' . "</option>";
        }
        $data['tax_type_new'] = $selectStart . $taxOptions . $selectEnd;
        $data['tax_types'] = $taxTypeList;

        return view('admin.purchase.purch_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {

        $user_id = \Auth::user()->id;
        $this->validate($request, [
            'into_stock_location' => 'required',
            'ord_date' => 'required',
            'supplier_id' => 'required',
        ]);

        // d($request->all());
        $order_id = $request->order_no;
        $data['ord_date'] = DbDateFormat($request->ord_date);
        $data['supplier_id'] = $request->supplier_id;
        //$data['reference'] = $request->reference;
        $data['into_stock_location'] = $request->into_stock_location;
        $data['comments'] = $request->comments;
        $data['total'] = $request->total;
        $data['updated_at'] = date('Y-m-d H:i:s');

        DB::table('purch_orders')->where('order_no', $order_id)->update($data);

        if (isset($request->item_quantity)) {

            $itemQty = $request->item_quantity;
            $itemIds = $request->item_id;
            $taxIds = $request->tax_id;
            $itemPrice = $request->item_price;
            $stock_id = $request->stock_id;
            $description = $request->description;
            $unitPrice = $request->unit_price;

            $invoiceData = (new Purchase)->getPurchaseInvoiceByID($order_id);
            $invoiceData = objectToArray($invoiceData);

            for ($i = 0; $i < count($invoiceData); $i++) {

                if (!in_array($invoiceData[$i]['item_id'], $itemIds)) {
                    DB::table('purch_order_details')->where([['order_no', '=', $invoiceData[$i]['order_no']], ['item_code', '=', $invoiceData[$i]['item_code']],])->delete();
                    DB::table('stock_moves')->where([['stock_id', '=', $invoiceData[$i]['item_code']], ['reference', '=', 'store_in_' . $order_id],])->delete();
                }
            }

            foreach ($itemQty as $key => $value) {

                $product[$itemIds[$key]] = $value;
            }

            for ($i = 0; $i < count($itemIds); $i++) {
                foreach ($product as $key => $value) {
                    if ($itemIds[$i] == $key) {
                        // Order Details
                        $purchaseOrderDetails[$i]['item_code'] = $stock_id[$i];
                        $purchaseOrderDetails[$i]['description'] = $stock_id[$i];
                        $purchaseOrderDetails[$i]['quantity_ordered'] = $value;
                        $purchaseOrderDetails[$i]['quantity_received'] = $value;
                        $purchaseOrderDetails[$i]['qty_invoiced'] = $value;
                        $purchaseOrderDetails[$i]['unit_price'] = $unitPrice[$i];
                        // Order Details
                        $stockMove[$i]['stock_id'] = $stock_id[$i];
                        $stockMove[$i]['trans_type'] = PURCHINVOICE;
                        $stockMove[$i]['loc_code'] = $request->into_stock_location;
                        $stockMove[$i]['tran_date'] = DbDateFormat($request->ord_date);
                        $stockMove[$i]['person_id'] = $user_id;
                        $stockMove[$i]['reference'] = 'store_in_' . $order_id;
                        $stockMove[$i]['transaction_reference_id'] = $order_id;
                        $stockMove[$i]['qty'] = $value;
                        $stockMove[$i]['price'] = $itemPrice[$i];
                    }
                }
            }

            for ($i = 0; $i < count($purchaseOrderDetails); $i++) {
                DB::table('purch_order_details')->where([['item_code', '=', $purchaseOrderDetails[$i]['item_code']], ['order_no', '=', $order_id],])->update($purchaseOrderDetails[$i]);
                DB::table('stock_moves')->where([['stock_id', '=', $stockMove[$i]['stock_id']], ['reference', '=', 'store_in_' . $order_id],])->update($stockMove[$i]);
            }
        } else {
            $invoiceData = (new Purchase)->getPurchInvoiceByID($order_id);
            $invoiceData = objectToArray($invoiceData);
            for ($i = 0; $i < count($invoiceData); $i++) {
                DB::table('purch_order_details')->where([['order_no', '=', $invoiceData[$i]['order_no']], ['item_code', '=', $invoiceData[$i]['item_code']],])->delete();
                DB::table('stock_moves')->where([['stock_id', '=', $invoiceData[$i]['item_code']], ['reference', '=', 'store_in_' . $order_id],])->delete();
            }
        }

        if (isset($request->item_quantity_new)) {
            $item_quantity_new = $request->item_quantity_new;
            $ids_new = $request->item_id_new;
            $taxIds_new = $request->tax_id_new;
            $itemPrice_new = $request->item_price_new;
            $unitPrice_new = $request->unit_price_new;
            $stock_id_new = $request->stock_id_new;
            $description_new = $request->description_new;

            foreach ($item_quantity_new as $key => $value) {
                $product_new[$ids_new[$key]] = $value;
            }


            for ($i = 0; $i < count($ids_new); $i++) {
                foreach ($product_new as $key => $value) {
                    if ($ids_new[$i] == $key) {
                        // Order
                        //  $itemPriceUnit = DB::table('purchase_prices')->select('price')->where('stock_id',$stock_id_new[$i])->first();
                        $purchOrderdetailNew[$i]['order_no'] = $order_id;
                        $purchOrderdetailNew[$i]['item_code'] = $stock_id_new[$i];
                        $purchOrderdetailNew[$i]['description'] = $description_new[$i];
                        $purchOrderdetailNew[$i]['quantity_ordered'] = $value;
                        $purchOrderdetailNew[$i]['quantity_received'] = $value;
                        $purchOrderdetailNew[$i]['qty_invoiced'] = $value;
                        $purchOrderdetailNew[$i]['unit_price'] = $itemPrice_new[$i];
                        $purchOrderdetailNew[$i]['tax_type_id'] = $taxIds_new[$i];
                        $purchOrderdetailNew[$i]['unit_price'] = $unitPrice_new[$i];

                        // Order Details
                        $stockMoveNew[$i]['stock_id'] = $stock_id_new[$i];
                        $stockMoveNew[$i]['trans_type'] = PURCHINVOICE;
                        $stockMoveNew[$i]['loc_code'] = $request->into_stock_location;
                        $stockMoveNew[$i]['tran_date'] = DbDateFormat($request->ord_date);
                        $stockMoveNew[$i]['person_id'] = $user_id;
                        $stockMoveNew[$i]['reference'] = 'store_in_' . $order_id;
                        $stockMoveNew[$i]['transaction_reference_id'] = $order_id;
                        $stockMoveNew[$i]['qty'] = $value;
                        $stockMoveNew[$i]['price'] = $itemPrice_new[$i];
                    }
                }
            }
            //d($purchOrderdetailNew,1);
            for ($i = 0; $i < count($purchOrderdetailNew); $i++) {
                DB::table('purch_order_details')->insertGetId($purchOrderdetailNew[$i]);
                DB::table('stock_moves')->insertGetId($stockMoveNew[$i]);
            }
        }

        \Session::flash('success', trans('message.success.save_success'));
        return redirect()->intended('purchase/list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (isset($id)) {
            $record = \DB::table('purch_orders')->where('order_no', $id)->first();
            if ($record) {
                DB::table('purch_orders')->where('order_no', '=', $record->order_no)->delete();
                DB::table('purch_order_details')->where('order_no', '=', $record->order_no)->delete();
                DB::table('stock_moves')->where('reference', '=', 'store_in_' . $record->order_no)->delete();
                \Session::flash('success', trans('message.success.delete_success'));
                return redirect()->intended('purchase/list');
            }
        }
    }

    public function pdfview($id, $r = '') {
        $supp_id = \DB::table('purch_orders')->where('order_no', $id)->first();
        $data['supplierData'] = \DB::table('suppliers')->where('supplier_id', $supp_id->supplier_id)->first();
        $data['invoiceData'] = \DB::table('purch_order_details')->where('order_no', $id)->get();

        $data['id'] = $id;

        $pdf = PDF::loadView('pdfviewIn', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('invoice_check_in_' . time() . '.pdf', array("Attachment" => 0));
    }

    public function searchItem(Request $request) {

        $output = '';
        $item = DB::table('stock_master')->where('stock_master.description', 'LIKE', '%' . $request->search . '%')
                ->where(['stock_master.inactive' => 0, 'stock_master.deleted_status' => 0])
                ->leftJoin('purchase_prices', 'stock_master.stock_id', '=', 'purchase_prices.stock_id')
                ->leftJoin('item_tax_types', 'item_tax_types.id', '=', 'stock_master.tax_type_id')
                ->leftJoin('item_code', 'item_code.stock_id', '=', 'stock_master.stock_id')
                ->select('stock_master.*', 'purchase_prices.price', 'item_code.id', 'item_tax_types.tax_rate', 'item_tax_types.id as tax_id')
                ->get();

        //d($item,1);
        if ($item) {
            $i = 0;
            foreach ($item as $key => $value) {
                $return_arr[$i]['id'] = $value->id;
                $return_arr[$i]['stock_id'] = $value->stock_id;
                $return_arr[$i]['description'] = $value->description;
                $return_arr[$i]['units'] = $value->units;
                $return_arr[$i]['price'] = $value->price;
                $return_arr[$i]['tax_rate'] = $value->tax_rate;
                $return_arr[$i]['tax_id'] = $value->tax_id;
                $i++;
            }

            echo json_encode($return_arr);
        }
    }

    /**
     * View Purchase details
     */
    public function viewPurchaseInvoiceDetail($id) {
        $data['menu'] = 'purchase';
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);

        $data['purchData'] = DB::table('purch_orders')
                ->where('order_no', '=', $id)
                ->leftJoin('suppliers', 'suppliers.supplier_id', '=', 'purch_orders.supplier_id')
                ->leftJoin('location', 'location.loc_code', '=', 'purch_orders.into_stock_location')
                ->select('purch_orders.*', 'suppliers.supp_name', 'suppliers.email', 'suppliers.address', 'suppliers.contact', 'suppliers.city', 'suppliers.state', 'suppliers.zipcode', 'suppliers.country', 'location.location_name')
                ->first();
        //d($data['purchData'],1);
        return view('admin.purchase.purchaseInvoiceDetails', $data);
    }

    /**
     * View Purchase details
     */
    public function invoicePdf($id) {
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);

        $data['purchData'] = DB::table('purch_orders')
                ->where('order_no', '=', $id)
                ->leftJoin('suppliers', 'suppliers.supplier_id', '=', 'purch_orders.supplier_id')
                ->select('purch_orders.*', 'suppliers.supp_name', 'suppliers.email', 'suppliers.address', 'suppliers.contact', 'suppliers.city', 'suppliers.state', 'suppliers.zipcode', 'suppliers.country')
                ->first();
        //return view('admin.purchase.invoicePdf', $data);
        $pdf = PDF::loadView('admin.purchase.invoicePdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('purchase_invoice_' . time() . '.pdf', array("Attachment" => 0));
    }

    /**
     * Print Purchase details
     */
    public function invoicePrint($id) {
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);

        $data['purchData'] = DB::table('purch_orders')
                ->where('order_no', '=', $id)
                ->leftJoin('suppliers', 'suppliers.supplier_id', '=', 'purch_orders.supplier_id')
                ->select('purch_orders.*', 'suppliers.supp_name', 'suppliers.email', 'suppliers.address', 'suppliers.contact', 'suppliers.city', 'suppliers.state', 'suppliers.zipcode', 'suppliers.country')
                ->first();
        //return view('admin.purchase.printPdf', $data);

        $pdf = PDF::loadView('admin.purchase.invoicePrint', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('purchase_invoice_' . time() . '.pdf', array("Attachment" => 0));
    }

    /**
     * Check reference no if exists
     */
    public function referenceValidation(Request $request) {

        $data = array();
        $ref = $request['ref'];
        $result = DB::table('purch_orders')->where("reference", $ref)->first();

        if (count($result) > 0) {
            $data['status_no'] = 1;
        } else {
            $data['status_no'] = 0;
        }

        return json_encode($data);
    }

    public function getItemByID($id) {

        $return_arr = NULL;
        $item = DB::table('stock_master')->where('stock_master.stock_id', '=', $id)
                ->where(['stock_master.inactive' => 0, 'stock_master.deleted_status' => 0])
                ->leftJoin('purchase_prices', 'stock_master.stock_id', '=', 'purchase_prices.stock_id')
                ->leftJoin('item_tax_types', 'item_tax_types.id', '=', 'stock_master.tax_type_id')
                ->leftJoin('item_code', 'item_code.stock_id', '=', 'stock_master.stock_id')
                ->select('stock_master.*', 'purchase_prices.price', 'item_code.id', 'item_tax_types.tax_rate', 'item_tax_types.id as tax_id')
                ->get();

        //d($item,1);
        if ($item) {
            $i = 0;
            foreach ($item as $key => $value) {
                $return_arr[$i]['id'] = $value->id;
                $return_arr[$i]['stock_id'] = $value->stock_id;
                $return_arr[$i]['description'] = $value->description;
                $return_arr[$i]['units'] = $value->units;
                $return_arr[$i]['price'] = $value->price;
                $return_arr[$i]['tax_rate'] = $value->tax_rate;
                $return_arr[$i]['tax_id'] = $value->tax_id;
                $i++;
            }
            //echo json_encode($return_arr);            
        }
        return $return_arr;
    }

    public function createRowWithCalc($row, $qty, $taxOptionList) {
        $html = '';
        $subTotal = 0;
        $totalTax = 0;
        $taxAmount = 0;
        foreach ($row as $key => $value) {
            $id = $value['id'];
            $price = $qty * $value['price'];
            $subTotal = $subTotal + $price;
            $taxAmount = (($value['price'] * $value['tax_rate']) / 100) * $qty;
            $html .= '<tr class="nr" id="rowid' . $value['id'] . '">' .
                    '<td>' . $value['stock_id'] . '<input type="hidden" name="stock_id[]" value="' . $value['stock_id'] . '"></td>' .
                    '<td>' . $value['description'] . '<input type="hidden" name="description[]" value="' . $value['description'] . '"></td>' .
                    '<td><input class="form-control text-center no_units" data-id="' . $id . '" data-rate="' . $price . '" type="text" id="qty_' . $id . '" name="item_quantity[]" value="' . $qty . '" data-tax ="' . $value['tax_rate'] . '"><input type="hidden" name="item_id[]" value="' . $id . '"></td>' .
                    '<td class="text-center"><input min="0"  type="text" class="form-control text-center unitprice" name="unit_price[]" data-id = "' . $id . '" id="rate_id_' . $id . '" value="' . $value['price'] . '" data-tax="' . $value['tax_rate'] . '"></td>' .
                    '<td class="text-center">' . $taxOptionList . '</td>' .
                    '<td class="text-center taxAmount">' . $taxAmount . '</td>' .
                    '<td><input class="form-control text-center amount" type="text" id="amount_' . $value['id'] . '" value="' . $price . '" name="item_price[]" data-tax-rate="' . $value['tax_rate'] . '" readonly></td>' .
                    '<td class="text-center"><button id="' . $id . '" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' .
                    '</tr>';
        }
        $grandTotal = ($subTotal + $taxAmount);
        return [
            'html' => $html,
            'subTotal' => $subTotal,
            'totalTax' => $totalTax,
            'grandTotal' => $grandTotal
        ];
    }

}
