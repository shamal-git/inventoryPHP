let cart = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchProducts('');
    const searchInput = document.getElementById('productSearch');
    searchInput.addEventListener('input', (e) => {
        fetchProducts(e.target.value);
    });
});

async function fetchProducts(query) {
    try {
        const res = await fetch(`/products/search?q=${encodeURIComponent(query)}`);
        const products = await res.json();
        const grid = document.getElementById('productResultsGrid');
        grid.innerHTML = '';

        products.forEach(p => {
            grid.innerHTML += `
                <div onclick="addToCart(${p.id}, '${p.name}', ${p.selling_price}, ${p.stock_quantity})" class="bg-slate-950 border border-slate-800 hover:border-cyan-500/50 p-4 rounded-xl cursor-pointer transition flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-mono text-cyan-400">${p.sku}</span>
                        <h4 class="font-semibold text-white text-sm mt-1 mb-2">${p.name}</h4>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-white font-bold">$${parseFloat(p.selling_price).toFixed(2)}</span>
                        <span class="text-xs px-2 py-0.5 rounded ${p.stock_quantity > 5 ? 'bg-emerald-950 text-emerald-400' : 'bg-amber-950 text-amber-400'}">Qty: ${p.stock_quantity}</span>
                    </div>
                </div>
            `;
        });
    } catch (err) {
        console.error('Error fetching products', err);
    }
}

function addToCart(id, name, price, maxStock) {
    const existing = cart.find(item => item.id === id);
    if (existing) {
        if (existing.quantity < maxStock) {
            existing.quantity++;
        } else {
            alert('Cannot add more than available stock!');
        }
    } else {
        cart.push({ id, name, price, quantity: 1, maxStock });
    }
    renderCart();
}

function updateQuantity(id, qty) {
    const item = cart.find(i => i.id === id);
    if (item) {
        if (qty > item.maxStock) {
            alert('Exceeds available stock quantity!');
            return;
        }
        item.quantity = parseInt(qty) || 1;
        if (item.quantity <= 0) cart = cart.filter(i => i.id !== id);
    }
    renderCart();
}

function removeFromCart(id) {
    cart = cart.filter(i => i.id !== id);
    renderCart();
}

function renderCart() {
    const list = document.getElementById('cartItemsList');
    const subtotalEl = document.getElementById('cartSubtotal');
    const totalEl = document.getElementById('cartTotal');

    if (cart.length === 0) {
        list.innerHTML = `<p class="text-slate-500 text-center py-8">Cart is currently empty</p>`;
        subtotalEl.innerText = '$0.00';
        totalEl.innerText = '$0.00';
        return;
    }

    list.innerHTML = '';
    let subtotal = 0;

    cart.forEach(item => {
        subtotal += item.price * item.quantity;
        list.innerHTML += `
            <div class="flex items-center justify-between bg-slate-900 p-3 rounded-lg border border-slate-800">
                <div>
                    <h5 class="text-sm font-semibold text-white">${item.name}</h5>
                    <span class="text-xs text-cyan-400">$${item.price.toFixed(2)} each</span>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="number" value="${item.quantity}" min="1" max="${item.maxStock}" onchange="updateQuantity(${item.id}, this.value)" class="w-14 bg-slate-950 border border-slate-800 text-center text-white rounded p-1 text-xs">
                    <button onclick="removeFromCart(${item.id})" class="text-rose-400 hover:text-rose-300 px-1"><i class="fa-solid fa-trash text-xs"></i></button>
                </div>
            </div>
        `;
    });

    subtotalEl.innerText = `$${subtotal.toFixed(2)}`;
    totalEl.innerText = `$${subtotal.toFixed(2)}`;
}

async function checkoutOrder() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }

    const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    const customerId = document.getElementById('customerId').value;
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    if (paidAmount < total) {
        alert('Paid amount cannot be less than total payable amount!');
        return;
    }

    try {
        const res = await fetch('/pos/checkout', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ customer_id: customerId, items: cart, paid_amount: paidAmount, payment_method: 'Cash' })
        });
        const result = await res.json();
        if (result.success) {
            alert(`Checkout successful! Invoice: ${result.invoice_number}`);
            cart = [];
            renderCart();
            document.getElementById('paidAmount').value = '';
            fetchProducts('');
        } else {
            alert('Checkout failed: ' + result.message);
        }
    } catch (err) {
        console.error('Checkout error', err);
    }
}