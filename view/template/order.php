<?php
require_once '../../config/connection.php';
require_once '../../backend/midtrans_config.php'; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../../index.php');
    exit;
}

$product_id = (int)$_GET['id'];

// Ambil detail produk
$query = "SELECT p.*, k.nm_kategori
          FROM produk p
          LEFT JOIN kat_produk k ON p.id_kategori = k.id_kategori
          WHERE p.id_produk = ? AND p.kodisi = 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header('Location: ../../index.php');
    exit;
}

$product = mysqli_fetch_assoc($result);

// PROSES MIDTRANS SAAT FORM DISUBMIT
$snapToken = null; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']); // Ambil data alamat dari form
    $quantity = (int)$_POST['quantity'];
    
    // Hitung harga setelah diskon
    $harga_satuan = $product['harga'] * (1 - $product['diskon']/100);
    $total_harga = $quantity * $harga_satuan;
    
    $kd_invoice = 'INV-' . time();
    $id_user = 1; 

    // 1. Simpan ke tabel PENJUALAN
    $query_penjualan = "INSERT INTO penjualan (id_user, kd_invoice, total_harga, status_pembayaran) 
                        VALUES (?, ?, ?, 'Pending')";
    $stmt_p = mysqli_prepare($conn, $query_penjualan);
    mysqli_stmt_bind_param($stmt_p, "isd", $id_user, $kd_invoice, $total_harga);

    if (mysqli_stmt_execute($stmt_p)) {
        $id_penjualan = mysqli_insert_id($conn);

        // 2. Simpan ke tabel DETAIL_PENJUALAN
        $query_detail = "INSERT INTO detail_penjualan (id_produk, harga, qty) VALUES (?, ?, ?)";
        $stmt_d = mysqli_prepare($conn, $query_detail);
        mysqli_stmt_bind_param($stmt_d, "idi", $product_id, $harga_satuan, $quantity);
        mysqli_stmt_execute($stmt_d);

        // 3. Siapkan Parameter Midtrans yang Lebih Lengkap
        $params = [
            'transaction_details' => [
                'order_id' => $kd_invoice,
                'gross_amount' => (int)$total_harga,
            ],
            // MENAMPILKAN DAFTAR BARANG
            'item_details' => [
                [
                    'id' => $product_id,
                    'price' => (int)$harga_satuan,
                    'quantity' => $quantity,
                    'name' => substr($product['nm_produk'], 0, 50), // Midtrans membatasi nama produk 50 karakter
                ]
            ],
            // MENAMPILKAN DETAIL PELANGGAN & ALAMAT
            'customer_details' => [
                'first_name'    => $nama,
                'email'         => $email,
                'phone'         => $telepon,
                'billing_address' => [
                    'first_name' => $nama,
                    'email'      => $email,
                    'phone'      => $telepon,
                    'address'    => $alamat,
                ],
                'shipping_address' => [
                    'first_name' => $nama,
                    'email'      => $email,
                    'phone'      => $telepon,
                    'address'    => $alamat,
                ]
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (Exception $e) {
            $error = "Midtrans Error: " . $e->getMessage();
        }
    } else {
        $error = "Gagal menyimpan data penjualan: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - <?php echo htmlspecialchars($product['nm_produk']); ?> - Pixel Part</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-U2pdocRQG3su3-Dp"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container">
            <a class="navbar-brand logo" href="../../index.php">PixelPart</a>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; margin-bottom: 50px;">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card bg-dark text-white border-secondary">
                    <div class="card-header border-secondary">
                        <h5 class="mb-0">Ringkasan Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="../../public/image/product/<?php echo htmlspecialchars($product['gambar']); ?>"
                                 class="img-fluid me-3" style="width: 100px; height: 100px; object-fit: contain;">
                            <div>
                                <h6><?php echo htmlspecialchars($product['nm_produk']); ?></h6>
                                <p class="text-primary fw-bold">
                                    Rp <?php echo number_format($product['harga'] * (1 - $product['diskon']/100), 0, ',', '.'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card bg-dark text-white border-secondary p-4">
                    <h4>Informasi Pembeli</h4>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control bg-secondary text-white border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control bg-secondary text-white border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="tel" name="telepon" class="form-control bg-secondary text-white border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control bg-secondary text-white border-0" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control bg-secondary text-white border-0">
                        </div>
                        <div class="py-3 border-top border-secondary mt-3">
                            <h5>Total: <span id="total-price" class="text-primary">Rp <?php echo number_format($product['harga'] * (1 - $product['diskon']/100), 0, ',', '.'); ?></span></h5>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 py-3 fw-bold">
                            <i class="fas fa-credit-card me-2"></i> LANJUTKAN PEMBAYARAN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update total harga real-time
        const quantityInput = document.getElementById('quantity');
        const totalPriceDisp = document.getElementById('total-price');
        const pricePerUnit = <?php echo $product['harga'] * (1 - $product['diskon']/100); ?>;

        quantityInput.addEventListener('input', () => {
            let qty = parseInt(quantityInput.value) || 1;
            let total = pricePerUnit * qty;
            totalPriceDisp.innerText = 'Rp ' + total.toLocaleString('id-ID');
        });

        // TRIGGER POPUP MIDTRANS JIKA TOKEN ADA
        <?php if ($snapToken): ?>
            window.snap.pay('<?php echo $snapToken; ?>', {
                onSuccess: function(result) {
                    alert("Pembayaran Berhasil!");
                    window.location.href = "../../index.php?status=success";
                },
                onPending: function(result) {
                    alert("Selesaikan pembayaran Anda segera.");
                    window.location.href = "../../index.php?status=pending";
                },
                onError: function(result) {
                    alert("Pembayaran Gagal.");
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>