<?php
// Jika $accountType terisi berarti mode ubah, jika kosong berarti mode tambah
$isEdit = !empty($accountType);
$action = $isEdit ? 'accountType/update/' . $accountType['id'] : 'accountType/store';
?>

<div class="card">
    <div class="card-header fs-5">
        <?= $isEdit ? 'Ubah Tipe Akun' : 'Tambah Tipe Akun' ?>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>index.php?url=<?= $action ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Tipe Akun</label>
                <input type="text" id="name" name="name" class="form-control" maxlength="128" required
                       value="<?= htmlspecialchars($accountType['name'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          class="form-control"><?= htmlspecialchars($accountType['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= BASE_URL ?>index.php?url=accountType" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>