<?php

namespace src;

class View
{
    public ?string $content;

    public function render($view, $data = [], $layout = 'main'): false|string
    {
        extract($data);
        $viewFile = ROOT . "/views/{$view}.php";
        if (is_file($viewFile)) {
            ob_start();
            include $viewFile;
            $this->content = ob_get_clean();
        }
        $layoutFile = ROOT . "/views/layouts/{$layout}.php";
        include $layoutFile;

        if (is_file($layoutFile)) {
            ob_start();
            include $layoutFile;
            return ob_get_clean();
        }
        return '';
    }

    public function renderPartial(string $view, $data = []): false|string
    {
        extract($data);
        $viewFile = ROOT . '/views/' . $view . '.php';

        if (is_file($viewFile)) {
            ob_start();
            include $viewFile;
            $content = ob_get_clean();
        }
        return $content;
    }
}