<?php

namespace App\Model;

use App\App;
use App\DB;

class Model
{

    protected DB $pdo;
    public function __construct()
    {
        $this->pdo = App::$db;
    }
}