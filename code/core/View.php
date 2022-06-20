<?php

namespace app\core;

class View
{
	public function renderView($view, $params = [])
	{
		if ($view == "auth_token")
			return $this->renderAuthToken($view, $params);

		$viewContent = $this->renderViewOnly($view, $params);
		$layoutContent = $this->layoutContent();
		$title = App::$app->getController()->getTitle();

		$cssFile = $view;
		if ($cssFile == "auth_email")
			$cssFile = "auth";

		return str_replace(
			array('{{content}}', '{{css_file}}', '{{title}}'),
			array($viewContent, $cssFile, $title),
			$layoutContent);
	}

	protected function layoutContent($layout = "")
	{
		if ($layout == "")
			$layout = App::$app->getController()->getLayout();
		ob_start();
		include_once "../views/layouts/$layout.php";
		return ob_get_clean();
	}

	public function renderViewOnly($view, $params = [])
	{
		//pass all the params to the view
		foreach ($params as $key => $value)
			$$key = $value;

		ob_start();
		include_once "../views/$view.php";
		return ob_get_clean();
	}

	private function renderAuthToken($view, $params = []) : string
	{
		$viewContent = $this->renderViewOnly($view, $params);
		$layoutContent = $this->layoutContent();
		$title = App::$app->getController()->getTitle();
		$cssFile = "auth";

		$error = "";
 		if (isset($params["isError"]))
			$error = $this->layoutContent("error");

		return str_replace(
			array('{{content}}', '{{css_file}}', '{{title}}', '{{error}}'),
			array($viewContent, $cssFile, $title, $error),
			$layoutContent);
	}
}