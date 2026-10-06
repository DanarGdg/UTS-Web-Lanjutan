<?php

require_once __DIR__ . '/../../core/Controller.php';

class AccountController extends Controller {

    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }
    }

    // Menampilkan daftar akun
    public function index() {
        $this->checkAuth();
        
        $accountModel = $this->model('Account');
        $accountTypeModel = $this->model('AccountType');

        $accounts = $accountModel->getAccounts();
        $accountTypes = $accountTypeModel->getAccountType();

        $data = [
            'title' => 'Manajemen Akun',
            'activeMenu' => 'account',
            'accounts' => $accounts,
            'accountTypes' => $accountTypes,
            'flash_success' => $_SESSION['flash_success'] ?? '',
            'flash_error' => $_SESSION['flash_error'] ?? ''
        ];

        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        $this->view('account/index', $data);
    }

    // Menambah akun baru
    public function store() {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $accountTypeId = $_POST['account_type_id'] ?? '';
        $status = $_POST['status'] ?? 'Aktif';
        $identificationNumber = trim($_POST['identification_number'] ?? '');
        $identificationType = $_POST['identification_type'] ?? 'NIM';

        if (empty($name) || empty($email) || empty($password) || empty($identificationNumber)) {
            $_SESSION['flash_error'] = 'Semua field wajib diisi.';
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $accountModel = $this->model('Account');

        // Check duplicate email
        if ($accountModel->findByEmail($email)) {
            $_SESSION['flash_error'] = 'Email sudah digunakan.';
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $created = $accountModel->createAccount([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'account_type_id' => $accountTypeId,
            'status' => $status,
            'identification_number' => $identificationNumber,
            'identification_type' => $identificationType
        ]);

        if ($created) {
            $_SESSION['flash_success'] = 'Akun baru berhasil ditambahkan!';
        } else {
            $_SESSION['flash_error'] = 'Gagal menambahkan akun baru.';
        }

        header('Location: ' . BASE_URL . 'index.php?url=account');
        exit;
    }

    // Mengubah data akun
    public function update($id = null) {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $accountTypeId = $_POST['account_type_id'] ?? '';
        $status = $_POST['status'] ?? 'Aktif';
        $identificationNumber = trim($_POST['identification_number'] ?? '');
        $identificationType = $_POST['identification_type'] ?? 'NIM';

        if (empty($name) || empty($email) || empty($identificationNumber)) {
            $_SESSION['flash_error'] = 'Semua field wajib diisi.';
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $accountModel = $this->model('Account');
        $updated = $accountModel->updateAccount($id, [
            'name' => $name,
            'email' => $email,
            'account_type_id' => $accountTypeId,
            'status' => $status,
            'identification_number' => $identificationNumber,
            'identification_type' => $identificationType
        ]);

        if ($updated) {
            $_SESSION['flash_success'] = 'Data akun berhasil diperbarui!';
        } else {
            $_SESSION['flash_error'] = 'Gagal memperbarui data akun.';
        }

        header('Location: ' . BASE_URL . 'index.php?url=account');
        exit;
    }

    // Menghapus akun (soft delete)
    public function delete($id = null) {
        $this->checkAuth();

        if (empty($id)) {
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $accountModel = $this->model('Account');
        $deleted = $accountModel->deleteAccount($id);

        if ($deleted) {
            $_SESSION['flash_success'] = 'Akun berhasil dihapus!';
        } else {
            $_SESSION['flash_error'] = 'Gagal menghapus akun.';
        }

        header('Location: ' . BASE_URL . 'index.php?url=account');
        exit;
    }
}
