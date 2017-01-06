<?php
namespace Pentagonal\SlimHelper\SlimOverride;

use Slim\Interfaces\RouteGroupInterface;

/**
 * Class Router
 * @package Pentagonal\SlimHelper\SlimOverride
 */
class Router extends \Slim\Router
{
    /**
     * Add a route group to the array
     *
     * @param string   $pattern
     * @param callable $callable
     *
     * @return RouteGroupInterface
     */
    public function pushGroup($pattern, $callable)
    {
        $group = new RouteGroup($pattern, $callable);
        array_push($this->routeGroups, $group);
        return $group;
    }

    /**
     * Removes the last route group from the array
     *
     * @return RouteGroup|bool The RouteGroup if successful, else False
     */
    public function popGroup()
    {
        $group = array_pop($this->routeGroups);
        return $group instanceof RouteGroup ? $group : false;
    }

    /**
     * @return mixed|\Slim\RouteGroup
     */
    public function getCurrentGroup()
    {
        return current($this->routeGroups);
    }
}
