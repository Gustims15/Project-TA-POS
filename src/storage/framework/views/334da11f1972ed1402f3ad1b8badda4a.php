<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title>Ngunjuk POS - History</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body class="history-page">
  <main class="app-shell">
    <aside class="sidebar">
      <div class="brand brand-with-logo">
      <img src="<?php echo e(asset('images/ngunjuk-logo.png')); ?>" alt="Logo Ngunjuk" class="brand-logo">

      <div class="brand-text">
        <strong><span>Ngu</span>njuk</strong>
        <small>POS SYSTEM</small>
      </div>
    </div>
      <nav class="nav-menu" aria-label="Menu utama">
        <a class="nav-item" href="<?php echo e(route('frontend.home')); ?>">
          <span class="nav-icon">⌂</span>
          <span>Home page</span>
        </a>

        <a class="nav-item active" href="<?php echo e(route('frontend.history')); ?>">
          <span class="nav-icon">◴</span>
          <span>History</span>
        </a>

        <a class="nav-item" href="<?php echo e(route('frontend.settings')); ?>">
          <span class="nav-icon">⚙</span>
          <span>Settings</span>
        </a>
      </nav>

      <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
        <?php echo csrf_field(); ?>

        <button class="nav-item logout logout-button" type="submit">
          <span class="nav-icon">↪</span>
          <span>Log out</span>
        </button>
      </form>
    </aside>

    <section class="content">
      <section class="history-area">
        <div class="history-head">
          <div>
            <span class="eyebrow">Riwayat Transaksi</span>
            <h1>History Order</h1>
          </div>

          <button class="export-btn" type="button" id="exportHistory">
            Export Report
          </button>
        </div>

        <div class="history-stats history-stats-daily">
          <article class="stat-card">
            <span>Total Produk Terjual Hari Ini</span>
            <strong id="statProductsSold">0</strong>
          </article>

          <article class="stat-card">
            <span>Total Order Hari Ini</span>
            <strong id="statOrders">0</strong>
          </article>

          <article class="stat-card">
            <span>Total Penjualan Hari Ini</span>
            <strong id="statSales">Rp 0</strong>
          </article>
        </div>

        <div class="history-filter">
          <label class="history-search" for="historySearch">
            <span>⌕</span>
            <input
              id="historySearch"
              type="search"
              placeholder="Cari ID order atau produk..."
              autocomplete="off"
            >
          </label>

          <select id="historyDateFilter" aria-label="Filter tanggal order">
            <option value="today" selected>Order Hari Ini</option>
            <option value="yesterday">Order Kemarin</option>
            <option value="week">Order Minggu Ini</option>
            <option value="month">Order Bulan Ini</option>
            <option value="all">Semua Order</option>
          </select>

          <select id="historySort" aria-label="Sorting order">
            <option value="latest" selected>Terbaru</option>
            <option value="oldest">Terlama</option>
            <option value="highest">Total Terbesar</option>
            <option value="lowest">Total Terkecil</option>
          </select>
        </div>

        <div class="history-table-wrap">
          <table class="history-table">
            <thead>
              <tr>
                <th>ID Order</th>
                <th>Item</th>
                <th>Waktu</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody id="historyBody"></tbody>
          </table>

          <div class="history-pagination" id="historyPagination">
            <button type="button" id="historyPrevPage">
              Sebelumnya
            </button>

            <span id="historyPageInfo">
              Halaman 1 dari 1
            </span>

            <button type="button" id="historyNextPage">
              Berikutnya
            </button>
          </div>
          <div class="cart-empty history-empty" id="historyEmpty">
            Data history tidak ditemukan.
          </div>
        </div>
      </section>
    </section>
  </main>

  <div class="invoice-modal-backdrop" id="invoiceModalBackdrop"></div>

  <section class="invoice-modal" id="invoiceModal" aria-label="Detail order">
    <div class="invoice-modal-card">
      <div class="invoice-modal-head">
        <div>
          <span class="eyebrow">Detail Transaksi</span>
          <p id="invoiceOrderCode">-</p>
        </div>

        <button class="invoice-close-btn" type="button" id="closeInvoiceModal">
          ×
        </button>
      </div>

      <div class="invoice-preview" id="invoicePreview">
        <div class="invoice-brand">
          <h3>Ngunjuk POS</h3>
        </div>

        <div class="invoice-meta">
          <div>
            <span>Order</span>
            <strong id="invoiceCode">-</strong>
          </div>

          <div>
            <span>Waktu</span>
            <strong id="invoiceDate">-</strong>
          </div>

          <div>
            <span>Status</span>
            <strong id="invoiceStatus">-</strong>
          </div>
        </div>

        <div class="invoice-items" id="invoiceItems"></div>

        <div class="invoice-total-box">
          <div>
            <span>Total Item</span>
            <strong id="invoiceTotalItem">0 item</strong>
          </div>

          <div class="invoice-grand-total">
            <span>Total Harga</span>
            <strong id="invoiceTotalPrice">Rp 0</strong>
          </div>
        </div>

        <div class="invoice-footer-note">
          <p>Terima kasih sudah berbelanja di Ngunjuk.</p>
          <small>Simpan struk ini sebagai bukti transaksi.</small>
        </div>
      </div>

      <div class="invoice-actions">
        <button class="invoice-secondary-btn" type="button" id="closeInvoiceModalBottom">
          Tutup
        </button>

        <button class="invoice-print-btn" type="button" id="printInvoice">
          Cetak Struk
        </button>
      </div>
    </div>
  </section>

  <div class="toast" id="toast">
    Data history siap diexport.
  </div>

  <script>
    window.NGUNJUK_ROUTES = {
      home: "<?php echo e(route('frontend.home')); ?>",
      history: "<?php echo e(route('frontend.history')); ?>",
      settings: "<?php echo e(route('frontend.settings')); ?>",
      historyApi: "<?php echo e(route('api.history.list')); ?>"
    };

    window.NGUNJUK_CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
  </script>

  <script src="<?php echo e(asset('js/historyy.js')); ?>"></script>
</body>
</html><?php /**PATH /var/www/html/resources/views/history.blade.php ENDPATH**/ ?>