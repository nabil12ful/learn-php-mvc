<?php

require_once __DIR__.'/../src/Support/helpers.php';
require_once base_path().'vendor/autoload.php';
require_once base_path().'routes/web.php';

use Dotenv\Dotenv;
use Nopel\Http\Route;
use Nopel\Http\Request;
use Nopel\Http\Response;
use Nopel\Support\Arr;

// $route = new Route(new Request, new Response);
// echo '<pre>'; 
// $route->resolve();
// echo '</pre>';

// var_dump(base_path());

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();
$a1 = [
    'db' => [
        'connection' => 
        [
            'default' => 'mysql',
        ]
    ]
];
// var_dump(Arr::only($a1, ['username', 'email']));
// var_dump(Arr::has(['db' => ['connection' => ['default' => 'mysql']]], 'db.connection.default'));

// Arr::forget($a1, 'db.connection.default');
// print_r($a1);
// $a1['db']['connection']['default'] = null;

// $a1 = [1, [2], [3], [[4]], [[[[[5]]]]]];
// Arr::unset($a1, 'db.connection.default');

// dump(config(['database.default' => 'sqlite']));
// dump(config());