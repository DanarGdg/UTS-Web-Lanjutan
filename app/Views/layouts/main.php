<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' . APP_NAME : APP_NAME ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <!-- Page Content Wrapper -->
        <div id="content">
            <!-- Navbar -->
            <?php require_once __DIR__ . '/navbar.php'; ?>

            <!-- Main Page View Content -->
            <main class="page-container">
                <?php 
                if (isset($contentView) && file_exists($contentView)) {
                    require_once $contentView;
                }
                ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= BASE_URL ?>bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
