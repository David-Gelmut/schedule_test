<?php

namespace src;

class Request
{
    public function getURI(): string
    {
        return trim(urldecode($_SERVER["REQUEST_URI"]), '/');
    }

    public function validation(): array
    {
        $errors = [];
        if ($this->isPost()) {
            foreach ($_POST as $key => $param) {
                if (empty($param)||$param == 0) {
                    $errors[$key] = 'Заполните поле';
                }
            }
        }
        return $errors;
    }

    public function htmlspecialcharsPrepareRequest(): array
    {
        $requestArray = $this->isGet() ? $_GET : $_POST;
        array_map(function ($item) {
            return htmlspecialchars($item);
        }, $requestArray);
        return $requestArray;
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    public function isGet(): bool
    {
        return $this->getMethod() == 'GET';
    }

    public function isPost(): bool
    {
        return $this->getMethod() == 'POST';
    }
}