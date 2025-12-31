<?php
require_once __DIR__ . '/Midtrans/Midtrans.php';

// 2. Set Konfigurasi
\Midtrans\Config::$serverKey = 'SB-Mid-server-M_dlz_FZmGjqTkCTR1_Uk2nq'; 
\Midtrans\Config::$clientKey = 'SB-Mid-client-U2pdocRQG3su3-Dp'; 
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;