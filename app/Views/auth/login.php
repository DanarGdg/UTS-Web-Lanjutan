<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NAME ?></title>
    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Autentikasi -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/auth.css">
</head>
<body>
    <div class="auth-card">
        <!-- Ikon Header -->
        <div class="icon-container">
            <div class="brand-icon-box">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2.5L19 5.5V11.2C19 16.2 16 20.6 12 21.8C8 20.6 5 16.2 5 11.2V5.5L12 2.5Z" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="10" r="1.6" stroke="#FFFFFF" stroke-width="1.6"/>
                    <path d="M11.1 11.4L10.6 15H13.4L12.9 11.4" fill="#FFFFFF"/>
                </svg>
            </div>
        </div>

        <!-- Judul Halaman -->
        <div class="card-header-text">
            <h1 class="card-title">Manajemen Akun</h1>
            <p class="card-subtitle">Masuk pakai email dan password kamu.</p>
        </div>

        <!-- Notifikasi Pesan -->
        <?php if (!empty($error)): ?>
        <div class="alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
        <div class="alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="<?= BASE_URL ?>index.php?url=auth/login" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required
                >
            </div>

            <button type="submit" class="btn-auth">
                <svg viewBox="0 0 16 16" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14 2H6a1.5 1.5 0 0 0-1.5 1.5v2a.5.5 0 0 0 1 0z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
                <span>Login</span>
            </button>
        </form>

    </div>
</body>
</html>
