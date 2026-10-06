<?php

require_once __DIR__ . '/../../core/Controller.php';

class AccountTypeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Tipe Akun',
            'activeMenu' => 'account_type'
        ];
        $this->view('account_type/index', $data);
    }
}
