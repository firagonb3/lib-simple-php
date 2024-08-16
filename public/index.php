<?php

require_once '../lib/Init.php';
require_once '../router/web.php';

use lib\DB;
use lib\Render;
use lib\Router;

DB::initDefault();
Render::setBaseHTML('base.Base');
Router::setError404('view.Error404');
Router::dispatch();
DB::close();