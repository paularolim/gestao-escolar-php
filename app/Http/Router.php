<?php

namespace App\Http;

use Closure;
use Exception;
use ReflectionFunction;
use \App\Http\Middlewares\Queue as MiddlewareQueue;

class Router
{
  private string $url = '';
  private string $prefix = '';
  private array $routes = [];
  private Request $request;

  public function __construct(string $url)
  {
    $this->request = new Request($this);
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

    $params['middlewares'] = $params['middlewares'] ?? [];

    $params['variables'] = [];
    $patternVariables = '/{(.*?)}/';
    if (preg_match_all($patternVariables, $route, $matches)) {
      $route = preg_replace($patternVariables, '(.*?)', $route);
      $params['variables'] = $matches[1];
    }

    $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

    $this->routes[$patternRoute][$method] = $params;
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
      if (preg_match($pattern, $uri, $matches)) {
        if (isset($method[$httpMethod])) {
          unset($matches[0]);

          $keys = $method[$httpMethod]['variables'];
          $method[$httpMethod]['variables'] = array_combine($keys, $matches);
          $method[$httpMethod]['variables']['request'] = $this->request;

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

      $reflection = new ReflectionFunction($route['controller']);
      foreach ($reflection->getParameters() as $parameter) {
        $name = $parameter->getName();
        $args[$name] = $route['variables'][$name] ?? '';
      }

      return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);
    } catch (Exception $e) {
      return new Response($e->getMessage(), $e->getCode());
    }
  }

  // redirect url
  public function redirect(string $route): void
  {
    $url = $this->url . $route;

    header('Location: ' . $url);
    exit;
  }

  public function get(string $route, array $params = [])
  {
    return $this->addRoute('GET', $route, $params);
  }

  public function post(string $route, array $params = [])
  {
    return $this->addRoute('POST', $route, $params);
  }
}
