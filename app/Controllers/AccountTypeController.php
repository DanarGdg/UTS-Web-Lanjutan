<?php

require_once __DIR__ . '/../../core/Controller.php';

// Controller untuk modul manajemen tipe akun
class AccountTypeController extends Controller {

    // Validasi sesi autentikasi pengguna
    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }
    }

    // Menampilkan halaman utama tipe akun
    public function index() {
        $this->checkAuth();
        $data = [
            'title' => 'Tipe Akun',
            'activeMenu' => 'account_type'
        ];
        $this->view('account_type/index', $data);
    }
}
