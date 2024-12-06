<?php

namespace App\Core;

class View
{
	public array $data = [];
  public static string $viewPath = __DIR__ . "/../../views/";
  public static string $templatePath = __DIR__ . "/../../views/templates/";
	public static array $globalVariable = [];
	/**
	 * @return string|string[]
	 */
	public function render(string $view, ?array $variables = [], ?string $template = "index")
	{
		$contentView = $this->getView($view);
		$variables = [...$variables, ...$this->data, ...static::$globalVariable];
		ob_start();
		extract($variables);
		echo $this->templateExist($template) ?
		require $this->template($template) : "{{content}}";
		ob_start();
    eval("?>".$contentView);
		$content = ob_get_clean();
		$output = ob_get_clean();
		$viewContent = preg_replace("/@define\([\w,\s']+\)/", "", $content);
		$result = str_replace("{{content}}", $viewContent, $output);

    file_put_contents(base_path("views/cache/$view.php"), $result);
    require base_path("views/cache/$view.php");
	}

	public function getView($view)
	{
    // Ambil isi dari view file
    $content = file_get_contents(static::$viewPath . "$view.php");
    // Set variable yang ada di view
    $viewVariables = $this->getViewVariable($content);
    $this->setData($viewVariables);
    // Hilangkan define directive dari konten
		$view = preg_replace("/@define\([\w,\s']+\)/", "", $content);
    // Match semua error directive
		preg_match_all("/@error\('([\w]+)'\)/", $view, $matchAll);
    // Replace error directive
    foreach($matchAll[1] as $key){
      $view = str_replace("@error('$key')", "<?php if(\$error = \$errors['$key'] ?? false): ?>", $view);
      $view = str_replace("@enderror", "<?php endif; ?>", $view);
    }
    return $view;
	}

	public function templateExist(string $template): bool
	{
		return file_exists(dirname(__DIR__) . "/../views/templates/$template.php");
	}

	public function template(string $template): string
	{
		return static::$templatePath . "$template.php";
	}

	public function getViewVariable($content)
	{
		preg_match_all("/@define\(\'([\w]+)\',\s\'([\w\s]+)\'\)/", $content, $matchAll);
		return array_combine($matchAll[1], $matchAll[2]);
	}

	public function setData($data)
	{
		if ($this->data !== []) {
			array_push($this->data, $data);
			exit;
		}
		$this->data = $data;
	}

}
