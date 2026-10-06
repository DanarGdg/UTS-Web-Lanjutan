<!-- Navbar Component -->
<header class="main-navbar">
    <div class="user-profile-info">
        <div class="user-details">
            <div class="user-name"><?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Administrator' ?></div>
            <div class="user-email"><?= isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'admin@pnj.ac.id' ?></div>
        </div>
        <a href="<?= BASE_URL ?>index.php?url=auth/logout" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </div>
</header>
