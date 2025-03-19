<?php

namespace src;

class Application
{
    public static Application $app;
    public Router $router;
    public ?Database $database;
    public Response $response;
    public Request $request;

    public function __construct()
    {
        self::$app = $this;
        $this->database = Database::getInstance();
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run()
    {
        $this->router->run();
    }
}