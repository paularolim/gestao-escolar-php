<?php

namespace App\Http\Middlewares;

use App\Http\Request;
use App\Http\Response;
use Closure;

class Queue
{
  public static array $map = [];
  public static array $mapDefault = [];

  private array $middlewares = [];
  private array $defaultMiddlewares = [];
  private Closure $controller;
  private array $controllerArgs = [];

  public function __construct(array $middlewares, Closure $controller, array $controllerArgs)
  {
    $this->middlewares = array_merge($middlewares, self::$mapDefault);
    $this->controller = $controller;
    $this->controllerArgs = $controllerArgs;
  }

  public static function setMap(array $map): void
  {
    self::$map = $map;
  }

  public static function setMapDefault(array $mapDefault): void
  {
    self::$mapDefault = $mapDefault;
  }

  public function next(Request $request): Response
  {
    // verify if queue are empty
    if (empty($this->middlewares))
      return call_user_func_array($this->controller, $this->controllerArgs);

    // current middleware
    $middleware = array_shift($this->middlewares);

    // verify map
    if (!isset(self::$map[$middleware]))
      throw new \Exception('Erro ao processar middleware', 500);

    // next
    $queue = $this;
    $next = function (Request $request) use ($queue) {
      return $queue->next($request);
    };

    // execute middleware
    return (new self::$map[$middleware])->handle($request, $next);
  }
}
