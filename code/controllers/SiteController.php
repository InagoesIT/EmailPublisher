<?php

namespace app\controllers;

use app\core\App;

class SiteController extends Controller
{
	public function home()
	{
		if (App::isUser())
			return $this::render('home');
		return $this::render('welcome');
	}
}