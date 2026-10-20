<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Login - Halaman Login</title>
</head>
<body class="bg-light">
<?php
//menyertakan file program koneksi.php pada register
require('koneksi.php');
//inisialisasi session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$validate = '';

//mengecek apakah sesssion username tersedia atau tidak jika tersedia maka akan diredirect ke halaman index
if (isset($_SESSION['username']) || isset($_SESSION['user_id'])) {
    header('Location: index.php?url=account');
    exit;
}

//mengecek apakah form disubmit atau tidak
if (isset($_POST['submit'])) {
    // validasi captcha terlebih dahulu
    $kodeCaptcha = trim($_POST['kodecaptcha'] ?? '');
    $sessionCaptcha = $_SESSION['code'] ?? '';

    if (empty($kodeCaptcha) || strtolower($kodeCaptcha) !== strtolower($sessionCaptcha)) {
        $error = 'Kode CAPTCHA anda salah !!';
    } else {
        // menghilangkan backshlases
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($con, $username);
        // menghilangkan backshlases
        $password = stripslashes($_POST['password']);
        //cara sederhana mengamankan dari sql injection
        $password = mysqli_real_escape_string($con, $password);

        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if (!empty(trim($username)) && !empty(trim($password))) {
            //select data berdasarkan username dari database
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($con, $query);
            $rows = mysqli_num_rows($result);

            if ($rows != 0) {
                $user = mysqli_fetch_assoc($result);
                $hash = $user['password'];
                if (password_verify($password, $hash)) {
                    $_SESSION['username']          = $user['username'];
                    $_SESSION['user_id']           = $user['id'];
                    $_SESSION['user_name']         = $user['name'];
                    $_SESSION['user_email']        = $user['email'];
                    $_SESSION['user_account_type'] = 'User';
                    header('Location: index.php?url=account');
                    exit;
                } else {
                    $error = 'Username atau password salah !!';
                }
            //jika gagal maka akan menampilkan pesan error
            } else {
                // fallback ke tabel accounts jika ada user default (seperti admin)
                $queryAcc = "SELECT * FROM accounts WHERE email = '$username' AND deleted_at IS NULL";
                $resultAcc = mysqli_query($con, $queryAcc);
                if ($resultAcc && mysqli_num_rows($resultAcc) > 0) {
                    $acc = mysqli_fetch_assoc($resultAcc);
                    if (password_verify($password, $acc['password']) || $password === $acc['password']) {
                        $_SESSION['username']          = $acc['name'];
                        $_SESSION['user_id']           = $acc['id'];
                        $_SESSION['user_name']         = $acc['name'];
                        $_SESSION['user_email']        = $acc['email'];
                        $_SESSION['user_account_type'] = 'Admin';
                        header('Location: index.php?url=account');
                        exit;
                    }
                }
                $error = 'Register User Gagal !!';
            }
        } else {
            $error = 'Data tidak boleh kosong !!';
        }
    }
}
?>

<section class="container-fluid mb-4 py-5">
    <!-- justify-content-center untuk mengatur posisi form agar berada di tengah-tengah -->
    <section class="row justify-content-center">
        <section class="col-12 col-sm-8 col-md-5 col-lg-4">
            <div class="card shadow-sm border-0 p-4">
                <form class="form-container" action="login.php" method="POST">
                    <h4 class="text-center fw-bold mb-4">Sign-In</h4>
                    <?php if ($error != '') { ?>
                        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error); ?></div>
                    <?php } ?>

                    <div class="form-group mb-3">
                        <label for="username" class="form-label small fw-bold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="InputPassword" class="form-label small fw-bold">Password</label>
                        <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
                        <?php if ($validate != '') { ?>
                            <p class="text-danger small mt-1 mb-0"><?= htmlspecialchars($validate); ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold d-block">Captcha</label>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="captcha.php" id="img-captcha" alt="Captcha" class="rounded border" style="height: 48px; width: 173px; object-fit: cover;">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('img-captcha').src='captcha.php?t='+new Date().getTime()" title="Acak Ulang Captcha">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                        <label for="kodecaptcha" class="form-label small fw-bold">Isikan captcha</label>
                        <input type="text" class="form-control" id="kodecaptcha" name="kodecaptcha" placeholder="Isikan captcha" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary w-100 py-2 fw-semibold">Sign In</button>
                    <div class="form-footer mt-3 text-center">
                        <p class="text-muted small mb-0">Belum punya account? <a href="register.php" class="text-decoration-none">Register</a></p>
                    </div>
                </form>
            </div>
        </section>
    </section>
</section>

<!-- Bootstrap JS -->
<script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

