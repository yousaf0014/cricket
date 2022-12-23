<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Plots;
use Image;
use Session;
use Excel;
use Input;
use DB;
use Validator;
use App\Model\Report;

class PlotsManagementController extends Controller
{
    public function __construct(Report $report) {
     /**
     * Set the database connection. reference app\helper.php
     */     
      //selectDatabase();
      $this->report = $report;
    }
    /**
     * Display a listing of the plots.
     *
     * @return plots list page view
     */
    public function index()
    {
        $data['menu'] = 'plots_mamangement';
        $data['header'] = 'plots';
        $qtyOnHand = 0;
        $costValueQtyOnHand = 0;
        $retailValueOnHand = 0;
        $profitValueOnHand = 0;
        $mac = 0;

        $data['plotsData'] = (new plots)->getAllplots();
        //$data['plotsQuantity'] = DB::table('plots')->select(DB::raw('SUM(pid) as total_plots'))->first();
		$data['availablePlotsQuantity'] = DB::table('plots')->select(DB::raw('SUM(pid) as total_plots'))->first();
		//$data['hiredPlotsQuantity'] = DB::table('plots')->select(DB::raw('SUM(pid) as total_plots'))->first();
        $plotsList = $this->report->getPlotsStockOnHand();
        //d($plotsList,1);
        
        
        $qtyOnHand = $data['availablePlotsQuantity'];
        foreach ($plotsList as $key => $plots) { 
            //echo $plots->is_hired;
            if($plots->is_hired !=1){
               $mac += $plots->plot_price;
            }

            $costValueQtyOnHand = $mac;
			//$costValueQtyOnHand = 0;
            //$retailValueOnHand += $qtyOnHand*$plots->plot_price;
            $retailValueOnHand = 0;
			//$profitValueOnHand += (($plots->available_qty*$plots->retail_price)-($plots->available_qty*$mac));
             $profitValueOnHand = 0;
        }
        $data['qtyOnHand'] = $qtyOnHand;
        $data['costValueQtyOnHand'] = $costValueQtyOnHand;
        $data['retailValueOnHand'] = $retailValueOnHand;
        $data['profitValueOnHand'] = $profitValueOnHand;

        return view('admin.plotsManagement.plots_list', $data);
    }

    /**
     * Show the form for creating a new plots.
     *
     * @return plots create page view
     */
    public function create($tab)
    {
        //$plots_stock_id = Session::get('stock_id');
        $data['menu'] = 'plots_mamangement';

        $unit =  DB::table('plots')->get();
        //$unit_name = array();
        //foreach ($unit as $value) {
          //  $unit_name[$value->id] = $value->name;
        //}
        
        //$data['unit_name'] = $unit_name;

        $data['locData']      = DB::table('location')->get();
       $data['taxTypes']     = DB::table('item_tax_types')->get();
        $data['saleTypes']    = DB::table('sales_types')->get();
        $data['categoryData'] = DB::table('stock_category')->get();
       // $data['unitData']     = DB::table('plots_unit')->get();
        $data['suppliers']    = DB::table('suppliers')->get();

        //if(!empty($plots_stock_id)) {

           // $data['stock_id'] = strtoupper($plots_stock_id);
       // }
        
        $data['tab'] = $tab;

        return view('admin.plotsManagement.plots_add', $data);
    }

    /**
     * Store a newly created plots in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirection plots list page view
     */
    public function store(Request $request)
    {
        
		$this->validate($request, [
            'plot_id' => 'required',
            'plot_location' => 'required',
            'plot_size' => 'required',
			'plot_price' => 'required',
            'tax_type_id' => 'required',
            'plot_img' => 'required'
        ]);
        
        $data['plot_id'] = strtoupper($request->plot_id);
        $data['plot_location'] = strtoupper($request->plot_location);
		$data['plot_size'] = $request->plot_size;
        $data['plot_price'] = $request->plot_price;
		$data['plot_img'] = $request->plot_img;
		
         
       echo $pic = $request->file('plot_img');
         
        if (isset($pic)) {
          $destinationPath = public_path('/uploads/plotsPic/');
          $filename = $pic->getClientOriginalName();
          $img = Image::make($request->file('plot_img')->getRealPath());

          $img->resize(400,400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);
          
          $data['plot_img'] = $filename;
        }

        $id = DB::table('plots')->insertGetId($data);
         
        if (!empty($id)) {
           
            //\Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended("edit-plotManagement/$id");

        } else {

            return back()->withInput()->withErrors(['email' => "Invalid Request !"]);
        }
    }

