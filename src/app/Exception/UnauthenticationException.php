<?php

namespace App\Exception;

class UnauthenticationException extends \Exception
{

    public $message = '401 Unauthentication';
}