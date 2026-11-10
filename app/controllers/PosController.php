<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Sale.php';
require_once __DIR__ . '/../models/Customer.php';

class PosController extends Controller
{
    public function index()
    {
        $this->checkAuth();
        $customerModel = new Customer();
        $data = [
            'customers' => $customerModel->getAll()
        ];
        $this->view('pos/index', $data);
    }

    public function checkout()
    {
        $this->checkAuth();
        if ($this->isPost()) {
            $input = json_decode(file_get_contents('php://input'), true);
            $customerId = $input['customer_id'] ?? null;
            $items = $input['items'] ?? [];
            $paidAmount = $input['paid_amount'] ?? 0;
            $paymentMethod = $input['payment_method'] ?? 'Cash';

            if (empty($items)) {
                $this->json(['success' => false, 'message' => 'Cart is empty'], 400);
            }

            try {
                $db = Database::connect();
                $db->beginTransaction();

                $subtotal = 0;
                foreach ($items as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                $totalAmount = $subtotal;
                $changeAmount = $paidAmount - $totalAmount;
                $invoiceNumber = 'INV-' . strtoupper(uniqid());

                // Insert Sale
                $stmt = $db->prepare("INSERT INTO sales (invoice_number, customer_id, user_id, subtotal, total_amount, paid_amount, change_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$invoiceNumber, $customerId, $_SESSION['user_id'], $subtotal, $totalAmount, $paidAmount, $changeAmount, $paymentMethod]);
                $saleId = $db->lastInsertId();

                // Insert Items & Update Stock
                foreach ($items as $item) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $stmtItem = $db->prepare("INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
                    $stmtItem->execute([$saleId, $item['id'], $item['quantity'], $item['price'], $itemTotal]);

                    // Deduct stock
                    $stmtStock = $db->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
                    $stmtStock->execute([$item['quantity'], $item['id']]);

                    // Log movement
                    $stmtMov = $db->prepare("INSERT INTO stock_movements (product_id, user_id, type, quantity, reference, remarks) VALUES (?, ?, 'OUT', ?, ?, ?)");
                    $stmtMov->execute([$item['id'], $_SESSION['user_id'], $item['quantity'], $invoiceNumber, 'POS Sale']);
                }

                $db->commit();
                $this->json(['success' => true, 'invoice_number' => $invoiceNumber, 'sale_id' => $saleId]);
            } catch (Exception $e) {
                $db->rollBack();
                $this->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }
    }
}
