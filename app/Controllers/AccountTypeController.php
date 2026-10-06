<?php

require_once __DIR__ . '/../../core/Controller.php';

class AccountTypeController extends Controller {

    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }
    }

    public function index() {
        $this->checkAuth();
        $data = [
            'title' => 'Tipe Akun',
            'activeMenu' => 'account_type'
        ];
        $this->view('account_type/index', $data);
    }
}
