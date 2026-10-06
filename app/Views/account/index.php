<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1 fw-bold text-dark">Manajemen Akun</h2>
        <p class="text-muted small mb-0">Kelola dan pantau daftar pengguna sistem yang terdaftar.</p>
    </div>
    <!-- Tombol Tambah Akun -->
    <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addAccountModal">
        <i class="bi bi-person-plus-fill"></i>
        <span>Tambah Akun</span>
    </button>
</div>

<!-- Pesan Notifikasi -->
<?php if (!empty($flash_success)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($flash_success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if (!empty($flash_error)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($flash_error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Tabel Data Akun -->
<div class="card-custom">
    <div class="card-header-custom">
        <h5 class="mb-0 fw-bold fs-6 text-dark">Daftar Akun Pengguna</h5>
        <span class="badge bg-light text-dark border"><?= count($accounts) ?> Akun Terdaftar</span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Tipe Akun</th>
                    <th>Identitas</th>
                    <th>Status</th>
                    <th style="width: 120px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($accounts)): ?>
                    <?php $no = 1; foreach ($accounts as $acc): ?>
                    <tr>
                        <td class="text-muted fw-bold"><?= $no++ ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?= htmlspecialchars($acc['name']) ?></div>
                        </td>
                        <td>
                            <span class="text-muted"><?= htmlspecialchars($acc['email']) ?></span>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">
                                <?= htmlspecialchars($acc['account_type_name'] ?? 'Tidak Ada') ?>
                            </span>
                        </td>
                        <td>
                            <small class="text-secondary fw-semibold"><?= htmlspecialchars($acc['identification_type']) ?>:</small> 
                            <span><?= htmlspecialchars($acc['identification_number']) ?></span>
                        </td>
                        <td>
                            <?php if (strtolower($acc['status']) === 'aktif' || strtolower($acc['status']) === 'active'): ?>
                                <span class="badge-status active">Aktif</span>
                            <?php else: ?>
                                <span class="badge-status inactive"><?= htmlspecialchars($acc['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <!-- Aksi: Edit & Hapus -->
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn-action edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editAccountModal"
                                    data-id="<?= htmlspecialchars($acc['id']) ?>"
                                    data-name="<?= htmlspecialchars($acc['name']) ?>"
                                    data-email="<?= htmlspecialchars($acc['email']) ?>"
                                    data-account-type-id="<?= htmlspecialchars($acc['account_type_id']) ?>"
                                    data-status="<?= htmlspecialchars($acc['status']) ?>"
                                    data-ident-type="<?= htmlspecialchars($acc['identification_type']) ?>"
                                    data-ident-num="<?= htmlspecialchars($acc['identification_number']) ?>"
                                    title="Ubah Akun">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="<?= BASE_URL ?>index.php?url=account/delete/<?= urlencode($acc['id']) ?>" 
                                    class="btn-action delete" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?');"
                                    title="Hapus Akun">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            <span>Belum ada data akun yang tersimpan.</span>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Akun -->
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="addAccountModalLabel">Tambah Data Akun Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>index.php?url=account/store" method="POST">
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password Anda (Minimal 6 karakter)" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label small fw-bold">Identitas</label>
                            <select name="identification_type" class="form-select" required>
                                <option value="NIM">NIM</option>
                                <option value="NIP">NIP</option>
                            </select>
                        </div>
                        <div class="col-8">
                            <label class="form-label small fw-bold">Nomor Identitas</label>
                            <input type="text" name="identification_number" class="form-control" placeholder="Masukkan Nomor Identitas Anda" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Tipe Akun</label>
                            <select name="account_type_id" class="form-select" required>
                                <?php if (!empty($accountTypes)): ?>
                                    <?php foreach ($accountTypes as $type): ?>
                                        <option value="<?= htmlspecialchars($type['id']) ?>">
                                            <?= htmlspecialchars($type['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Belum ada tipe akun</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Akun -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="editAccountModalLabel">Ubah Data Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAccountForm" method="POST" data-base-action="<?= BASE_URL ?>index.php?url=account/update/">
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" id="edit_email" name="email" class="form-control" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label small fw-bold">Identitas</label>
                            <select id="edit_identification_type" name="identification_type" class="form-select" required>
                                <option value="NIM">NIM</option>
                                <option value="NIP">NIP</option>
                            </select>
                        </div>
                        <div class="col-8">
                            <label class="form-label small fw-bold">Nomor Identitas</label>
                            <input type="text" id="edit_identification_number" name="identification_number" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Tipe Akun</label>
                            <select id="edit_account_type_id" name="account_type_id" class="form-select" required>
                                <?php if (!empty($accountTypes)): ?>
                                    <?php foreach ($accountTypes as $type): ?>
                                        <option value="<?= htmlspecialchars($type['id']) ?>">
                                            <?= htmlspecialchars($type['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select id="edit_status" name="status" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>public/js/account.js"></script>