    /**
     * Store a newly created plots  sales price in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return redirection plots purchasing price
     *
     public function storeSalePrice(Request $request){
        $this->validate($request, [
            'stock_id' => 'required|unique:sale_prices,stock_id',
            'sales_type_id' => 'required',
            'price' => 'required|numeric'
        ]);
        $data['stock_id'] = strtoupper($request->stock_id);
        $data['sales_type_id'] = $request->sales_type_id;
        $data['price'] = $request->price;
        $data['curr_abrev'] = $request->curr_abrev;
        DB::table('sale_prices')->insert($data);
        return redirect()->intended('create-plotManagement/purchase');

     }

    /**
     * Update plots  sales price in storage.
     * @param  \Illuminate\Http\Request  $request
     * 
     *
     public function addSalePrice(Request $request) {
        $this->validate($request, [
            'plot_id' => 'required',
            'sales_type_id' => 'required',
            'plot_price' => 'required|numeric'
        ]);

        $id = $request->plots_id;

        $data['stock_id'] = $request->stock_id;
        $data['sales_type_id'] = $request->sales_type_id;
        $data['price'] = $request->price;
        $data['curr_abrev'] = $request->curr_abrev;

        $ceck = DB::table('sale_prices')->where([
                                                    ['stock_id', '=', $request->stock_id],
                                                    ['sales_type_id', '=', $request->sales_type_id],
                                                ])->first();
        if(!empty($ceck)) {
            \Session::flash('fail',"Already added !");
            return redirect()->intended("edit-plotManagement/sales-info/$id");
        }else{

            DB::table('sale_prices')->insert($data);
            \Session::flash('success',trans('message.success.update_success'));
            return redirect()->intended('edit-plotManagement/sales-info/'.$request->plots_id);
        }


     }

     public function editSalePrice(Request $request) {
        //dd($request->id);
        $id = $request->id;

        $saleTypes = DB::table('sales_types')->get();

        $salesTypeName = array();
        foreach ($saleTypes as $value) {
            $salesTypeName[$value->id] = $value->sales_type;
        }

        $data = DB::table('sale_prices')->where('id', $id)->first();

        if(!empty($data)) {
            $v['id'] = $id;
            $v['sales_type_id'] = $salesTypeName[$data->sales_type_id];
            $v['price'] = $data->price;
            $v['status'] = 1;

            echo json_encode($v);
        }
     }

     public function updateSalePrice(Request $request)
     {
         $id = $request->id;

         DB::table('sale_prices')
            ->where('id', $id)
            ->update(['price' => $request->price]);

            \Session::flash('success',trans('message.success.update_success'));
            return redirect()->intended('edit-plotManagement/sales-info/'.$request->plots_id);

     }

     public function deleteSalePrice($id, $plots_id)
     {
         if (isset($id)) {
            $record = \DB::table('sale_prices')->where('id', $id)->first();
            if ($record) {
                
                \DB::table('sale_prices')->where('id', '=', $id)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
               return redirect()->intended('edit-plotManagement/sales-info/'.$plots_id);
            }
        }
     }

    /**
     * Store a newly created plots  purchase price in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return redirection plots purchasing price
     *
     public function updatePurchasePrice(Request $request){
        $this->validate($request, [
            'stock_id' => 'required',
            'price' => 'required|numeric',
           // 'supplier_id'=>'required'
        ]);
        
        $data['price'] = $request->price;
        //$data['supplier_id'] = $request->supplier_id;
        $data['stock_id'] = $request->stock_id;
        $priceInfo = DB::table('purchase_prices')->where('stock_id',$request->stock_id)->count();
       // d($priceInfo,1);
        if($priceInfo==0){
            DB::table('purchase_prices')->insert($data);
        }else{
            DB::table('purchase_prices')->where('stock_id', $request->stock_id)->update($data);
        }
        
        \Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('edit-plotManagement/purchase-info/'.$request->plots_id);
     }
    /**
     * Store a newly created plots  purchase price in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return redirection plots purchasing price
     *
     public function storePurchasePrice(Request $request){
        $this->validate($request, [
            'stock_id' => 'required|unique:purchase_prices,stock_id',
           // 'suppliers_uom' => 'required',
            'price' => 'required|numeric',
            'supplier_id'=>'required'
        ]);
        
        $data['stock_id'] = strtoupper($request->stock_id);
        $data['suppliers_uom'] = $request->suppliers_uom;
        $data['price'] = $request->price;
        $data['supplier_id'] = $request->supplier_id;
        $data['conversion_factor'] = $request->conversion_factor;
        $data['supplier_description'] = $request->supplier_description;        

        \Session::flash('success',trans('message.success.save_success'));
        DB::table('purchase_prices')->insert($data);
        return redirect()->intended('plotsManagement');

     }


    /**
     * Display the specified plots.
     *
     * @param  int  $id
     * @return plots show page view
     */
    public function show($id)
    {
        $data['menu'] = 'plots_mamangement';
        $data['header'] = 'plots';
        $data['breadcrumb'] = 'showplots';
        $loc =  DB::table('location')->get();
        $loc_name = array();
        foreach ($loc as $value) {
            $loc_name[$value->loc_code] = $value->location_name;
        }
        
        $data['loc_name'] = $loc_name;

        $data['plotsData'] = (new plots)->getplotsById($id);
        $data['loc_Data'] = (new plots)->getTransaction($data['plotsData']->stock_id);
        $data['locData'] = DB::table('location')->get();
        $data['plotsHistory'] = DB::table('stock_moves')
                                ->where(['stock_id'=>$data['plotsData']->stock_id])
                                ->orderBy('trans_id', 'desc')
                                ->take(5)
                                ->get();

        
        return view('admin.plotsManagement.plots_show', $data);
    }

