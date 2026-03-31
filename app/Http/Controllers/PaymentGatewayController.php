<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentGatewaySetting;
use App\Support\PaymongoConfig;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $setting = PaymentGatewaySetting::where('gateway', 'paymongo')->latest()->first();
        $mode = PaymongoConfig::mode();

        return view('maintenance.payment-gateway', compact('setting', 'mode'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mode' => 'required|in:test,live',
            'test_key' => 'nullable|string',
            'live_key' => 'nullable|string',
            'test_webhook_secret' => 'nullable|string',
            'live_webhook_secret' => 'nullable|string',
        ]);

        PaymentGatewaySetting::updateOrCreate(
            ['gateway' => 'paymongo'],
            array_merge($data, ['updated_by' => auth()->user()->name])
        );

        PaymongoConfig::bustCache();

        return back()->with('status', 'PayMongo settings saved.');
    }
}
