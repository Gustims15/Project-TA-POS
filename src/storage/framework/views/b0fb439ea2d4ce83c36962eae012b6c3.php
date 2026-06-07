<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login - Ngunjuk POS</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>?v=login-orange-luxury-final">
</head>

<body class="login-page">
  <div class="login-blur-bg" aria-hidden="true"></div>

  <main class="luxury-login-shell" aria-label="Halaman login Ngunjuk POS">
    <section class="luxury-login-hero">
      <div class="luxury-hero-glow luxury-hero-glow-one"></div>
      <div class="luxury-hero-glow luxury-hero-glow-two"></div>

      <div class="luxury-hero-content">
        <span class="luxury-line-accent"></span>

        <h1>
          Point of Sale
          <strong><span>Ngunjuk</span></strong>
        </h1>

        <div class="luxury-title-divider">
        </div>

        <p>
          Kelola transaksi minuman, keranjang pesanan, dan riwayat order
          dalam satu tampilan kasir.
        </p>

        <div class="luxury-login-bubbles" aria-label="Contoh kategori produk">
        </div>
      </div>

      <div class="luxury-hero-footer">
        <span>Digital cashier</span>
      </div>
    </section>

    <section class="luxury-login-panel">
      <div class="luxury-login-card">
        <div class="login-card-head luxury-card-head">
          <span class="eyebrow">Kasir Area</span>
          <h2>Login</h2>
          <p>Masuk menggunakan akun kasir.</p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
          <div class="login-alert success luxury-alert">
            <span class="luxury-alert-icon">✓</span>
            <span><?php echo e(session('success')); ?></span>
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
          <div class="login-alert error luxury-alert">
            <span class="luxury-alert-icon">!</span>
            <span><?php echo e($errors->first()); ?></span>
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form action="<?php echo e(route('login.process')); ?>" method="POST" class="login-form luxury-login-form">
          <?php echo csrf_field(); ?>

          <label class="luxury-field">
            <span>Email</span>
            <div class="luxury-input-wrap">
              <i aria-hidden="true">✉</i>
              <input
                name="email"
                type="email"
                placeholder="Masukkan email"
                autocomplete="email"
                value="<?php echo e(old('email')); ?>"
                required
              >
            </div>
          </label>

          <label class="luxury-field">
            <span>Password</span>
            <div class="luxury-input-wrap">
              <i aria-hidden="true">🔒</i>
              <input
                id="loginPassword"
                name="password"
                type="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
              >
              <button
                class="password-toggle"
                type="button"
                aria-label="Tampilkan atau sembunyikan password"
                onclick="toggleLoginPassword()"
              >
                👁
              </button>
            </div>
          </label>

          <label class="remember-row luxury-remember-row">
            <input type="checkbox" name="remember" value="1">
            <span>Ingat saya</span>
          </label>

          <button class="order-btn luxury-login-btn" type="submit">
            <span>Masuk</span>
            <i aria-hidden="true">→</i>
          </button>

          <p class="login-hint luxury-login-hint">
          </p>
        </form>
      </div>
    </section>
  </main>

  <script>
    function toggleLoginPassword() {
      const input = document.getElementById('loginPassword');

      if (!input) {
        return;
      }

      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/login.blade.php ENDPATH**/ ?>