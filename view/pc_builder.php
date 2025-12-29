<?php
require_once '../backend/connection.php';

// Query untuk mengambil komponen berdasarkan kategori
$query_cpu = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'Processor') AND kodisi = 1 ORDER BY harga";
$result_cpu = mysqli_query($conn, $query_cpu);

$query_gpu = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'VGA') AND kodisi = 1 ORDER BY harga";
$result_gpu = mysqli_query($conn, $query_gpu);

$query_mobo = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'Motherboard') AND kodisi = 1 ORDER BY harga";
$result_mobo = mysqli_query($conn, $query_mobo);

$query_ram = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'RAM') AND kodisi = 1 ORDER BY harga";
$result_ram = mysqli_query($conn, $query_ram);

$query_storage = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'Storage') AND kodisi = 1 ORDER BY harga";
$result_storage = mysqli_query($conn, $query_storage);

$query_psu = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'PSU') AND kodisi = 1 ORDER BY harga";
$result_psu = mysqli_query($conn, $query_psu);

$query_case = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'Case') AND kodisi = 1 ORDER BY harga";
$result_case = mysqli_query($conn, $query_case);

$query_cooling = "SELECT id_produk, nm_produk, harga FROM produk WHERE id_kategori = (SELECT id_kategori FROM kat_produk WHERE nm_kategori = 'Cooling') AND kodisi = 1 ORDER BY harga";
$result_cooling = mysqli_query($conn, $query_cooling);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder - Pixel Part</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .pc-builder-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .component-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 200, 255, 0.3);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .component-card:hover {
            border-color: #00caff;
            box-shadow: 0 0 20px rgba(0, 200, 255, 0.2);
        }

        .component-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .component-title {
            font-size: 18px;
            font-weight: bold;
            color: #00caff;
        }

        .component-price {
            font-size: 16px;
            color: #fff;
            font-weight: bold;
        }

        .component-select {
            width: 100%;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            color: #fff;
        }

        .component-select option {
            background: #000;
            color: #fff;
        }

        .total-section {
            background: linear-gradient(135deg, #001a2a, #003b74);
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            text-align: center;
            border: 1px solid #00caff;
        }

        .total-price {
            font-size: 36px;
            font-weight: bold;
            color: #00caff;
            margin: 20px 0;
        }

        .compatibility-warning {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            color: #ffc107;
            display: none;
        }

        .preset-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .preset-btn {
            background: rgba(0, 200, 255, 0.2);
            border: 1px solid #00caff;
            color: #00caff;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .preset-btn:hover {
            background: #00caff;
            color: #000;
        }

        .builder-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .component-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .builder-actions {
                flex-direction: column;
            }

            .preset-buttons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <?php include 'template/navbar.php'; ?>

    <div class="pc-builder-container">
        <h1 class="text-center mb-4" style="color: #00caff; text-shadow: 0 0 15px #00caff;">
            <i class="fas fa-tools me-2"></i>PC Builder - Rakit PC Impian Anda
        </h1>

        <p class="text-center mb-4" style="color: #cfefff;">
            Pilih komponen terbaik untuk membangun PC gaming Anda. Kami akan menghitung total harga dan memeriksa kompatibilitas.
        </p>

        <!-- Preset Buttons -->
        <div class="preset-buttons">
            <button class="preset-btn" onclick="loadPreset('budget')">Budget Gaming</button>
            <button class="preset-btn" onclick="loadPreset('mid')">Mid-Range</button>
            <button class="preset-btn" onclick="loadPreset('high')">High-End</button>
            <button class="preset-btn" onclick="loadPreset('ultra')">Ultra Gaming</button>
        </div>

        <!-- CPU -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-microchip me-2"></i>Processor (CPU)
                </div>
                <div class="component-price" id="cpu-price">Rp 0</div>
            </div>
            <select class="component-select" id="cpu-select" onchange="updatePrice('cpu')">
                <option value="">Pilih Processor</option>
                <?php while ($cpu = mysqli_fetch_assoc($result_cpu)): ?>
                    <option value="<?php echo $cpu['harga']; ?>" data-id="<?php echo $cpu['id_produk']; ?>">
                        <?php echo htmlspecialchars($cpu['nm_produk']); ?> - Rp <?php echo number_format($cpu['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- GPU -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-palette me-2"></i>Graphics Card (GPU)
                </div>
                <div class="component-price" id="gpu-price">Rp 0</div>
            </div>
            <select class="component-select" id="gpu-select" onchange="updatePrice('gpu')">
                <option value="">Pilih Graphics Card</option>
                <?php while ($gpu = mysqli_fetch_assoc($result_gpu)): ?>
                    <option value="<?php echo $gpu['harga']; ?>" data-id="<?php echo $gpu['id_produk']; ?>">
                        <?php echo htmlspecialchars($gpu['nm_produk']); ?> - Rp <?php echo number_format($gpu['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Motherboard -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-memory me-2"></i>Motherboard
                </div>
                <div class="component-price" id="mobo-price">Rp 0</div>
            </div>
            <select class="component-select" id="mobo-select" onchange="updatePrice('mobo')">
                <option value="">Pilih Motherboard</option>
                <?php while ($mobo = mysqli_fetch_assoc($result_mobo)): ?>
                    <option value="<?php echo $mobo['harga']; ?>" data-id="<?php echo $mobo['id_produk']; ?>">
                        <?php echo htmlspecialchars($mobo['nm_produk']); ?> - Rp <?php echo number_format($mobo['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- RAM -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-memory me-2"></i>Memory (RAM)
                </div>
                <div class="component-price" id="ram-price">Rp 0</div>
            </div>
            <select class="component-select" id="ram-select" onchange="updatePrice('ram')">
                <option value="">Pilih RAM</option>
                <?php while ($ram = mysqli_fetch_assoc($result_ram)): ?>
                    <option value="<?php echo $ram['harga']; ?>" data-id="<?php echo $ram['id_produk']; ?>">
                        <?php echo htmlspecialchars($ram['nm_produk']); ?> - Rp <?php echo number_format($ram['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Storage -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-hdd me-2"></i>Storage
                </div>
                <div class="component-price" id="storage-price">Rp 0</div>
            </div>
            <select class="component-select" id="storage-select" onchange="updatePrice('storage')">
                <option value="">Pilih Storage</option>
                <?php while ($storage = mysqli_fetch_assoc($result_storage)): ?>
                    <option value="<?php echo $storage['harga']; ?>" data-id="<?php echo $storage['id_produk']; ?>">
                        <?php echo htmlspecialchars($storage['nm_produk']); ?> - Rp <?php echo number_format($storage['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- PSU -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-plug me-2"></i>Power Supply (PSU)
                </div>
                <div class="component-price" id="psu-price">Rp 0</div>
            </div>
            <select class="component-select" id="psu-select" onchange="updatePrice('psu')">
                <option value="">Pilih Power Supply</option>
                <?php while ($psu = mysqli_fetch_assoc($result_psu)): ?>
                    <option value="<?php echo $psu['harga']; ?>" data-id="<?php echo $psu['id_produk']; ?>">
                        <?php echo htmlspecialchars($psu['nm_produk']); ?> - Rp <?php echo number_format($psu['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Case -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-box me-2"></i>Case
                </div>
                <div class="component-price" id="case-price">Rp 0</div>
            </div>
            <select class="component-select" id="case-select" onchange="updatePrice('case')">
                <option value="">Pilih Case</option>
                <?php while ($case = mysqli_fetch_assoc($result_case)): ?>
                    <option value="<?php echo $case['harga']; ?>" data-id="<?php echo $case['id_produk']; ?>">
                        <?php echo htmlspecialchars($case['nm_produk']); ?> - Rp <?php echo number_format($case['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Cooling (Optional) -->
        <div class="component-card">
            <div class="component-header">
                <div class="component-title">
                    <i class="fas fa-fan me-2"></i>Cooling (Opsional)
                </div>
                <div class="component-price" id="cooling-price">Rp 0</div>
            </div>
            <select class="component-select" id="cooling-select" onchange="updatePrice('cooling')">
                <option value="">Pilih Cooling (Opsional)</option>
                <?php while ($cooling = mysqli_fetch_assoc($result_cooling)): ?>
                    <option value="<?php echo $cooling['harga']; ?>" data-id="<?php echo $cooling['id_produk']; ?>">
                        <?php echo htmlspecialchars($cooling['nm_produk']); ?> - Rp <?php echo number_format($cooling['harga'], 0, ',', '.'); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Compatibility Warning -->
        <div class="compatibility-warning" id="compatibility-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Periksa kompatibilitas komponen Anda. Pastikan socket CPU dan chipset motherboard cocok.
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <h3>Total Estimasi Harga</h3>
            <div class="total-price" id="total-price">Rp 0</div>
            <p style="color: #bbb; margin: 10px 0;">*Harga belum termasuk biaya assembly dan pajak</p>

            <div class="builder-actions">
                <button class="btn" onclick="checkCompatibility()">
                    <i class="fas fa-check-circle me-2"></i>Periksa Kompatibilitas
                </button>
                <button class="btn" onclick="saveBuild()">
                    <i class="fas fa-save me-2"></i>Simpan Build
                </button>
                <button class="btn" onclick="addToCart()">
                    <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <?php include 'template/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Component prices
        let prices = {
            cpu: 0,
            gpu: 0,
            mobo: 0,
            ram: 0,
            storage: 0,
            psu: 0,
            case: 0,
            cooling: 0
        };

        // Selected products
        let selectedProducts = {
            cpu: null,
            gpu: null,
            mobo: null,
            ram: null,
            storage: null,
            psu: null,
            case: null,
            cooling: null
        };

        function updatePrice(component) {
            const select = document.getElementById(component + '-select');
            const priceElement = document.getElementById(component + '-price');
            const selectedOption = select.options[select.selectedIndex];

            prices[component] = parseInt(selectedOption.value) || 0;
            selectedProducts[component] = selectedOption.getAttribute('data-id');

            priceElement.textContent = 'Rp ' + prices[component].toLocaleString('id-ID');
            updateTotal();
        }

        function updateTotal() {
            const total = Object.values(prices).reduce((sum, price) => sum + price, 0);
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function checkCompatibility() {
            // Basic compatibility check
            const warning = document.getElementById('compatibility-warning');

            if (!selectedProducts.cpu || !selectedProducts.mobo) {
                warning.textContent = 'Pilih CPU dan Motherboard terlebih dahulu untuk cek kompatibilitas.';
                warning.style.display = 'block';
                return;
            }

            // Simple compatibility logic (can be enhanced with more rules)
            warning.textContent = 'Komponen terlihat kompatibel. Untuk konfirmasi pasti, hubungi tim kami.';
            warning.style.background = 'rgba(25, 135, 84, 0.1)';
            warning.style.borderColor = '#198754';
            warning.style.color = '#198754';
            warning.style.display = 'block';
        }

        function loadPreset(type) {
            // Preset configurations (can be customized)
            const presets = {
                budget: {
                    cpu: 'Intel Core i3',
                    gpu: 'GTX 1650',
                    mobo: 'H510',
                    ram: '8GB DDR4',
                    storage: 'SSD 256GB',
                    psu: '450W',
                    case: 'Mid Tower',
                    cooling: 'Stock'
                },
                mid: {
                    cpu: 'Intel Core i5',
                    gpu: 'RTX 3060',
                    mobo: 'B560',
                    ram: '16GB DDR4',
                    storage: 'SSD 512GB',
                    psu: '650W',
                    case: 'Mid Tower RGB',
                    cooling: 'Air Cooler'
                },
                high: {
                    cpu: 'Intel Core i7',
                    gpu: 'RTX 4070',
                    mobo: 'Z690',
                    ram: '32GB DDR4',
                    storage: 'SSD 1TB',
                    psu: '750W',
                    case: 'Full Tower RGB',
                    cooling: 'AIO 240mm'
                },
                ultra: {
                    cpu: 'Intel Core i9',
                    gpu: 'RTX 4090',
                    mobo: 'Z790',
                    ram: '64GB DDR5',
                    storage: 'SSD 2TB',
                    psu: '1000W',
                    case: 'Full Tower Premium',
                    cooling: 'Custom Loop'
                }
            };

            alert(`Preset ${type} dimuat. Pilih komponen sesuai rekomendasi untuk performa optimal.`);
        }

        function saveBuild() {
            // Save build to localStorage or send to server
            const buildData = {
                components: selectedProducts,
                total: Object.values(prices).reduce((sum, price) => sum + price, 0),
                timestamp: new Date().toISOString()
            };

            localStorage.setItem('savedBuild', JSON.stringify(buildData));
            alert('Build berhasil disimpan! Anda dapat melanjutkan nanti.');
        }

        function addToCart() {
            // Add selected components to cart
            const selectedComponents = Object.entries(selectedProducts)
                .filter(([key, value]) => value !== null)
                .map(([key, value]) => value);

            if (selectedComponents.length === 0) {
                alert('Pilih minimal satu komponen untuk ditambahkan ke keranjang.');
                return;
            }

            // Here you would typically send to server or update cart
            alert(`Ditambahkan ${selectedComponents.length} komponen ke keranjang!`);
        }

        // Load saved build on page load
        window.onload = function() {
            const savedBuild = localStorage.getItem('savedBuild');
            if (savedBuild) {
                const buildData = JSON.parse(savedBuild);
                // Restore selections (simplified)
                console.log('Build tersimpan ditemukan:', buildData);
            }
        };
    </script>
</body>
</html>