    /**
     * Show the form for editing the specified plots.
     *
     * @param  int  $id
     * @return plots edit page view
     */
    public function edit($id)
    { 
        $data['menu'] = 'plots_mamangement';
        $data['header'] = 'plots';
        $data['breadcrumb'] = 'addplots';
        $data['customers'] = DB::table('cust_branch')->get();

        $loc =  DB::table('location')->get();
        $loc_name = array();
        foreach ($loc as $value) {
            $loc_name[$value->loc_code] = $value->location_name;
        }
        
        $data['loc_name'] = $loc_name;


        //$salesTypeName = array();
        //foreach ($data['saleTypes'] as $value) {
          //  $salesTypeName[$value->id] = $value->sales_type;
        //}
        
       // $data['salesTypeName'] = $salesTypeName;

      //  $data['plotInfo'] = DB::select(DB::raw("SELECT * From plots WHERE plot_id = '".$id."' ORDER By plots.pid ASC"));
          $data['plotInfo'] = DB::table('plots')
                          ->where('pid',$id)
                          ->select('*')
                          ->first();

        return view('admin.plotsManagement.plots_edit', $data);
    }

    /**
     * Show the form for Copy the specified plots.
     *
     * @param  int  $id
     * @return plots copy page view
     */
    public function copy($id)
    {
        $data['menu'] = 'plots_mamangement';
        $data['header'] = 'plots';
        $data['breadcrumb'] = 'copyplots';
        $data['locData'] = DB::table('location')->get();
        $data['taxTypes']     = DB::table('plots_tax_types')->get();
        $data['categoryData'] = DB::table('stock_category')->get();
        $data['unitData'] = DB::table('plots_unit')->get();
        $data['plotsData'] = (new plots)->getplotsById($id);
        
        return view('admin.plotsManagement.plots_copy', $data);
    }

