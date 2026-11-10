<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Sale.php';

class DashboardController extends Controller
{
    public function index()
    {
        $this->checkAuth();

        $productModel = new Product();
        $saleModel = new Sale();

        $data = [
            'total_products' => $productModel->getTotalProducts(),
            'low_stock' => $productModel->getLowStockCount(),
            'total_sales' => $saleModel->getTotalSalesCount(),
            'total_revenue' => $saleModel->getTotalRevenue(),
            'recent_sales' => $saleModel->getRecentSales(5)
        ];

        $this->view('dashboard/index', $data);
    }
}
