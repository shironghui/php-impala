<?php
/**
 * Impala odbc driver
 * @author Tris<tris_10@sina.com>
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
     * @var ImpalaConnection
     */
    private $connection;
    /**
     * @var Table name
     */
    private $table;
    /**
     * Impala constructor.
     * @param SessionManager $session
     * @param Repository $config
     */
    public function __construct(SessionManager $session, Repository $config)
    {
        $this->session = $session;
        $this->config = $config;
        $this->connection = ImpalaConnection::getConnection(
            $this->config->get('impala.DSN'),
            $this->config->get('impala.USER'),
            $this->config->get('impala.PASSWORD')
        );
    }

    public function setTable($tableName){
        if (empty($tableName)) {
            return FALSE;
        }

        $this->table = $tableName;
    }

    /**
     * 查询单表单条数据
     * @param array $whereArray
     * @param string $fields
     * @param string $orderBy
     * @return array|bool
     */
    public function getFirst($whereArray = [], $fields = "*", $orderBy = NULL) {
        if (empty($this->table)) {
            return FALSE;
        }

        $sql = $this->buildWhereSql($whereArray, $fields, 1, 1, $orderBy);
        return $this->execute($sql);
    }

    /**
     * 分页查询单表数据
     * @param array  $whereArray
     * @param string $fields
     * @param int    $page
     * @param int    $pageSize
     * @param null   $orderBy
     * @return array|bool
     */
    public function getList($whereArray = [], $fields = "*", $page = 1, $pageSize = 10, $orderBy = NULL) {
        if (empty($this->table)) {
            return FALSE;
        }

        $sql = $this->buildWhereSql($whereArray, $fields, $page, $pageSize, $orderBy);
        return $this->execute($sql);
    }

    /**
     * 查询自定义SQL
     * @param $sql
     * @return array|bool
     */
    public function execute($sql) {
        if (empty($sql)) {
            return FALSE;
        }

        try {
            $resource = odbc_exec($this->connection, $sql);
            $response = [];
            while ($row = odbc_fetch_array($resource)) {
                $response[] = $row;
            }
        } catch (\Exception $exception) {
            $response = NULL;
        }

        return $response;
    }

    /**
     * 构建SQL where语句
     * @param array $whereArray
     * @param string $field
     * @param null   $page
     * @param null   $pageSize
     * @param null   $orderByField
     * @return string
     */
    private function buildWhereSql($whereArray, $field = '*', $page = NULL, $pageSize = NULL, $orderByField = NULL) {
        $conditions = (is_array($whereArray) && $whereArray) ? implode(' AND ', $whereArray) : '1 = 1';
        $sql = 'SELECT ' . $field . ' FROM ' . $this->table . ' WHERE ' . $conditions;
        if ($orderByField) {
            $sql .= ' ORDER BY ' . $orderByField;
        }
        if ($page && $pageSize) {
            $sql .= ' LIMIT ' . $pageSize . ' OFFSET ' . ($page - 1) * $pageSize;
        }

        return $sql;
    }
}