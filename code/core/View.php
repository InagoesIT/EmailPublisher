<?php

namespace app\core;

class View
{
	public string $title = '';

	public function renderView($view, $params = [])
	{
		$viewContent = $this->renderViewOnly($view, $params);
		$layoutContent = $this->layoutContent();
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	protected function layoutContent()
	{
		$layout = App::$app->getController()->getLayout();
		ob_start();
		include_once "../views/layouts/$layout.php";
		return ob_get_clean();
	}

	protected function renderViewOnly($view, $params = [])
	{
		//pass all the params to the view
		foreach ($params as $key => $value)
		{
			$$key = $value;
		}
		ob_start();
		//display the home page if the user is logged in
		if ($view === 'welcome' && App::isUser())
			$view = 'home';
		include_once "../views/$view.php";
		return ob_get_clean();
	}
}