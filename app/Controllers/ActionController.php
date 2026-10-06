<?php

require_once __DIR__ . '/../../core/Controller.php';

class ActionController extends Controller {
    public function index() {
        $data = [
            'title' => 'Jenis Aksi',
            'activeMenu' => 'action'
        ];
        $this->view('action/index', $data);
    }
}