    /**
     * Update the specified plots in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return redirection plots list page view
     */
    public function updateplotInfo(Request $request)
    {
        $this->validate($request, [
            'plot_id' => 'required',
            'plot_location' => 'required',
            'plot_size' => 'required',
            'plot_price' => 'required',
            'access_passes' => 'required',
            'debtor_no' => 'required',
            'amount_paid' => 'required',
            'amount_remaining' => 'required',
            'is_hired' => 'required',
            'plot_img' => 'mimes:jpeg,bmp,png'
        ]); 

        $data['plot_id'] = $request->plot_id;
        $data['plot_location'] = $request->plot_location;
        $data['plot_size'] = $request->plot_size;
        $data['plot_price'] = $request->plot_price;
        $data['access_passes'] = $request->access_passes;
        $data['debtor_no'] = $request->debtor_no;
        $data['amount_paid'] = $request->amount_paid;
        $data['amount_remaining'] = $request->amount_remaining;
        $data['is_hired'] = $request->is_hired;
        
        //$data['updated_at'] = date('Y-m-d H:i:s');

        $pic = $request->file('plot_img');

        if (isset($pic)) {

          $pic1 = $request->pic;
          if ($pic1 != NULL) {
            $dir = public_path("uploads/plotsPic/$pic1");
            if (file_exists($dir)) {
               unlink($dir);  
            }

          $destinationPath = public_path('/uploads/plotsPic/');
          $filename = $pic->getClientOriginalName();
          $img = Image::make($request->file('plot_img')->getRealPath());

          $img->resize(400,400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);

          $data['plot_img'] = $filename;
          }
        }
        
        DB::table('plots')->where('pid', $request->pid)->update($data);


        Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('edit-plotManagement/'.$request->pid);

    }

    /**
     * Remove the specified plots from storage.
     *
     * @param  int  $id
     * @return redirect plots list page view
     */
    public function destroy($id)
    {
        if (isset($id)) {
            $record = DB::table('plots')->where('plot_id', $id)->first();
            if ($record) {
                DB::table('plots')->where('plot_id', '=', $id)->update(['is_hired'=>0]);
                Session::flash('success',trans('message.success.status_success'));
                return redirect()->intended('plotsManagement');
            }
        }
    }

