<?php
namespace App\Controllers;


class HomeController
{
    public function index()
    {
        // echo 'hello from controller';
        return view('home');
    }
}