<?php

namespace lib;

use mysqli;

class DB
{
    protected static $db_host = DB_HOST;
    protected static $db_user = DB_USER;
    protected static $db_pass = DB_PASS;
    protected static $db_name = DB_NAME;

    protected static $conn    = null;
    protected static $res     = null;
    protected static $query   = null;

    public static function initDefault()
    {
        self::init(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
    }

    public static function init($db_host, $db_user, $db_pass, $db_name)
    {
        self::$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if (self::$conn->connect_errno) {
            die('Error de conexion:' . self::$conn->connect_errno);
        }
    }

    public static function close()
    {
        mysqli_close(self::$conn);
    }

    public static function query($query = null)
    {
        if ($query === null) {
            $query = self::$query;
        }

        self::$res = self::$conn->query($query);

        return new self();
    }

    public static function get()
    {
        if (self::$query !== null) {
            self::$res = self::$conn->query(self::$query);
        }
        return self::$res->fetch_all(MYSQLI_ASSOC);
    }

    public static function push()
    {
        if (self::$query !== null) {
            self::$res = self::$conn->query(self::$query);
        }
        return;
    }

    public static function pop()
    {
        self::push();
        return;
    }

    public static function select($table, $columns = '*')
    {
        self::$query = "SELECT {$columns} FROM {$table}";
        return new self();
    }

    public static function insert($table, $data)
    {
        $key = array_keys($data);
        $key = implode(', ', $key);

        $value = array_values($data);
        $value = "'" . implode("', '", $value) . "'";

        self::$query = "insert into {$table} ({$key}) values ({$value})";
        return new self();
    }

    public static function update($table, $data)
    {
        $list = [];

        foreach ($data as $key => $value) {
            $list[] = "{$key} = '{$value}'";
        }

        $list = implode(', ', $list);
        self::$query = "update {$table} set {$list}";

        return new self();
    }

    public static function delete($table)
    {
        self::$query = "delete from {$table}";
        return new self();
    }

    public static function where($key, $operator = null, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $value = self::$conn->real_escape_string($value);

        if (strpos(self::$query, 'WHERE') === false) {
            self::$query .= " WHERE {$key} {$operator} '{$value}'";
        } else {
            self::$query .= " AND {$key} {$operator} '{$value}'";
        }
        return new self();
    }
}