    /**
     * Add plots to stock.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect plots show page view
     *
    public function addStock(Request $request)
    {
        $p_id = \Auth::user()->id;
        $data['stock_id'] = $request->stock_id;
        $data['type'] = $request->type;
        $data['loc_code'] = $request->loc_code;
        $data['person_id'] = $p_id;
        $data['qty'] = $request->quantity;
        $data['note'] = $request->reference;
        $data['tran_date'] = date('Y-m-d H:i:s');

        $insert_id = DB::table('stock_moves')->insertGetId($data);
        
        $id = $request->id;
        
        if (!empty($insert_id)) {
            \Session::flash('success',trans('message.success.added_success'));
            return redirect()->intended("show-plotManagement/$id");
        }
    }

    /**
     * Remove plots to stock.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect plots show page view
     *
    public function removeStock(Request $request)
    {
        $p_id = \Auth::user()->id; 
        $data['stock_id'] = $request->stock_id;
        $data['type'] = $request->type;
        $data['loc_code'] = $request->loc_code;
        $data['person_id'] = $p_id;
        $data['qty'] = "-".$request->quantity;
        $data['note'] = $request->reference;
        $data['tran_date'] = date('Y-m-d H:i:s');

        $id = $request->id;

        $status = $this->qtyValidate($request->loc_code, $request->stock_id,$request->quantity);
        //dd($status);

        if ($status['fail'] == 1) {
            $nm = $status['stock']; 
            \Session::flash('fail',"You Can not Remove more than $nm plots.");
            return redirect()->intended("show-plotManagement/$id");
            exit();
        }
        $insert_id = DB::table('stock_moves')->insertGetId($data);
        
        
        if (!empty($insert_id)) {
            \Session::flash('success',trans('message.success.removed_success'));
            return redirect()->intended("show-plotManagement/$id");
        }
    }

    /**
     * Move plots from one to another stock.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect plots show page view
     *
    public function moveStock(Request $request)
    {
        $id = $request->id;
        $p_id = \Auth::user()->id;
        $data['stock_id'] = $request->stock_id;
        $data['type'] = $request->type;
        $data['loc_code'] = $request->loc_code1;
        $data['person_id'] = $p_id;
        $data['qty'] = "-".$request->quantity;
        $data['note'] = $request->reference;
        $data['tran_date'] = date('Y-m-d H:i:s');

        $status = $this->qtyValidate($request->loc_code1, $request->stock_id,$request->quantity);
        
        if($status['fail'] == 1){

            $nm = $status['stock']; 
            \Session::flash('fail',"You Can not Move more than $nm plots.");
            return redirect()->intended("show-plotManagement/$id");
            exit();
        }


        $insert_id = DB::table('stock_moves')->insert($data);

        $data2['stock_id'] = $request->stock_id;
        $data2['type'] = $request->type;
        $data2['loc_code'] = $request->loc_code2;
        $data2['person_id'] = $p_id;
        $data2['qty'] = $request->quantity;
        $data2['note'] = $request->reference;
        $data2['tran_date'] = date('Y-m-d H:i:s');

        $insert_id = DB::table('stock_moves')->insert($data2);

        $loc =  DB::table('location')->get();
        $loc_name = array();
        foreach ($loc as $value) {
            $loc_name[$value->loc_code] = $value->location_name;
        }


        $a = $loc_name[$request->loc_code1];
        $b = $request->quantity;
        $c = $loc_name[$request->loc_code2];
        
        \Session::flash('success',trans('message.success.moved_success'));
            return redirect()->intended("show-plotManagement/$id");

    }

    /**
     * Validated plots quantity if it can be removed from stock.
     *
    public function qtyValidate($loc, $id, $qty)
    {
        $v = [];
        $current_stock = (new plots)->stock_validate($loc, $id);
        
        if ($current_stock->total < $qty) {
            
            $v['stock'] = $current_stock->total;
            $v['fail'] = 1;

            return $v;
            
        } else {
            $v['fail'] = 0;
            return $v;
        }
    }

    /**
     * Validated plots quantity if it can be removed from stock. using ajax 
     *
    public function qtyValidAjax()
    {
        $v = [];
        $id = $_POST['mvid'];
        $loc = $_POST['loc1'];
        $qty = $_POST['qty'];

        $current_stock = (new plots)->stock_validate($loc, $id);
        //dd($current_stock);

        if (empty($current_stock)) {
            
            $v['fail'] = 2;
            echo json_encode($v);
            
        } elseif (!empty($current_stock) && $current_stock->total < $qty) {
            
            $v['stock'] = $current_stock->total;
            $v['fail'] = 1;

            echo json_encode($v);
        
        } else {
            $v['fail'] = 0;
            echo json_encode($v);
        }
    }

    /**
     * Validated plots Id is unique or not
     *
    public function stockValidChk()
    {
        $st_id = $_POST['stock_id'];
        $v = DB::table('plots_code')->where('stock_id',$st_id)->first();
        
        if (!empty($v)) {
             echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * Show full transation details
     */
    public function showFullDetails($id)
    {
        $data['menu'] = 'plots_mamangement';
        $data['header'] = 'plots';
        $data['breadcrumb'] = 'historyplots';
        $loc =  DB::table('location')->get();
        $loc_name = array();
        foreach ($loc as $value) {
            $loc_name[$value->loc_code] = $value->location_name;
        }
        
        $data['loc_name'] = $loc_name;
        $data['plotsHistory'] = DB::table('stock_moves')
                                ->where(['stock_id'=>$id])
                                ->orderBy('trans_id', 'desc')
                                ->get();


        return view('admin.plotsManagement.plots_transition', $data);
    }

