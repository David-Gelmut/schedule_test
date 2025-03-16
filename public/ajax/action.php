<?php
require_once '../../config/core.php';
require_once '../../helpers/helpers.php';
spl_autoload_register(function (string $classname) {
    require_once(ROOT . '/' . implode('/', explode('\\', $classname)) . '.php');
});

$request = new \src\Request();

if(!$request->isAjax()){
    echo json_encode([
        'status' => false,
        'message'=>"Это не Ajax запрос"
    ]);
    die();
}

$errors = $request->validation();
$fieldsRequest = $request->htmlspecialcharsPrepareRequest();

if (count($errors) > 0) {
    echo json_encode([
        'status' => false,
        'message' => 'Оишибки валидации',
        'errors' => $errors
    ]);
    die();
}

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
    if($method == 'store'){
        if($schedulesResult['status']){
            echo json_encode([
                'status' => true,
                'message' => 'Данные сохранены',
            ]);
            die();
        }
        if(isset($schedulesResult['data'])){
            echo json_encode([
                'status' => false,
                'message' => 'Курьер вне доступа',
                'error_store' =>  $schedulesResult['data']
            ]);
            die();
        }
        echo json_encode([
            'status' => false,
            'message' => 'Ошибка при сохранении в базе'
        ]);
        die();
    }

    if($method == 'filter'){

    }
}






