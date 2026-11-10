<?php
class Report extends Model
{
    public function getDailySales($date = null)
    {
        $date = $date ?? date('Y-m-d');
        $stmt = $this->db->prepare("
            SELECT s.*, c.name as customer_name 
            FROM sales s 
            LEFT JOIN customers c ON s.customer_id = c.id 
            WHERE DATE(s.created_at) = ?
        ");
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    public function getMonthlySales($yearMonth = null)
    {
        $yearMonth = $yearMonth ?? date('Y-m');
        $stmt = $this->db->prepare("
            SELECT DATE(created_at) as sale_date, COUNT(*) as total_transactions, SUM(total_amount) as daily_revenue 
            FROM sales 
            WHERE DATE_FORMAT(created_at, '%Y-%m') = ? 
            GROUP BY DATE(created_at) 
            ORDER BY sale_date DESC
        ");
        $stmt->execute([$yearMonth]);
        return $stmt->fetchAll();
    }

    public function getProfitReport()
    {
        $stmt = $this->db->query("
            SELECT 
                p.id, 
                p.name, 
                p.sku, 
                SUM(si.quantity) as total_sold, 
                SUM(si.total_price) as total_revenue, 
                SUM(si.quantity * p.cost_price) as total_cost, 
                (SUM(si.total_price) - SUM(si.quantity * p.cost_price)) as net_profit 
            FROM sale_items si 
            JOIN products p ON si.product_id = p.id 
            GROUP BY p.id 
            ORDER BY net_profit DESC
        ");
        return $stmt->fetchAll();
    }
}
