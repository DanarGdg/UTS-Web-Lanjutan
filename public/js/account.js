// Handler interaksi halaman manajemen akun
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editAccountModal');
    const searchInput = document.getElementById('searchInput');
    const btnSearch = document.getElementById('btnSearch');
    const table = document.getElementById('accountTable');
    const noResultsRow = document.getElementById('noResultsRow');

    // Pengisian data ke modal ubah akun
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            const id = button.getAttribute('data-id');
            const form = document.getElementById('editAccountForm');
            const baseAction = form.getAttribute('data-base-action');
            const deleteBaseAction = form.getAttribute('data-delete-base-action');
            const btnDelete = document.getElementById('btnDeleteAccount');

            // Set URL aksi form pembaruan data
            if (form && baseAction && id) {
                form.action = baseAction + encodeURIComponent(id);
            }

            // Set URL aksi tombol hapus akun (soft delete)
            if (btnDelete && deleteBaseAction && id) {
                btnDelete.href = deleteBaseAction + encodeURIComponent(id);
            }

            // Isi nilai formulir
            document.getElementById('edit_name').value = button.getAttribute('data-name') || '';
            document.getElementById('edit_email').value = button.getAttribute('data-email') || '';
            document.getElementById('edit_identification_type').value = button.getAttribute('data-ident-type') || 'NIP';
            document.getElementById('edit_identification_number').value = button.getAttribute('data-ident-num') || '';
            document.getElementById('edit_account_type_id').value = button.getAttribute('data-account-type-id') || '';
            document.getElementById('edit_status').value = button.getAttribute('data-status') || 'Aktif';
        });
    }

    // Fungsi pencarian data akun secara realtime
    function filterTable() {
        if (!table || !searchInput) return;

        const query = searchInput.value.toLowerCase().trim();
        const rows = table.querySelectorAll('tbody tr.account-row');
        let visibleCount = 0;

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Tampilkan pesan jika data tidak ditemukan
        if (noResultsRow) {
            noResultsRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterTable();
            }
        });
    }

    if (btnSearch) {
        btnSearch.addEventListener('click', filterTable);
    }
});
