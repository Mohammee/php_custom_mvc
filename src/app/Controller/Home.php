<?php

namespace App\Controller;

use App\App;
use App\View;

class Home
{

    public function index()
    {

       if(! isset($_SESSION['AUTH'])){
           header('Location: /login');
           exit;
       }

        return View::make('index', [
            'name' => 'mohamamd'
        ]);
    }
}