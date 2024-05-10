<?php

namespace App\Func;

use App\Models\OlxApartment;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyFunc
{
    public static function stripTags(array $fields): array
    {
        return array_map(function ($item) {
            return strip_tags($item);
        }, $fields);
    }

    public static function getLocation(): array
    {
        $location = OlxApartment::all('location')->groupBy('location')->toArray();

        return array_keys($location);
    }

    public static function getDollar(): mixed
    {
        if (Rate::latest()->get('dollar')->isEmpty()) {
            return 1;
        }

        return Rate::latest()->get('dollar')[0]->dollar;
    }

    public static function getToken(): array
    {
        $token = Auth::user()->createToken(Auth::user()->name);

        return ['token' => $token->plainTextToken];

    }

    public static function getListToArray(string $text): array
    {
        $array = explode(',', substr($text, 0, strlen($text) - 1));
        $object = DB::table('olx_apartments')
            ->where('deleted_at', '=', null)
            ->whereIn('id', $array)
            ->get();

        return [$object, $array];
    }
}
