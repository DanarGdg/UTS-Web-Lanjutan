<?php

require_once __DIR__ . '/../../core/Model.php';

class Action extends Model {
    protected $table = 'actions';

    public function getActions() {
        if (!$this->db) return [];
        $stmt = $this->db->prepare("SELECT * FROM actions WHERE deleted_at IS NULL");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getActionById($id) {
        if (!$this->db) return null;
        $stmt = $this->db->prepare("SELECT * FROM actions WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function createAction($data) {
        if (!$this->db) return false;
        $id = self::generateUuid();
        $stmt = $this->db->prepare("INSERT INTO actions (id, name, description, created_at, updated_at) 
                                    VALUES (:id, :name, :description, NOW(), NOW())");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);
    }

    public function updateAction($id, $data) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("UPDATE actions 
                                    SET name = :name, description = :description, updated_at = NOW() 
                                    WHERE id = :id AND deleted_at IS NULL");
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);
    }

    public function deleteAction($id) {
        if (!$this->db) return false;
        // Soft delete
        $stmt = $this->db->prepare("UPDATE actions SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
