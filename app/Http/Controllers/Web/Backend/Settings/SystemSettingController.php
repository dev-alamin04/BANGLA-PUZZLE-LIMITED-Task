<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    public function index(): View
    {
        $setting = SystemSetting::latest('id')->first();
        return view('backend.layouts.settings.system_settings', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'system_name'             => 'nullable|string|max:255',
            'email'                   => 'nullable|email|max:255',
            'copyright_text'          => 'nullable|string|max:255',
            'logo'                    => 'nullable|image|mimes:png,jpg,jpeg,svg|max:20480',
            'favicon'                 => 'nullable|image|mimes:png,jpg,jpeg,svg|max:20480',
            'description'             => 'nullable|string',           
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $data = SystemSetting::first();
            $setting = SystemSetting::firstOrNew();

            $setting->system_name             = $request->system_name;
            $setting->email                   = $request->email;
            $setting->copyright_text          = $request->copyright_text;

            $setting->description             = $request->description;
           

            // Logo
            if ($request->hasFile('logo')) {
                $setting->logo = uploadImage($request->file('logo'), 'logos');

                if ($data && $data->logo && file_exists(public_path($data->logo))) {
                    unlink(public_path($data->logo));
                }
            } else {
                $setting->logo = $data->logo ?? null;
            }

            // Favicon
            if ($request->hasFile('favicon')) {
                $setting->favicon = uploadImage($request->file('favicon'), 'favicons');

                if ($data && $data->favicon && file_exists(public_path($data->favicon))) {
                    unlink(public_path($data->favicon));
                }
            } else {
                $setting->favicon = $data->favicon ?? null;
            }

            $setting->save();

            return back()->with('success', 'System settings updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update settings. ' . $e->getMessage());
        }
    }
}
