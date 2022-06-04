<?php

namespace app\core;
class Router
{
	protected array $routes = [];
	protected Request $request;
	public Response $response;

	/**
	 * @param Request $request
	 * @param Response $response
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function get($path, $callback): void
	{
		$this->routes['GET'][$path] = $callback;
	}

	public function post($path, $callback): void
	{
		$this->routes['POST'][$path] = $callback;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		$callback = $this->routes[$method][$path] ?? false;

		if (!$callback)
		{
			App::$app->response->setStatusCode(404);
			return "NOT FOUND";
		}

		if(is_string($callback))
			return App::$app->view->renderView($callback);

		if (is_array($callback))
		{
			App::$app->setController(new $callback[0]());
			$callback[0] = App::$app->getController();
		}

		return call_user_func($callback, $this->request, $this->response);
	}
}