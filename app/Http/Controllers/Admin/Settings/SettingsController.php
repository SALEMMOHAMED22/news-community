<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Setting;
use App\utils\ImageManger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function __construct(){
        $this->middleware('can:settings') ;
    }
    public function index()
    {
        return view('admin.settings.index');
    }
    public function update(SettingRequest $request)
    {
        try {
            DB::beginTransaction();
            $setting = Setting::findOrFail($request->setting_id);

            $favicon_name = $setting->favicon;
            $logo_name = $setting->logo;


            if ($request->hasFile('favicon')) {
                ImageManger::delteImageFromLocale($favicon_name);
                $favicon_new_name = ImageManger::generateImageName($request->favicon);
                $favicon_path = ImageManger::storeImageInLocale($request->favicon, 'settings', $favicon_new_name);
            }

            if ($request->hasFile('logo')) {
                ImageManger::delteImageFromLocale($logo_name);
                $logo_new_name = ImageManger::generateImageName($request->logo);
                $logo_path = ImageManger::storeImageInLocale($request->logo, 'settings', $logo_new_name);
            }



            $updateData = $request->except(['_token', 'setting_id']);
            if ($request->hasFile('favicon')) {
                $updateData['favicon'] = $favicon_path;
            }
            if ($request->hasFile('logo')) {
                $updateData['logo'] = $logo_path;
            }

            $setting = $setting->update($updateData);

            DB::commit();
            if (!$setting) {
                return redirect()->back()->with('error', 'Error in updating settings');
            }
            return redirect()->back()->with('success', 'Setting updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);
        }
    }
}
