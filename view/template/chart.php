<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

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
    <tbody>
      <tr>
        <td><input type="checkbox" class="check-item"></td>
        <td>
          <div class="d-flex align-items-center">
            <img src="/e_commerce2/public/image/product/ASRock Radeon RX 6500 XT 4GB DDR6 - Phantom Gaming D 4G OC.png" alt="VGA" width="100">
            <div class="ms-3">
              <div>ASRock Radeon RX 6500 XT 4GB DDR6 - Phantom Gaming D 4G OC</div>
            </div>
          </div>
        </td>
        <td>
          <div class="price">Rp45.140</div>
          <div class="old-price">Rp62.000 (27%)</div>
        </td>
        <td>
          <div class="input-group input-group-sm" style="width: 120px;">
            <button class="btn btn-minus">-</button>
            <input type="text" class="form-control text-center qty" value="1">
            <button class="btn btn-plus">+</button>
          </div>
        </td>
        <td class="total-price">Rp45.140</td>
        <td><button class="btn btn-outline-danger btn-sm">🗑 Hapus</button></td>
      </tr>

      <tr>
        <td><input type="checkbox" class="check-item"></td>
        <td>
          <div class="d-flex align-items-center">
            <img src="/e_commerce2/public/image/product/ASRock Radeon RX 7800 XT 16GB GDDR6 - Challenger 16G OC.png" alt="VGA" width="100">
            <div class="ms-3">
              <div>ASRock Radeon RX 7800 XT 16GB GDDR6 - Challenger 16G OC</div>
            </div>
          </div>
        </td>
        <td>
          <div class="price">Rp1.425.000</div>
          <div class="old-price">Rp1.500.000 (5%)</div>
        </td>
        <td>
          <div class="input-group input-group-sm" style="width: 120px;">
            <button class="btn btn-minus">-</button>
            <input type="text" class="form-control text-center qty" value="1">
            <button class="btn btn-plus">+</button>
          </div>
        </td>
        <td class="total-price">Rp1.425.000</td>
        <td><button class="btn btn-outline-danger btn-sm">🗑 Hapus</button></td>
      </tr>

      <tr>
        <td><input type="checkbox" class="check-item"></td>
        <td>
          <div class="d-flex align-items-center">
            <img src="/e_commerce2/public/image/product/Intel Core Ultra 5 225 3.3GHz Up To 4.9GHz - Cache 20MB [Box] Socket LGA 1851 - Arrow Lake Series.jpg" alt="VGA" width="100">
            <div class="ms-3">
              <div>Intel Core Ultra 5 225 3.3GHz Up To 4.9GHz - Cache 20MB [Box] Socket LGA 1851 - Arrow Lake Series</div>
            </div>
          </div>
        </td>
        <td>
          <div class="price">Rp1.667.250</div>
          <div class="old-price">Rp2.099.000 (21%)</div>
        </td>
        <td>
          <div class="input-group input-group-sm" style="width: 120px;">
            <button class="btn btn-minus">-</button>
            <input type="text" class="form-control text-center qty" value="1">
            <button class="btn btn-plus">+</button>
          </div>
        </td>
        <td class="total-price">Rp1.667.250</td>
        <td><button class="btn btn-outline-danger btn-sm">🗑 Hapus</button></td>
      </tr>
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
  // Fungsi tambah/kurang jumlah
  document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.addEventListener('click', () => {
      let input = btn.parentElement.querySelector('.qty');
      input.value = parseInt(input.value) + 1;
    });
  });

  document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.addEventListener('click', () => {
      let input = btn.parentElement.querySelector('.qty');
      if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    });
  });

  // Pilih semua checkbox
  const checkAll = document.getElementById('checkAll');
  const items = document.querySelectorAll('.check-item');

  checkAll.addEventListener('change', () => {
    items.forEach(cb => cb.checked = checkAll.checked);
  });
</script>

</body>
</html>
