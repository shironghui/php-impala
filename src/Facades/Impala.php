<?php
namespace Odbc\Impala\Facades;

use Illuminate\Support\Facades\Facade;
class Impala extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'impala';
    }
}