<?php

namespace lib;

class Request
{
    private $request = null;

    public function __construct()
    {
        $this->request = file_get_contents('php://input');
    }

    public function get($key)
    {
        $res = json_decode($this->request, true);
        return  array_key_exists($key, $res) ? [$key => $res[$key]] : null;
    }

    public function getValue($key)
    {
        $res = json_decode($this->request, true);
        return array_key_exists($key, $res) ? $res[$key] : null;
    }

    public function isKey($key)
    {
        $res = json_decode($this->request, true);
        return array_key_exists($key, $res) ? true : false;
    }


    public function getAll()
    {
        return $this->request;
    }
}
