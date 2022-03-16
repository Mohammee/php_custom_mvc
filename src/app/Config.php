<?php

namespace App;

/**
 * @property-read $db
 */
class Config
{

    private array $config;

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host' => $env['DB_HOST'],
                'driver' => $env['DB_DRIVER'] ?? 'mysql',
                'name' => $env['DB_NAME'],
                'username' => $env['DB_USERNAME'],
                'pass' => $env['DB_PASS'],
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }


}