<?php

namespace KrishnaWijaya\TiniPosReport\Facades;

use Illuminate\Support\Facades\Facade;

class TiniPosReportFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tiniposreport';
    }
}
