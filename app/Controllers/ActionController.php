<?php

require_once __DIR__ . '/../../core/Controller.php';

// Controller untuk modul manajemen jenis aksi
class ActionController extends Controller {

    // Validasi sesi autentikasi pengguna
    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }
    }

    // Menampilkan halaman utama jenis aksi
    public function index() {
        $this->checkAuth();
        $data = [
            'title' => 'Jenis Aksi',
            'activeMenu' => 'action'
        ];
        $this->view('action/index', $data);
    }
}
