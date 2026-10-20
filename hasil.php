<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil CAPTCHA</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body p-4 text-center">
                <h2 class="mb-4">Informasi Login:</h2>
                <div class="alert <?= (isset($_POST['kodecaptcha']) && isset($_SESSION['code']) && $_SESSION['code'] == $_POST['kodecaptcha']) ? 'alert-success' : 'alert-danger' ?>">
                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    $nama = htmlspecialchars($_POST["username"] ?? '');
                    $pwd = htmlspecialchars($_POST["password"] ?? '');
                    $inputCaptcha = $_POST["kodecaptcha"] ?? '';
                    $sessionCaptcha = $_SESSION["code"] ?? '';

                    //mengecek apakah user menginput captcha dengan benar
                    //jika captcha salah, maka akan menjalankan yang pertama
                    if ($sessionCaptcha != $inputCaptcha || empty($inputCaptcha)) {
                        echo "Username anda adalah <b>$nama</b><br />";
                        echo "Password anda adalah <b>$pwd</b><br /><br />";
                        echo "<span class='text-danger fw-bold'>Kode CAPTCHA anda salah</span>";
                    } else { // jika captcha benar, maka perintah yang bawah akan dijalankan
                        echo "Username anda adalah <b>$nama</b><br />";
                        echo "Password anda adalah <b>$pwd</b><br /><br />";
                        echo "<span class='text-success fw-bold'>Kode CAPTCHA anda benar</span>";
                    }
                    ?>
                </div>
                <div class="mt-3">
                    <a href="index.php?url=auth" class="btn btn-primary btn-sm">Kembali ke Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

