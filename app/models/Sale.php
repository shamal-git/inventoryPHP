<?php
class Sale extends Model
{
    public function getTotalSalesCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM sales");
        return $stmt->fetch()['count'];
    }

    public function getTotalRevenue()
    {
        $stmt = $this->db->query("SELECT SUM(total_amount) as total FROM sales");
        return $stmt->fetch()['total'] ?? 0.00;
    }

    public function getRecentSales($limit = 5)
    {
        $stmt = $this->db->prepare("
            SELECT s.*, c.name as customer_name, u.name as user_name 
            FROM sales s 
            LEFT JOIN customers c ON s.customer_id = c.id 
            LEFT JOIN users u ON s.user_id = u.id 
            ORDER BY s.id DESC LIMIT ?
        ");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT s.*, c.name as customer_name, u.name as user_name 
            FROM sales s 
            LEFT JOIN customers c ON s.customer_id = c.id 
            LEFT JOIN users u ON s.user_id = u.id 
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getSaleItems($saleId)
    {
        $stmt = $this->db->prepare("
            SELECT si.*, p.name as product_name, p.sku 
            FROM sale_items si 
            JOIN products p ON si.product_id = p.id 
            WHERE si.sale_id = ?
        ");
        $stmt->execute([$saleId]);
        return $stmt->fetchAll();
    }
}
