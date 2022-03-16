<?php

namespace App;

use App\Exception\NotFoundException;

class View
{
    public function __construct(protected string $path, protected array $params = [])
    {
    }

    public static function make(string $path, array $params = [])
    {
        return (new self($path, $params))->render();
    }

    private function render(): string
    {
        $file = __VIEW_PATH__.$this->path.'.php';

        if(! file_exists($file)){
            throw new NotFoundException();
        }

        extract($this->params);

        ob_start();
        include $file;
        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
       return $this->render();
    }

}