<?php

namespace app\core;

use app\controllers\SiteController;
use app\controllers\Controller;
use app\models\User;

class App
{
	public static App $app;
	public Router $router;
	public Response $response;
	protected Request $request;
	public Controller $controller;
	public Database $db;
	public Session $session;
	public ?DbModel $user;
	public View $view;

	public function __construct(array $config)
	{
		self::$app = $this;
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->router = new Router($this->request, $this->response);
		$this->db = new Database($config['db']);
		$this->view = new View();

		$primaryValue = $this->session->get('user');
		if ($primaryValue)
		{
			$primaryKey = User::primaryKey();
			$this->user = User::findOne([$primaryKey => $primaryValue]);
		}
		else
			$this->user = null;
	}

	public function run(): void
	{
		echo $this->router->resolve();
	}

	/**
	 * @return Controller
	 */
	public function getController() : Controller
	{
		return $this->controller;
	}

	/**
	 * @param Controller $controller
	 */
	public function setController(Controller $controller): void
	{
		$this->controller = $controller;
	}

	public function login(DbModel $user): bool
	{
		$this->user = $user;
		$primaryKey = $user->primaryKey();
		$primaryValue = $user->{$primaryKey};
		$this->session->set('user', $primaryValue);
		return true;
	}

	public function logout()
	{
		$this->user = null;
		$this->session->remove('user');
	}

	public static function isUser() : bool
	{
		return self::$app->user !== null;
	}
}