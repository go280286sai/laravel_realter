<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OlxApartment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getFiles(Request $request): void
    {
        try {
            $name = $request->get('name');
            OlxApartment::uploadImage($name, $request->file('file'));
            Log::info('UploadImage:'.Auth::id());

        } catch (\Exception $e) {
            Log::info('Error UploadImage:'.Auth::id());
        }
    }

    public function getMae(Request $request): void
    {
        try {
            $value = $request->json('mae');
            Setting::addSetting(['name' => 'mae', 'text' => $value]);
            Log::info('AddSetting:'.Auth::id());
        } catch (\Exception $e) {
            Log::info('Error AddSetting:'.Auth::id().' '.$e->getMessage().' Date'.date('Y-m-d H:i:s'));
        }
    }
}
