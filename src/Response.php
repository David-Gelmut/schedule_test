<?php

namespace src;

class Response
{
    public function json(bool $status, string $message = '', mixed $errors = [], mixed $error_store = [])
    {
        return json_encode([
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
            'error_store' => $error_store,
        ]);
    }
}