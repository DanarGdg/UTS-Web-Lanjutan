<!-- Header halaman manajemen akun -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0 fw-bold text-dark">Manajemen Akun</h2>
    <!-- Tombol tambah akun baru -->
    <button type="button" class="btn-add-account" data-bs-toggle="modal" data-bs-target="#addAccountModal">
        <i class="bi bi-plus-lg"></i>
        <span>Tambah Akun</span>
    </button>
</div>

<!-- Notifikasi pesan -->
<?php if (!empty($flash_success)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($flash_success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if (!empty($flash_error)): ?>
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($flash_error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Bar pencarian data akun -->
<div class="search-bar-container mb-4">
    <div class="search-input-wrapper">
        <i class="bi bi-search search-icon"></i>
        <input 
            type="text" 
            id="searchInput" 
            class="search-input" 
            placeholder="Cari nama, email, NIM/NIP, atau tipe akun..."
            autocomplete="off"
        >
        <button type="button" id="btnSearch" class="btn-search">Cari</button>
    </div>
</div>

<!-- Tabel daftar data akun -->
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-account align-middle" id="accountTable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Identitas</th>
                    <th>Tipe Akun</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($accounts)): ?>
                    <?php foreach ($accounts as $acc): ?>
                    <tr class="account-row">
                        <td class="account-name fw-bold"><?= htmlspecialchars($acc['name']) ?></td>
                        <td class="account-email"><?= htmlspecialchars($acc['email']) ?></td>
                        <td class="account-identity">
                            <span class="badge-identity"><?= htmlspecialchars($acc['identification_type']) ?></span>
                            <span class="identity-number"><?= htmlspecialchars($acc['identification_number']) ?></span>
                        </td>
                        <td class="account-type"><?= htmlspecialchars($acc['account_type_name'] ?? 'User') ?></td>
                        <td class="account-status">
                            <?php if (strtolower($acc['status']) === 'aktif' || strtolower($acc['status']) === 'active'): ?>
                                <span class="badge-pill-status active">Aktif</span>
                            <?php else: ?>
                                <span class="badge-pill-status inactive"><?= htmlspecialchars($acc['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <!-- Tombol ubah akun -->
                            <button type="button" class="btn-action-edit" 
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
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="emptyRow">
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            <span>Belum ada data akun yang tersimpan.</span>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr id="noResultsRow" style="display: none;">
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-search fs-2 d-block mb-2 text-secondary"></i>
                        <span>Data akun tidak ditemukan.</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal tambah akun baru -->
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
                        <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password (Minimal 6 karakter)" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label small fw-bold">Identitas</label>
                            <select name="identification_type" class="form-select" required>
                                <option value="NIP">NIP</option>
                                <option value="NIM">NIM</option>
                            </select>
                        </div>
                        <div class="col-8">
                            <label class="form-label small fw-bold">Nomor Identitas</label>
                            <input type="text" name="identification_number" class="form-control" placeholder="Masukkan Nomor Identitas" required>
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

<!-- Modal ubah akun -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="editAccountModalLabel">Ubah Data Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAccountForm" method="POST" data-base-action="<?= BASE_URL ?>index.php?url=account/update/" data-delete-base-action="<?= BASE_URL ?>index.php?url=account/delete/">
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
                                <option value="NIP">NIP</option>
                                <option value="NIM">NIM</option>
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
                <div class="modal-footer border-top-0 pt-0 d-flex justify-content-between">
                    <!-- Tombol hapus akun (soft delete) -->
                    <a id="btnDeleteAccount" href="#" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                        <i class="bi bi-trash me-1"></i>Hapus Akun
                    </a>
                    <div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script handler halaman akun -->
<script src="<?= BASE_URL ?>public/js/account.js"></script>