    public function downloadCsv($type)
    {
        if ($type == 'csv' ) {

            $plotsdata = (new plots)->getAllplotsCsv();
//d($plotsdata,1);
            foreach ($plotsdata as $key => $value) {
                $csvdata[$key]['Plots ID'] = $value->plot_id;
                $csvdata[$key]['Plots Location'] = $value->plot_location;
                $csvdata[$key]['Plot Size'] = $value->plot_size;
                $csvdata[$key]['Plot Price'] = $value->plot_price;
                $csvdata[$key]['Plot Image'] = $value->plot_img;
                $csvdata[$key]['Access Passes'] = $value->access_passes;
				$csvdata[$key]['Customer ID'] = $value->debtor_no;
				$csvdata[$key]['Amount Paid'] = $value->amount_paid;
                $csvdata[$key]['Amount Remaining'] = $value->amount_remaining;
				$csvdata[$key]['Is Hired'] = $value->is_hired;
				
            }
        }
        //d($csvdata,1);

        if( $type == 'sample' ) {
            $csvdata[0]['Plots ID'] = 'Plot-1'; 
            $csvdata[0]['Plots Location'] = 'Main';
            $csvdata[0]['Plot Size'] = '5x5';
            $csvdata[0]['Plot Price'] = '500';
            $csvdata[0]['Plot Image'] = 'image.jpg';
            $csvdata[0]['Access Passes'] = '5';
            $csvdata[0]['Customer ID'] = '45';
            $csvdata[0]['Amount Paid'] = '250';
            $csvdata[0]['Amount Remaining'] = '250';
			$csvdata[0]['Is Hired'] = '1';

            $type = 'csv';
        }

        return Excel::create('plots_sheet'.time().'', function($excel) use ($csvdata) {
            
            $excel->sheet('mySheet', function($sheet) use ($csvdata)
            {
                $sheet->fromArray($csvdata);
            });
            
        })->download($type);
    }

    public function import()
    {
        $data['menu'] = 'plots_mamangement';
        
        return view('admin.plotsManagement.plots_import', $data);
    }

    public function importCsv(Request $request)
    {
        $file = $request->file('import_file');
        
        $validator = Validator::make(
            [
                'file'      => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors(['email' => "File type Invalid !"]);
        }

        if (Input::hasFile('import_file')) {
                $path = Input::file('import_file')->getRealPath();
            
            $csv = array_map('str_getcsv', file($path));
            $unMatch = [];
            $header = array("Plot ID", "Plot Name", "Long Description", "plots Category", "Unit", "Tax Type", "Purchase Price", "Retail Price", "Wholesale Price",'is_hired');
            $size = sizeof($csv[0]);
            for ($i=0; $i < $size; $i++) {
                if (! in_array($csv[0][$i], $header)) {
                    $unMatch[] = $csv[0][$i];
                }
            }

            if(!empty($unMatch)) {

                return back()->withErrors(['email' => "Please Check Csv Header Name !"]);
            }
            
            $data = [];
            foreach ($csv as $key => $value) {
                if($key != 0) {
                    $data[$key]['plot_id'] = $value[0];
                    $data[$key]['plot_location'] = $value[1];
                    $data[$key]['plot_size'] = $value[2];
                    $data[$key]['plot_price'] = $value[3];
                    $data[$key]['plot_img'] = $value[4];
                    $data[$key]['access_passes'] = $value[5];
                    $data[$key]['debtor_no'] = $value[6];
                    $data[$key]['amount_paid'] = $value[7];
                    $data[$key]['amount_remaining'] = $value[8];
                    $data[$key]['is_hired'] = $value[9];
                }
            }

            $data = array_values($data);
            
            if (!empty($data)) {

                $plots = uniqueMultidimArray($data,'plot_id');
                sort($plots);
                foreach ($plots as $key => $value) {
                    
                    $plotsCount = DB::table('plots')->where('plot_id','=',$value['plot_id'])->count();
                   
                    if ($plotsCount == 0 ) {
                        //d($data);
                        DB::table('plots')->insert($data);
                    }else{
                        return back()->withErrors(['email' => "Please Check Csv File !"]);
                    }
                }
                //d($plotsCode,1);
                /*d($plotsCode);
                d($salePrice);
                d($purchPrice,1);*/

              

                
                if (!empty($plotsCode)) {
                    DB::table('plots')->insert($plotsCode);
                    
                    \Session::flash('success',trans('message.success.import_success'));
                    return redirect()->intended('plotsManagement');
                }else{
                        return back()->withErrors(['email' => "Please Check Csv File !"]);
                    }
            }
        }
        return back();
    }
}