<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    h3 {
      font-weight: 600;
      color: #333;
    }

    .cart-table {
      border-radius: 15px;
      overflow: hidden;
    }

    .cart-table img {
      width: 80px;
      height: 80px;
      object-fit: contain;
      border-radius: 10px;
      background-color: #f2f2f2;
      padding: 5px;
    }

    .cart-table th {
      background-color: #eef1ff;
      font-weight: 600;
    }

    .cart-table tr {
      transition: 0.2s;
    }

    .cart-table tr:hover {
      background-color: #f9faff;
    }

    .price {
      color: #e91e63;
      font-weight: bold;
      font-size: 1rem;
    }

    .old-price {
      text-decoration: line-through;
      color: gray;
      font-size: 0.85rem;
    }

    .btn-minus, .btn-plus {
      border: 1px solid #dee2e6;
      color: #333;
      transition: 0.2s;
    }

    .btn-minus:hover, .btn-plus:hover {
      background-color: #0d6efd;
      color: #fff;
    }

    .btn-outline-danger {
      border-radius: 6px;
    }

    .footer {
      margin-top: 25px;
      padding: 20px 25px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .footer strong {
      font-size: 1.2rem;
      color: #212529;
    }

    .btn-success {
      font-weight: 500;
      padding: 10px 20px;
      border-radius: 8px;
    }

    /* animasi kecil saat hover beli */
    .btn-success:hover {
      background-color: #198754;
      transform: scale(1.03);
      transition: 0.2s;
    }
  </style>
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
      <div class="container-fluid px-4">
<<<<<<< HEAD
         <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
      <img src="/e_commerce2/public/image/icons/logo.png" alt="Logo" width="35" height="35" class="me-2">
      Pixel Part
    </a>

=======
        <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
          <img src="../public/image/icons/logo.png" alt="Logo" width="35" height="35" class="me-2">
          Pixel Part
        </a>
>>>>>>> fe5ecd52205490683c7d147950170d4410a813c5

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
          <form class="d-flex flex-grow-1 justify-content-center mx-lg-4 my-2 my-lg-0" role="search">
            <div class="input-group w-75 w-lg-50">
              <input class="form-control border-0" type="search" placeholder="Search..." aria-label="Search">
              <button class="btn btn-light border-0" type="submit">
                <i class="fas fa-search text-primary"></i>
              </button>
            </div>
          </form>

          <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item">
              <a class="nav-link text-white fw-semibold" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white fw-semibold" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white fw-semibold" href="register.php">Register</a>
            </li>
            <li class="nav-item position-relative">
              <a class="nav-link text-white fw-semibold" href="chart.php">
                <i class="fas fa-shopping-cart"></i> Keranjang
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="cart-count">0</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

<div class="container mt-4">
  <h3 class="mb-4 text-primary">🛒 Keranjang Belanja</h3>

  <!-- Tabel Produk -->
  <table class="table cart-table bg-white shadow-sm">
    <thead>
      <tr>
        <th><input type="checkbox" id="checkAll"></th>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Aksi</th>
      </tr>
    </thead>
  <tbody id="cart-items">
      <!-- Cart items will be loaded dynamically -->
    </tbody>
  </table>

  <!-- Footer -->
  <div class="footer">
    <div>
      <input type="checkbox" id="selectAll"> 
      <label for="selectAll" class="ms-2">Pilih Semua</label>
    </div>
    <div>
      <strong>Total Bayar: Rp3.137.390</strong>
      <button class="btn btn-success ms-3">Beli Sekarang</button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let selectedItems = [];

    function loadCart() {
      const cartItemsContainer = document.getElementById('cart-items');
      cartItemsContainer.innerHTML = '';

      if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<tr><td colspan="6" class="text-center py-4">Keranjang kosong</td></tr>';
        updateCartBadge();
        updateTotal();
        return;
      }

      cart.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td><input type="checkbox" class="check-item" data-index="${index}"></td>
          <td>
            <div class="d-flex align-items-center">
              <img src="../${item.image}" alt="${item.name}" width="80">
              <div class="ms-3">
                <div>${item.name}</div>
              </div>
            </div>
          </td>
          <td>
            <div class="price">Rp${item.price.toLocaleString()}</div>
          </td>
          <td>
            <div class="input-group input-group-sm" style="width: 120px;">
              <button class="btn btn-minus" data-index="${index}">-</button>
              <input type="text" class="form-control text-center qty" value="${item.quantity}" data-index="${index}">
              <button class="btn btn-plus" data-index="${index}">+</button>
            </div>
          </td>
          <td class="total-price">Rp${(item.price * item.quantity).toLocaleString()}</td>
          <td><button class="btn btn-outline-danger btn-sm remove-item" data-index="${index}">🗑 Hapus</button></td>
        `;
        cartItemsContainer.appendChild(row);
      });

      updateCartBadge();
      updateTotal();
      attachEventListeners();
    }

    function updateCartBadge() {
      const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
      const badge = document.getElementById('cart-badge');
      if (badge) {
        badge.textContent = totalItems;
      }
    }

    function attachEventListeners() {
      // Quantity buttons
      document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
          const index = parseInt(this.dataset.index);
          cart[index].quantity += 1;
          localStorage.setItem('cart', JSON.stringify(cart));
          loadCart();
        });
      });

      document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
          const index = parseInt(this.dataset.index);
          if (cart[index].quantity > 1) {
            cart[index].quantity -= 1;
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
          }
        });
      });

      // Remove item
      document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
          const index = parseInt(this.dataset.index);
          cart.splice(index, 1);
          localStorage.setItem('cart', JSON.stringify(cart));
          loadCart();
        });
      });

      // Checkbox selection
      document.querySelectorAll('.check-item').forEach(cb => {
        cb.addEventListener('change', function() {
          const index = parseInt(this.dataset.index);
          if (this.checked) {
            selectedItems.push(index);
          } else {
            selectedItems = selectedItems.filter(i => i !== index);
          }
          updateTotal();
        });
      });
    }

    function updateTotal() {
      let total = 0;
      selectedItems.forEach(index => {
        if (cart[index]) {
          total += cart[index].price * cart[index].quantity;
        }
      });
      document.querySelector('.footer strong').textContent = `Total Bayar: Rp${total.toLocaleString()}`;
    }

    // Select all checkbox
    const checkAll = document.getElementById('checkAll');
    checkAll.addEventListener('change', () => {
      const items = document.querySelectorAll('.check-item');
      selectedItems = [];
      items.forEach((cb, index) => {
        cb.checked = checkAll.checked;
        if (checkAll.checked) {
          selectedItems.push(index);
        }
      });
      updateTotal();
    });

    loadCart();
  });
</script>

</body>
</html>
