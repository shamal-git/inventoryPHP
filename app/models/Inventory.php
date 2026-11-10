<?php
class Inventory extends Model
{
    public function getAllMovements()
    {
        $stmt = $this->db->query("
            SELECT sm.*, p.name as product_name, p.sku, u.name as user_name 
            FROM stock_movements sm 
            JOIN products p ON sm.product_id = p.id 
            LEFT JOIN users u ON sm.user_id = u.id 
            ORDER BY sm.id DESC
        ");
        return $stmt->fetchAll();
    }

    public function addMovement($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO stock_movements (product_id, user_id, type, quantity, reference, remarks) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['product_id'],
            $data['user_id'],
            $data['type'], // 'IN', 'OUT', 'ADJUSTMENT'
            $data['quantity'],
            $data['reference'] ?? null,
            $data['remarks'] ?? null
        ]);
    }
}
