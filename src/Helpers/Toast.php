<?php

namespace Krishnawijaya\DodiUkirReport\Helpers;

use Illuminate\Support\Facades\Session;

class Toast
{
    public static function success($message)
    {
        self::show('success', $message);
    }

    public static function error($message)
    {
        self::show('error', $message);
    }

    public static function info($message)
    {
        self::show('info', $message);
    }

    public static function warning($message)
    {
        self::show('warning', $message);
    }

    public static function show($type, $message)
    {
        Session::flash('message', $message);
        Session::flash('alert-type', $type);
    }
}
