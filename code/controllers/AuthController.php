<?php

namespace app\controllers;

use app\core\App;
use app\core\Request;
use app\core\Response;

class AuthController extends Controller
{
	public function auth(/*Request $request = , Response $response*/)
	{
		//verify if the token is valid!
		if (isset($_POST['token']))
			return  "email: " . $_SESSION['email'] . " token: " . $_POST['token'];

		$_SESSION['email'] = $_POST['email'];
		$this->setLayout('auth');
		return $this->render('auth_token');
	}

	public function authEmail()
	{
		$this->setLayout('auth');
		return $this->render('auth_email');
	}

	public function logout(Request $request, Response $response) : void
	{
		App::$app->logout();
		$response->redirect('/');
	}
}