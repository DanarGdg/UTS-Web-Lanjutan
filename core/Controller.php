<?php

class Controller {
    public function model($model) {
        require_once __DIR__ . '/../app/Models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        extract($data);
        
        $viewFile = __DIR__ . '/../app/Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            // Content view file to be rendered inside layout
            $contentView = $viewFile;
            require_once __DIR__ . '/../app/Views/layouts/main.php';
        } else {
            die("View file does not exist: " . $viewFile);
        }
    }
}
