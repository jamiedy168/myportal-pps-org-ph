<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;
use Session;
use App\Models\Role;
use App\Models\ORMaster;
use App\Models\MemberInfo;
use App\Models\Event;
use App\Models\EventTransaction;
use App\Models\TestWebhook;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Support\PaymongoConfig;


class WebHookController extends Controller
{

    public function paymentWebhook(Request $request)
    {
        // Verify PayMongo signature to prevent spoofed webhooks
        if (!$this->verifyPaymongoSignature($request)) {
            Log::warning('Invalid PayMongo signature on webhook.');
            return response()->json(['status' => 'invalid-signature'], 400);
        }

        $eventType = $request->input('data.attributes.type');
        if (!in_array($eventType, ['payment.paid','payment.failed'])) {
            Log::info('Ignoring unsupported PayMongo event', ['type' => $eventType]);
            return response()->json(['status' => 'ignored'], 200);
        }

        $transaction_type = $request->input('data.attributes.data.attributes.metadata.transaction_type');

        switch ($transaction_type) {
            case 'ANNUAL_DUES':  
                
                    Log::info('Processing ANNUAL_DUES transaction.');
                    try {
                        Log::info('Webhook received', ['request' => $request->all()]);
                
                        $payment_id = $request->input('data.attributes.data.id');
                        $paymongoStatus = $eventType;

                        // Confirm status and amount directly from PayMongo to prevent tampering
                        $payment = $this->fetchPayment($payment_id);
                        if (!$payment || $payment->attributes->status !== 'paid') {
                            Log::warning('Payment not confirmed as paid', ['payment_id' => $payment_id]);
                            return response()->json(['status' => 'not-confirmed'], 400);
                        }
                
                        // Check if payment already exists
                        $paymongoExistId = ORMaster::where('paymongo_payment_id', $payment_id)->count();
                
                        if ($paymongoExistId == 0) {
                            if ($paymongoStatus === 'payment.paid') {
                                $metadata = $request->input('data.attributes.data.attributes.metadata');
                                $source_type = $request->input('data.attributes.data.attributes.source.type');
                
                                $ormaster = ORMaster::where('transaction_id', $metadata['transaction_id'])
                                                    ->where('pps_no', $metadata['pps_no'])
                                                    ->first();
                
                                if ($ormaster) {
                                    $expectedAmount = $ormaster->total_amount ?? 0;
                                    if (!$this->validatePaymentAmount($payment, $expectedAmount, $payment->attributes->currency ?? 'PHP')) {
                                        return response()->json(['status' => 'amount-mismatch'], 400);
                                    }
                                    // Update the record
                                    $ormaster->updated_by = $metadata['pps_member'];
                                    $ormaster->payment_dt = now()->timezone('Asia/Manila');
                                    $ormaster->paymongo_payment_id = $payment_id;
                                    $ormaster->payment_mode = $source_type;
                                    $ormaster->save();
                
                                    $member = MemberInfo::where('is_active', true)
                                                        ->where('pps_no', $metadata['pps_no'])
                                                        ->first();
                                    if ($member) {
                                        $member->annual_fee = true;
                                        $member->save();
                                    }
                
                                    Log::info('ORMaster updated successfully', [
                                        'transaction_id' => $metadata['transaction_id'],
                                        'payment_id' => $payment_id
                                    ]);
                
                                    return response()->json(['status' => 'success'], 200);
                                } else {
                                    Log::warning('ORMaster not found for transaction', [
                                        'transaction_id' => $metadata['transaction_id'],
                                        'pps_no' => $metadata['pps_no']
                                    ]);
                                }
                            } else {
                                Log::warning('Received a non-payment.paid event', [
                                    'payment_id' => $payment_id,
                                    'status' => $paymongoStatus
                                ]);
                            }
                
                            return response()->json(['status' => 'ignored'], 200);
                        } else {
                            Log::warning('Duplicate payment detected', ['paymongo_id' => $payment_id]);
                            return response()->json(['status' => 'duplicate'], 200);
                        }
                    } catch (\Exception $e) {
                        Log::error('Webhook processing failed', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'request' => $request->all()
                        ]);
                        return response()->json(['status' => 'error'], 500);
                    }
                break;

            case 'EVENT':
                
                    Log::info('Processing EVENT transaction.');
                    try {
                        Log::info('Webhook received', ['request' => $request->all()]);
                
                        $payment_id = $request->input('data.attributes.data.id');
                        $paymongoStatus = $eventType;

                        $payment = $this->fetchPayment($payment_id);
                        if (!$payment || $payment->attributes->status !== 'paid') {
                            Log::warning('Payment not confirmed as paid', ['payment_id' => $payment_id]);
                            return response()->json(['status' => 'not-confirmed'], 400);
                        }
                
                        // Check if payment already exists
                        $paymongoExistId = ORMaster::where('paymongo_payment_id', $payment_id)->count();
                
                        if ($paymongoExistId == 0) {
                            if ($paymongoStatus === 'payment.paid') { 
                                $metadata = $request->input('data.attributes.data.attributes.metadata');
                                $source_type = $request->input('data.attributes.data.attributes.source.type');
                
                                // Fetch event details
                                $event = Event::select('tbl_event.*', 'category.name as category')
                                    ->where('tbl_event.id', $metadata['event_id'])
                                    ->join('tbl_event_category as category', 'category.id', '=', 'tbl_event.category_id')
                                    ->first();
                
                                // Fetch member details
                                $info = MemberInfo::select('tbl_member_info.*', 'type.member_type_name')
                                    ->join('tbl_member_type as type', 'type.id', '=', 'tbl_member_info.member_type')
                                    ->where('tbl_member_info.is_active', true)
                                    ->where('tbl_member_info.pps_no', $metadata['pps_no'])
                                    ->first();
                
                                // Check if event transaction exists
                                $event_trans = EventTransaction::where('is_active', true)
                                    ->where('event_id', $metadata['event_id'])
                                    ->where('pps_no', $metadata['pps_no'])
                                    ->first();
                
                                if (!$event_trans) {
                                    $event_trans = new EventTransaction();
                                    $event_trans->is_active = true;
                                    $event_trans->status = 'PAID';
                                    $event_trans->created_by = $metadata['pps_member'];
                                    $event_trans->event_id = $metadata['event_id'];
                                    $event_trans->pps_no = $metadata['pps_no'];
                                    $event_trans->paid = true;
                                    $event_trans->joined_dt = now()->timezone('Asia/Manila');
                                    $event_trans->selected_topic_id = $metadata['topic_id'];
                                    $event_trans->save();
                                }
                
                                $transaction_id = $event_trans->id;
                
                                // Create ORMaster record
                                $ormaster = new ORMaster();
                                $ormaster->is_active = true;
                                $ormaster->created_by = $metadata['pps_member'];
                                $ormaster->transaction_type = 'EVENT';
                                $ormaster->transaction_id = $transaction_id;
                                $ormaster->total_amount = $metadata['price_session'];
                                $ormaster->pps_no = $metadata['pps_no'];
                                $ormaster->payment_dt = now()->timezone('Asia/Manila');
                                $ormaster->payment_mode = $source_type;
                                $ormaster->paymongo_payment_id = $payment_id;
                
                                if ($info && $info->member_type_name === 'FOREIGN DELEGATE') {
                                    $ormaster->is_dollar = true;
                                    $ormaster->dollar_rate = $metadata['dollar_rate'];
                                    $ormaster->dollar_conversion = $metadata['dollar_conversion'];
                                }

                                $ormaster->save();
                                // verify amount matches
                                $expectedAmount = $ormaster->total_amount ?? 0;
                                if (!$this->validatePaymentAmount($payment, $expectedAmount, $payment->attributes->currency ?? 'PHP')) {
                                    return response()->json(['status' => 'amount-mismatch'], 400);
                                }
                                $or_id = $ormaster->id;
                
                                // Update EventTransaction with ORMaster ID
                                $event_trans->updated_by = $metadata['pps_member'];
                                $event_trans->or_id = $or_id;
                                $event_trans->save();
                
                                Log::info('Event Payment processed successfully', [
                                    'transaction_id' => $transaction_id,
                                    'paymongo_payment_id' => $payment_id
                                ]);
                
                                return response()->json(['status' => 'success'], 200);
                            }
                        } else {
                            Log::warning('Duplicate payment for event detected', ['paymongo_id' => $payment_id]);
                            return response()->json(['status' => 'duplicate'], 200);
                        }
                    } catch (\Exception $e) {
                        Log::error('Webhook processing failed', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'request' => $request->all()
                        ]);
                        return response()->json(['status' => 'error'], 500);
                    }
                break;

