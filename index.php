<?php

// Load configurations
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

// Load Core classes
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';

// Initialize Router
$app = new Router();
