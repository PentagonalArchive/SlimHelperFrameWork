<?php
namespace Pentagonal\SlimHelper\SlimOverride;

use Slim\App as Slim;

/**
 * Class RouteGroup
 * @package Pentagonal\SlimHelper\SlimOverride
 */
class RouteGroup extends \Slim\RouteGroup
{
    /**
     * Invoke the group to register any Route able objects within it.
     *
     * @param Slim $app The App to bind the callable to.
     */
    public function __invoke(Slim $app = null)
    {
        $callable = $this->resolveCallable($this->callable);
        if ($callable instanceof \Closure && $app !== null) {
            $callable = $callable->bindTo($app);
        }

        if (is_object($callable) && method_exists($callable, '__invoke')) {
            $callable($app);
        } else {
            call_user_func_array($callable, [$app]);
        }
    }
}
