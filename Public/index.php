<?php

require_once __DIR__.'/../src/Support/helpers.php';
require_once base_path().'vendor/autoload.php';
require_once base_path().'routes/web.php';

use Dotenv\Dotenv;
use Nopel\Http\Route;
use Nopel\Http\Request;
use Nopel\Http\Response;
use Nopel\Support\Arr;
use Nopel\Validation\Rules\AlphaNumericalRule;
use Nopel\Validation\Rules\RequiredRule;
use Nopel\Validation\Validator;

// $route = new Route(new Request, new Response);
// echo '<pre>'; 
// $route->resolve();
// echo '</pre>';

// var_dump(base_path());

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();


$data = [
    'password' => 'nabil',
    'password_confirmation' => 'nabil4',
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

// $valid = new Validator();
// // $valid->setAliases([
    
// // ]);
// $valid->make($data, [
//     'password' => 'required'
// ]);

// dump($valid->errors());