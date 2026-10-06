// Handler modal edit data akun
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editAccountModal');
    if (!editModal) return;

    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const form = document.getElementById('editAccountForm');
        const baseAction = form.getAttribute('data-base-action');

        // Set action URL form update
        form.action = baseAction + encodeURIComponent(id);

        // Isi nilai input form edit
        document.getElementById('edit_name').value = button.getAttribute('data-name') || '';
        document.getElementById('edit_email').value = button.getAttribute('data-email') || '';
        document.getElementById('edit_identification_type').value = button.getAttribute('data-ident-type') || 'NIM';
        document.getElementById('edit_identification_number').value = button.getAttribute('data-ident-num') || '';
        document.getElementById('edit_account_type_id').value = button.getAttribute('data-account-type-id') || '';
        document.getElementById('edit_status').value = button.getAttribute('data-status') || 'Aktif';
    });
});
