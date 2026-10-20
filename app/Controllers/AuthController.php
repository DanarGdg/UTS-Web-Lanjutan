<?php

require_once __DIR__ . '/../../core/Controller.php';

class AuthController extends Controller {

    // Menampilkan halaman login
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST['submit'])) {
            $this->login();
            return;
        }

        if (isset($_SESSION['user_id']) || isset($_SESSION['username'])) {
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $data = [
            'title' => 'Login',
            'error' => '',
            'validate' => '',
            'success' => '',
            'oldEmail' => ''
        ];

        if (isset($_SESSION['login_error'])) {
            $data['error'] = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }

        if (isset($_SESSION['login_validate'])) {
            $data['validate'] = $_SESSION['login_validate'];
            unset($_SESSION['login_validate']);
        }

        if (isset($_SESSION['login_success'])) {
            $data['success'] = $_SESSION['login_success'];
            unset($_SESSION['login_success']);
        }

        if (isset($_SESSION['old_email'])) {
            $data['oldEmail'] = $_SESSION['old_email'];
            unset($_SESSION['old_email']);
        }

        $this->viewOnly('auth/login', $data);
    }

    // Menampilkan halaman registrasi (form sama seperti Tambah Akun)
    public function register() {
        if (isset($_SESSION['user_id']) || isset($_SESSION['username'])) {
            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        }

        $accountModel = $this->model('Account');
        $accountTypeModel = $this->model('AccountType');

        $accountTypes = $accountTypeModel->getAccountType();
        $usedTypeIds = $accountModel->getUsedAccountTypeIds();

        // Cek apakah ada tipe akun yang tersedia
        $availableCount = 0;
        foreach ($accountTypes as $type) {
            if (!in_array($type['id'], $usedTypeIds)) {
                $availableCount++;
            }
        }

        $data = [
            'title' => 'Register',
            'error' => '',
            'validate' => '',
            'old' => [],
            'accountTypes' => $accountTypes,
            'usedTypeIds' => $usedTypeIds,
            'noTypeAvailable' => ($availableCount === 0)
        ];

        if (isset($_SESSION['reg_error'])) {
            $data['error'] = $_SESSION['reg_error'];
            unset($_SESSION['reg_error']);
        }

        if (isset($_SESSION['reg_validate'])) {
            $data['validate'] = $_SESSION['reg_validate'];
            unset($_SESSION['reg_validate']);
        }

        if (isset($_SESSION['reg_old'])) {
            $data['old'] = $_SESSION['reg_old'];
            unset($_SESSION['reg_old']);
        }

        $this->viewOnly('auth/register', $data);
    }

    // Memproses form registrasi (validasi sama seperti store di AccountController)
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_POST['submit'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        $name                 = stripslashes(trim($_POST['name'] ?? ''));
        $email                = stripslashes(trim($_POST['email'] ?? ''));
        $password             = stripslashes($_POST['password'] ?? '');
        $accountTypeId        = $_POST['account_type_id'] ?? '';
        $status               = $_POST['status'] ?? 'Aktif';
        $identificationNumber = stripslashes(trim($_POST['identification_number'] ?? ''));
        $identificationType   = $_POST['identification_type'] ?? 'NIP';

        // Simpan input sementara untuk user experience
        $_SESSION['reg_old'] = [
            'name' => $name,
            'email' => $email,
            'identification_number' => $identificationNumber,
            'identification_type' => $identificationType,
            'account_type_id' => $accountTypeId,
            'status' => $status
        ];

        // Validasi: semua field wajib diisi
        if (empty($name) || empty($email) || empty($password) || empty($identificationNumber) || empty($accountTypeId)) {
            $_SESSION['reg_error'] = 'Semua field wajib diisi.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        // Validasi format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['reg_error'] = 'Format email tidak valid.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        // Validasi password minimal 6 karakter
        if (strlen($password) < 6) {
            $_SESSION['reg_error'] = 'Password harus memiliki minimal 6 karakter.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        $accountModel = $this->model('Account');

        // Cek duplikasi email
        if ($accountModel->findByEmail($email)) {
            $_SESSION['reg_error'] = 'Email sudah digunakan oleh akun lain.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        // Cek duplikasi nomor identitas
        if ($accountModel->findByIdentificationNumber($identificationNumber)) {
            $_SESSION['reg_error'] = 'Nomor Identitas sudah terdaftar pada akun lain.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        // Cek batasan relasi 1:1 antara account dan account_type
        if ($accountModel->isAccountTypeUsed($accountTypeId)) {
            $_SESSION['reg_error'] = 'Tipe akun yang dipilih sudah digunakan oleh akun lain.';
            header('Location: ' . BASE_URL . 'index.php?url=auth/register');
            exit;
        }

        // Insert ke tabel accounts
        $result = $accountModel->createAccount([
            'name'                  => $name,
            'email'                 => $email,
            'password'              => $password,
            'account_type_id'       => $accountTypeId,
            'status'                => $status,
            'identification_number' => $identificationNumber,
            'identification_type'   => $identificationType
        ]);

        if ($result) {
            unset($_SESSION['reg_old']);

            // Ambil data akun yang baru dibuat untuk session
            $account = $accountModel->findByEmail($email);

            $_SESSION['username']          = $account['name'];
            $_SESSION['user_id']           = $account['id'];
            $_SESSION['user_name']         = $account['name'];
            $_SESSION['user_email']        = $account['email'];
            $_SESSION['user_account_type'] = $account['account_type_name'] ?? 'User';

            $_SESSION['flash'] = [
                'type'    => 'success',
                'message' => 'Selamat datang! Registrasi berhasil.'
            ];

            header('Location: ' . BASE_URL . 'index.php?url=account');
            exit;
        } else {
            $_SESSION['reg_error'] = 'Register gagal! Silakan coba lagi.';
        }

        header('Location: ' . BASE_URL . 'index.php?url=auth/register');
        exit;
    }

    // Memproses login beserta validasi CAPTCHA sesuai materi PPT
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_POST['submit'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }

        // Menghilangkan backslashes
        $email    = stripslashes(trim($_POST['email'] ?? ''));
        $password = stripslashes($_POST['password'] ?? '');
        $kodeCaptcha = trim($_POST['kodecaptcha'] ?? '');
        $sessionCaptcha = $_SESSION['code'] ?? '';

        $_SESSION['old_email'] = $email;

        // Cek apakah nilai captcha diisi dan cocok (validasi Captcha PPT)
        if (empty($kodeCaptcha) || strtolower($kodeCaptcha) !== strtolower($sessionCaptcha)) {
            $_SESSION['login_error'] = 'Kode CAPTCHA anda salah !!';
            header('Location: ' . BASE_URL . 'index.php?url=auth');
            exit;
        }

        // Cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if (!empty($email) && !empty($password)) {
            // Cari data akun di tabel accounts berdasarkan email
            $accountModel = $this->model('Account');
            $account = $accountModel->findByEmail($email);

            if ($account) {
                // Verifikasi password (hash atau plain text untuk akun bawaan)
                if (password_verify($password, $account['password']) || $password === $account['password']) {
                    unset($_SESSION['old_email']);
                    unset($_SESSION['code']);

                    $_SESSION['username']          = $account['name'];
                    $_SESSION['user_id']           = $account['id'];
                    $_SESSION['user_name']         = $account['name'];
                    $_SESSION['user_email']        = $account['email'];
                    $_SESSION['user_account_type'] = $account['account_type_name'] ?? 'User';

                    header('Location: ' . BASE_URL . 'index.php?url=account');
                    exit;
                } else {
                    $_SESSION['login_error'] = 'Email atau password salah !!';
                }
            } else {
                $_SESSION['login_error'] = 'Email tidak terdaftar !!';
            }
        } else {
            $_SESSION['login_error'] = 'Data tidak boleh kosong !!';
        }

        header('Location: ' . BASE_URL . 'index.php?url=auth');
        exit;
    }

    // Endpoint penghasil gambar CAPTCHA
    public function captcha() {
        require_once __DIR__ . '/../../captcha.php';
        exit;
    }

    // Memproses logout
    public function logout() {
        $_SESSION = [];
        if (session_id() !== '' || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        session_destroy();

        header('Location: ' . BASE_URL . 'index.php?url=auth');
        exit;
    }
}
