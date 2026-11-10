<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left: Product Search & Grid -->
    <div class="lg:col-span-2 space-y-4">
        <div class="relative">
            <input type="text" id="productSearch" placeholder="Search spare parts by name, SKU or scan barcode..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 pl-10 text-white focus:outline-none focus:border-cyan-500">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-4 text-slate-400"></i>
        </div>
        <div id="productResultsGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Dynamically populated via JavaScript AJAX -->
        </div>
    </div>

    <!-- Right: Active Cart & Checkout -->
    <div class="bg-slate-950 border border-slate-800 rounded-xl p-6 flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-bold text-white mb-4"><i class="fa-solid fa-cart-shopping mr-2"></i>Current Invoice</h3>
            <div id="cartItemsList" class="space-y-3 max-h-80 overflow-y-auto pr-2 mb-4">
                <p class="text-slate-500 text-center py-8">Cart is currently empty</p>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-4 space-y-3">
            <div class="flex justify-between text-slate-400 text-sm">
                <span>Subtotal</span>
                <span id="cartSubtotal" class="text-white font-semibold">$0.00</span>
            </div>
            <div class="flex justify-between text-slate-400 text-sm">
                <span>Total Payable</span>
                <span id="cartTotal" class="text-cyan-400 font-bold text-xl">$0.00</span>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-slate-400">Customer</label>
                <select id="customerId" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-white text-sm">
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-slate-400">Cash Tendered</label>
                <input type="number" id="paidAmount" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-white text-sm" placeholder="0.00">
            </div>

            <button onclick="checkoutOrder()" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-cyan-900/30">
                Complete Checkout
            </button>
        </div>
    </div>
</div>

<script src="/assets/js/pos.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>