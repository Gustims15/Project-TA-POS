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
      <div class="brand">
        <span>Ngun</span>juk
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

      <section class="menu-area abstract-area">
        <div class="category-tabs" id="categoryTabs"></div>

        <div class="section-title">
          <h1 id="menuTitle">Coffee menu</h1>
          <p>Pilih varian minuman dan masukkan ke keranjang.</p>
        </div>

        <div class="product-grid" id="productGrid"></div>
      </section>
    </section>
  </main>

  <div class="cart-backdrop" id="cartBackdrop"></div>

  <aside class="cart-drawer" id="cartDrawer" aria-label="Keranjang pesanan">
    <div class="cart-drawer-head">
      <div>
        <h2>Cart</h2>
        <span id="orderCode">Order #3243</span>
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