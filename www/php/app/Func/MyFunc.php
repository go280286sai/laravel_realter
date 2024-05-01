<?php

namespace App\Func;


use App\Models\OlxApartment;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MyFunc
{
    /**
     * @param array $fields
     * @return array
     */
    public static function stripTags(array $fields): array
    {
        return array_map(function ($item) {
            return strip_tags($item);
        }, $fields);
    }

    /**
     * @return array
     */
    public static function getLocation(): array
    {
        if (Cache::has('location')) {
            $location = Cache::get('location');
        } else {
            $location = OlxApartment::all('location')->groupBy('location')->toArray();
            Cache::put('location', $location);
        }

        return array_keys($location);
    }

    /**
     * @return mixed
     */
    public static function getDollar(): mixed
    {
        if (Rate::latest()->get('dollar')->isEmpty()) {
            return 0;
        }
           return Rate::latest()->get('dollar')[0]->dollar;
    }

    /**
     * @return mixed
     */
    public static function getToken()
    {
        $token = DB::table('personal_access_tokens')->where('tokenable_id', '=', Auth::id())->select('token')->get();
        if (count($token) > 0) {
            $token = $token[0]->token;
        } else {
            $token = Auth::user()->createToken('API TOKEN')->plainTextToken;
        }

        return $token;
    }

    /**
     * @param string $text
     * @return array
     */
    public static function getListToArray(string $text): array
    {
        $array = explode(',', substr($text, 0, strlen($text) - 1));
        $object = DB::table('olx_apartments')
            ->where('deleted_at','=',null)
            ->whereIn('id', $array)
            ->get();

        return [$object, $array];
    }
}
