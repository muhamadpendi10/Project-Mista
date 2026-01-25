<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class DeviceHelper
{
    public static function generate(Request $request): string
    {
        $userAgent = $request->userAgent();
        $ip = $request->ip();
        $language = $request->header('Accept-Language');

        return hash('sha256', $userAgent . '|' . $ip . '|' . $language);
    }

    public static function name(Request $request): string
    {
        return $request->userAgent();
    }
}
