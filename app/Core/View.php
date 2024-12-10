<?php

namespace App\Core;

class View
{
	public $view_path = __DIR__ . "/../../views/";
	private $data = [];
	public static $globalVariable = [];
	public static function render($view = "", $variables = [], $template = "index")
	{
		$class = new static();
		$viewContent = $class->getViewContent($view);
		$templateContent = $class->getTemplateContent($template) ?? "{{content}}";
		$variables = [...$class->data, ...static::$globalVariable];
		ob_start();
		extract($variables);
		eval("?>" . $templateContent);
		$output = ob_get_clean();
		$output = $class->replaceContent($viewContent, $output);
		ob_start();
		eval("?>" . $output);
		return ob_get_clean();
	}


	public function getViewContent($view)
	{
		$content = file_get_contents($this->view_path . "$view.php");
		$viewVariables = $this->getViewVariable($content);
		$this->setData($viewVariables);
		$output = static::handleDirective($content);
		return $output;

	}
	public static function getTemplateContent($template = "index")
	{
		$file_path = (new static())->view_path . "templates/$template.php";
		return file_exists($file_path) ? file_get_contents((new static())->view_path . "templates/$template.php") : "{{content}}";
	}

	private static function replaceContent($view, $template)
	{
		return str_replace("{{content}}", $view, $template);
	}

	private static function handleDirective($content)
	{
		$content = preg_replace("/@define\([\w,\s']+\)/", "", $content);
		$content = preg_replace("/@error\('([\w]+)'\)/", "<?php if(\$error = \$errors['$1'] ?? false): ?>", $content);
		$content = preg_replace("/@enderror/", "<?php endif; ?> ", $content);
		return $content;

	}

	public function getViewVariable($content)
	{
		preg_match_all("/@define\(\'([\w]+)\',\s\'([\w\s]+)\'\)/", $content, $matchAll);
		return array_combine($matchAll[1], $matchAll[2]);
	}

	public function setData($data): void
	{
		if ($this->data !== []) {
			array_push($this->data, $data);
			exit;
		}
		$this->data = $data;
	}
}
