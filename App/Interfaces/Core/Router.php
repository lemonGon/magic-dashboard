<?php

namespace App\Interfaces\Core;

/**
 * Interface Router
 * @package App\Interfaces\Core
 */
interface Router
{
    public function add($route, array $params);

    public function match($url);

    public function dispatch($url);
}
