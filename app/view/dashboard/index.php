<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-400">Total Products</p>
            <h3 class="text-3xl font-bold text-white mt-2"><?= $total_products ?></h3>
        </div>
        <div class="w-12 h-12 bg-blue-500/10 text-blue-400 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
    </div>
    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-400">Low Stock Alerts</p>
            <h3 class="text-3xl font-bold text-amber-400 mt-2"><?= $low_stock ?></h3>
        </div>
        <div class="w-12 h-12 bg-amber-500/10 text-amber-400 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
    </div>
    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-400">Total Sales</p>
            <h3 class="text-3xl font-bold text-white mt-2"><?= $total_sales ?></h3>
        </div>
        <div class="w-12 h-12 bg-emerald-500/10 text-emerald-400 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-receipt"></i>
        </div>
    </div>
    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-400">Total Revenue</p>
            <h3 class="text-3xl font-bold text-cyan-400 mt-2">$<?= number_format($total_revenue, 2) ?></h3>
        </div>
        <div class="w-12 h-12 bg-cyan-500/10 text-cyan-400 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>
</div>

<div class="bg-slate-950 border border-slate-800 rounded-xl p-6">
    <h3 class="text-lg font-bold text-white mb-4">Recent Transactions</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900 uppercase text-xs text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="p-3">Invoice</th>
                    <th class="p-3">Payment Method</th>
                    <th class="p-3">Total Amount</th>
                    <th class="p-3">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recent_sales)): ?>
                    <?php foreach ($recent_sales as $sale): ?>
                        <tr class="border-b border-slate-900 hover:bg-slate-900/50">
                            <td class="p-3 font-semibold text-white"><?= $sale['invoice_number'] ?></td>
                            <td class="p-3"><?= $sale['payment_method'] ?></td>
                            <td class="p-3 text-cyan-400 font-bold">$<?= number_format($sale['total_amount'], 2) ?></td>
                            <td class="p-3 text-slate-400"><?= $sale['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-4 text-center text-slate-500">No recent sales found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>