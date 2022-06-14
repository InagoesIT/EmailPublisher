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
		if (isset($_POST[self::TOKEN]))
			return $this->login($request, $response);

		return $this->tokenAuth($response);
	}

	private function login(Request $request, Response $response): string
	{
		$session = App::$app->session;
		$token = $request->getValueFor(self::TOKEN);
		$user = new User($session->get(self::EMAIL));

		//will add the error message
		if (!$user->isTokenValid($token))
		{
			$response->setStatusCode(400);
			$this->setTitle("authentication");
			return $this->render('auth_token', ["isError" => true]);
		}

		$user->login();
		$response->setStatusCode(200);
		$response->redirect("/");
		return "email: " . $_SESSION[self::EMAIL] . " token: " . $_POST[self::TOKEN];
	}

	private function tokenAuth(Response $response)
	{
		$session = App::$app->session;
		$session->set(self::EMAIL, $_POST[self::EMAIL]);

		$user = new User();
		$user->setEmail($_POST[self::EMAIL]);
		$user->generateToken();
		if (!$user->save())
			$user->updateToken();

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