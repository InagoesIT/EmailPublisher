<?php

namespace app\controllers;
use app\core\App;

class Controller
{
	private string $layout = 'main';
	private string $title = 'email publisher';

	public function render($view, $params = [])
	{
		return App::$app->view->renderView($view, $params);
	}

	/**
	 * @return string
	 */
	public function getLayout(): string
	{
		return $this->layout;
	}

	/**
	 * @param string $layout
	 */
	public function setLayout(string $layout): void
	{
		$this->layout = $layout;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title): void
	{
		$this->title = $title;
	}
}