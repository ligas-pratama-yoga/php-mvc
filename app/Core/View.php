<?php

namespace App\Core;

class View
{
	/**
	 * @return string|string[]
	 */
	public function render(string $view, ?array $variables = [], ?string $template = "index"): string
	{
		ob_start();
		extract($variables);
		echo $this->templateExist($template) ?
		require $this->template($template) : "{{content}}";
		ob_start();
		require dirname(__DIR__) . "/../views/$view.php";
		$content = ob_get_clean();
		$output = ob_get_clean();
		return str_replace("{{content}}", $content, $output);
	}

	public function templateExist(string $template): bool
	{
		return file_exists(dirname(__DIR__) . "/../views/templates/$template.php");
	}

	public function template(string $template): string
	{
		return dirname(__DIR__) . "/../views/templates/{$template}.php";
	}

	public function getViewVariable()
	{
		//TODO:Implementasi pengambilan variabel dari view
	}
}
