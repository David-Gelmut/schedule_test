<?php

namespace src;

class Application
{
    public static Application $app;
    public Router $router;
    public ?Database $database;

    public function __construct()
    {
        self::$app = $this;
        $this->database = Database::getInstance();
        $this->router = new Router();
    }

    public function run()
    {
        $this->router->run();
    }
}