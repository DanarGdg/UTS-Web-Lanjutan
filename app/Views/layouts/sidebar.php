<!-- Navigasi sidebar -->
<nav id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand-icon">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2.5L19 5.5V11.2C19 16.2 16 20.6 12 21.8C8 20.6 5 16.2 5 11.2V5.5L12 2.5Z" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="10" r="1.6" stroke="#FFFFFF" stroke-width="1.6"/>
                <path d="M11.1 11.4L10.6 15H13.4L12.9 11.4" fill="#FFFFFF"/>
            </svg>
        </div>
        <span>Manajemen Akun</span>
    </div>

    <ul class="components">
        <li class="<?= (isset($activeMenu) && $activeMenu === 'account') ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>index.php?url=account">
                <i class="bi bi-people"></i>
                <span>Akun</span>
            </a>
        </li>
        <li class="<?= (isset($activeMenu) && $activeMenu === 'account_type') ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>index.php?url=accountType">
                <i class="bi bi-phone"></i>
                <span>Tipe Akun</span>
            </a>
        </li>
        <li class="<?= (isset($activeMenu) && $activeMenu === 'action') ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>index.php?url=action">
                <i class="bi bi-lightning-charge"></i>
                <span>Jenis Aksi</span>
            </a>
        </li>
    </ul>
</nav>
