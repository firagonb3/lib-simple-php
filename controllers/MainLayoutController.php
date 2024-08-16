<?php

namespace controllers;

use lib\DB;
use lib\Render;
use lib\Request;

class MainLayoutController 
{
    public function create($content = 'home')
    {
        $array = [
            'home' => '/', 
            'cosa' => '/cosa'
        ];

        if (!array_key_exists($content, $array)) {
            $content = 'home';
        }

        return Render::view('layout.MainLayot', [
            'content' => $content,
            'MainHeader' => Render::component('components.MainHeader', [
                'list' => $array
            ])
        ]);
    }

    public function store(Request $req)
    {
        return DB::select('users')->where('pass', $req->getValue('key2'))->get();
    }
}
