<?php

namespace App\Http\Controllers\Admin;

use App\Models\DrugUnitPrice;
use App\Models\OrderBusy;
use App\Models\OrderFile;
use App\Models\OrderInfo;
use App\Models\OrderMessage;
use App\Models\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Organization;
use App\Models\Drug;
use App\Models\OrderDeliveryStatus;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('from',Auth::guard('admin')->user()['organization_id'])->orWhere('to',Auth::guard('admin')->user()['organization_id'])->where('status','!=',Order::SAVED)->orderBy('id','DESC')->get();
        $status = Order::$status;
        $status_to = array(
            Order::PROCEEDFROM => $status[Order::PROCEEDFROM],
            Order::APPROVED => $status[Order::APPROVED],
            Order::CANCELED => $status[Order::CANCELED],
        );
        return view('admin.order.index',['orders' => $orders,'status' => $status, 'status_to' => $status_to]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $warning_drugs = Storage::where('organization_id',Auth::guard("admin")->user()['organization_id'])->where('count','<', 10)->get();
        $orders = Order::where('from',Auth::guard('admin')->user()['organization_id'])->whereNotIn('status',array(Order::APPROVED,Order::CANCELED))->get();
        $warning_drugs = Storage::warningDrugs();
        $organizations = Organization::where('status',1)->get();
        return view('admin.order.create',['organizations' => $organizations, 'warning_drugs' => $warning_drugs]);
    }

    public function store(Request $request){
        $data = $request->all();
        $status = Order::SAVED;
        if(isset($data['order_send'])){
            $status = Order::PROCEEDTO;
        }
        $data_order = array();
        $data_order['to'] = $data['to'];
        $data_order['from'] = Auth::guard('admin')->user()['organization_id'];
        $data_order['status'] = $status;
        if(isset($data['delivery_status_id'])){
            if($data['delivery_status_id'] != 0){
                $data_order['delivery_status_id'] = $data['delivery_status_id'];
            }
        }
        if(isset($data['order_delivery_address'])){
            if($data['order_delivery_address'] != 0){
                $data_order['delivery_address'] = $data['order_delivery_address'];
            }
        }
        $order = Order::create($data_order);
        if(isset($data['order_send'])){
            $drugs = json_decode($data['data']);
            OrderMessage::create(array(
                'order_id' => $order->id,
                'from' => Auth::guard('admin')->user()['organization_id'],
                'message' => $data['message']
            ));
            foreach($drugs as $drug){
                OrderInfo::create(array(
                    'order_id' => $order->id,
                    'storage_id' => $drug->storage_id,
                    'count' => $drug->count
                ));
            }
        }elseif($data['order_save']){
            $drugs = $data['info'];
            foreach($drugs as $drug){
                OrderInfo::create(array(
                    'order_id' => $order->id,
                    'storage_id' => $drug['storage_id'],
                    'count' => $drug['count']
                ));
            }
        }

        if($status == Order::PROCEEDTO){
            $this->generateExcel($order->id);
        }

        return response()->json(true);
    }
    public function edit($id)
    {
        $order = Order::where('id',$id)->first();
        $checkBusy = $this->checkOrderBusy($order->id);
        if(!$checkBusy){
            return redirect()->back()->withErrors(['error' => 'This order has been taken by another user']);
        }
        if($order->to == Auth::guard("admin")->user()['organization_id']){
            $this->orderBusy($order->id);
        }
        if(Order::CANCELED == $order->status && $order->from == Auth::guard("admin")->user()['organization_id']){
            return redirect('/admin/order');
        }
        if($order->status == Order::APPROVED){
            return redirect('/admin/order');
        }else{
            if($order->from == Auth::guard("admin")->user()['organization_id'] && ($order->status != Order::PROCEEDFROM && $order->status != Order::SAVED)){
                return redirect('/admin/order');
            }elseif($order->to == Auth::guard("admin")->user()['organization_id'] && $order->status == Order::PROCEEDFROM){
                return redirect('/admin/order');
            }
        }
        $drugs = OrderInfo::where('order_id',$id)->get();
        $answer_order = false;
        if($order->to == Auth::guard("admin")->user()['organization_id']){
            $answer_order = true;
        }
        return view('admin.order.edit',['drugs' => $drugs,'order' => $order,'answer_order' => $answer_order]);
    }

    public function show(Request $request,$id){
        $data = $request->all();
        $order = OrderInfo::where('order_id',$id)->where('storage_id',$data['storage_id'])->first();
        $currentDrug = Drug::find($order->storage->drug_id);
        $currentDrug->category;
        $currentDrug->certificate_number;
        $currentDrug->country;
        $currentDrug->expiration_date;
        $currentDrug->group;
        $currentDrug->manufacturer;
        $currentDrug->count;
        $currentDrug->picture;
        $currentDrug->registration_certificate_holder;
        $currentDrug->registration_date;
        $currentDrug->release_packaging;
        $currentDrug->release_order;
        $currentDrug->series;
        $currentDrug->supplier;
        $currentDrug->type;
        $currentDrug->type_belonging;
        $currentDrug->unit;
        $currentDrug->unit_price;
        $currentDrug->character;
        return response()->json(array("order" => $order, "drug" => $currentDrug));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $status = Order::SAVED;
        if(isset($data['order_send'])){
            $status = Order::PROCEEDTO;
            if($data['status']){
                $status = $data['status'];
            }
        }

        if(isset($data['order_send'])){
            $drugs = json_decode($data['data']);
            OrderMessage::create(array(
                'order_id' => $id,
                'from' => Auth::guard('admin')->user()['organization_id'],
                'message' => $data['message']
            ));
            if(!empty($drugs)){
                OrderInfo::where('order_id',$id)->delete();
                foreach($drugs as $drug){
                    OrderInfo::create(array(
                        'order_id' => $id,
                        'storage_id' => $drug->storage_id,
                        'count' => $drug->count
                    ));
                }
            }
        }elseif($data['order_save']){
            if(isset($data['info'])){
                OrderInfo::where('order_id',$id)->delete();
                $drugs = $data['info'];
                foreach($drugs as $drug){
                    OrderInfo::create(array(
                        'order_id' => $id,
                        'storage_id' => $drug['storage_id'],
                        'count' => $drug['count']
                    ));
                }
            }
        }


        $order_data = array();
        $order_data['status'] = $status;
        if(isset($data['delivery_status_id'])){
            if($data['delivery_status_id']){
                $order_data['delivery_status_id'] = $data['delivery_status_id'];
            }
        }
        if(isset($data['order_delivery_address'])){
            if($data['order_delivery_address']){
                $order_data['delivery_address'] = $data['order_delivery_address'];
            }
        }
        if(isset($data['delivery_date'])){
            if($data['delivery_date'] != 0){
                $order_data['date'] = $data['delivery_date'];
            }else{
                if($data['status'] == Order::APPROVED){
                    $order_data['date'] = date("Y-m-d H:i:s",strtotime("+3 hour"));
                }
            }
        }else{
            if(isset($data['status'])){
                if($data['status'] == Order::APPROVED){
                    $order_data['date'] = date("Y-m-d H:i:s",strtotime("+3 hour"));
                }
            }
        }
        Order::where('id',$id)->update($order_data);
        if(isset($data['status'])){
            if($data['status'] != Order::CANCELED){
                $file = $this->generateExcel($id);
                if($data['status'] == Order::APPROVED){
                    Order::where('id',$id)->update(array('file' => $file));
                }
            }
        }
        return response()->json(true);
    }
    public function messages($id){
        $messages = OrderMessage::where('order_id',$id)->get();
        OrderMessage::where('order_id',$id)->update(array(
            'read' => 1
        ));
        return response()->json($messages);
    }

    public function changeStatus(Request $request){
        $data = $request->all();
        Order::where('id',$data['id'])->update(array(
           'status' => $data['status']
        ));

        return redirect('/admin/order');
    }

    public function getAnswerStatuses(){
        $status = Order::$status;
        $statuses = array(
            Order::PROCEEDFROM => $status[Order::PROCEEDFROM],
            Order::APPROVED => $status[Order::APPROVED],
            Order::CANCELED => $status[Order::CANCELED],
        );
        return response()->json($statuses);
    }

    public function getDeliveryStatuses(){
        $delivery_statuses = OrderDeliveryStatus::all();
        return response()->json($delivery_statuses);
    }

    public function changeStatusTo(Request $request){
        $data = $request->all();
        $order = Order::where('id',$data['id'])->first();
        $checkBusy = $this->checkOrderBusy($data['id']);
        if(!$checkBusy){
            return response()->json(['error' => 'This order has been taken by another user']);
        }
        if($order->to == Auth::guard("admin")->user()['organization_id']){
            $this->orderBusy($order->id);
        }
        $data_order = array();
        $data_order['status'] = $data['status'];
        if(!empty($data['delivery_date'])){
            $data_order['date'] = $data['delivery_date'];
        }else{
            if($data['status'] == Order::APPROVED){
                $data_order['date'] = date("Y-m-d H:i:s",strtotime("+3 hour"));
            }
        }
        Order::where('id',$data['id'])->update($data_order);

        OrderMessage::create(array(
           'order_id' => $data['id'],
            'from' => Auth::guard('admin')->user()['organization_id'],
            'message' => $data['message']
        ));
        if($data['status'] == Order::APPROVED){
            $file = OrderFile::where('order_id',$data['id'])->orderBy('id','Desc')->first();
            Order::where('id',$data['id'])->update(array('file' => $file->file));
        }
        return response()->json(true);
    }

    public function receivedOrder(Request $request){
        $data = $request->all();
        $drugs = OrderInfo::where('order_id',$data['order_id'])->get();
        foreach($drugs as $drug){
            $price = number_format($data[$drug->id],2,".","");
            if(!DrugUnitPrice::where('drug_id',$drug->id)->where('price',$price)->count()){
                $drug_unit_price = DrugUnitPrice::create(array(
                    'drug_id' => $drug->id,
                    'price' => $price
                ));
            }else{
                $drug_unit_price = DrugUnitPrice::where('drug_id',$drug->id)->where('price',$price)->first();
            }
            if($count = Storage::checkDrugExists($drug->storage->drug_id,$drug->storage->drug_settings)){
                Storage::where('organization_id',Auth::guard('admin')->user()['organization_id'])
                    ->where('drug_id',$drug->storage->drug_id)->where('drug_settings',$drug->storage->drug_settings)
                    ->update(array(
                       'count' => ($count + $drug->count),
                        'price_id' => $drug_unit_price->id
                    ));
                $count = $drug->count;
            }else{
                Storage::create(array(
                   'organization_id' =>  Auth::guard('admin')->user()['organization_id'],
                    'drug_id' => $drug->storage->drug_id,
                    'drug_settings' => $drug->storage->drug_settings,
                    'count' => $drug->count,
                    'price_id' => $drug_unit_price->id
                ));
                $count = $drug->count;
            }
            // update whole sale storage
            $old_count = Storage::where('id',$drug->storage_id)->first();
            Storage::where('id',$drug->storage_id)->update(array(
                'count' => ($old_count->count - $count)
            ));
        }
        Order::where('id',$data['order_id'])->update(array(
            'status' => Order::RECEIVED
        ));
        return response()->json(true);
    }

    public function changeOrganization(Request $request){
        return redirect()->back()->withInput();
    }

    private function orderBusy($order_id){
        OrderBusy::where('order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->update(array(
           'status' => 0
        ));
        if(OrderBusy::where('order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->where('admin_id',Auth::guard('admin')->user()['id'])->count()){
            OrderBusy::where('order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->where('admin_id',Auth::guard('admin')->user()['id'])->update(array(
                'status' => 1
            ));
        }else{
            OrderBusy::create(array(
               'order_id' => $order_id,
                'organization_id' => Auth::guard('admin')->user()['organization_id'],
                'admin_id' => Auth::guard('admin')->user()['id'],
                'status' => 1
            ));
        }
    }
    private function checkOrderBusy($order_id){
        if(OrderBusy::where('order_id',$order_id)->where('status',1)->where('admin_id','!=',Auth::guard('admin')->user()['id'])->where('organization_id',Auth::guard('admin')->user()['organization_id'])->count()){
            return false;
        }
        return true;
    }

    public function release($order_id){
        OrderBusy::where('order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->where('admin_id',Auth::guard('admin')->user()['id'])->update(array(
            'status' => 0
        ));
        return redirect()->back();
    }
    public function getReceivedInfo(Request $request, Drug $drug){
        $data = $request->all();
        $infos = OrderInfo::where('order_id',$data['order_id'])->get();
        $response = array();
        foreach($infos as $info){
            $settings = json_decode($info->storage->drug_settings);
            $response_settings = array();
            foreach($settings as $key => $setting){
                foreach($info->storage->drug->$key as $drug_settings){
                    if($drug_settings->id == $setting){
                        if(preg_match('/date/',$key)){
                            $response_settings[] = array($drug->setting_names()[$key] => $drug_settings->date);
                        }elseif(preg_match('/count/',$key) && $key != 'country'){
                            $response_settings[] = array($drug->setting_names()[$key] => $drug_settings->count);
                        }else{
                            $response_settings[] = array($drug->setting_names()[$key] => $drug_settings->name);
                        }
                    }
                }
            }
            $response[] = array(
                'id' => $info->id,
                'name' => $info->storage->drug->trade_name,
                'count' => $info->count,
                'price' => $info->storage->price->price,
                'settings' => $response_settings
            );
        }
        return response()->json($response);
    }

    public function excelFiles(Request $request){
        $data = $request->all();
        $order = Order::where('id',$data['order_id'])->first();
        if($order->status == Order::APPROVED || $order->status == Order::RECEIVED){
            $files = array(OrderFile::where('order_id',$data['order_id'])->orderBy('id','Desc')->first());
        }else{
            $files = OrderFile::where('order_id',$data['order_id'])->get();
        }
        $approved = false;
        if($order->status == Order::APPROVED){
            $approved = true;
        }
        return response()->json(["files"=>$files,"approved" => $approved]);
    }

    public function excelDownload($file){
        return response()->download(storage_path().'/exports/'.$file.'.xls');
    }

    public function generateExcel($order_id = null){
        $order = Order::where('id',$order_id)->first();
        if($order->delivery_status->id == 1){
            $delivery_status = 'ՏԵղում';
        }else{
            $delivery_status = 'Առաքում';
        }
        if($order->organizationTo->status == 1){
            $organization_status = 'Մեծածախ';
        }elseif ($order->organizationTo->status == 2){
            $organization_status = 'Դեղատուն';
        }else{
            $organization_status = '';
        }
        if($order->organizationFrom->status == 1){
            $organization_from_status = 'Մեծածախ';
        }elseif ($order->organizationFrom->status == 2){
            $organization_from_status = 'Դեղատուն';
        }else{
            $organization_from_status = '';
        }
        $order_details = array(
            'B2' => $order->id.". ".$order->created_at.", ".$delivery_status."",
            'C4' => $organization_status. " (".$order->organizationTo->name.")",
            'C5' => $order->organizationFrom->admin[0]->firstname." ".$order->organizationTo->admin[0]->lastname." (".$order->organizationTo->admin[0]->email.")",
            'C6' => $order->organizationFrom->admin[0]->city." ".$order->organizationTo->admin[0]->street." ".$order->organizationTo->admin[0]->apartment,
            'C7' => $order->organizationFrom->identification_number,
            'C8' => $order->organizationFrom->bank_account_number,
            'C9' => $order->organizationFrom->phone,
            'C10' => $order->organizationFrom->email,
            'C11' => $order->delivery_address,
            'C12' => $order->delivery_date,
            'C14' => $organization_from_status. " (".$order->organizationFrom->name.")",
            'C15' => $order->organizationTo->admin[0]->firstname." ".$order->organizationFrom->admin[0]->lastname." (".$order->organizationFrom->admin[0]->email.")",
            'C16' => $order->organizationTo->admin[0]->city." ".$order->organizationFrom->admin[0]->street." ".$order->organizationFrom->admin[0]->apartment,
            'C17' => $order->organizationTo->identification_number,
            'C18' => $order->organizationTo->bank_account_number,
            'C19' => $order->organizationTo->phone,
            'C20' => $order->organizationTo->email,
        );
        $drugs = OrderInfo::where('order_id',$order_id)->get();
        $i = 1;
        $data_drugs = array();
        foreach($drugs as $drug){
            $settings = json_decode($drug->drug_settings);
            $unit_price = '';
            $price = '';
            if(isset($drug->unit_price)){
                $unit_price = $drug->unit_price;
                $price = $drug->count * $unit_price;
            }
            $data_drugs[] = array($i,$drug->storage->drug->trade_name,'',$drug->count,$unit_price,$price,'','','');
        }
        $filename = $order_id."_".date("Y_m_d_H_i_s");
        Excel::create($filename, function($excel) use($order_details,$data_drugs) {
            // Our first sheet
            $excel->sheet('First', function($sheet) use($order_details,$data_drugs) {
                $sheet->setFontSize(10);
                // Set width for multiple cells
                $sheet->setWidth(array(
                    'A'     =>  5,
                    'B'     =>  50,
                    'C'     =>  20,
                    'D'     =>  10,
                    'E'     =>  15,
                    'F'     =>  10,
                    'G'     =>  25,
                    'H'     =>  13,
                    'I'     =>  10,
                ));
                $sheet->cell('B2', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setAlignment('center');
                });
                $sheet->cell('B3', function($cell) {
                    $cell->setValue('Պատվիրող');
                    $cell->setFontWeight('bold');
                });
                $sheet->cell('B4', function($cell) {
                    $cell->setValue('Անվանումը');
                });
                $sheet->cell('B5', function($cell) {
                    $cell->setValue('Անունը');
                });
                $sheet->cell('B6', function($cell) {
                    $cell->setValue('Հասցե');
                });
                $sheet->cell('B7', function($cell) {
                    $cell->setValue('ՀՎՀՀ');
                });
                $sheet->cell('B8', function($cell) {
                    $cell->setValue('Բանկային Հ/Հ');
                });
                $sheet->cell('B9', function($cell) {
                    $cell->setValue('Բջջային հեռ․');
                });
                $sheet->cell('B10', function($cell) {
                    $cell->setValue('Էլ․ փոստի հասցե');
                });
                $sheet->cell('B11', function($cell) {
                    $cell->setValue('Մատակարարվող ապրանքների նշանակման վայրը');
                });
                $sheet->cell('B12', function($cell) {
                    $cell->setValue('Մատակարարման ամսաթիվ');
                });
                $sheet->cell('B13', function($cell) {
                    $cell->setValue('Մատակարար');
                    $cell->setFontWeight('bold');
                });
                $sheet->cell('B14', function($cell) {
                    $cell->setValue('Անվանումը');
                });
                $sheet->cell('B15', function($cell) {
                    $cell->setValue('Անունը');
                });
                $sheet->cell('B16', function($cell) {
                    $cell->setValue('Հասցե');
                });
                $sheet->cell('B17', function($cell) {
                    $cell->setValue('ՀՎՀՀ');
                });
                $sheet->cell('B18', function($cell) {
                    $cell->setValue('Բանկային Հ/Հ');
                });
                $sheet->cell('B19', function($cell) {
                    $cell->setValue('Բջջային հեռ․');
                });
                $sheet->cell('B20', function($cell) {
                    $cell->setValue('Էլ․ փոստի հասցե');
                });
                foreach($order_details as $key => $order_detail){
                    $sheet->cell($key, function($cell) use ($order_detail) {
                        $cell->setValue($order_detail);
                    });
                }
                $sheet->mergeCells('A21:D21');
                $sheet->cells('A21', function($cell) {
                    $cell->setValue('Մատակարարվող ապրանքների քանակի և վճարման ենթակա գումարի հաշվարկ');
                    $cell->setValignment('center');
                    $cell->setFontWeight('bold');
                });
                $sheet->setBorder('A22:I22', 'thin');
                $sheet->cell('A22', function($cell) {
                    $cell->setValue('Հ/Հ');
                    $cell->setValignment('center');
                });
                $sheet->cell('B22', function($cell) {
                    $cell->setValue('Ապրանքի անվանումը');
                    $cell->setAlignment('center');
                });
                $sheet->cell('C22', function($cell) {
                    $cell->setValue('Չափման միավորը');
                    $cell->setAlignment('center');
                });
                $sheet->cell('D22', function($cell) {
                    $cell->setValue('Քանակը');
                    $cell->setAlignment('center');
                });
                $sheet->cell('E22', function($cell) {
                    $cell->setValue('Միավորի գինը');
                    $cell->setAlignment('center');
                });
                $sheet->cell('F22', function($cell) {
                    $cell->setValue('Արժեքը');
                    $cell->setAlignment('center');
                });
                $sheet->cell('G22', function($cell) {
                    $cell->setValue('ԱԱՀ դրույքաչափը (%)');
                    $cell->setAlignment('center');
                });
                $sheet->cell('H22', function($cell) {
                    $cell->setValue('ԱԱՀ գումարը');
                    $cell->setAlignment('center');
                });
                $sheet->cell('I22', function($cell) {
                    $cell->setValue('Ընդամենը');
                    $cell->setAlignment('center');
                });
                $sheet->setBorder('A23:I99', 'thin');
                $sheet->cell('A23:I99', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontSize(12);
                });
                $sheet->fromArray($data_drugs, null, 'A23', false, false);
            });
        })->store('xls');
        OrderFile::create(array(
            'order_id' => $order_id,
            'organization_id' => Auth::guard('admin')->user()['organization_id'],
            'file' => $filename
        ));
        return $filename;
    }
}
