<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - <?= APP_NAME ?></title>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Auth CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/auth.css">
</head>
<body>
    <div class="auth-card auth-card-wide">
        <!-- Top Icon Badge -->
        <div class="icon-container">
            <div class="brand-icon-box">
                <!-- User Plus / Shield Icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
        </div>

        <!-- Header Titles -->
        <div class="card-header-text">
            <h1 class="card-title">Daftar Akun Baru</h1>
            <p class="card-subtitle">Lengkapi formulir untuk membuat akun baru.</p>
        </div>

        <!-- Error Message Alert -->
        <?php if (!empty($error)): ?>
        <div class="alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="<?= BASE_URL ?>index.php?url=auth/storeRegister" method="POST" autocomplete="off">
            <div class="form-group compact">
                <label for="name" class="form-label compact">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control compact" 
                    placeholder="Masukkan Nama Anda"
                    required 
                    autofocus
                >
            </div>

            <div class="form-group compact">
                <label for="email" class="form-label compact">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control compact" 
                    placeholder="Masukkan Email Anda"
                    required
                >
            </div>

            <div class="form-group compact">
                <label for="password" class="form-label compact">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control compact" 
                    placeholder="Masukkan Password Anda (Minimal 6 karakter)"
                    required
                >
            </div>

            <div class="form-row">
                <div class="form-group compact">
                    <label for="identification_type" class="form-label compact">Tipe Identitas</label>
                    <select id="identification_type" name="identification_type" class="form-control compact" required>
                        <option value="NIM">NIM</option>
                        <option value="NIP">NIP</option>
                    </select>
                </div>
                <div class="form-group compact">
                    <label for="identification_number" class="form-label compact">No. Identitas</label>
                    <input 
                        type="text" 
                        id="identification_number" 
                        name="identification_number" 
                        class="form-control compact" 
                        placeholder="Masukkan Nomor Identitas Anda"
                        required
                    >
                </div>
            </div>

            <div class="form-group compact">
                <label for="account_type_id" class="form-label compact">Tipe Akun</label>
                <select id="account_type_id" name="account_type_id" class="form-control compact" required>
                    <?php if (!empty($accountTypes)): ?>
                        <?php foreach ($accountTypes as $type): ?>
                            <option value="<?= htmlspecialchars($type['id']) ?>">
                                <?= htmlspecialchars($type['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="default">User / Pengguna</option>
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn-auth compact">
                <!-- User Check Icon -->
                <svg viewBox="0 0 16 16" fill="currentColor">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 1.336a.5.5 0 0 1-.707 0l-.636-.636a.5.5 0 1 1 .707-.707l.282.282 1.018-1.018a.5.5 0 0 1 .707.707Z"/>
                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                    <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                </svg>
                <span>Daftar Sekarang</span>
            </button>
        </form>

        <div class="form-footer-link compact">
            <span>Sudah punya akun?</span>
            <a href="<?= BASE_URL ?>index.php?url=auth">Masuk di sini</a>
        </div>
    </div>
</body>
</html>
