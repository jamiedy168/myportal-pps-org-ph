<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ORMaster;
use App\Models\MemberInfo;
use Illuminate\Support\Facades\Crypt;
use Curl;
use Session;
use Illuminate\Support\Str;
use App\Support\PaymongoConfig;
use Log;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Carbon\Carbon;

class PaymentController extends Controller
{

    // private $pps_url = 'https://dev.pps.org.ph/';
    private $pps_url = 'https://portal.pps.org.ph/';
    // private $pps_url = 'http://127.0.0.1:8000/';



    public function paymentList()
    {

        $paymentList = ORMaster::select('tbl_or_master.*',
                    'member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no',
                    'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type',
                    'memtype.member_type_name',
                    'dues.description','dues.year_dues')
                    ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
                    ->join('tbl_member_info as member','member.pps_no','=','tbl_or_master.pps_no')
                    ->join('tbl_member_type as memtype','memtype.id','=','member.member_type')
                    ->where('tbl_or_master.is_active',true)
                    ->where('tbl_or_master.pps_no',auth()->user()->pps_no)
                    ->where('tbl_or_master.transaction_type','ANNUAL DUES')
                    ->orderBy('tbl_or_master.id','ASC')
                    ->get();

        $paymongoMode = PaymongoConfig::mode();

        return view('payment.listing',compact('paymentList', 'paymongoMode'));

    }

    public function paymentOnlineFinal($id)
    {

        $ids = Crypt::decrypt($id);

        $paymentList = ORMaster::select('tbl_or_master.*',
                    'member.picture','member.first_name','member.middle_name','member.last_name','member.pps_no',
                    'member.suffix','member.type','member.email_address','member.mobile_number','member.country_code','member.type',
                    'memtype.member_type_name',
                    'dues.description','dues.year_dues')
                    ->leftJoin('tbl_annual_dues as dues','dues.id','=','tbl_or_master.transaction_id')
                    ->join('tbl_member_info as member','member.pps_no','=','tbl_or_master.pps_no')
                    ->join('tbl_member_type as memtype','memtype.id','=','member.member_type')
                    ->where('tbl_or_master.id',$ids)
                    ->where('tbl_or_master.is_active',true)
                    ->where('tbl_or_master.pps_no',auth()->user()->pps_no)
                    ->where('tbl_or_master.transaction_type','ANNUAL DUES')
                    ->first();


        return view('payment.payment-online-final',compact('paymentList'));

    }



    // public function paymentOnline(Request $request)
    // {
    //     if($request->payment_type == 'gcash')
    //     {
    //         $amount = $request->total_price * 1.030 . '00';
    //     }
    //     else
    //     {
    //         $amount = ($request->total_price * 1.040) + 15 . '00';
    //     }


    //     $success_url = $this->pps_url."success-or-payment/".$request->transaction_id.'/'.$request->total_price.'/'.$request->pps_no;
    //     $failed_url = $this->pps_url."failed-or-payment";

    //     $total = (float) $amount;

    //         $data = [
    //             'data' => [
    //                 'attributes' => [
    //                     'billing' => [
    //                         'email' => $request->email_adddress,
    //                         'name' => $request->customer_name

    //                     ],
    //                     'line_items' => [
    //                         [
    //                             'currency' => 'PHP',
    //                             'amount' => $total,
    //                             'description' => $request->description .' ' . $request->year_dues,
    //                             'name'  =>  $request->description .' ' . $request->year_dues,
    //                             'quantity'  =>  1,


    //                         ],

    //                 ],
    //                 'payment_method_types' => [
    //                     $request->payment_type

    //                 ],
    //                     'success_url'   =>  $success_url,
    //                     'cancel_url'    =>   $this->pps_url.'payment-listing',
    //                     'description'   =>  $request->description .' ' . $request->year_dues,
    //                     'send_email_receipt' => true
    //                 ],

    //             ]
    //         ];

    //         $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
    //                         ->withHeader('Content-Type: application/json')
    //                         ->withHeader('accept: application/json')
    //                         ->withHeader('Authorization: Basic '.\Config::get('services.paymongo.key'))
    //                         ->withData($data)
    //                         ->asJson()
    //                         ->post();

                  



    //         $ormaster =  ORMaster::where('transaction_id',$request->transaction_id)->where('pps_no',$request->pps_no)->first();
    //         $ormaster->temporary_checkout_session = $response->data->id;
    //         $ormaster->save();

    //         // Session::put('checkout_id',$response->data->id);

    //         return redirect()->to($response->data->attributes->checkout_url);

    // }


    public function paymentOnline(Request $request)
    {
    
        // Calculate amount based on payment type
        $amount = $request->payment_type === 'gcash'
            ? $request->total_price * 1.03 . '00'  // Add GCASH fee
            : ($request->total_price * 1.04) + 15 . '00'; // Add credit card fee

        $success_url = $this->pps_url . "success-or-payment/{$request->transaction_id}/{$request->total_price}/{$request->pps_no}";
        $failed_url = $this->pps_url . "failed-or-payment";

        $total = (float) $amount;

        // Prepare data for PayMongo API
        $data = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'email' => $request->email_adddress,
                        'name' => $request->customer_name,
                        'phone' => $request->mobile_number
                    ],
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => $total,
                            'description' => "{$request->description} {$request->year_dues}",
                            'name' => "{$request->description} {$request->year_dues}",
                            'quantity' => 1,
                        ],
                    ],
                    'metadata' => [
                        'transaction_type' => 'ANNUAL_DUES',
                        'transaction_id' => $request->transaction_id,
                        'pps_no' => $request->pps_no,
                        'pps_member' => auth()->user()->name
                    ],
                    'payment_method_types' => [$request->payment_type],
                    'success_url' => $success_url,
                    'cancel_url' => $this->pps_url . 'payment-listing',
                    'description' => "{$request->description} {$request->year_dues}",
                    'send_email_receipt' => true,
                ],
            ],
        ];

        

        try {
            // Send request to PayMongo
            $idempotencyKey = (string) \Illuminate\Support\Str::uuid();
            $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                ->withHeader('Content-Type: application/json')
                ->withHeader('Accept: application/json')
                ->withHeader('Idempotency-Key: ' . $idempotencyKey)
                ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
                ->withData($data)
                ->asJson()
                ->post();



            if (!isset($response->data)) {
                throw new \Exception('Invalid response from PayMongo');
            }

            // Update ORMaster record with the session ID
            $ormaster = ORMaster::where('transaction_id', $request->transaction_id)
                ->where('pps_no', $request->pps_no)
                ->first();

            if (!$ormaster) {
                throw new \Exception('ORMaster record not found');
            }

            $ormaster->temporary_checkout_session = $response->data->id;
            $ormaster->save();

            // Redirect to PayMongo checkout URL
            return redirect()->to($response->data->attributes->checkout_url);
        } catch (\Exception $e) {
            // Log error and redirect to a failure page
            Log::error('Payment processing failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return redirect($failed_url)->with('error', 'Payment processing failed. Please try again.');
        }
    }



    public function successOrPayment($transaction_id,$total_amount,$pps_no)
    {

        sleep(4);

        $paymentUpdated = session('payment_updated', false);

        if ($paymentUpdated) {
            $countexistannualdues = ORMaster::where('is_active', true)
                                            ->where('pps_no', $pps_no)
                                            ->where('payment_dt', null)
                                            ->count();
    
            if ($countexistannualdues >= 1) {
                return redirect('payment-listing')->withStatus('exist');
            } else {
                return redirect('payment-listing')->withStatus('success');
            }
        } else {
            return redirect('payment-listing')->withStatus('waiting');
        }
        
    }
}
