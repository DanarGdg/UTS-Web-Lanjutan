<?php

require_once __DIR__ . '/../../core/Model.php';

// Model untuk tabel accounts
class Account extends Model {
    protected $table = 'accounts';

    // Mengambil seluruh data akun aktif beserta relasi tipe akun
    public function getAccounts() {
        if (!$this->db) return [];
        $stmt = $this->db->prepare("SELECT a.*, t.name as account_type_name 
                                    FROM accounts a 
                                    LEFT JOIN account_type t ON a.account_type_id = t.id 
                                    WHERE a.deleted_at IS NULL");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Mengambil satu data akun berdasarkan ID
    public function getAccountById($id) {
        if (!$this->db) return null;
        $stmt = $this->db->prepare("SELECT * FROM accounts WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Menambahkan data akun baru ke database
    public function createAccount($data) {
        if (!$this->db) return false;
        $id = self::generateUuid();
        $stmt = $this->db->prepare("INSERT INTO accounts (id, name, email, password, account_type_id, status, identification_number, identification_type, created_at, updated_at) 
                                    VALUES (:id, :name, :email, :password, :account_type_id, :status, :identification_number, :identification_type, NOW(), NOW())");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'account_type_id' => $data['account_type_id'],
            'status' => $data['status'],
            'identification_number' => $data['identification_number'],
            'identification_type' => $data['identification_type']
        ]);
    }

    // Memperbarui data akun berdasarkan ID
    public function updateAccount($id, $data) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("UPDATE accounts 
                                    SET name = :name, email = :email, account_type_id = :account_type_id, status = :status, identification_number = :identification_number, identification_type = :identification_type, updated_at = NOW() 
                                    WHERE id = :id AND deleted_at IS NULL");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'email' => $data['email'],
            'account_type_id' => $data['account_type_id'],
            'status' => $data['status'],
            'identification_number' => $data['identification_number'],
            'identification_type' => $data['identification_type']
        ]);
    }

    // Menghapus data akun secara soft delete (mengisi kolom deleted_at)
    public function deleteAccount($id) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("UPDATE accounts SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Mencari data akun berdasarkan email untuk proses autentikasi
    public function findByEmail($email) {
        if (!$this->db) return null;
        $stmt = $this->db->prepare("SELECT a.*, t.name as account_type_name 
                                    FROM accounts a 
                                    LEFT JOIN account_type t ON a.account_type_id = t.id 
                                    WHERE a.email = :email AND a.deleted_at IS NULL");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
