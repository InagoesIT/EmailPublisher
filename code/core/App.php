<?php

namespace app\core;

use app\controllers\AuthController;
use app\controllers\MailController;
use app\controllers\PublishController;
use app\controllers\SiteController;
use app\controllers\Controller;
use app\models\Publication;
use app\controllers\StatsController;
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

	public function configureRoutes()
	{

		$this->router->get('/', [SiteController::class, 'home']);
		$this->router->get('/auth', [AuthController::class, 'authEmail']);
		$this->router->post('/auth', [AuthController::class, 'auth']);
		$this->router->get('/logout', [AuthController::class, 'logout']);

        $this->router->get('/stats',[StatsController::class, 'print'] );
        $this->router->post('/stats',[StatsController::class, 'stats'] );

        $this->router->get('/mail', [MailController::class, 'processInbox']);

        // PUBLICATIONS ROUTES
        $publications = Publication::findAll();
        if ($publications != NULL)
            foreach ($publications as $pub) {
                $link = $pub->link;

                $this->router->get('/publication/' . $link, [PublishController::class, 'print']);
                $this->router->post('/publication/' . $link, [PublishController::class, 'getPublish']);

//                $this->router->get('/publication/' . $link . '/stats', [StatsController::class, 'print']);
//                $this->router->post('/publication/' . $link . '/stats', [StatsController::class, 'stats']);


                $this->router->get('/publication/' . $link . '/changeTags', [PublishController::class, 'printChangeTags']);
                $this->router->post('/publication/' . $link . '/changeTags', [PublishController::class, 'changeTags']);

                $this->router->get('/publication/' . $link . '/stats', [StatsController::class, 'print']);
                $this->router->post('/publication/' . $link . '/stats', [StatsController::class, 'stats']);

            }
	}
}