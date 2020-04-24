<?php
/**
 * Impala odbc driver
 * @author Tris
 * Date: 2020-04-24
 */

namespace Odbc\Impala;


use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;

class Impala {
    /**
     * @var SessionManager
     */
    protected $session;
    /**
     * @var Repository
     */
    protected $config;
    /**
     * Impala constructor.
     * @param SessionManager $session
     * @param Repository $config
     */
    public function __construct(SessionManager $session, Repository $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     * @param string $msg
     * @return string
     */
    public function test_rtn($msg = ''){
        $config_arr = $this->config->get('impala.options');
        return $msg.' <strong>from your custom develop package!</strong>>';
    }

    public function showTables() {
        $handle = odbc_connect("MyImpala", "", "");
        $result = odbc_exec($handle, "show tables");
        $tables = [];
        while ($row = odbc_fetch_array($result)) {
            $tables[] = $row;
        }

        return $tables;
    }

}