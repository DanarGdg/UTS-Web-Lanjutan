<?php

require_once __DIR__ . '/AuthController.php';

// Controller alias untuk rute register yang menginduk pada AuthController
class RegisterController extends AuthController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegister();
        } else {
            $this->register();
        }
    }
}

