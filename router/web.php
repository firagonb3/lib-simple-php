<?php

use lib\Router;

use controllers\HomeController;
use controllers\MainLayoutController;

Router::get('/', [MainLayoutController::class, 'create']);
Router::get('/:content', [MainLayoutController::class, 'create']);
Router::get('/public/home', [HomeController::class, 'create']);

Router::post('/', [HomeController::class, 'store']);
