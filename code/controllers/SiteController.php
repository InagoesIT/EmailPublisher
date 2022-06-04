<?php

namespace app\controllers;

class SiteController extends Controller
{
	public function welcome()
	{
		return $this::render('welcome');
	}
}