<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="cart-container">
    <h1 class="cart-title">🛒 Keranjang Belanja</h1>

    <div class="cart-item" data-price="150000">
        <div class="item-info">
            <h3>Gaming Mouse RGB</h3>
            <p>Rp 150.000</p>
        </div>
        <div class="item-action">
            <button class="qty-btn minus">−</button>
            <span class="qty">1</span>
            <button class="qty-btn plus">+</button>
            <button class="delete">✖</button>
        </div>
    </div>

    <div class="cart-item" data-price="350000">
        <div class="item-info">
            <h3>Mechanical Keyboard</h3>
            <p>Rp 350.000</p>
        </div>
        <div class="item-action">
            <button class="qty-btn minus">−</button>
            <span class="qty">1</span>
            <button class="qty-btn plus">+</button>
            <button class="delete">✖</button>
        </div>
    </div>

    <div class="cart-footer">
        <h2>Total: <span id="total">Rp 0</span></h2>
        <button class="checkout">Checkout</button>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    display: flex;
    justify-content: center;
    align-items: center;
}

.cart-container {
    width: 400px;
    padding: 25px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    box-shadow: 0 0 30px rgba(0,255,255,0.2);
    color: #fff;
}

.cart-title {
    text-align: center;
    margin-bottom: 20px;
    letter-spacing: 1px;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-radius: 15px;
    margin-bottom: 15px;
    background: rgba(255,255,255,0.08);
    transition: 0.3s;
}

.cart-item:hover {
    transform: scale(1.03);
    box-shadow: 0 0 15px rgba(0,255,255,0.5);
}

.item-info h3 {
    font-size: 16px;
}

.item-info p {
    font-size: 14px;
    color: #00ffff;
}

.item-action {
    display: flex;
    align-items: center;
    gap: 8px;
}

.qty {
    min-width: 20px;
    text-align: center;
}

.qty-btn {
    background: transparent;
    border: 1px solid #00ffff;
    color: #00ffff;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    transition: 0.3s;
}

.qty-btn:hover {
    background: #00ffff;
    color: #000;
}

.delete {
    background: transparent;
    border: none;
    color: #ff4d4d;
    font-size: 18px;
    cursor: pointer;
}

.cart-footer {
    text-align: center;
    margin-top: 20px;
}

.checkout {
    margin-top: 10px;
    width: 100%;
    padding: 12px;
    border-radius: 15px;
    border: none;
    background: linear-gradient(90deg, #00ffff, #00bfff);
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.checkout:hover {
    box-shadow: 0 0 20px #00ffff;
}
</style>

<script>
const cartItems = document.querySelectorAll('.cart-item');
const totalEl = document.getElementById('total');

function updateTotal() {
    let total = 0;

    cartItems.forEach(item => {
        if (!item.classList.contains('removed')) {
            const price = parseInt(item.dataset.price);
            const qty = parseInt(item.querySelector('.qty').innerText);
            total += price * qty;
        }
    });

    totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
}

cartItems.forEach(item => {
    const plus = item.querySelector('.plus');
    const minus = item.querySelector('.minus');
    const qtyEl = item.querySelector('.qty');
    const del = item.querySelector('.delete');

    plus.onclick = () => {
        qtyEl.innerText = parseInt(qtyEl.innerText) + 1;
        updateTotal();
    };

    minus.onclick = () => {
        if (qtyEl.innerText > 1) {
            qtyEl.innerText = parseInt(qtyEl.innerText) - 1;
            updateTotal();
        }
    };

    del.onclick = () => {
        item.classList.add('removed');
        item.style.display = 'none';
        updateTotal();
    };
});

updateTotal();
</script>