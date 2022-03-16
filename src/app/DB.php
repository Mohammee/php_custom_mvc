<?php

namespace App;

/**
 * @mixin \PDO
 */
class DB
{

    private \PDO $pdo;
    private static ?DB $instance = null;

    public function __construct(private array $config)
    {
        $defaultOptions = [
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new \PDO(
                $config['driver'].':host='.$config['host'].';dbname='.$config['name'],
                $this->config['username'],
                $this->config['pass'],
                $this->config['options'] ?? $defaultOptions
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function make(array $config)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}