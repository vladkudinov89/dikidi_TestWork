<?php

namespace app;

class Router
{
    protected static Router $instance;
    protected static string $path;

    /**
     * @param string $path
     * @return Router
     */
    public static function getInstance(string $path = ''): Router
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        static::$path = $path;

        return static::$instance;
    }

    /**
     * @param string $route
     * @return string
     */
    public static function to(string $route): string
    {
        if (empty(static::$path)) {
            return $route;
        }
        return static::$path . '/' . $route;
    }

    /**
     *
     * @return string
     */
    public static function getPath(): string
    {
        return static::$path;
    }
}
