<?php

namespace app\core;

class Request
{
	public function getPath()
	{
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');

		if ($position === false)
			return $path;

		return substr($path, $position);
	}

	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getBody()
	{
		$body = [];

		if ($this->getMethod() === 'get')
		{
			foreach ($_GET as $key => $value)
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
		}
		else if ($this->getMethod() === 'POST')
		{
			foreach ($_GET as $key => $value)
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
		}

		return $body;
	}

	public function isGet()
	{
		return $this->getMethod() == 'GET';
	}

	public function isPost()
	{
		return $this->getMethod() == 'POST';
	}
}