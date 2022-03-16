<?php

namespace App;

use App\Exception\NotFoundException;
use App\Exception\UnauthenticationException;

class App
{
    public static DB $db;

    public function __construct(
        protected Route $route,
        protected string $request_method,
        protected string $uri,
        protected Config $config
    ) {
        self::$db = DB::make($config->db ?? []);
    }

    public function run()
    {
        try {
            echo $this->route->resolve($this->request_method, $this->uri);
        } catch (NotFoundException $e) {
//            http_response_code(404);
            header('HTTP/1.1 404 Not Found');

            throw new $e;
        }catch (UnauthenticationException $e){
            http_response_code(401);

            throw new $e;
        }
    }

}