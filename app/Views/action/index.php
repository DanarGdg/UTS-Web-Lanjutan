<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0 fw-bold">Jenis Aksi</h2>
    <a href="<?= BASE_URL ?>index.php?url=action/create" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Tambah Aksi
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
    <input type="hidden" name="url" value="action">
    <input type="text" name="q" class="form-control" placeholder="Cari nama atau deskripsi..."
           value="<?= htmlspecialchars($keyword) ?>">
    <button class="btn btn-outline-primary" type="submit">Cari</button>
</form>

<!-- Tabel daftar jenis aksi -->
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
            <?php if (empty($actions)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Data jenis aksi tidak ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($actions as $item): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['description'] ?? '-') ?></td>
                        <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                        <td class="text-end">
                            <a href="<?= BASE_URL ?>index.php?url=action/edit/<?= $item['id'] ?>"
                               class="btn btn-outline-warning btn-sm" title="Ubah">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="<?= BASE_URL ?>index.php?url=action/delete/<?= $item['id'] ?>"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus jenis aksi ini?');">
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