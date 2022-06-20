<?php

namespace app\controllers;

use app\core\App;

class SiteController extends Controller
{
	public function home()
	{
		if (App::isUser())
            if (App::$app->user->getEmail() == 'emailpublisherweb@gmail.com')
                return $this::render('admin');
			else return $this::render('home');
		return $this::render('welcome');
	}
}