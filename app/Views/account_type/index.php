<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0 fw-bold">Tipe Akun</h2>
    <a href="<?= BASE_URL ?>index.php?url=accountType/create" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Tambah Tipe Akun
    </a>
</div>

<!-- Pesan sukses/gagal -->
<?php if (!empty($flash)): ?>
    <div class="alert alert-<?= $flash['type'] ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>

<!-- Form pencarian -->
<form method="GET" action="<?= BASE_URL ?>index.php" class="input-group mb-3">
    <input type="hidden" name="url" value="accountType">
    <input type="text" name="q" class="form-control" placeholder="Cari nama atau deskripsi..."
           value="<?= htmlspecialchars($keyword) ?>">
    <button class="btn btn-outline-primary" type="submit">Cari</button>
</form>

<!-- Tabel daftar tipe akun -->
<div class="card">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Dibuat</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($accountTypes)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Data tipe akun tidak ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($accountTypes as $type): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($type['name']) ?></td>
                        <td><?= htmlspecialchars($type['description'] ?? '-') ?></td>
                        <td><?= date('d M Y H:i', strtotime($type['created_at'])) ?></td>
                        <td class="text-end">
                            <a href="<?= BASE_URL ?>index.php?url=accountType/edit/<?= $type['id'] ?>"
                               class="btn btn-outline-warning btn-sm" title="Ubah">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="<?= BASE_URL ?>index.php?url=accountType/delete/<?= $type['id'] ?>"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus tipe akun ini?');">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>