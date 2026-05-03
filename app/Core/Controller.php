<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    protected function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->view->assign($key, $value);
        }

        $this->view->render($template);
    }

    protected function redirect(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }
}
