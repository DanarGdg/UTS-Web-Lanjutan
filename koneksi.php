<?php

// Memuat konfigurasi database jika belum dimuat
if (!defined('DB_HOST')) {
    require_once __DIR__ . '/config/database.php';
}

// Koneksi database menggunakan MySQLi sesuai materi PPT
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek apakah koneksi berhasil
if (!$con) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset utf8mb4
mysqli_set_charset($con, "utf8mb4");

