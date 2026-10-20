<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-In - <?= APP_NAME ?></title>
    <!-- CSS Bootstrap 5 -->
    <link rel="stylesheet" href="<?= BASE_URL ?>bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 440px;">
        <div class="card-body p-4 p-md-5">
            <!-- Header Card -->
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 mb-3 p-3 shadow-sm">
                    <i class="bi bi-shield-lock-fill fs-2"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">Sign-In</h4>
                <p class="text-muted small">Masuk dengan akun Anda dan verifikasi CAPTCHA</p>
            </div>

            <!-- Notifikasi Pesan Error / Sukses -->
            <?php if (!empty($error)): ?>
                <div class="text-danger small text-center mb-3">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="text-success small text-center mb-3">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="<?= BASE_URL ?>index.php?url=auth/login" method="POST" autocomplete="off">
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="Masukkan email"
                        value="<?= htmlspecialchars($oldEmail ?? '') ?>"
                        required 
                        autofocus
                    >
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Password"
                        required
                    >
                    <?php if (!empty($validate)): ?>
                        <p class="text-danger small mt-1 mb-0"><i class="bi bi-x-circle me-1"></i><?= htmlspecialchars($validate) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Bagian Captcha -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary d-block">Captcha</label>
                    <div class="d-flex align-items-center gap-2 mb-2">
                <img 
                    src="<?= BASE_URL ?>captcha.php" 
                    id="img-captcha" 
                    alt="Captcha Image" 
                    class="rounded border shadow-sm"
                    style="height: 48px; width: 173px; object-fit: cover;"
                >
                    </div>  
                    <label for="kodecaptcha" class="form-label small fw-bold text-secondary">Isikan captcha</label>
                    <input 
                        type="text" 
                        id="kodecaptcha" 
                        name="kodecaptcha" 
                        class="form-control" 
                        placeholder="Isikan captcha"
                        required
                    >
                </div>

                <!-- Tombol Submit -->
                <button type="submit" name="submit" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 mb-3">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Sign-In</span>
                </button>

                <!-- Footer Link ke Register -->
                <div class="text-center">
                    <p class="text-muted small mb-0">Belum punya account? <a href="<?= BASE_URL ?>index.php?url=auth/register" class="text-primary text-decoration-none fw-semibold">Register</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="<?= BASE_URL ?>bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function refreshCaptcha() {
            var img = document.getElementById('img-captcha');
            if (img) {
                img.src = '<?= BASE_URL ?>captcha.php?t=' + new Date().getTime();
            }
        }
    </script>
</body>
</html>
