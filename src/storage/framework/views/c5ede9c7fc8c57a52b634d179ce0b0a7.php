<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title>Ngunjuk POS - Kasir</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body>
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
        <a class="nav-item active" href="<?php echo e(route('frontend.home')); ?>">
          <span class="nav-icon">⌂</span>
          <span>Home page</span>
        </a>

        <a class="nav-item" href="<?php echo e(route('frontend.history')); ?>">
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
        <label class="search-box" for="searchInput">
          <span>⌕</span>
          <input
            id="searchInput"
            type="search"
            placeholder="Search menu..."
            autocomplete="off"
          >
        </label>

        <div class="topbar-spacer"></div>

        <button class="cart-toggle" id="openCart" type="button">
          <span>🛒</span>
          Cart
          <small id="cartCount">0</small>
        </button>

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

      <section class="menu-area abstract-area pos-luxury-area">
        <div class="category-tabs luxury-category-tabs" id="categoryTabs"></div>

        <h1 id="menuTitle" class="sr-only">Coffee menu</h1>

        <div class="product-grid luxury-product-grid" id="productGrid"></div>
      </section>
    </section>
  </main>

  <div class="cart-backdrop" id="cartBackdrop"></div>

  <aside class="cart-drawer" id="cartDrawer" aria-label="Keranjang pesanan">
    <div class="cart-drawer-head">
      <div>
        <h2>Keranjang</h2>
        <span id="orderCode">Order baru</span>
      </div>

      <button class="close-cart" id="closeCart" type="button">
        ×
      </button>
    </div>

    <div class="cart-list" id="cartList"></div>

    <div class="summary">
      <div>
        <span>Items</span>
        <strong id="itemsTotal">Rp 0</strong>
      </div>

      <div class="summary-total">
        <span>Total</span>
        <strong id="grandTotal">Rp 0</strong>
      </div>
    </div>

    <button class="order-btn" id="placeOrder" type="button">
      Place an order
    </button>
  </aside>

  <div class="checkout-success-backdrop" id="checkoutSuccessBackdrop"></div>

  <section class="checkout-success-modal" id="checkoutSuccessModal" aria-label="Order berhasil">
    <div class="checkout-success-card">
      <div class="success-icon-wrap">
        <div class="success-icon">✓</div>
      </div>

      <span class="success-eyebrow">Transaksi Berhasil</span>

      <div class="success-order-box">
        <div>
          <span>Kode Order</span>
          <strong id="successOrderCode">-</strong>
        </div>
      </div>

      <div class="success-order-items" id="successOrderItems"></div>

      <div class="success-order-box">
        <div>
          <span>Total Item</span>
          <strong id="successTotalItem">0 item</strong>
        </div>

        <div class="success-total-row">
          <span>Total Harga</span>
          <strong id="successTotalPrice">Rp 0</strong>
        </div>
      </div>

      <div class="success-actions success-actions-three">
        <button class="success-secondary-btn" type="button" id="successStayPos">
          Kembali ke POS
        </button>

        <button class="success-print-btn" type="button" id="successPrintReceipt">
          Cetak Struk
        </button>

        <button class="success-primary-btn" type="button" id="successGoHistory">
          Lihat History
        </button>
      </div>
    </div>
  </section>

  <div class="checkout-confirm-backdrop" id="checkoutConfirmBackdrop"></div>

  <section class="checkout-confirm-modal" id="checkoutConfirmModal" aria-label="Konfirmasi order">
    <div class="checkout-confirm-card">
      <div class="confirm-icon-wrap">
        <div class="confirm-icon">?</div>
      </div>

      <span class="confirm-eyebrow">Konfirmasi Order</span>

      <div class="confirm-order-items" id="confirmOrderItems"></div>

      <div class="confirm-order-box">
        <div>
          <span>Total Item</span>
          <strong id="confirmTotalItem">0 item</strong>
        </div>

        <div class="confirm-total-row">
          <span>Total Harga</span>
          <strong id="confirmTotalPrice">Rp 0</strong>
        </div>
      </div>

      <div class="confirm-actions">
        <button class="confirm-secondary-btn" type="button" id="cancelCheckout">
          Batal
        </button>

        <button class="confirm-primary-btn" type="button" id="confirmCheckout">
          Konfirmasi Order
        </button>
      </div>
    </div>
  </section>

  <div class="toast" id="toast">
    Transaksi berhasil disimpan.
  </div>

  <script>
    window.NGUNJUK_ROUTES = {
      products: "<?php echo e(route('api.products.list')); ?>",
      orders: "<?php echo e(route('api.orders.store')); ?>",
      history: "<?php echo e(route('frontend.history')); ?>",
      storage: "<?php echo e(asset('storage')); ?>"
    };

    window.NGUNJUK_CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
  </script>

  <script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html><?php /**PATH /var/www/html/resources/views/index.blade.php ENDPATH**/ ?>