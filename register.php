<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Register - Halaman Pendaftaran</title>
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
if (isset($_SESSION['username']) || isset($_SESSION['user_id'])) {
    header('Location: index.php?url=account');
    exit;
}

//mengecek apakah data username yang diinpukan user kosong atau tidak
if (isset($_POST['submit'])) {
    // menghilangkan backshlases
    $username = stripslashes($_POST['username']);
    // cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($con, $username);
    $name     = stripslashes($_POST['name']);
    $name     = mysqli_real_escape_string($con, $name);
    $email    = stripslashes($_POST['email']);
    $email    = mysqli_real_escape_string($con, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $repass   = stripslashes($_POST['repassword']);
    $repass   = mysqli_real_escape_string($con, $repass);

    //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
    if (!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))) {
        //mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
        if ($password == $repass) {
            //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
            if (cek_nama($username, $con) == 0) {
                //hashing password sebelum disimpan didatabase
                $pass = password_hash($password, PASSWORD_DEFAULT);
                //insert data ke database
                $query = "INSERT INTO users (username, name, email, password) VALUES ('$username', '$name', '$email', '$pass')";
                $result = mysqli_query($con, $query);
                //jika insert data berhasil maka akan diredirect ke halaman index.php serta menyimpan data username ke session
                if ($result) {
                    $newId = mysqli_insert_id($con);

                    // Cek apakah tipe akun "User" sudah ada, jika belum buat otomatis
                    $cekTipe = mysqli_query($con, "SELECT id FROM account_type WHERE name = 'User' AND deleted_at IS NULL LIMIT 1");
                    $tipe = mysqli_fetch_assoc($cekTipe);
                    if (!$tipe) {
                        $tipeId = md5(uniqid(mt_rand(), true));
                        $tipeId = substr($tipeId, 0, 8) . '-' . substr($tipeId, 8, 4) . '-' . substr($tipeId, 12, 4) . '-' . substr($tipeId, 16, 4) . '-' . substr($tipeId, 20, 12);
                        mysqli_query($con, "INSERT INTO account_type (id, name, description) VALUES ('$tipeId', 'User', 'Akun pengguna yang mendaftar sendiri')");
                    } else {
                        $tipeId = $tipe['id'];
                    }

                    // Simpan juga ke tabel accounts agar muncul di Manajemen Akun
                    $accId = md5(uniqid(mt_rand(), true));
                    $accId = substr($accId, 0, 8) . '-' . substr($accId, 8, 4) . '-' . substr($accId, 12, 4) . '-' . substr($accId, 16, 4) . '-' . substr($accId, 20, 12);
                    $accPass = password_hash($password, PASSWORD_BCRYPT);
                    mysqli_query($con, "INSERT INTO accounts (id, name, email, password, account_type_id, status, identification_number, identification_type, created_at, updated_at)
                                        VALUES ('$accId', '$name', '$email', '$accPass', NULL, 'Aktif', '-', 'NIM', NOW(), NOW())");

                    $_SESSION['username']          = $username;
                    $_SESSION['user_id']           = $newId;
                    $_SESSION['user_name']         = $name;
                    $_SESSION['user_email']        = $email;
                    $_SESSION['user_account_type'] = 'User';

                    header('Location: index.php?url=account');
                    exit;
                //jika gagal maka akan menampilkan pesan error
                } else {
                    $error = 'Register User Gagal !!';
                }
            } else {
                $error = 'Username sudah terdaftar !!';
            }
        } else {
            $validate = 'Password tidak sama !!';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}

//fungsi untuk mengecek username apakah sudah terdaftar atau belum
function cek_nama($username, $con) {
    $nama = mysqli_real_escape_string($con, $username);
    $query = "SELECT * FROM users WHERE username = '$nama'";
    if ($result = mysqli_query($con, $query)) {
        return mysqli_num_rows($result);
    }
    return 0;
}
?>

<section class="container-fluid mb-4 py-5">
    <!-- justify-content-center untuk mengatur posisi form agar berada di tengah-tengah -->
    <section class="row justify-content-center">
        <section class="col-12 col-sm-8 col-md-5 col-lg-4">
            <div class="card shadow-sm border-0 p-4">
                <form class="form-container" action="register.php" method="POST">
                    <h4 class="text-center fw-bold mb-4">Sign-Up</h4>
                    <?php if ($error != '') { ?>
                        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error); ?></div>
                    <?php } ?>

                    <div class="form-group mb-3">
                        <label for="name" class="form-label small fw-bold">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="InputEmail" class="form-label small fw-bold">Alamat Email</label>
                        <input type="email" class="form-control" id="InputEmail" name="email" placeholder="Masukkan email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

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

                    <div class="form-group mb-4">
                        <label for="InputRePassword" class="form-label small fw-bold">Re-Password</label>
                        <input type="password" class="form-control" id="InputRePassword" name="repassword" placeholder="Re-Password">
                        <?php if ($validate != '') { ?>
                            <p class="text-danger small mt-1 mb-0"><?= htmlspecialchars($validate); ?></p>
                        <?php } ?>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary w-100 py-2 fw-semibold">Register</button>
                    <div class="form-footer mt-3 text-center">
                        <p class="text-muted small mb-0">Sudah punya account? <a href="login.php" class="text-decoration-none">Login</a></p>
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

