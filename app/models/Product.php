<?php
class Product extends Model
{
    public function getAllWithDetails()
    {
        $stmt = $this->db->query("
            SELECT p.*, c.name as category_name, s.name as supplier_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LEFT JOIN suppliers s ON p.supplier_id = s.id 
            ORDER BY p.id DESC
        ");
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, sku, barcode, category_id, supplier_id, item_location, cost_price, selling_price, stock_quantity, min_stock_alert, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['sku'],
            $data['barcode'] ?? null,
            $data['category_id'] ?? null,
            $data['supplier_id'] ?? null,
            $data['item_location'] ?? null,
            $data['cost_price'],
            $data['selling_price'],
            $data['stock_quantity'] ?? 0,
            $data['min_stock_alert'] ?? 5,
            $data['image'] ?? 'default.png'
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE products SET name = ?, sku = ?, barcode = ?, category_id = ?, supplier_id = ?, item_location = ?, cost_price = ?, selling_price = ?, stock_quantity = ?, min_stock_alert = ?, image = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['sku'],
            $data['barcode'] ?? null,
            $data['category_id'] ?? null,
            $data['supplier_id'] ?? null,
            $data['item_location'] ?? null,
            $data['cost_price'],
            $data['selling_price'],
            $data['stock_quantity'],
            $data['min_stock_alert'],
            $data['image'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getLowStockCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM products WHERE stock_quantity <= min_stock_alert");
        return $stmt->fetch()['count'];
    }

    public function getTotalProducts()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM products");
        return $stmt->fetch()['count'];
    }

    public function search($keyword)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.name LIKE ? OR p.sku LIKE ? OR p.barcode LIKE ?
            LIMIT 15
        ");
        $term = "%{$keyword}%";
        $stmt->execute([$term, $term, $term]);
        return $stmt->fetchAll();
    }
}
