<?php
/*
 * This file is part of the php-odbc-impala package.
 *
 * (c) Tris <tris_10@sina.com>
 */

namespace Odbc\Impala;

/**
 * Class ImpalaConnection
 * @package Odbc\Impala
 * @author Tris <tris_10@sina.com>
 */
class ImpalaConnection {

    private static $connectHandle;

    public static function getConnection($dsn, $user, $password)
    {
        if (!isset(self::$connectHandle) || empty(self::$connectHandle)) {
            self::$connectHandle = odbc_connect($dsn, $user, $password);
        }

        return self::$connectHandle;
    }

    public function disconnect()
    {
        if (!empty(self::$connectHandle)) {
            odbc_close(self::$connectHandle);
        }
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}