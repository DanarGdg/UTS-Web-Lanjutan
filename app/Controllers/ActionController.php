<?php

require_once __DIR__ . '/../../core/Controller.php';

class ActionController extends Controller {

    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }
    }

    public function index() {
        $this->checkAuth();
        $data = [
            'title' => 'Jenis Aksi',
            'activeMenu' => 'action'
        ];
        $this->view('action/index', $data);
    }
}
