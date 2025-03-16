<?php

namespace src;

class View
{
    public function render($view, $data = [], $layout = 'main')
    {

        extract($data);

        $viewFile =  ROOT . "/views/{$view}.php";

        if (is_file($viewFile)) {
            ob_start();
            require $viewFile;
            $content = ob_get_clean();
        }

        $layoutFile = ROOT . "/views/layouts/{$layout}.php";

        if (is_file($layoutFile)) {
            ob_start();
            require_once $layoutFile;
            return ob_get_clean();
        }
    }

   /* public function render(string $view)
    {
        $viewFile = ROOT . '/resources/views/' . $view.'.php';

        if(is_file($viewFile)){
            ob_start();
            require $viewFile;
            $content = ob_get_clean();
        }

        return $content;
    }*/
}