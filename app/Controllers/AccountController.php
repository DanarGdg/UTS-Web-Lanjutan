<?php

require_once __DIR__ . '/../../core/Controller.php';

class AccountController extends Controller {
    public function index() {
        $data = [
            'title' => 'Manajemen Akun',
            'activeMenu' => 'account'
        ];
        $this->view('account/index', $data);
    }
}
