<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function paymentIndex()
    {
        $settings = Setting::payment();
        return view('admin.payment_settings', compact('settings'));
    }

    public function paymentUpdate(Request $request)
    {
        $data = $request->validate([
            'crypto_address'      => ['nullable', 'string', 'max:255'],
            'moniffy_tag'         => ['nullable', 'string', 'max:255'],
            'bank_name'           => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'bank_account_name'   => ['nullable', 'string', 'max:255'],
            'whatsapp_number'     => ['nullable', 'string', 'max:30'],
            'price_usd'           => ['required', 'numeric', 'min:1'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        return redirect()->route('admin.settings.payment')
            ->with('message', 'Payment settings saved successfully.');
    }
}
