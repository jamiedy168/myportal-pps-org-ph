<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\EventTransaction;
use App\Models\ORMaster;
use App\Models\Event;
use App\Models\EventPrice;
use App\Models\EventCart;
use App\Models\MemberInfo;
use App\Models\AnnualDuesCart;
use App\Models\AnnualDues;
use App\Models\TransactionCart;
use App\Models\EventSelected;
use App\Models\EventTopic;
use App\Models\SyncAnnualDues;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CashierReportExport;
use Illuminate\Support\Str;
use App\Support\PaymongoConfig;
use Batch;
use Carbon\Carbon;

use DB;
use Curl;
use Session;
use DataTables;

class CashierController extends Controller
{
    //

    private $pps_url = 'https://portal.pps.org.ph/';
    // private $pps_url = 'http://127.0.0.1/';.

    public function searchMemberDropDown(Request $request)
    {
        $search = $request->get('q'); 

        $members = MemberInfo::where('is_active', true)
            ->where('status', 'ACCEPTED')
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'ILIKE', "%{$search}%")
                            ->orWhere('middle_name', 'ILIKE', "%{$search}%")
                            ->orWhere('last_name', 'ILIKE', "%{$search}%")
                            ->orWhere('suffix', 'ILIKE', "%{$search}%")
                            ->orWhere('prc_number', 'ILIKE', "%{$search}%");
                });
            })
            ->limit(10)
            ->get();

        $results = $members->map(function ($m) {
            return [
                'id' => Crypt::encrypt($m->pps_no),
                'text' => "{$m->first_name} {$m->middle_name} {$m->last_name} {$m->suffix} | {$m->member_type_name} | {$m->prc_number}"
            ];
        });

        return response()->json(['results' => $results]);

    }


    public function searchMemberDropDownWithoutEncrypt(Request $request)
    {
        $search = $request->get('q'); 

        $members = MemberInfo::where('is_active', true)
            ->where('status', 'ACCEPTED')
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'ILIKE', "%{$search}%")
                            ->orWhere('middle_name', 'ILIKE', "%{$search}%")
                            ->orWhere('last_name', 'ILIKE', "%{$search}%")
                            ->orWhere('suffix', 'ILIKE', "%{$search}%")
                            ->orWhere('prc_number', 'ILIKE', "%{$search}%");
                });
            })
            ->limit(10)
            ->get();

        $results = $members->map(function ($m) {
            return [
                'id' => $m->pps_no,
                'text' => "{$m->first_name} {$m->middle_name} {$m->last_name} {$m->suffix} | {$m->member_type_name} | {$m->prc_number}"
            ];
        });

        return response()->json(['results' => $results]);

    }



    public function cashierEventView()
    {
     
            $eventTransaction = EventTransaction::select('tbl_event_transaction.*','member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no',
            'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type','member.prc_number',
            'category.name as category_name',
            'memtype.member_type_name',
            'event.title','event.price','event.description','member.type',
            'ormaster.payment_mode','ormaster.payment_dt','ormaster.amount','ormaster.total_amount','ormaster.change','ormaster.or_no',
            DB::raw("(
                select price from tbl_event_price where event_id = event.id and is_active = true and member_type_id = member.member_type) as prices"),
            )
            ->join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
            ->join('tbl_event_category as category','category.id','=','event.category_id')
            ->join('tbl_member_info as member','member.pps_no','=','tbl_event_transaction.pps_no')
            ->leftJoin('tbl_or_master as ormaster','ormaster.transaction_id','=','tbl_event_transaction.id')
            ->leftjoin('tbl_member_type as memtype','memtype.id','=','member.member_type')
            ->where('event.is_active',true)
            ->orderBy('ormaster.payment_dt','DESC')
            ->paginate(10);

            $event = Event::select( 'tbl_event.*')
            ->where('is_active',true)
            ->where('status','!=','COMPLETED')
            ->get();

            $member = MemberInfo::where('is_active',true)
            ->where('status','ACCEPTED')
            ->paginate(10);

            return view('cashier.cashier-event',compact('eventTransaction','event','member'));

    }

    public function cashierSearchEventTransaction(Request $request)
    {

        $name = $request->input('searchinput');
        

        $eventTransaction = EventTransaction::select('tbl_event_transaction.*','member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no',
            'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type','member.prc_number',
            'category.name as category_name',
            'memtype.member_type_name',
            'event.title','event.price','event.description','member.type',
            'ormaster.payment_mode','ormaster.payment_dt','ormaster.amount','ormaster.total_amount','ormaster.change','ormaster.or_no',
            DB::raw("(
                select price from tbl_event_price where event_id = event.id and is_active = true and member_type_id = member.member_type) as prices"),
            )
            ->join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
            ->join('tbl_event_category as category','category.id','=','event.category_id')
            ->join('tbl_member_info as member','member.pps_no','=','tbl_event_transaction.pps_no')
            ->leftJoin('tbl_or_master as ormaster','ormaster.transaction_id','=','tbl_event_transaction.id')
            ->leftjoin('tbl_member_type as memtype','memtype.id','=','member.member_type')
            ->where('event.is_active',true)
            ->where(function($query) use ($name) {
                $query
                      ->orWhere('member.first_name', 'ILIKE', "%$name%")
                      ->orWhere('member.middle_name', 'ILIKE', "%$name%")
                      ->orWhere('member.last_name', 'ILIKE', "%$name%")
                      ->orWhere('member.prc_number', 'ILIKE', "%$name%");                             
            })
            ->orderBy('ormaster.payment_dt','DESC')
            ->paginate(10);

            $event = Event::select( 'tbl_event.*')
            ->where('is_active',true)
            ->where('status','!=','COMPLETED')
            ->get();

            $member = MemberInfo::where('is_active',true)
            ->where('status','ACCEPTED')
            ->paginate(10);

            return view('cashier.cashier-event',compact('eventTransaction','event','member'));
    }


    

    public function cashierEventPay($id)
    {   
        if(auth()->user()->role_id != 4)
        {
            return redirect('dashboard');
        }

        else
        {

        
        $ids = Crypt::decrypt($id);
        $eventTransaction = EventTransaction::select('tbl_event_transaction.*',
                                                    'member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no',
                                                    'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type',
                                                    'event.title','event.price','event.description',
                                                    'category.name as category_name',)
                                            ->join('tbl_event as event','event.id','=','tbl_event_transaction.event_id')
                                            ->join('tbl_event_category as category','category.id','=','event.category_id')
                                            ->join('tbl_member_info as member','member.pps_no','=','tbl_event_transaction.pps_no')
                                            ->where('tbl_event_transaction.is_active',true)
                                            ->where('tbl_event_transaction.id',$ids)->first();

        return view('cashier.cashier-event-pay',compact('eventTransaction'));
        }
    }

    public function cashierEventTransaction($id)
    {   
        $ids = Crypt::decrypt($id);


        $event = Event::select( 'tbl_event.*','category.name as category')
                        ->join('tbl_event_category as category','category.id','=','tbl_event.category_id')
                        ->where('tbl_event.is_active',true)
                        ->where('tbl_event.status','!=','COMPLETED')
                        ->where('tbl_event.id',$ids)
                        ->first();


        $member = MemberInfo::select('tbl_member_info.*')
        ->where('tbl_member_info.is_active',true)
        ->where('status','!=','PENDING')
        ->get();

        $cart = EventCart::select('tbl_event_cart.*',
                                  'info.first_name','info.middle_name','info.last_name','info.suffix',
                                  'type.member_type_name',
                                  'price.price')
        ->join('tbl_member_info as info','info.pps_no','=','tbl_event_cart.pps_no')
        ->join('tbl_member_type as type','type.id','=','info.member_type')
        ->join('tbl_event_price as price','price.id','=','tbl_event_cart.event_price_id')
        ->where('tbl_event_cart.is_active',true)
        ->where('tbl_event_cart.status','=','PENDING')
        ->where('tbl_event_cart.event_id',$ids)
        ->where('tbl_event_cart.session_id',auth()->user()->id)
        ->get();

          

        return view('cashier.cashier-event-transaction',compact('event','member','cart'));
    }

    public function cashierEventAddCustomer(Request $request)
    {  
        $checkMemberJoined = EventTransaction::where('event_id',$request->event_id)
                                                ->where('pps_no',$request->pps_no)
                                                ->where('paid',true)
                                                ->count();
        $checkMemberSelected = EventCart::where('event_id',$request->event_id)
                                                ->where('pps_no',$request->pps_no)
                                                ->count();                                        
        if($checkMemberJoined >= 1)
        {
            return "exist";
        }  
        else if($checkMemberSelected >= 1)
        {
            return "selected";
        }
        else
        {

            $member = MemberInfo::select('tbl_member_info.*')
            ->where('tbl_member_info.is_active',true)
            ->where('pps_no',$request->pps_no)
            ->where('status','!=','PENDING')
            ->first();


            $eventPrice = EventPrice::where('event_id',$request->event_id)
            ->where('member_type_id',$member->member_type)
            ->first();



            $event_cart = new EventCart();
            $event_cart->created_by = auth()->user()->name;
            $event_cart->is_active = true;
            $event_cart->status = "PENDING";
            $event_cart->event_id = $request->event_id;
            $event_cart->pps_no = $request->pps_no;
            $event_cart->event_price_id = $eventPrice->id;
            $event_cart->session_id = auth()->user()->id;
            $event_cart->save();
            
        }                                      
        
    }


    



    public function cashierEventPayment(Request $request)
    {

        if($request->total_price == 0)
        {
            $eventTransaction = EventTransaction::where('id',$request->transaction_id)->first();
            $eventTransaction->paid = true;
            $eventTransaction->updated_by = auth()->user()->name;
          
            $eventTransaction->save();

            return redirect('cashier-event')->withStatus('success');
        }
        
        else
        {
            $amount = $request->total_price . '00';

            $success_url = $this->pps_url.'success-event-payment/'.$request->transaction_id.'/'.$request->total_price.'/'.$request->pps_no;
            $failed_url = $this->pps_url.'failed-event-payment';
            
            
            $total = (float) $amount;
            $description = 'EVENT - '.$request->event_title;
            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'email' => $request->event_email_adddress,
                            'name' => $request->event_customer_name
    
                        ],
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $total,
                                'description' => $description,
                                'name'  =>  $request->event_title,
                                'quantity'  =>  1,
                               
                              
                            ],      
                         
                    ],
                    'payment_method_types' => [
                        'card',
                        'gcash'
                     
                    ],
                        'success_url'   =>  $success_url,
                        'cancel_url'    =>  $this->pps_url,
                        'description'   =>  $description,
                        'send_email_receipt' => true
                    ],
                    
                ]  
            ];
            $idempotencyKey = (string) Str::uuid();
            $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                            ->withHeader('Content-Type: application/json')
                            ->withHeader('accept: application/json')
                            ->withHeader('Idempotency-Key: ' . $idempotencyKey)
                            ->withHeader('Authorization: Basic '.PaymongoConfig::key())
                            ->withData($data)
                            ->asJson()
                            ->post();
        
            Session::put('session_id',$response->data->id);         
                
            return redirect()->to($response->data->attributes->checkout_url);
        }
    
    }

    public function successEventPayment($transaction_id,$total_amount,$pps_no)
    {
       
        $sessionId = Session::get('session_id');
    
        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionId)
                        ->withHeader('accept: application/json')
                        ->withHeader('Authorization: Basic '.PaymongoConfig::key())
                        ->asJson()
                        ->get();
                           
        $lastTransaction = EventTransaction::orderBy('id', 'desc')->pluck('id')->first();
        $transaction_number = date('Y') . date('m'). date('d') . $lastTransaction;

        $ormaster = new ORMaster();
        $ormaster->is_active = true;
        $ormaster->created_by = auth()->user()->name;
        $ormaster->updated_by = auth()->user()->name;
        $ormaster->transaction_type = 'EVENT';
        $ormaster->transaction_id = $transaction_id;
        $ormaster->total_amount = $total_amount;
        $ormaster->pps_no = $pps_no;
        $ormaster->or_no = $transaction_number;
        $ormaster->payment_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
        $ormaster->check_out_sessions_id = $sessionId;
        $ormaster->payment_mode = $response->data->attributes->payment_method_used;

        $ormaster->save();     
        $or_id = $ormaster->id;

        $eventTransaction = EventTransaction::where('id',$transaction_id)->first();
        $eventTransaction->paid = true;
        $eventTransaction->updated_by = auth()->user()->name;;
        $eventTransaction->or_id = $or_id;

        $eventTransaction->save();       
        
        session()->forget('session_id');
    
        return redirect('cashier-event')->withStatus('success');
                   
            
    }

    public function cashierEventPayManual(Request $request)
    {
        $lastTransaction = EventTransaction::orderBy('id', 'desc')->pluck('id')->first();
        $transaction_number = date('Y') . date('m'). date('d') . $lastTransaction;


        $ormaster = new ORMaster();
        
        $ormaster->created_by = auth()->user()->name;
        $ormaster->updated_by = auth()->user()->name;
        $ormaster->is_active = true;
        $ormaster->or_no = $transaction_number;
        $ormaster->transaction_type = 'EVENT';
        $ormaster->transaction_id = $request->transaction_id;
        $ormaster->amount = $request->amount;
        $ormaster->change = $request->change;
        $ormaster->total_amount = $request->priceofevent;
        $ormaster->pps_no = $request->pps_no;
        $ormaster->payment_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
        $ormaster->payment_mode = 'cashier';
 
        $ormaster->save();    
        
        $or_id = $ormaster->id;

        $eventTransaction = EventTransaction::where('id',$request->transaction_id)->first();
        $eventTransaction->paid = true;
        $eventTransaction->updated_by = auth()->user()->name;;
        $eventTransaction->or_id = $or_id;

        $eventTransaction->save();       
        
        return Response()->json([
            "success" => true,
            "url"=>url('/cashier-event')
           
      ]);
    }

    public function failedEventPayment()
    {
        return redirect('cashier-event')->withStatus('failed');           
    }



    public function cashierAnnualDuesView()
    {
        $name ="";
        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','!=','PENDING')
        ->paginate(10);

        $transaction = ORMaster::select('tbl_or_master.*',
                    'member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no','member.prc_number',
                    'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type',
                    'memtype.member_type_name',
                    'dues.description','dues.year_dues')
                    ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
                    ->leftJoin('tbl_member_info as member','member.pps_no','=','tbl_or_master.pps_no')
                    ->leftJoin('tbl_member_type as memtype','memtype.id','=','member.member_type')
                    ->where('tbl_or_master.is_active',true)
                    ->where('tbl_or_master.transaction_type','ANNUAL DUES')
                    ->orderBy('tbl_or_master.payment_dt','ASC')
                    ->paginate(10);   

        return view('cashier.cashier-annual-dues',compact('member','transaction','name'));

    }

    
    public function cashierAnnualDuesChooseMember(Request $request)
    {
        return redirect('cashier-annual-dues-transaction/'. $request->selected_pps_no);
    }

    public function cashierAnnualDuesRemove(Request $request)
    {
        $transaction = ORMaster::where('id',$request->id)->where('is_active',true)->first();

        Session::put('pps_nos',$transaction->pps_no);

        $transaction2 = ORMaster::where('id',$request->id)->delete();

        // $session_pps_no= Session::get('pps_nos');

        // $annual_dues = ORMaster::where('transaction_type','ANNUAL DUES')
        //                         ->where('pps_no',$session_pps_no)
        //                         ->where('is_active',true)
        //                         ->first();

       return $transaction;
    }

    

    

    public function cashierTestDatatable(Request $request)
    {
         // Page Length
         
         $pageNumber = $request->length == 0 ? 0 : ( $request->start / $request->length )+1;
        //  $pageNumber = ( $request->start / $request->length )+1;
         $pageLength = $request->length;
         $skip       = ($pageNumber-1) * $pageLength;
 
         // Page Order
         $orderColumnIndex = $request->order[0]['column'] ?? '0';
         $orderBy = $request->order[0]['dir'] ?? 'desc';
 
         // get data from products table
         $query = \DB::table('tbl_member_info')->select('*');
 
         // Search
         $search = $request->search;
         $query = $query->where(function($query) use ($search){
             $query->orWhere('first_name', 'like', "%".$search."%");
             $query->orWhere('middle_name', 'like', "%".$search."%");
             $query->orWhere('last_name', 'like', "%".$search."%");
         });
 
         $orderByName = 'first_name';
         switch($orderColumnIndex){
             case '0':
                 $orderByName = 'first_name';
                 break;
             case '1':
                 $orderByName = 'middle_name';
                 break;
             case '2':
                 $orderByName = 'last_name';
                 break;
         
         }
         $query = $query->orderBy($orderByName, $orderBy);
         $recordsFiltered = $recordsTotal = $query->count();
         $users = $query->skip($skip)->take($pageLength)->get();
 
         return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $users], 200);
    }
        
    

    
    public function cashierSearchAnnualDuesTransaction(Request $request)
    {
        $name = $request->input('searchinput');
        
        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
        ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
        ->where('tbl_member_info.is_active',true)
        ->where('tbl_member_info.status','!=','PENDING')
        ->paginate(10);

        $transaction = ORMaster::select('tbl_or_master.*',
                    'member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no','member.prc_number',
                    'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type',
                    'memtype.member_type_name',
                    'dues.description','dues.year_dues')
                    ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
                    ->leftjoin('tbl_member_info as member','member.pps_no','=','tbl_or_master.pps_no')
                    ->leftjoin('tbl_member_type as memtype','memtype.id','=','member.member_type')
                    ->where('tbl_or_master.is_active',true)
                    ->where('tbl_or_master.transaction_type','ANNUAL DUES')
                    ->where(function($query) use ($name) {
                        $query
                              ->orWhere('member.first_name', 'ILIKE', "%$name%")
                              ->orWhere('member.middle_name', 'ILIKE', "%$name%")
                              ->orWhere('member.last_name', 'ILIKE', "%$name%")
                              ->orWhere('member.prc_number', 'ILIKE', "%$name%");                             
                    })
                 
                    ->orderBy('tbl_or_master.payment_dt','ASC')
                    ->paginate(10);   

        return view('cashier.cashier-annual-dues',compact('member','transaction','name'));            
    }

    




    public function cashierAnnualDuesTransaction($pps_no)
    {
        $pps_no2 = Crypt::decrypt($pps_no);

        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
            ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
            ->where('tbl_member_info.pps_no',$pps_no2)
            ->where('tbl_member_info.is_active',true)
            ->where('tbl_member_info.status','!=','PENDING')
            ->first();

        $paymentList = ORMaster::select('tbl_or_master.*',
            'dues.description','dues.year_dues','dues.amount as duesamount')
            ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
            ->where('tbl_or_master.is_active',true)
            ->where('tbl_or_master.payment_dt',null)
            ->where('tbl_or_master.pps_no',$pps_no2)
            ->where('tbl_or_master.transaction_type','ANNUAL DUES')
            ->orderBy('tbl_or_master.id','ASC')
            ->get();     
            
        $cart = AnnualDuesCart::select('tbl_annual_dues_cart.*','dues.description','dues.amount as duesamount','dues.year_dues')
                ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_annual_dues_cart.annual_dues_id')  
                ->where('tbl_annual_dues_cart.is_active',true)
                ->where('tbl_annual_dues_cart.status','PENDING')
                ->where('tbl_annual_dues_cart.pps_no',$pps_no2)
                ->orderBy('tbl_annual_dues_cart.id','ASC')
                ->get();
        
        $cartcount = AnnualDuesCart::select('tbl_annual_dues_cart.*','dues.description','dues.amount as duesamount','dues.year_dues')
                ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_annual_dues_cart.annual_dues_id')  
                ->where('tbl_annual_dues_cart.is_active',true)
                ->where('tbl_annual_dues_cart.status','PENDING')
                ->where('tbl_annual_dues_cart.pps_no',$pps_no2)
                ->count();

        $cartsubtotal = AnnualDuesCart::leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_annual_dues_cart.annual_dues_id')  
                ->where('tbl_annual_dues_cart.is_active',true)
                ->where('tbl_annual_dues_cart.status','PENDING')
                ->where('tbl_annual_dues_cart.pps_no',$pps_no2)
                ->sum('dues.amount');    

        $carttotal = AnnualDuesCart::leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_annual_dues_cart.annual_dues_id')  
                ->where('tbl_annual_dues_cart.is_active',true)
                ->where('tbl_annual_dues_cart.status','PENDING')
                ->where('tbl_annual_dues_cart.pps_no',$pps_no2)
                ->sum('dues.amount');    


        $annualduesList = ORMaster::select('tbl_or_master.*',
            'dues.description','dues.year_dues','dues.amount as duesamount')
            ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
            ->where('tbl_or_master.is_active',true)
            ->where('tbl_or_master.payment_dt',null)
            ->where('tbl_or_master.pps_no',$pps_no2)
            ->where('tbl_or_master.transaction_type','ANNUAL DUES')
            ->orderBy('tbl_or_master.id','ASC')
            ->get();     
            
        $annualDuesList = AnnualDues::select('tbl_annual_dues.*')
            ->where('tbl_annual_dues.is_active',true)
            ->get();  
                

        return view('cashier.cashier-annual-dues-transaction',compact('member','paymentList','cart','cartsubtotal','carttotal','cartcount','annualDuesList'));
    }

    public function cashierAddAnnualDues(Request $request)
    {
         
        $orannualdues = ORMaster::where('transaction_id',$request->id)->where('pps_no',$request->pps_no)->count();
        $annualDues = AnnualDues::where('id',$request->id)
            ->where('is_active',true)
            ->first();  

        if($orannualdues >= 1)
        {
            return "billed";
        }
        else
        {
            $ormaster = new ORMaster();
            $ormaster->created_by = auth()->user()->name;
            $ormaster->is_active = true;
            $ormaster->transaction_type = "ANNUAL DUES";
            $ormaster->transaction_id = $request->id;
            $ormaster->pps_no = $request->pps_no;
            $ormaster->total_amount = $annualDues->amount;
            $ormaster->save();

            return "available";
        }
        
    }


    
    public function cashierAnnualDuesAddCart(Request $request)
    {

        $paymentList = ORMaster::select('tbl_or_master.*',
        'dues.description','dues.year_dues','dues.amount as duesamount','dues.id as duesid')
        ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
        ->where('tbl_or_master.is_active',true)
        ->where('tbl_or_master.payment_dt',null)
        ->where('tbl_or_master.id',$request->or_id)
        ->first();     

        $countcart = AnnualDuesCart::where('annual_dues_id',$paymentList->duesid)
                                    ->where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->where('status','PENDING')
                                    ->count();
        if($countcart >= 1)
        {
            return "exist";
        }
        else
        {
            $cart = new AnnualDuesCart();
            $cart->created_by = auth()->user()->name;
            $cart->is_active = true;
            $cart->status = 'PENDING';
            $cart->or_master_id = $request->or_id;
            $cart->pps_no = $request->pps_no;
            $cart->annual_dues_id = $paymentList->duesid;
            $cart->save();
            
            return "success";
        }

        
    }

    public function cashierAnnualDuesRemoveCart(Request $request)
    {

        AnnualDuesCart::find($request->cart_id)->delete();
      
        return "removed";
    }


    public function cashierAnnualDuesPay(Request $request)
    {
 
        $cart = AnnualDuesCart::where('pps_no',$request->pps_no)
        ->where('is_active',true)
        ->where('status','PENDING')
        ->pluck('or_master_id')->toArray();


        $or_master = ORMaster::where('is_active',true)
                    ->where('payment_dt',null)
                    ->whereIn('id', $cart)
                    ->update(['updated_by' => auth()->user()->name,
                              'or_no' => $request->or_no,
                              'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                              'amount' => $request->amount,
                              'payment_mode' => 'cash'
                            ]);


        $cart2 = AnnualDuesCart::where('is_active',true)
                    ->where('status','PENDING')  
                    ->where('pps_no',$request->pps_no)  
                    ->update(['updated_by' => auth()->user()->name,
                                'status' => 'PAID',    
                            ]);


        $annual_dues_count = ORMaster::where('is_active',true)
                                        ->where('transaction_type','ANNUAL DUES')
                                        ->where('pps_no',$request->pps_no)
                                        ->where('payment_dt',null)
                                        ->count();

                                        return Response()->json([
                                            "success" => true,
                                            "type" => 'success',
                                            "url"=>url('/cashier-annual-dues')   
                                        ]);
                

        if($annual_dues_count >= 1)
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = false;
            $member->save();  
            return Response()->json([
                "success" => true,
                "type" => 'exist',
                "url"=>url('/cashier-annual-dues')   
            ]);
        }                  
        else
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = true;
            $member->save();                     
            return Response()->json([
                "success" => true,
                "type" => 'success',
                "url"=>url('/cashier-annual-dues')   
            ]);
        }              


        
    }

    public function cashierAnnualDuesPayCheque(Request $request)
    {
        
        $cart = AnnualDuesCart::where('pps_no',$request->pps_no)
        ->where('is_active',true)
        ->where('status','PENDING')
        ->pluck('or_master_id')->toArray();


        $or_master = ORMaster::where('is_active',true)
        ->where('payment_dt',null)  
        ->whereIn('id', $cart)
        ->update(['updated_by' => auth()->user()->name,
                  'bank_name' => strtoupper($request->bank_name),
                  'cheque_number' => $request->cheque_number,
                  'posting_dt' => $request->posting_dt,
                  'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                  'amount' => $request->amount_cheque,
                  'payment_mode' => 'cheque'
                ]);

        $cart2 = AnnualDuesCart::where('is_active',true)
            ->where('status','PENDING')  
            ->where('pps_no',$request->pps_no)  
            ->update(['updated_by' => auth()->user()->name,
                        'status' => 'PAID',    
                    ]);

        $annual_dues_count = ORMaster::where('is_active',true)
                    ->where('transaction_type','ANNUAL DUES')
                    ->where('pps_no',$request->pps_no)
                    ->where('payment_dt',null)
                    ->count(); 
                   
                    
        if($annual_dues_count >= 1)
        {
            $member = MemberInfo::where('is_active',true)
                                    ->where('pps_no',$request->pps_no)
                                    ->first();
            $member->annual_fee = false;
            $member->save();  
            return Response()->json([
                "success" => true,
                "type" => 'exist',
                "url"=>url('/cashier-annual-dues')   
            ]);
        }                  
        else
        {
            $member = MemberInfo::where('is_active',true)
                                    ->where('pps_no',$request->pps_no)
                                    ->first();
            $member->annual_fee = true;
            $member->save();                     
            return Response()->json([
                "success" => true,
                "type" => 'success',
                "url"=>url('/cashier-annual-dues')   
            ]);
        }                      

    }


    public function cashierAnnualDuesPayBankTransfer(Request $request)
    {
        
        $cart = AnnualDuesCart::where('pps_no',$request->pps_no)
        ->where('is_active',true)
        ->where('status','PENDING')
        ->pluck('or_master_id')->toArray();


        $or_master = ORMaster::where('is_active',true)
        ->where('payment_dt',null)  
        ->whereIn('id', $cart)
        ->update(['updated_by' => auth()->user()->name,
                  'bank_name' => strtoupper($request->bank_name),
                  'bank_transfer_transaction_number' => $request->bank_transfer_transaction_number,
                  'bank_transfer_dt' => $request->bank_transfer_dt,
                  'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                  'amount' => $request->amount_bank_transfer,
                  'bank_transfer_remarks' => $request->bank_transfer_remarks,
                  'payment_mode' => 'bank transfer'
                ]);

        $cart2 = AnnualDuesCart::where('is_active',true)
            ->where('status','PENDING')  
            ->where('pps_no',$request->pps_no)  
            ->update(['updated_by' => auth()->user()->name,
                        'status' => 'PAID',    
                    ]);

        $annual_dues_count = ORMaster::where('is_active',true)
                    ->where('transaction_type','ANNUAL DUES')
                    ->where('pps_no',$request->pps_no)
                    ->where('payment_dt',null)
                    ->count(); 
                   
                    
        if($annual_dues_count >= 1)
        {
            $member = MemberInfo::where('is_active',true)
                                    ->where('pps_no',$request->pps_no)
                                    ->first();
            $member->annual_fee = false;
            $member->save();  
            return Response()->json([
                "success" => true,
                "type" => 'exist',
                "url"=>url('/cashier-annual-dues')   
            ]);
        }                  
        else
        {
            $member = MemberInfo::where('is_active',true)
                                    ->where('pps_no',$request->pps_no)
                                    ->first();
            $member->annual_fee = true;
            $member->save();                     
            return Response()->json([
                "success" => true,
                "type" => 'success',
                "url"=>url('/cashier-annual-dues')   
            ]);
        }               

    }


    public function annualDuesPaymentOnline(Request $request)
    {
        $member = MemberInfo::where('is_active',true)
        ->where('pps_no',$request->pps_no2)
        ->first();

        // $cart = AnnualDuesCart::where('tbl_annual_dues_cart.pps_no',$request->pps_no2)
        // ->leftJoin('tbl_annual_dues as annual','annual.id','=','tbl_annual_dues_cart.annual_dues_id')
        // ->where('tbl_annual_dues_cart.is_active',true)
        // ->where('tbl_annual_dues_cart.status','PENDING')
        // ->get('year_dues')->toArray();

        $cart = AnnualDuesCart::select('annual.year_dues','annual.amount')
        ->where('tbl_annual_dues_cart.pps_no',$request->pps_no2)
        ->leftJoin('tbl_annual_dues as annual','annual.id','=','tbl_annual_dues_cart.annual_dues_id')
        ->where('tbl_annual_dues_cart.is_active',true)
        ->where('tbl_annual_dues_cart.status','PENDING')
        ->get();

        $pps = Crypt::encrypt($request->pps_no2);
    
        $lineItems = [];

        foreach($cart as $cart2)
        {
            if($request->payment_type == 'gcash')
            {
                $amount = $cart2->amount * 1.030 . '00';
            }
            else
            {
                $amount = ($cart2->amount * 1.040) + 15 . '00';
            }
          
            // $amount = $cart2->amount . '00';
            $lineItems[] = 
                [
                    'currency' => 'PHP',
                    'amount' => (float) $amount, 
                    'description' => 'Annual Dues',
                    'name'  =>  'Annual Dues '. $cart2->year_dues,
                    'quantity'  =>  1,
                ];
        }

        

 
    
        
        // $final_description = implode(', ', array_map(function ($entry) {
        //     return ($entry[key($entry)]);
        //   }, $cart));



        // $amount = $request->total . '00';

        $success_url = $this->pps_url.'success-cashier-annual-dues-payment-online/'.$request->pps_no2 .'/' . $request->total;
        $failed_url = $this->pps_url.'cashier-annual-dues-transaction/'.$pps;


        // $total = (float) $amount;
            $description = 'ANNUAL DUES';
            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'email' => $member->email_address,
                            'name' => $member->first_name .' '. $member->middle_name .' '. $member->last_name,
     
                        ],
                        'line_items' => $lineItems,
                        'payment_method_types' => [
                            $request->payment_type
                        ],
                        'success_url'   =>  $success_url,
                        'cancel_url'    =>   $this->pps_url.'cashier-annual-dues-transaction/'.$pps,
                        'description'   =>  $description,
                        'send_email_receipt' => true,
                    ],
                ]  
            ];
            $idempotencyKey = (string) Str::uuid();
            $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                            ->withHeader('Content-Type: application/json')
                            ->withHeader('accept: application/json')
                            ->withHeader('Idempotency-Key: ' . $idempotencyKey)
                            ->withHeader('Authorization: Basic '.PaymongoConfig::key())
                            ->withData($data)
                            ->asJson()
                            ->post();

            Session::put('online_payment_id',$response->data->id);         
            return redirect()->to($response->data->attributes->checkout_url);


    }


    public function successCashierAnnualDuesPaymentMember($pps_no,$total)
    {
       
        $session_payment_id = Session::get('online_payment_id');
    

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$session_payment_id)
                        ->withHeader('accept: application/json')
                        ->withHeader('Authorization: Basic '.PaymongoConfig::key())
                        ->asJson()
                        ->get();
                               
        
        $cart = AnnualDuesCart::where('pps_no',$pps_no)
                                ->where('is_active',true)
                                ->where('status','PENDING')
                                ->pluck('or_master_id')->toArray();      
      
                
        $or_master = ORMaster::where('is_active',true)
                                ->where('payment_dt',null)  
                                ->whereIn('id', $cart)
                                ->update(['updated_by' => auth()->user()->name,
                                            'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                                            'amount' => $total,
                                            'check_out_sessions_id' => $session_payment_id,
                                            'payment_mode' => $response->data->attributes->payment_method_used,
                                        ]);

        $cart2 = AnnualDuesCart::where('is_active',true)
                                ->where('status','PENDING')  
                                ->where('pps_no',$pps_no)  
                                ->update(['updated_by' => auth()->user()->name,
                                            'status' => 'PAID',    
                                        ]);   
                                        
        $annual_dues_count = ORMaster::where('is_active',true)
                                        ->where('transaction_type','ANNUAL DUES')
                                        ->where('pps_no',$pps_no)
                                        ->where('payment_dt',null)
                                        ->count();                                 

            if($annual_dues_count >= 1)
            {
                $member = MemberInfo::where('is_active',true)
                                        ->where('pps_no',$pps_no)
                                        ->first();
                $member->annual_fee = false;
                $member->save();  
                return redirect('cashier-annual-dues')->withStatus('exist');
            }                  
            else
            {
                $member = MemberInfo::where('is_active',true)
                                        ->where('pps_no',$pps_no)
                                        ->first();
                $member->annual_fee = true;
                $member->save();                     
                return redirect('cashier-annual-dues')->withStatus('completed');
            }   
               
            
    }


    public function cashierAnnualDuesUpdateORNumber(Request $request)
    {

        $or_master = ORMaster::where('is_active',true)
        ->where('id',$request->or_master_id)
        ->first();        

        $or_master->updated_by = auth()->user()->name;
        $or_master->or_no = $request->or_no;
        $or_master->save();
       

        return "success";
    }


    public function cashierAnnualDuesUpdateOnlinePayment(Request $request)
    {

        $or_master = ORMaster::where('tbl_or_master.is_active',true)
        ->leftJoin('tbl_member_info as info','info.pps_no','=','tbl_or_master.pps_no')
        ->leftJoin('tbl_annual_dues as annual','annual.id','=','tbl_or_master.transaction_id')
        ->where('tbl_or_master.id',$request->or_master_id_2)
        ->first();  
        
       

        $response = Curl::to('https://api.paymongo.com/v1/payments/'.$request->paymongo_transaction_number)
                        ->withHeader('accept: application/json')
                        ->withHeader('Authorization: Basic '.\Config::get('services.paymongo.key'))
                        ->asJson()
                        ->get();


                   
        $or_master_email = $or_master->email_address;  
        $paymongo_email = $response->data->attributes->billing->email;
        
     
        
       if($or_master_email == $paymongo_email)
       {
        
        $paymentintent = Curl::to('https://api.paymongo.com/v1/payment_intents/'.$response->data->attributes->payment_intent_id)
        ->withHeader('accept: application/json')
        ->withHeader('Authorization: Basic '.\Config::get('services.paymongo.key'))
        ->asJson()
        ->get();

            $updateor = ORMaster::where('tbl_or_master.is_active',true)
                                 ->where('id',$request->or_master_id_2)
                                 ->first();

            $updateor->updated_by = auth()->user()->name;               
            $updateor->payment_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
            $updateor->payment_mode = implode(",",$paymentintent->data->attributes->payment_method_allowed);
            $updateor->save();
            return redirect('cashier-annual-dues')->withStatus('paymentcomplete');
       }
       else
       {
        return redirect('cashier-annual-dues')->withStatus('wrongpayment');
  
       }

           

    }


    
    public function cashierEventUpdateOnlinePayment(Request $request)
    {
              
 


        $eventcount = EventTransaction::where('tbl_event_transaction.event_id',$request->event_id)
                                        ->where('tbl_event_transaction.pps_no',$request->pps_no)
                                        ->count();
        if($eventcount >= 1)
        {
            return "exist";
        }   
        else
        {

            $member = MemberInfo::where('tbl_member_info.is_active',true)
            ->join('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
            ->where('tbl_member_info.pps_no',$request->pps_no)
            ->first();

            
            $event = Event::select('tbl_event.*','category.name as category',
            DB::raw("(select price from tbl_event_price where event_id = tbl_event.id and is_active = true and member_type_id = $member->member_type) as prices"),
            )
            ->where('tbl_event.id',$request->event_id)
            ->join('tbl_event_category as category','category.id','=','tbl_event.category_id')
            ->first();
    
      
    
            $event = Event::select('tbl_event.*','category.name as category',
            DB::raw("(select price from tbl_event_price where event_id = tbl_event.id and is_active = true and member_type_id = $member->member_type) as prices"),
            )
            ->where('tbl_event.id',$request->event_id)
            ->join('tbl_event_category as category','category.id','=','tbl_event.category_id')
            ->first();
            
    
                $response = Curl::to('https://api.paymongo.com/v1/payments/'.$request->paymongo_transaction_number)
                ->withHeader('accept: application/json')
                ->withHeader('Authorization: Basic '.\Config::get('services.paymongo.key'))
                ->asJson()
                ->get();
    
    
                $member_email = $member->email_address;  
                $paymongo_email = $response->data->attributes->billing->email;
    
    
                if($member_email == $paymongo_email)
                {
                    $paymentintent = Curl::to('https://api.paymongo.com/v1/payment_intents/'.$response->data->attributes->payment_intent_id)
                    ->withHeader('accept: application/json')
                    ->withHeader('Authorization: Basic '.\Config::get('services.paymongo.key'))
                    ->asJson()
                    ->get();
    
    
                    $transaction = new EventTransaction();
                    $transaction->is_active = true;
                    $transaction->created_by = auth()->user()->name;
                    $transaction->event_id = $request->event_id;
                    $transaction->pps_no = $request->pps_no;
                    $transaction->paid = true;
                    $transaction->joined_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
    
                    $transaction->save();
    
                    $transaction_id = $transaction->id;
    
    
                    $ormaster = new ORMaster();
                    $ormaster->is_active = true;
                    $ormaster->created_by = auth()->user()->name;
                    $ormaster->transaction_type = 'EVENT';
                    $ormaster->transaction_id = $transaction_id;
                    $ormaster->total_amount = $event->prices;
                    $ormaster->pps_no = $request->pps_no;
                    $ormaster->payment_dt = \Carbon\Carbon::now('UTC')->timezone('Asia/Manila');
                    $ormaster->payment_mode = implode(",",$paymentintent->data->attributes->payment_method_allowed);
    
    
    
                    if($member->member_type_name == 'FOREIGN DELEGATE')
                    {
                        $req_url = 'https://v6.exchangerate-api.com/v6/138b122e4e8702fdb6422935/latest/USD';
                        $response_json = file_get_contents($req_url);
                        if(false !== $response_json) {
                            $response_convert = json_decode($response_json);
                            $base_price = $event->prices;
                            $peso = round(($base_price * $response_convert->conversion_rates->PHP), 0);
    
                            $dollar_rate = $response_convert->conversion_rates->PHP;
            
                            
                        }
    
                    $ormaster->is_dollar = true;
                    $ormaster->dollar_rate = $dollar_rate;
                    $ormaster->dollar_conversion = $peso;
                      
            
                    }
    
                    $ormaster->save();  
    
                    $or_id = $ormaster->id;
    
                    $eventTransaction = EventTransaction::where('id',$transaction_id)->first();
                    $eventTransaction->updated_by = auth()->user()->name;;
                    $eventTransaction->or_id = $or_id;
            
                    $eventTransaction->save();    
                   
    
                    return "completed";
                }
                else
                {
                    return "wrongid";
            
                }
        }                       

      
   
    }
    

    public function cashierNewTransaction(Request $request)
    {
        return view('cashier.cashier-new-transaction');
    }


    public function cashierNewTransactionProceed(Request $request)
    {
      
        return redirect('cashier-new-transaction-cart/'. $request->selected_pps_no);
    }

    public function cashierNewTransactionCart($pps_no)
    {


        $pps_no2 = Crypt::decrypt($pps_no);

        $annual_dues_count = ORMaster::where('is_active',true)
        ->where('transaction_type','ANNUAL DUES')
        ->where('pps_no',$pps_no2)
        ->where('payment_dt',null)
        ->count();

        
        $cartcountannualdues = TransactionCart::select('tbl_transaction_cart.*')
            ->where('tbl_transaction_cart.is_active',true)
            ->where('tbl_transaction_cart.status','PENDING')
            ->where('tbl_transaction_cart.annual_dues_id','!=',null)
            ->where('tbl_transaction_cart.pps_no',$pps_no2)
            ->count();

          


        $member = MemberInfo::select('tbl_member_info.*','type.member_type_name')
            ->leftJoin('tbl_member_type as type','type.id','=','tbl_member_info.member_type')
            ->where('tbl_member_info.pps_no',$pps_no2)
            ->where('tbl_member_info.is_active',true)
            ->where('tbl_member_info.status','!=','PENDING')
            ->first();

        $paymentList = ORMaster::select('tbl_or_master.*',
            'dues.description','dues.year_dues','dues.amount as duesamount','dues.id as annual_dues_id')
            ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
            ->where('tbl_or_master.is_active',true)
            ->where('tbl_or_master.payment_dt',null)
            ->where('tbl_or_master.pps_no',$pps_no2)
            ->where('tbl_or_master.transaction_type','ANNUAL DUES')
            ->orderBy('tbl_or_master.id','ASC')
            ->get(); 

        $cartcount = TransactionCart::select('tbl_transaction_cart.*')
            ->where('tbl_transaction_cart.is_active',true)
            ->where('tbl_transaction_cart.status','PENDING')
            ->where('tbl_transaction_cart.pps_no',$pps_no2)
            ->count();



        $event = Event::select( 'tbl_event.*',
        DB::raw("(
            select price from tbl_event_price where event_id = tbl_event.id and is_active = true and member_type_id = $member->member_type) as prices")
        )
            ->where('is_active',true)
            ->where('status','!=','COMPLETED')
            ->get();   


        $cartList = TransactionCart::select('tbl_transaction_cart.*',
            'dues.description','dues.year_dues','dues.amount as duesamount','dues.id as annual_dues_id',
            'event.title as event_title',
            DB::raw("(
                select price from tbl_event_price where event_id = event.id and is_active = true and member_type_id = $member->member_type) as event_prices")
            )
            ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_transaction_cart.annual_dues_id')
            ->leftJoin('tbl_event as event','event.id','=','tbl_transaction_cart.event_id')
            ->where('tbl_transaction_cart.is_active',true)
            ->where('tbl_transaction_cart.pps_no',$pps_no2)
            ->where('tbl_transaction_cart.status','PENDING')
            ->orderBy('tbl_transaction_cart.id','ASC')
            ->get();    
          
        $carttotal = TransactionCart::
             where('tbl_transaction_cart.is_active',true)
            ->where('tbl_transaction_cart.status','PENDING')
            ->where('tbl_transaction_cart.pps_no',$pps_no2)
            ->sum('tbl_transaction_cart.price');    

        $annualDuesList = AnnualDues::select('tbl_annual_dues.*')
            ->where('tbl_annual_dues.is_active',true)
            ->get();      

        $eventTopic = EventTopic::where('is_active',true)->orderBy('id','asc')->get();
            
        return view('cashier.cashier-new-transaction-cart',compact('member','paymentList','event','cartList','cartcount','carttotal','annualDuesList','annual_dues_count','cartcountannualdues','eventTopic'));
    }


    public function cashierTransactionAnnualDuesAddCart(Request $request)
    {

        $countcart = TransactionCart::where('annual_dues_id',$request->id)
                                    ->where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->where('status','PENDING')
                                    ->count();
        if($countcart >= 1)
        {
            return "exist";
        }
        else
        {
            $cart = new TransactionCart();
            $cart->created_by = auth()->user()->name;
            $cart->is_active = true;
            $cart->status = 'PENDING';  
            $cart->annual_dues_id = $request->id;
            $cart->price = $request->amount;
            $cart->pps_no = $request->pps_no;
            $cart->or_master_id = $request->or_master_id;
  
            $cart->save();
            
            return "success";
        }
       
    }

    public function cashierTransactionEventsAddCart(Request $request)
    {
   
        $countcart = TransactionCart::where('event_id',$request->id)
                                    ->where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->where('status','PENDING')
                                    ->count();
        $event_transaction_count = EventTransaction::where('event_id',$request->id)
                                    ->where('pps_no',$request->pps_no)
                                    ->where('is_active',true)
                                    ->count();  
                                    
        $event = Event::where('id',$request->id)->first();

        $event_selected_count = EventSelected::where('event_id',$request->id)
                                    ->where('pps_no',$request->pps_no)
                                    ->where('selected',true)
                                    ->where('is_active',true)
                                    ->count(); 
        
        if($event->selected_members == true && $event_selected_count == 0)
        {
            return "membernotselected";
        }

        else if($countcart >= 1)
        {
            return "exist";
        }
        else
        {
            if( $event_transaction_count >= 1)
            {
                return "paid";
            }
            else
            {
                $cart = new TransactionCart();
                $cart->created_by = auth()->user()->name;
                $cart->is_active = true;
                $cart->status = 'PENDING';
                $cart->event_id = $request->id;
                $cart->price = $request->amount;
                $cart->pps_no = $request->pps_no;
                $cart->topic_id = $request->topic_id;
                
                $cart->save();
            
            return "success";
            }
            
        }
    }


    

    public function cashierTransactionRemoveCart(Request $request)
    {
        TransactionCart::find($request->cart_id)->delete();
      
        return "removed";
    }

    
    public function cashierTransactionPaymentOnline(Request $request)
    {
        $member = MemberInfo::where('is_active',true)
        ->where('pps_no',$request->pps_no2)
        ->first();


        $cart = TransactionCart::
        select('tbl_transaction_cart.*',
            'dues.description','dues.year_dues','dues.amount as duesamount','dues.id as annual_dues_id',
            'event.title as event_title')
        ->where('tbl_transaction_cart.pps_no',$request->pps_no2)
        ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_transaction_cart.annual_dues_id')
        ->leftJoin('tbl_event as event','event.id','=','tbl_transaction_cart.event_id')
        ->where('tbl_transaction_cart.is_active',true)
        ->where('tbl_transaction_cart.status','PENDING')
        ->get();


        $pps = Crypt::encrypt($request->pps_no2);
    
        $lineItems = [];

        foreach($cart as $cart2)
        {
            if($request->payment_type == 'gcash')
            {
                $amount = $cart2->price * 1.030 . '00';
            }
            else
            {
                $amount = ($cart2->price * 1.040) + 15 . '00';
            }

            if($cart2->event_id == null)
            {
                $name = $cart2->description . ' ' . $cart2->year_dues;
                $description = $cart2->description;
            }
            else
            {
                $name = $cart2->event_title;
                $description = $cart2->event_title;
            }

            $lineItems[] = 
                [
                    'currency' => 'PHP',
                    'amount' => (float) $amount, 
                    'description' =>  $description,
                    'name'  =>  $name,
                    'quantity'  =>  1,
                ];
        }

        

        $success_url = $this->pps_url.'success-cashier-transaction-payment-online/'.$request->pps_no2 .'/' . $request->total;
        $failed_url = $this->pps_url.'cashier-new-transaction-cart/'.$pps;

  
            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'email' => $member->email_address,
                            'name' => $member->first_name .' '. $member->middle_name .' '. $member->last_name,
     
                        ],
                        'line_items' => $lineItems,
                        'payment_method_types' => [
                            $request->payment_type
                        ],
                        'success_url'   =>  $success_url,
                        'cancel_url'    =>   $this->pps_url.'cashier-new-transaction-cart/'.$pps,
                        'description'   =>  'EVENT AND ANNUAL DUES',
                        'send_email_receipt' => true,
                    ],
                ]  
            ];
            $idempotencyKey = (string) Str::uuid();
            $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                            ->withHeader('Content-Type: application/json')
                            ->withHeader('accept: application/json')
                            ->withHeader('Idempotency-Key: ' . $idempotencyKey)
                            ->withHeader('Authorization: Basic '.\Config::get('services.paymongo.key'))
                            ->withData($data)
                            ->asJson()
                            ->post();


            Session::put('online_payment_id',$response->data->id);         
            return redirect()->to($response->data->attributes->checkout_url);
    }



    public function successCashierTransactionPaymentMember($pps_no,$total)
    {
       
        $session_payment_id = Session::get('online_payment_id');
        

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$session_payment_id)
                        ->withHeader('accept: application/json')
                        ->withHeader('Authorization: Basic '.\Config::get('services.paymongo.key'))
                        ->asJson()
                        ->get();

                                               
                          
        // START OF SAVING EVENT TO EVENT TRANSACTION AND OR MASTER
        $insertEventTransaction = [];
        $insertEventOrMaster = [];
        

        $event_transaction = TransactionCart::where('pps_no',$pps_no)
            ->where('is_active',true)
            ->where('status','PENDING')
            ->where('event_id', '!=', null)
            ->get();

       
        foreach($event_transaction as $event_transactions) {
            $insertEventTransaction[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'status' => 'PENDING', 
                    'is_active' => true,
                    'paid' => true,
                    'joined_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'event_id' => $event_transactions->event_id,
                    'selected_topic_id' => $event_transactions->topic_id,
                    'pps_no' => $pps_no
                    ]; 
        }
        
        DB::table('tbl_event_transaction')->insert($insertEventTransaction);    
        

        $event_transaction2 = TransactionCart::
        select('tbl_transaction_cart.price','transaction.id as trans_id')
        ->leftJoin('tbl_event_transaction as transaction','transaction.event_id','=','tbl_transaction_cart.event_id')
        ->where('tbl_transaction_cart.pps_no',$pps_no)
        ->where('tbl_transaction_cart.is_active',true)
        ->where('tbl_transaction_cart.status','PENDING')
        ->where('transaction.status','PENDING')
        ->where('tbl_transaction_cart.event_id', '!=', null)
        ->get();    
    


        foreach($event_transaction2 as $event_transaction2s) {
            $insertEventOrMaster[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'is_active' => true,
                    'transaction_type' => 'EVENT',
                    'transaction_id' => $event_transaction2s->trans_id,
                    'pps_no' => $pps_no,
                    'total_amount' => $event_transaction2s->price,
                    'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'check_out_sessions_id' => $session_payment_id,
                    'payment_mode' => $response->data->attributes->payment_method_used,
                    ]; 
        }   

        DB::table('tbl_or_master')->insert($insertEventOrMaster);   


        $cashierEventTransaction = new EventTransaction;

        $value = ORMaster::select('transaction_id as id','id as or_id')
        ->where('is_active',true)
        ->where('check_out_sessions_id', $session_payment_id)
        ->get()
        ->toArray();

        $index = 'id';

        Batch::update($cashierEventTransaction, $value, $index);

        $event_transaction_update = EventTransaction::where('is_active',true)
                                ->where('status','PENDING')  
                                ->where('pps_no',$pps_no)  
                                ->update(['updated_by' => auth()->user()->name,
                                            'status' => 'PAID',    
                                        ]);   

        // END OF SAVING EVENT TO EVENT TRANSACTION AND OR MASTER
      

        // START OF UPDATING PAYMENT OF ANNUAL DUES
        $annualduescart = TransactionCart::where('pps_no',$pps_no)
                                ->where('is_active',true)
                                ->where('status','PENDING')
                                ->where('annual_dues_id','!=',null)
                                ->pluck('or_master_id')->toArray();  

                
        $or_master = ORMaster::where('is_active',true)
                                ->where('payment_dt',null)  
                                ->whereIn('id', $annualduescart)
                                ->update(['updated_by' => auth()->user()->name,
                                            'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                                            'amount' => $total,
                                            'check_out_sessions_id' => $session_payment_id,
                                            'payment_mode' => $response->data->attributes->payment_method_used,
                                        ]);
        // END OF UPDATING PAYMENT OF ANNUAL DUES                                

        $cart2 = TransactionCart::where('is_active',true)
                                ->where('status','PENDING')  
                                ->where('pps_no',$pps_no)  
                                ->update(['updated_by' => auth()->user()->name,
                                            'status' => 'PAID',    
                                        ]);   
                                        
        $annual_dues_count = ORMaster::where('is_active',true)
                                        ->where('transaction_type','ANNUAL DUES')
                                        ->where('pps_no',$pps_no)
                                        ->where('payment_dt',null)
                                        ->count();                                 

        session()->forget('session_payment_id');                                
        $pps = Crypt::encrypt($pps_no);
            if($annual_dues_count >= 1)
            {
                $member = MemberInfo::where('is_active',true)
                                        ->where('pps_no',$pps_no)
                                        ->first();
                $member->annual_fee = false;
                $member->save();  
                return redirect('cashier-new-transaction-cart/'. $pps)->withStatus('exist');
    
            }                  
            else
            {
                $member = MemberInfo::where('is_active',true)
                                        ->where('pps_no',$pps_no)
                                        ->first();
                $member->annual_fee = true;
                $member->save();                     
                return redirect('cashier-new-transaction-cart/'. $pps)->withStatus('completed');
            }   
               
            
    }


    public function cashierTransactionPay(Request $request)
    {



        $insertEventTransaction = [];
        $insertEventOrMaster = [];
        

        $event_transaction = TransactionCart::where('pps_no',$request->pps_no)
            ->where('is_active',true)
            ->where('status','PENDING')
            ->where('event_id', '!=', null)
            ->get();

    
       
        foreach($event_transaction as $event_transactions) {
            $insertEventTransaction[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'status' => 'PENDING', 
                    'is_active' => true,
                    'paid' => true,
                    'joined_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'event_id' => $event_transactions->event_id,
                    'selected_topic_id' => $event_transactions->topic_id,
                    'pps_no' => $request->pps_no
                    ]; 
        }
        
        DB::table('tbl_event_transaction')->insert($insertEventTransaction);    

        
        $event_transaction2 = TransactionCart::
            select('tbl_transaction_cart.price','transaction.id as trans_id')
            ->leftJoin('tbl_event_transaction as transaction','transaction.event_id','=','tbl_transaction_cart.event_id')
            ->where('tbl_transaction_cart.pps_no',$request->pps_no)
            ->where('tbl_transaction_cart.is_active',true)
            ->where('tbl_transaction_cart.status','PENDING')
            ->where('transaction.status','PENDING')
            ->where('tbl_transaction_cart.event_id', '!=', null)
            ->get();   
            
            

        foreach($event_transaction2 as $event_transaction2s) {
            $insertEventOrMaster[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'is_active' => true,
                    'transaction_type' => 'EVENT',
                    'transaction_id' => $event_transaction2s->trans_id,
                    'pps_no' => $request->pps_no,
                    'total_amount' => $event_transaction2s->price,
                    'or_no' => $request->or_no,
                    'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'payment_mode' => 'cash',
                    ]; 
        }


        DB::table('tbl_or_master')->insert($insertEventOrMaster);   



        $cashierEventTransaction = new EventTransaction;

        $value = ORMaster::select('transaction_id as id','id as or_id')
        ->where('is_active',true)
        ->where('or_no', $request->or_no)
        ->get()
        ->toArray();

        $index = 'id';

        Batch::update($cashierEventTransaction, $value, $index);


        $event_transaction_update = EventTransaction::where('is_active',true)
        ->where('status','PENDING')  
        ->where('pps_no',$request->pps_no)  
        ->update(['updated_by' => auth()->user()->name,
                    'status' => 'PAID',    
                ]);   



        $cart = TransactionCart::where('pps_no',$request->pps_no)
        ->where('is_active',true)
        ->where('status','PENDING')
        ->pluck('or_master_id')->toArray();


        $or_master = ORMaster::where('is_active',true)
                    ->where('payment_dt',null)
                    ->whereIn('id', $cart)
                    ->update(['updated_by' => auth()->user()->name,
                              'or_no' => $request->or_no,
                              'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                              'amount' => $request->amount,
                              'payment_mode' => 'cash'
                            ]);


        $cart2 = TransactionCart::where('is_active',true)
                    ->where('status','PENDING')  
                    ->where('pps_no',$request->pps_no)  
                    ->update(['updated_by' => auth()->user()->name,
                                'status' => 'PAID',    
                            ]);

                 
        $pps = Crypt::encrypt($request->pps_no);        

        $annual_dues_count = ORMaster::where('is_active',true)
        ->where('transaction_type','ANNUAL DUES')
        ->where('pps_no',$request->pps_no)
        ->where('payment_dt',null)
        ->count();

        return Response()->json([
            "success" => true,
            "type" => 'success',
            "url"=>url('/cashier-annual-dues')   
        ]);

        if($annual_dues_count >= 1)
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = false;
            $member->save();  
            return Response()->json([
                "success" => true,
                "type" => 'exist',
                "url"=>url('/cashier-new-transaction-cart/'.$pps)   
            ]);
        }                  
        else
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = true;
            $member->save();                     
            return Response()->json([
                "success" => true,
                "type" => 'success',
                "url"=>url('/cashier-new-transaction-cart/'.$pps)  
            ]);
        }              


    }


    public function cashierTransactionPayCheque(Request $request)
    {
        
        $insertEventTransaction = [];
        $insertEventOrMaster = [];
        

        $event_transaction = TransactionCart::where('pps_no',$request->pps_no)
            ->where('is_active',true)
            ->where('status','PENDING')
            ->where('event_id', '!=', null)
            ->get();

    
       
        foreach($event_transaction as $event_transactions) {
            $insertEventTransaction[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'status' => 'PENDING', 
                    'is_active' => true,
                    'paid' => true,
                    'joined_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'event_id' => $event_transactions->event_id,
                    'selected_topic_id' => $event_transactions->topic_id,
                    'pps_no' => $request->pps_no
                    ]; 
        }
        
        DB::table('tbl_event_transaction')->insert($insertEventTransaction);    

   
        
        $event_transaction2 = TransactionCart::
            select('tbl_transaction_cart.price','transaction.id as trans_id')
            ->leftJoin('tbl_event_transaction as transaction','transaction.event_id','=','tbl_transaction_cart.event_id')
            ->where('tbl_transaction_cart.pps_no',$request->pps_no)
            ->where('tbl_transaction_cart.is_active',true)
            ->where('tbl_transaction_cart.status','PENDING')
            ->where('transaction.status','PENDING')
            ->where('tbl_transaction_cart.event_id', '!=', null)
            ->get();   
            
            

        foreach($event_transaction2 as $event_transaction2s) {
            $insertEventOrMaster[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'is_active' => true,
                    'transaction_type' => 'EVENT',
                    'transaction_id' => $event_transaction2s->trans_id,
                    'pps_no' => $request->pps_no,
                    'total_amount' => $event_transaction2s->price,
                    'or_no' => $request->or_no,
                    'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'payment_mode' => 'cheque',
                    'bank_name' => $request->bank_name,
                    'cheque_number' => $request->cheque_number,
                    'posting_dt' => $request->posting_dt,
                    'amount' => $request->amount_cheque,
                    
                    ]; 
        }
        DB::table('tbl_or_master')->insert($insertEventOrMaster);   



        $cashierEventTransaction = new EventTransaction;

        $value = ORMaster::select('transaction_id as id','id as or_id')
        ->where('is_active',true)
        ->where('cheque_number', $request->cheque_number)
        ->get()
        ->toArray();

        $index = 'id';

        Batch::update($cashierEventTransaction, $value, $index);


        $event_transaction_update = EventTransaction::where('is_active',true)
        ->where('status','PENDING')  
        ->where('pps_no',$request->pps_no)  
        ->update(['updated_by' => auth()->user()->name,
                    'status' => 'PAID',    
                ]);   



        $cart = TransactionCart::where('pps_no',$request->pps_no)
        ->where('is_active',true)
        ->where('status','PENDING')
        ->pluck('or_master_id')->toArray();


        $or_master = ORMaster::where('is_active',true)
                    ->where('payment_dt',null)
                    ->whereIn('id', $cart)
                    ->update(['updated_by' => auth()->user()->name,
                              'or_no' => $request->or_no,
                              'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                              'payment_mode' => 'cheque',
                              'bank_name' => $request->bank_name,
                              'cheque_number' => $request->cheque_number,
                              'posting_dt' => $request->posting_dt,
                              'amount' => $request->amount_cheque,
                            ]);


        $cart2 = TransactionCart::where('is_active',true)
                    ->where('status','PENDING')  
                    ->where('pps_no',$request->pps_no)  
                    ->update(['updated_by' => auth()->user()->name,
                                'status' => 'PAID',    
                            ]);

                 
        $pps = Crypt::encrypt($request->pps_no);        

        $annual_dues_count = ORMaster::where('is_active',true)
        ->where('transaction_type','ANNUAL DUES')
        ->where('pps_no',$request->pps_no)
        ->where('payment_dt',null)
        ->count();

        return Response()->json([
            "success" => true,
            "type" => 'success',
            "url"=>url('/cashier-annual-dues')   
        ]);

        if($annual_dues_count >= 1)
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = false;
            $member->save();  
            return Response()->json([
                "success" => true,
                "type" => 'exist',
                "url"=>url('/cashier-new-transaction-cart/'.$pps)   
            ]);
        }                  
        else
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = true;
            $member->save();                     
            return Response()->json([
                "success" => true,
                "type" => 'success',
                "url"=>url('/cashier-new-transaction-cart/'.$pps)  
            ]);
        }                  

    }


    public function cashierTransactionPayBankTransfer(Request $request)
    {
        
        $insertEventTransaction = [];
        $insertEventOrMaster = [];
        

        $event_transaction = TransactionCart::where('pps_no',$request->pps_no)
            ->where('is_active',true)
            ->where('status','PENDING')
            ->where('event_id', '!=', null)
            ->get();

    
       
        foreach($event_transaction as $event_transactions) {
            $insertEventTransaction[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'status' => 'PENDING', 
                    'is_active' => true,
                    'paid' => true,
                    'joined_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'event_id' => $event_transactions->event_id,
                    'selected_topic_id' => $event_transactions->topic_id,
                    'pps_no' => $request->pps_no
                    ]; 
        }
        
        DB::table('tbl_event_transaction')->insert($insertEventTransaction);    

   
        
        $event_transaction2 = TransactionCart::
            select('tbl_transaction_cart.price','transaction.id as trans_id')
            ->leftJoin('tbl_event_transaction as transaction','transaction.event_id','=','tbl_transaction_cart.event_id')
            ->where('tbl_transaction_cart.pps_no',$request->pps_no)
            ->where('tbl_transaction_cart.is_active',true)
            ->where('tbl_transaction_cart.status','PENDING')
            ->where('transaction.status','PENDING')
            ->where('tbl_transaction_cart.event_id', '!=', null)
            ->get();   
            
            

        foreach($event_transaction2 as $event_transaction2s) {
            $insertEventOrMaster[] = [ 'created_by' => auth()->user()->name,
                    'updated_by' => auth()->user()->name,
                    'is_active' => true,
                    'transaction_type' => 'EVENT',
                    'transaction_id' => $event_transaction2s->trans_id,
                    'pps_no' => $request->pps_no,
                    'total_amount' => $event_transaction2s->price,
                    'or_no' => $request->or_no,
                    'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                    'payment_mode' => 'bank transfer',
                    'bank_name' => $request->bank_name,
                    'bank_transfer_transaction_number' => $request->bank_transfer_transaction_number,
                    'bank_transfer_dt' => $request->bank_transfer_dt,
                    'bank_transfer_remarks' => $request->bank_transfer_remarks,
                    'amount' => $request->amount_bank_transfer,
                    
                    
                    ]; 
        }
        DB::table('tbl_or_master')->insert($insertEventOrMaster);   

        $cashierEventTransaction = new EventTransaction;

        $value = ORMaster::select('transaction_id as id','id as or_id')
        ->where('is_active',true)
        ->where('bank_transfer_transaction_number', $request->bank_transfer_transaction_number)
        ->get()
        ->toArray();

        $index = 'id';

        Batch::update($cashierEventTransaction, $value, $index);


        $event_transaction_update = EventTransaction::where('is_active',true)
        ->where('status','PENDING')  
        ->where('pps_no',$request->pps_no)  
        ->update(['updated_by' => auth()->user()->name,
                    'status' => 'PAID',    
                ]);   



        $cart = TransactionCart::where('pps_no',$request->pps_no)
        ->where('is_active',true)
        ->where('status','PENDING')
        ->pluck('or_master_id')->toArray();


        $or_master = ORMaster::where('is_active',true)
                    ->where('payment_dt',null)
                    ->whereIn('id', $cart)
                    ->update(['updated_by' => auth()->user()->name,
                              'or_no' => $request->or_no,
                              'payment_dt' => \Carbon\Carbon::now('UTC')->timezone('Asia/Manila'),
                              'payment_mode' => 'bank transfer',
                              'bank_name' => $request->bank_name,
                              'bank_transfer_transaction_number' => $request->bank_transfer_transaction_number,
                              'bank_transfer_dt' => $request->bank_transfer_dt,
                              'bank_transfer_remarks' => $request->bank_transfer_remarks,
                              'amount' => $request->amount_bank_transfer,
                            ]);


        $cart2 = TransactionCart::where('is_active',true)
                    ->where('status','PENDING')  
                    ->where('pps_no',$request->pps_no)  
                    ->update(['updated_by' => auth()->user()->name,
                                'status' => 'PAID',    
                            ]);

                 
        $pps = Crypt::encrypt($request->pps_no);        

        $annual_dues_count = ORMaster::where('is_active',true)
        ->where('transaction_type','ANNUAL DUES')
        ->where('pps_no',$request->pps_no)
        ->where('payment_dt',null)
        ->count();

        return Response()->json([
            "success" => true,
            "type" => 'success',
            "url"=>url('/cashier-annual-dues')   
        ]);

        if($annual_dues_count >= 1)
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = false;
            $member->save();  
            return Response()->json([
                "success" => true,
                "type" => 'exist',
                "url"=>url('/cashier-new-transaction-cart/'.$pps)   
            ]);
        }                  
        else
        {
            $member = MemberInfo::where('is_active',true)
                                 ->where('pps_no',$request->pps_no)
                                 ->first();
            $member->annual_fee = true;
            $member->save();                     
            return Response()->json([
                "success" => true,
                "type" => 'success',
                "url"=>url('/cashier-new-transaction-cart/'.$pps)  
            ]);
        }             

    }


    public function cashierReport()
    {
        $ormaster = ORMaster::select('tbl_or_master.*',
                    'member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no','member.prc_number',
                    'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type',
                    'memtype.member_type_name',
                    'dues.description','dues.year_dues')
                    ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
                    ->leftJoin('tbl_member_info as member','member.pps_no','=','tbl_or_master.pps_no')
                    ->leftJoin('tbl_member_type as memtype','memtype.id','=','member.member_type')
                    ->where('tbl_or_master.is_active',true)
                    ->where('tbl_or_master.transaction_type','ANNUAL DUES')
                    ->orderBy('tbl_or_master.payment_dt','ASC')
                    ->paginate(10);   
        $paymongoMode = PaymongoConfig::mode();
        return view('cashier.cashier-report',compact('ormaster', 'paymongoMode'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new CashierReportExport($request->transaction_type, $request->date_from, $request->date_to),
            'cashier-data.xlsx'
        );
    }

    public function cashierSyncEventPayment(Request $request)
    {
        $limit = 100;
        $updatedCount = 0;
        $filteredPayments = [];
        $processedPayments = [];
        $afterCursor = null;

        $startDate = Carbon::parse($request->date_from)->startOfDay()->format('Y-m-d H:i');
        $endDate = Carbon::parse($request->date_to)->endOfDay()->format('Y-m-d H:i');

        do {
            $queryParams = [
                'limit' => $limit,
                'created_at.between' => "{$startDate}..{$endDate}",
                'status' => 'paid',
            ];

            if ($afterCursor) {
                $queryParams['after'] = $afterCursor;
            }

            $response = Curl::to('https://api.paymongo.com/v1/payments/?' . http_build_query($queryParams))
                ->withHeader('Content-Type: application/json')
                ->withHeader('Accept: application/json')
                ->withHeader('Authorization: Basic ' . \Config::get('services.paymongo.key'))
                ->withResponseHeaders()
                ->asJson(true)
                ->get();

            if (!empty($response['data'])) {
                foreach ($response['data'] as $payment) {

                    // Check for EVENT in description
                    if (!empty($payment['attributes']['description']) &&
                        stripos($payment['attributes']['description'], 'EVENT') !== false) {

                        $metadata = $payment['attributes']['metadata'] ?? [];
                        $pps_no = isset($metadata['pps_no']) ? (int) $metadata['pps_no'] : null;
                        $price_session = isset($metadata['price_session']) ? (int) $metadata['price_session'] : null;            
                        $event_id = isset($metadata['event_id']) ? (int) $metadata['event_id'] : null;
                        $dollar_rate = isset($metadata['dollar_rate']) ? (int) $metadata['dollar_rate'] : null;
                        $dollar_conversion = isset($metadata['dollar_conversion']) ? (int) $metadata['dollar_conversion'] : null;
                        $is_foreign_delegate = isset($metadata['is_foreign_delegate']) ? (int) $metadata['is_foreign_delegate'] : null;
                        
                        $payment_mode = $payment['attributes']['source']['type'] ?? null;
                        $bank_name = $payment['attributes']['source']['provider']['id'] ?? null;
                        $payment_dt = isset($payment['attributes']['paid_at']) 
                            ? Carbon::createFromTimestamp($payment['attributes']['paid_at'], 'Asia/Manila')->toDateTimeString() 
                            : null;

                        // Skip if essential metadata is missing
                        if (!$pps_no || !$event_id) {
                            continue;
                        }

                        $uniqueKey = "{$pps_no}_{$event_id}";

                        // Avoid duplicates in the same sync
                        if (!isset($processedPayments[$uniqueKey])) {

                            // Check if this payment already exists in EventTransaction
                            $exists = EventTransaction::where('is_active', true)
                                ->where('event_id', $event_id)
                                ->where('pps_no', $pps_no)
                                ->exists();

                            if (!$exists) {
                                // Save to EventTransaction
                               // 1️⃣ Save EventTransaction
                                    $eventTrans = EventTransaction::create([
                                        'created_by' => auth()->user()->name,
                                        'is_active' => true,
                                        'status' => 'PAID',
                                        'pps_no' => $pps_no,
                                        'event_id' => $event_id,
                                        'paid' => true,
                                        'joined_dt' => now()->timezone('Asia/Manila')
                                    ]);

                                    // 2️⃣ Prepare ORMaster data
                                    $data = [
                                        'created_by'       => auth()->user()->name,
                                        'is_active'        => true,
                                        'status'           => 'PAID',
                                        'transaction_type' => 'EVENT',
                                        'transaction_id'   => $eventTrans->id,
                                        'total_amount'     => $price_session,
                                        'pps_no'           => $pps_no,
                                        'payment_dt'       => $payment_dt,
                                        'payment_mode'     => $payment_mode,
                                        'bank_name'        => $bank_name,
                                        'dollar_rate'      => $dollar_rate,
                                        'dollar_conversion'=> $dollar_conversion,
                                        'paymongo_payment_id' => $payment['id']
                                    ];

                                    // Conditionally add 'is_dollar'
                                    if ($is_foreign_delegate == 'no') {
                                        $data['is_dollar'] = false;
                                    }

                                    // 3️⃣ Save ORMaster
                                    $orMaster = ORMaster::create($data);

                                    // 4️⃣ Update EventTransaction with ORMaster ID
                                    $eventTrans->or_id = $orMaster->id;
                                    $eventTrans->save();



                                $updatedCount++;
                                $filteredPayments[] = [
                                    'pps_no' => $pps_no,
                                    'event_id' => $event_id,
                                    'status' => 'paid',
                                ];

                                \Log::info("Saved Event Payment for PPS No: {$pps_no}, Event ID: {$event_id}");
                            }

                            $processedPayments[$uniqueKey] = true;
                        }
                    }
                }
            }

            $afterCursor = $response['meta']['after'] ?? null;

        } while ($afterCursor);

        return redirect('/cashier-event')
            ->with('status', 'sync')
            ->with('total_updated', $updatedCount);
    }


    public function cashierSyncAnnualDues(Request $request)
    {

        $limit = 100;
        $updatedCount = 0;
        $filteredPayments = [];
        $processedPayments = [];
        $afterCursor = null;
    

        $startDate = Carbon::parse($request->date_from)->startOfDay()->format('Y-m-d H:i');
        $endDate = Carbon::parse($request->date_to)->endOfDay()->format('Y-m-d H:i');
    
        do {
            $queryParams = [
                'limit' => $limit,
                'created_at.between' => "{$startDate}..{$endDate}",
                'status' => 'paid',
            ];
    
            if ($afterCursor) {
                $queryParams['after'] = $afterCursor;
            }
    

            $response = Curl::to('https://api.paymongo.com/v1/payments/?' . http_build_query($queryParams))
                ->withHeader('Content-Type: application/json')
                ->withHeader('Accept: application/json')
                ->withHeader('Authorization: Basic ' . \Config::get('services.paymongo.key'))
                ->withResponseHeaders()
                ->asJson(true)
                ->get();
    
            if (!empty($response['data'])) {
                foreach ($response['data'] as $payment) {
                    if (!empty($payment['attributes']['description']) &&
                        stripos($payment['attributes']['description'], 'Member Annual Dues') !== false) {
    
                 
                        $metadata = $payment['attributes']['metadata'] ?? [];
                        $transaction_id = isset($metadata['transaction_id']) ? (int) $metadata['transaction_id'] : null;
                        $pps_no = isset($metadata['pps_no']) ? (int) $metadata['pps_no'] : null;
                        $payment_mode = $payment['attributes']['source']['type'] ?? null;
                        $bank_name = $payment['attributes']['source']['provider']['id'] ?? null;
                        $payment_dt = isset($payment['attributes']['paid_at']) 
                            ? Carbon::createFromTimestamp($payment['attributes']['paid_at'], 'Asia/Manila')->toDateTimeString() 
                            : null;
    
                        if ($pps_no && $transaction_id) {
                            $uniqueKey = "{$pps_no}_{$transaction_id}";
    
                    
                            if (!isset($processedPayments[$uniqueKey])) {
                
                                $records = ORMaster::where('pps_no', $pps_no)
                                    ->where('transaction_id', $transaction_id)
                                    ->where('payment_dt', null)
                                    ->get();
    
                                foreach ($records as $record) {
                                    $record->updated_by = auth()->user()->name;
                                    $record->status = 'PAID';
                                    $record->payment_dt = $payment_dt;
                                    $record->paymongo_payment_id = $payment['id'];
                                    $record->payment_mode = $payment_mode;
                                    $record->bank_name = $bank_name;
                                    $record->save(); 

                                    SyncAnnualDues::create([
                                        'created_by' => auth()->user()->name,
                                        'is_active' => true,
                                        'status' => 'PAID',
                                        'pps_no' => $pps_no,
                                        'annual_dues_id' => $transaction_id,
                                        
                                        'payment_dt' => $payment_dt
                                    ]);
    
                                    $updatedCount++;
    
                                    $filteredPayments[] = [
                                        'pps_no' => $pps_no,
                                        'transaction_id' => $transaction_id,
                                        'status' => 'paid',
                                    ];
                                }
    
                  
                                $processedPayments[$uniqueKey] = true;
    
                                \Log::info("Updated Records: " . count($records) . " for PPS No: " . $pps_no . " Transaction ID: " . $transaction_id);
                            }
                        }
                    }
                }
            }
    
            $afterCursor = $response['meta']['after'] ?? null;
    
        } while ($afterCursor);


        return redirect('/cashier-annual-dues')
        ->with('status', 'sync')
        ->with('total_updated', $updatedCount);
    }
    
    
}
