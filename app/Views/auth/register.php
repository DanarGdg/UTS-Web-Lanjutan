<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?= APP_NAME ?></title>
    <!-- CSS Bootstrap 5 -->
    <link rel="stylesheet" href="<?= BASE_URL ?>bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 580px;">
        <div class="card-body p-4 p-md-5">
            <!-- Header Card -->
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 mb-3 p-3 shadow-sm">
                    <i class="bi bi-person-plus-fill fs-2"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">Sign-Up</h4>
                <p class="text-muted small">Daftarkan akun baru Anda untuk mengakses sistem</p>
            </div>

            <!-- Notifikasi Pesan Error -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 px-3 small text-center mb-3" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Form Registrasi (sama seperti Tambah Akun) -->
            <form action="<?= BASE_URL ?>index.php?url=auth/processRegister" method="POST" autocomplete="off">
                <!-- Nama & Email -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap"
                               value="<?= htmlspecialchars($old['name'] ?? '') ?>" required autofocus>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email"
                               value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                    </div>
                </div>

                <!-- Password, Jenis Identitas, Nomor Identitas -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Masukkan Password (Minimal 6 karakter)" required>
                        <?php if (!empty($validate)): ?>
                            <p class="text-danger small mt-1 mb-0"><i class="bi bi-x-circle me-1"></i><?= htmlspecialchars($validate) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <label for="identification_type" class="form-label small fw-bold text-secondary">Jenis Identitas</label>
                        <select id="identification_type" name="identification_type" class="form-select" required>
                            <option value="NIP" <?= ($old['identification_type'] ?? '') === 'NIP' ? 'selected' : '' ?>>NIP</option>
                            <option value="NIM" <?= ($old['identification_type'] ?? '') === 'NIM' ? 'selected' : '' ?>>NIM</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="identification_number" class="form-label small fw-bold text-secondary">Nomor Identitas</label>
                        <input type="text" class="form-control" id="identification_number" name="identification_number"
                               placeholder="Masukkan Nomor Identitas"
                               value="<?= htmlspecialchars($old['identification_number'] ?? '') ?>" required>
                    </div>
                </div>

                <!-- Tipe Akun & Status -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="account_type_id" class="form-label small fw-bold text-secondary">Tipe Akun</label>
                        <select id="account_type_id" name="account_type_id" class="form-select" required>
                            <option value="">-- Pilih Tipe Akun --</option>
                            <?php if (!empty($accountTypes)): ?>
                                <?php foreach ($accountTypes as $type): ?>
                                    <?php
                                    $isSelected = ($old['account_type_id'] ?? '') === $type['id'];
                                    $isUsed = in_array($type['id'], $usedTypeIds ?? []);
                                    ?>
                                    <option value="<?= htmlspecialchars($type['id']) ?>"
                                        <?= $isSelected ? 'selected' : '' ?>
                                        <?= ($isUsed && !$isSelected) ? 'disabled' : '' ?>>
                                        <?= htmlspecialchars($type['name']) ?>
                                        <?= ($isUsed && !$isSelected) ? ' (Sudah Digunakan)' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (!empty($noTypeAvailable)): ?>
                            <p class="text-danger small mt-1 mb-0"><i class="bi bi-exclamation-circle me-1"></i>Tidak ada tipe akun yang tersedia. Silakan hubungi admin untuk menambah tipe akun terlebih dahulu.</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label small fw-bold text-secondary">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="Aktif" <?= ($old['status'] ?? 'Aktif') === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?= ($old['status'] ?? '') === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" name="submit" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 mb-3">
                    <span>Register</span>
                </button>

                <!-- Footer Link ke Login -->
                <div class="text-center">
                    <p class="text-muted small mb-0">Sudah punya account? <a href="<?= BASE_URL ?>index.php?url=auth" class="text-primary text-decoration-none fw-semibold">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="<?= BASE_URL ?>bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
