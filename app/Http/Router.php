<?php

namespace App\Http;

use Closure;
use Exception;

class Router
{
  private string $url = '';
  private string $prefix = '';
  private array $routes = [];
  private Request $request;

  public function __construct(string $url)
  {
    $this->request = new Request();
    $this->url = $url;
  }

  private function addRoute(string $method, string $route, array $params = [])
  {
    foreach ($params as $key => $value) {
      if ($value instanceof Closure) {
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }

    $pattern = '/^' . str_replace('/', '\/', $route) . '$/';

    $this->routes[$pattern][$method] = $params;
  }

  private function getUri(): string
  {
    $uri = $this->request->getUri();
    return $uri;
  }

  private function getRoute(): array
  {
    $uri = $this->getUri();

    $httpMethod = $this->request->getHttpMethod();

    foreach ($this->routes as $pattern => $method) {
      if (preg_match($pattern, $uri)) {
        if ($method[$httpMethod]) {
          return $method[$httpMethod];
        }

        throw new Exception('Método não permitido', 405);
      }
    }

    throw new Exception('URL não encontrada', 404);
  }

  public function run(): Response
  {
    try {
      $route = $this->getRoute();

      if (!isset($route['controller'])) {
        throw new Exception('A URL não pôde ser processada', 500);
      }

      $args = [];
      return call_user_func_array($route['controller'], $args);
    } catch (Exception $e) {
      return new Response($e->getMessage(), $e->getCode());
    }
  }

  public function get(string $route, array $params = [])
  {
    return $this->addRoute('GET', $route, $params);
  }
}