            default:
                
                    Log::warning('Unknown transaction type received:', ['transaction_type' => $transaction_type]);
                    return response()->json(['status' => 'success'], 200);
                break;
        }


    }

    // public function paymentWebhook(Request $request)
    // {
    //     try {
    //         Log::info('Webhook received', ['request' => $request->all()]);
    
    //         $payment_id = $request->input('data.attributes.data.id');
    //         $paymongoStatus = $request->input('data.attributes.type');
    
    //         // Check if payment already exists
    //         $paymongoExistId = ORMaster::where('paymongo_payment_id', $payment_id)->count();
    
    //         if ($paymongoExistId == 0) {
    //             if ($paymongoStatus === 'payment.paid') {
    //                 $metadata = $request->input('data.attributes.data.attributes.metadata');
    //                 $source_type = $request->input('data.attributes.data.attributes.source.type');
    
    //                 $ormaster = ORMaster::where('transaction_id', $metadata['transaction_id'])
    //                                     ->where('pps_no', $metadata['pps_no'])
    //                                     ->first();
    
    //                 if ($ormaster) {
    //                     // Update the record
    //                     $ormaster->updated_by = $metadata['pps_member'];
    //                     $ormaster->payment_dt = now()->timezone('Asia/Manila');
    //                     $ormaster->paymongo_payment_id = $payment_id;
    //                     $ormaster->payment_mode = $source_type;
    //                     $ormaster->save();
    
    //                     $member = MemberInfo::where('is_active', true)
    //                                         ->where('pps_no', $metadata['pps_no'])
    //                                         ->first();
    //                     if ($member) {
    //                         $member->annual_fee = true;
    //                         $member->save();
    //                     }
    
    //                     Log::info('ORMaster updated successfully', [
    //                         'transaction_id' => $metadata['transaction_id'],
    //                         'payment_id' => $payment_id
    //                     ]);
    
    //                     return response()->json(['status' => 'success'], 200);
    //                 } else {
    //                     Log::warning('ORMaster not found for transaction', [
    //                         'transaction_id' => $metadata['transaction_id'],
    //                         'pps_no' => $metadata['pps_no']
    //                     ]);
    //                 }
    //             } else {
    //                 Log::warning('Received a non-payment.paid event', [
    //                     'payment_id' => $payment_id,
    //                     'status' => $paymongoStatus
    //                 ]);
    //             }
    
    //             return response()->json(['status' => 'ignored'], 200);
    //         } else {
    //             Log::warning('Duplicate payment detected', ['paymongo_id' => $payment_id]);
    //             return response()->json(['status' => 'duplicate'], 200);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Webhook processing failed', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //             'request' => $request->all()
    //         ]);
    //         return response()->json(['status' => 'error'], 500);
    //     }
    // }


    // public function eventPaymentWebhook(Request $request)
    // {
    //     try {
    //         Log::info('Webhook received', ['request' => $request->all()]);
    
    //         $payment_id = $request->input('data.attributes.data.id');
    //         $paymongoStatus = $request->input('data.attributes.type');
    
    //         // Check if payment already exists
    //         $paymongoExistId = ORMaster::where('paymongo_payment_id', $payment_id)->count();
    
    //         if ($paymongoExistId == 0) {
    //             if ($paymongoStatus === 'payment.paid') { 
    //                 $metadata = $request->input('data.attributes.data.attributes.metadata');
    //                 $source_type = $request->input('data.attributes.data.attributes.source.type');
    
    //                 // Fetch event details
    //                 $event = Event::select('tbl_event.*', 'category.name as category')
    //                     ->where('tbl_event.id', $metadata['event_id'])
    //                     ->join('tbl_event_category as category', 'category.id', '=', 'tbl_event.category_id')
    //                     ->first();
    
    //                 // Fetch member details
    //                 $info = MemberInfo::select('tbl_member_info.*', 'type.member_type_name')
    //                     ->join('tbl_member_type as type', 'type.id', '=', 'tbl_member_info.member_type')
    //                     ->where('tbl_member_info.is_active', true)
    //                     ->where('tbl_member_info.pps_no', $metadata['pps_no'])
    //                     ->first();
    
    //                 // Check if event transaction exists
    //                 $event_trans = EventTransaction::where('is_active', true)
    //                     ->where('event_id', $metadata['event_id'])
    //                     ->where('pps_no', $metadata['pps_no'])
    //                     ->first();
    
    //                 if (!$event_trans) {
    //                     $event_trans = new EventTransaction();
    //                     $event_trans->is_active = true;
    //                     $event_trans->status = 'PAID';
    //                     $event_trans->created_by = $metadata['pps_member'];
    //                     $event_trans->event_id = $metadata['event_id'];
    //                     $event_trans->pps_no = $metadata['pps_no'];
    //                     $event_trans->paid = true;
    //                     $event_trans->joined_dt = now()->timezone('Asia/Manila');
    //                     $event_trans->selected_topic_id = $metadata['topic_id'];
    //                     $event_trans->save();
    //                 }
    
    //                 $transaction_id = $event_trans->id;
    
    //                 // Create ORMaster record
    //                 $ormaster = new ORMaster();
    //                 $ormaster->is_active = true;
    //                 $ormaster->created_by = $metadata['pps_member'];
    //                 $ormaster->transaction_type = 'EVENT';
    //                 $ormaster->transaction_id = $transaction_id;
    //                 $ormaster->total_amount = $metadata['price_session'];
    //                 $ormaster->pps_no = $metadata['pps_no'];
    //                 $ormaster->payment_dt = now()->timezone('Asia/Manila');
    //                 $ormaster->payment_mode = $source_type;
    //                 $ormaster->paymongo_payment_id = $payment_id;
    
    //                 if ($info && $info->member_type_name === 'FOREIGN DELEGATE') {
    //                     $ormaster->is_dollar = true;
    //                     $ormaster->dollar_rate = $metadata['dollar_rate'];
    //                     $ormaster->dollar_conversion = $metadata['dollar_conversion'];
    //                 }
    
    //                 $ormaster->save();
    //                 $or_id = $ormaster->id;
    
    //                 // Update EventTransaction with ORMaster ID
    //                 $event_trans->updated_by = $metadata['pps_member'];
    //                 $event_trans->or_id = $or_id;
    //                 $event_trans->save();
    
    //                 Log::info('Event Payment processed successfully', [
    //                     'transaction_id' => $transaction_id,
    //                     'paymongo_payment_id' => $payment_id
    //                 ]);
    
    //                 return response()->json(['status' => 'success'], 200);
    //             }
    //         } else {
    //             Log::warning('Duplicate payment for event detected', ['paymongo_id' => $payment_id]);
    //             return response()->json(['status' => 'duplicate'], 200);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Webhook processing failed', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //             'request' => $request->all()
    //         ]);
    //         return response()->json(['status' => 'error'], 500);
    //     }
    // }

    /**
     * Verify PayMongo webhook signature.
     */
    private function verifyPaymongoSignature(Request $request): bool
    {
        $header = $request->header('Paymongo-Signature');
        if (!$header) {
            return false;
        }

        $parts = collect(explode(',', $header))
            ->map(fn($p) => explode('=', $p, 2))
            ->filter(fn($p) => count($p) === 2)
            ->mapWithKeys(fn($p) => [$p[0] => $p[1]]);

        $timestamp = $parts['t'] ?? null;
        $signature = $parts['v1'] ?? null;
        if (!$timestamp || !$signature) {
            return false;
        }

        // Prevent replay: 5-minute window
        if (abs(time() - (int)$timestamp) > 300) {
            return false;
        }

        $secret = PaymongoConfig::webhookSecret();
        if (!$secret) {
            Log::warning('PayMongo webhook secret missing in config.');
            return false;
        }

        $payload = $request->getContent();
        $signedPayload = $timestamp . '.' . $payload;
        $computed = hash_hmac('sha256', $signedPayload, $secret);

        return hash_equals($computed, $signature);
    }

    /**
     * Fetch payment from PayMongo for verification.
     */
    private function fetchPayment(string $paymentId)
    {
        try {
            $response = Curl::to('https://api.paymongo.com/v1/payments/' . $paymentId)
                ->withHeader('accept: application/json')
                ->withHeader('Authorization: Basic ' . PaymongoConfig::key())
                ->asJson()
                ->get();

            if (!isset($response->data)) {
                Log::warning('PayMongo payment fetch missing data', ['paymentId' => $paymentId, 'response' => $response]);
                return null;
            }

            return $response->data;
        } catch (\Throwable $e) {
            Log::error('Failed to fetch PayMongo payment', ['paymentId' => $paymentId, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Validate payment amount and currency against expected pesos.
     */
    private function validatePaymentAmount($payment, float $expectedAmountPeso, string $expectedCurrency = 'PHP'): bool
    {
        if (!$payment || !isset($payment->attributes)) {
            return false;
        }

        $paidCurrency = $payment->attributes->currency ?? null;
        $paidAmountCents = $payment->attributes->amount ?? null; // PayMongo amount is in cents

        if ($paidCurrency !== $expectedCurrency) {
            Log::warning('Currency mismatch', ['paid' => $paidCurrency, 'expected' => $expectedCurrency]);
            return false;
        }

        $expectedCents = (int) round($expectedAmountPeso * 100);
        if ($paidAmountCents !== $expectedCents) {
            Log::warning('Amount mismatch', ['paid_cents' => $paidAmountCents, 'expected_cents' => $expectedCents]);
            return false;
        }

        return true;
    }
}
