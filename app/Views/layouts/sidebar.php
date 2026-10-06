<!-- Sidebar Component -->
<nav id="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-shield-check"></i>
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
