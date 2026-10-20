<?php

require_once __DIR__ . '/../../core/Model.php';

// Model untuk tabel users (sesuai materi PPT Login & Register)
class User extends Model {
    protected $table = 'users';

    // Mencari data user berdasarkan username
    public function findByUsername($username) {
        if (!$this->db) return null;
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            return null;
        }
    }

    // Mencari data user berdasarkan email
    public function findByEmail($email) {
        if (!$this->db) return null;
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            return null;
        }
    }

    // Mengecek apakah username sudah terdaftar
    public function cekNama($username) {
        if (!$this->db) return 0;
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            return (int) $stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    // Menambahkan pengguna baru ke tabel users
    public function registerUser($data) {
        if (!$this->db) return false;
        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, username, email, password, created_at, updated_at) 
                                        VALUES (:name, :username, :email, :password, NOW(), NOW())");
            return $stmt->execute([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'] // Di-hash dengan password_hash() sebelum dipanggil
            ]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    // Mengambil semua data user
    public function getAllUsers() {
        if (!$this->db) return [];
        try {
            $stmt = $this->db->query("SELECT id, name, username, email, created_at FROM users ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }
}

