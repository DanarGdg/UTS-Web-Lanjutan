<?php
// Jika $actionItem terisi berarti mode ubah, jika kosong berarti mode tambah
$isEdit = !empty($actionItem);
$formUrl = $isEdit ? 'action/update/' . $actionItem['id'] : 'action/store';
?>

<div class="card">
    <div class="card-header fs-5">
        <?= $isEdit ? 'Ubah Jenis Aksi' : 'Tambah Jenis Aksi' ?>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>index.php?url=<?= $formUrl ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Aksi</label>
                <input type="text" id="name" name="name" class="form-control" maxlength="128" required
                       value="<?= htmlspecialchars($actionItem['name'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          class="form-control"><?= htmlspecialchars($actionItem['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= BASE_URL ?>index.php?url=action" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>