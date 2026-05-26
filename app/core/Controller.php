<?php

abstract class Controller
{
    protected function model(string $model): object
    {
        require_once APP_ROOT . '/app/models/' . $model . '.php';
        return new $model();
    }

    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require APP_ROOT . '/app/views/' . $view . '.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function json(array $payload): void
    {
        header('Content-Type: application/json');
        echo json_encode($payload);
        exit;
    }
}

