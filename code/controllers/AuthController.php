<?php

namespace app\controllers;

use app\core\App;
use app\core\Request;
use app\core\Response;
use app\models\User;

class AuthController extends Controller
{
	private const TOKEN = 'token';
	private const EMAIL = 'email';

	public function auth(Request $request, Response $response)
	{
		//TODO send email with token
		//TODO verify if the token is valid!
		//we now need to log in the user!
		//"email: " . $_SESSION[self::EMAIL] . " token: " . $_POST[self::TOKEN];
		$session = App::$app->session;
		if (isset($_POST[self::TOKEN]))
		{
			$user = new User($session->get(self::EMAIL), $request->getValueFor(self::TOKEN));
			//TODO implement error when logging in
			$user->login();
			$response->setStatusCode(200);
			$response->redirect("/");
			return null;
		}

		$session->set(self::EMAIL, $_POST[self::EMAIL]);
		$response->setStatusCode(200);
		$this->setTitle("authentication");
		return $this->render('auth_token');
	}

	public function authEmail(Request $request, Response $response)
	{
		$response->setStatusCode(200);
		$this->setTitle("authentication");
		return $this->render('auth_email');
	}

	public function logout(Request $request, Response $response) : void
	{
		App::$app->logout();
		$response->redirect('/');
	}
}