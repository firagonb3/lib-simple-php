<?php

namespace controllers;

use lib\DB;
use lib\Render;
use lib\Request;

class HomeController 
{
    public function create()
    {
        return Render::view('view.Home');
    }

    public function store(Request $req)
    {
        return DB::select('users')->where('pass', $req->getValue('key2'))->get();
    }
}
