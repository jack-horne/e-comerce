<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .cart-table img {
      width: 80px;
      height: 80px;
      object-fit: contain;
    }
    .cart-table th, .cart-table td {
      vertical-align: middle;
    }
    .price {
      color: #d63384;
      font-weight: bold;
    }
    .old-price {
      text-decoration: line-through;
      color: gray;
      font-size: 0.9rem;
    }
    .shop-name {
      font-weight: bold;
    }
    .footer {
      margin-top: 20px;
      padding: 15px;
      background: white;
      border-top: 1px solid #dee2e6;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <h3 class="mb-4">Keranjang Belanja</h3>

  <!-- Tabel Produk -->
  <table class="table cart-table bg-white shadow-sm">
    <thead class="table-light">
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
            <img src="public/image/product/ASRock Radeon RX 6500 XT 4GB DDR6 - Phantom Gaming D 4G OC.png" alt="VGA" width="100">

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
            <button class="btn btn-outline-secondary btn-minus">-</button>
            <input type="text" class="form-control text-center qty" value="1">
            <button class="btn btn-outline-secondary btn-plus">+</button>
          </div>
        </td>
        <td class="total-price">Rp45.140</td>
        <td><button class="btn btn-outline-danger btn-sm">🗑 Hapus</button></td>
      </tr>

      <tr>
        <td><input type="checkbox" class="check-item"></td>
        <td>
          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/80x80?text=Knalpot" alt="WRX GP3">
            <div class="ms-3">
              <div>Knalpot WRX GP3 Limited K150 Vario</div>
            </div>
          </div>
        </td>
        <td>
          <div class="price">Rp1.425.000</div>
          <div class="old-price">Rp1.500.000 (5%)</div>
        </td>
        <td>
          <div class="input-group input-group-sm" style="width: 120px;">
            <button class="btn btn-outline-secondary btn-minus">-</button>
            <input type="text" class="form-control text-center qty" value="1">
            <button class="btn btn-outline-secondary btn-plus">+</button>
          </div>
        </td>
        <td class="total-price">Rp1.425.000</td>
        <td><button class="btn btn-outline-danger btn-sm">🗑 Hapus</button></td>
      </tr>

      <tr>
        <td><input type="checkbox" class="check-item"></td>
        <td>
          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/80x80?text=Mouse" alt="Logitech MX Master 3S">
            <div class="ms-3">
              <div>Logitech MX Master 3S Performance Mouse</div>
            </div>
          </div>
        </td>
        <td>
          <div class="price">Rp1.667.250</div>
          <div class="old-price">Rp2.099.000 (21%)</div>
        </td>
        <td>
          <div class="input-group input-group-sm" style="width: 120px;">
            <button class="btn btn-outline-secondary btn-minus">-</button>
            <input type="text" class="form-control text-center qty" value="1">
            <button class="btn btn-outline-secondary btn-plus">+</button>
          </div>
        </td>
        <td class="total-price">Rp1.667.250</td>
        <td><button class="btn btn-outline-danger btn-sm">🗑 Hapus</button></td>
      </tr>
    </tbody>
  </table>

  <!-- Footer -->
  <div class="footer shadow-sm">
    <div>
      <input type="checkbox" id="selectAll"> <label for="selectAll">Pilih Semua</label>
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
