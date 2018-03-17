<?php

namespace Core;

/**
 * Class Controller
 * @package Core
 */
abstract class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * @param array $params Routing params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     * @throws \Exception
     */
    public function __call($name, array $args)
    {
        $method = "{$name}Action";

        if (!method_exists($this, $method)) {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }

        if ($this->before() !== false) {
            call_user_func_array([$this, $method], $args);
            $this->after();
        }
    }

    /**
     * Before filter - called before an action method.
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     */
    protected function after()
    {
    }
}
