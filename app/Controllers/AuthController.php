<?php

require_once __DIR__ . '/../../core/Controller.php';

class AuthController extends Controller {

    /**
     * Display the login page
     */
    public function index() {
        // Redirect to dashboard if already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $data = [
            'title' => 'Login',
            'error' => '',
            'success' => ''
        ];

        if (isset($_SESSION['login_error'])) {
            $data['error'] = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }

        if (isset($_SESSION['login_success'])) {
            $data['success'] = $_SESSION['login_success'];
            unset($_SESSION['login_success']);
        }

        $this->viewOnly('auth/login', $data);
    }

    /**
     * Display the registration page
     */
    public function register() {
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $accountTypeModel = $this->model('AccountType');
        $accountTypes = $accountTypeModel->getAccountType();

        $data = [
            'title' => 'Daftar Akun Baru',
            'accountTypes' => $accountTypes,
            'error' => ''
        ];

        if (isset($_SESSION['register_error'])) {
            $data['error'] = $_SESSION['register_error'];
            unset($_SESSION['register_error']);
        }

        $this->viewOnly('auth/register', $data);
    }

    /**
     * Process registration submission
     */
    public function storeRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $identificationType = $_POST['identification_type'] ?? 'NIM';
        $identificationNumber = trim($_POST['identification_number'] ?? '');
        $accountTypeId = $_POST['account_type_id'] ?? '';

        // Validation
        if (empty($name) || empty($email) || empty($password) || empty($identificationNumber)) {
            $_SESSION['register_error'] = 'Semua field wajib diisi.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Format email tidak valid.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        $accountModel = $this->model('Account');

        // Check if email already registered
        $existingAccount = $accountModel->findByEmail($email);
        if ($existingAccount) {
            $_SESSION['register_error'] = 'Email ini sudah terdaftar. Silakan gunakan email lain atau langsung login.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        // Fallback for account type if not set or invalid
        $accountTypeModel = $this->model('AccountType');
        if (empty($accountTypeId) || $accountTypeId === 'default') {
            $accountTypeId = $accountTypeModel->getOrCreateDefaultTypeId();
        }

        $created = $accountModel->createAccount([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'account_type_id' => $accountTypeId,
            'status' => 'Aktif',
            'identification_number' => $identificationNumber,
            'identification_type' => $identificationType
        ]);

        if ($created) {
            $_SESSION['login_success'] = 'Akun Anda berhasil didaftarkan! Silakan masuk.';
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        } else {
            $_SESSION['register_error'] = 'Gagal membuat akun baru. Pastikan koneksi database aktif.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }
    }

    /**
     * Process authentication
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Email dan password wajib diisi.';
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }

        $accountModel = $this->model('Account');
        $account = $accountModel->findByEmail($email);

        if (!$account) {
            $_SESSION['login_error'] = 'Email atau password salah.';
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }

        // Verify password (supports bcrypt hash and plain text fallback)
        $isPasswordValid = false;
        if (password_verify($password, $account['password'])) {
            $isPasswordValid = true;
        } elseif ($password === $account['password']) {
            $isPasswordValid = true;
        }

        if (!$isPasswordValid) {
            $_SESSION['login_error'] = 'Email atau password salah.';
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }

        // Authentication successful
        $_SESSION['user_id'] = $account['id'];
        $_SESSION['user_name'] = $account['name'];
        $_SESSION['user_email'] = $account['email'];
        $_SESSION['user_account_type'] = $account['account_type_name'] ?? 'User';

        header('Location: ' . BASE_URL . 'index.php?url=account');
        exit;
    }

    /**
     * Process logout
     */
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_account_type']);
        session_destroy();

        header('Location: ' . BASE_URL . 'index.php?url=auth');
        exit;
    }
}
