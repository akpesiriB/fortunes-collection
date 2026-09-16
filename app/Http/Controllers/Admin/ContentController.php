<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        $settings = [
            'announcement_ticker' => SiteSetting::get('announcement_ticker', ''),
            'hero_title' => SiteSetting::get('hero_title', 'FORTUNES COLLECTION'),
            'hero_subtitle' => SiteSetting::get('hero_subtitle', 'WHERE PASSION MEETS FASHION'),
            'maison_address' => SiteSetting::get('maison_address', 'PLOT 12, PTI ROAD, EFFURUN, DELTA STATE'),
            'maison_status' => SiteSetting::get('maison_status', 'STATUS: ARCHIVE 03 PRODUCTION'),
            'customer_service_phone' => SiteSetting::get('customer_service_phone', '+234 1 888 3490'),
            'customer_service_email' => SiteSetting::get('customer_service_email', 'concierge@fortunes.ng'),
        ];

        return view('admin.content.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'announcement_ticker' => 'required|string|max:500',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'maison_address' => 'required|string|max:255',
            'maison_status' => 'required|string|max:255',
            'customer_service_phone' => 'nullable|string|max:50',
            'customer_service_email' => 'nullable|email|max:100',
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return back()->with('success', 'Maison website content updated across all public pages.');
    }
}
