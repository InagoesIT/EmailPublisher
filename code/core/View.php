<?php

namespace app\core;

class View
{
	public function renderView($view, $params = [])
	{
		$viewContent = $this->renderViewOnly($view, $params);
		$layoutContent = $this->layoutContent();
		$title = App::$app->getController()->getTitle();

		$cssFile = $view;
		if ($cssFile == "auth_email" || $cssFile == "auth_token")
			$cssFile = "auth";

		return str_replace(
			array('{{content}}', '{{css_file}}', '{{title}}'),
			array($viewContent, $cssFile, $title),
			$layoutContent);
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
			$$key = $value;

		ob_start();
		include_once "../views/$view.php";
		return ob_get_clean();
	}
}