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
                if (empty($param) || $param == 0) {
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

    public function ajaxRequest(Response $response, array $fieldsRequest): false|string
    {
        $action = explode('/', $fieldsRequest['action']);
        unset($fieldsRequest['action']);
        $controllerName = ucfirst($action[0]) . 'Controller';
        $method = $action[1];
        $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once($controllerFile);
            $controllerObject = '\\controllers\\' . $controllerName;
            $controllerObject = new $controllerObject;
            $schedulesResult = $controllerObject->$method($fieldsRequest);
            switch ($method) {
                case 'store':
                    if ($schedulesResult['status']) {
                        return $response->json(true, 'Данные сохранены');
                    }
                    if (isset($schedulesResult['data'])) {
                        return $response->json(false, 'Курьер вне доступа', [], $schedulesResult['data']);
                    }
                    return $response->json(false, 'Ошибка при сохранении в базе');
                case 'filter':
                    if ($schedulesResult) {
                        return $schedulesResult;
                    }
                    return 'Ошибка получения данных';
            }
        }
        return $response->json(false, 'Не найден контроллер');
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