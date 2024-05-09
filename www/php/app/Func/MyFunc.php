<?php

namespace App\Func;


use App\Models\OlxApartment;
use App\Models\Rate;
use Exception;
use Illuminate\Http\Request;
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
//        if (Cache::has('location')) {
//            $location = Cache::get('location');
//        } else {
//            $location = OlxApartment::all('location')->groupBy('location')->toArray();
//            Cache::put('location', $location);
//        }
            $location = OlxApartment::all('location')->groupBy('location')->toArray();

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
     * @return array
     */
    public static function getToken(): array
    {
        $token =Auth::user()->createToken(Auth::user()->name);

        return ['token' => $token->plainTextToken];

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
