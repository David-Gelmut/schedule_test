<?php
require_once '../../config/core.php';
require_once '../../helpers/helpers.php';
setEnvData();
spl_autoload_register(function (string $classname) {
    require_once(ROOT . '/' . implode('/', explode('\\', $classname)) . '.php');
});

$request = new \src\Request();
$response = new \src\Response();

if (!$request->isAjax()) {
  echo $response->json(false, 'Это не Ajax запрос');
  die();
}

$errors = $request->validation();
if (count($errors) > 0) {
    echo $response->json(false, 'Ошибки валидации', $errors);
    die();
}

$fieldsRequest = $request->htmlspecialcharsPrepareRequest();
echo $request->ajaxRequest($response, $fieldsRequest);
die();






