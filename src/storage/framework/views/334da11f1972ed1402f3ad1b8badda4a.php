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

<body>
  <main class="app-shell single-content">
    <aside class="sidebar">
      <div class="brand">
        <span>Ngun</span>juk
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
      <header class="topbar">
        <label class="search-box" for="historySearchTop">
          <span>⌕</span>
          <input
            id="historySearchTop"
            type="search"
            placeholder="Search order ID atau produk..."
            autocomplete="off"
          >
        </label>

        <div class="topbar-spacer"></div>

        <a class="cart-toggle page-link-btn" href="<?php echo e(route('frontend.home')); ?>">
          🛒 POS Menu
        </a>

        <a class="profile-mini" href="<?php echo e(route('frontend.settings')); ?>">
          <div class="avatar">
            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

          </div>

          <div>
            <strong><?php echo e(auth()->user()->name); ?></strong>
            <p><?php echo e(auth()->user()->email); ?></p>
          </div>
        </a>
      </header>

      <section class="history-area">
        <div class="history-head">
          <div>
            <span class="eyebrow">Riwayat Transaksi</span>
            <h1>History Order</h1>
            <p>
              History menampilkan data transaksi. Tabel bisa difilter berdasarkan hari ini, kemarin, minggu ini, bulan ini, atau semua order.
            </p>
          </div>

          <button class="export-btn" type="button" id="exportHistory">
            Export Report
          </button>
        </div>

        <div class="history-stats">
          <article class="stat-card">
            <span>Total Order</span>
            <strong id="statOrders">0</strong>
          </article>

          <article class="stat-card">
            <span>Total Penjualan</span>
            <strong id="statSales">Rp 0</strong>
          </article>

          <article class="stat-card">
            <span>Order Selesai</span>
            <strong id="statDone">0</strong>
          </article>

          <article class="stat-card">
            <span>Rata-rata Order</span>
            <strong id="statAverage">Rp 0</strong>
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

          <!-- <select id="historyStatus" aria-label="Filter status order">
            <option value="all" selected>Semua status</option>
            <option value="Selesai">Selesai</option>
            <option value="Diproses">Diproses</option>
            <option value="Dibatalkan">Dibatalkan</option>
          </select> -->
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
              </tr>
            </thead>

            <tbody id="historyBody"></tbody>
          </table>

          <div class="cart-empty history-empty" id="historyEmpty">
            Data history tidak ditemukan.
          </div>
        </div>
      </section>
    </section>
  </main>

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
</html>
<?php /**PATH /var/www/html/resources/views/history.blade.php ENDPATH**/ ?>