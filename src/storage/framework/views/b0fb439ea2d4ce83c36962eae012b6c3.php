<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login - Ngunjuk POS</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body class="login-page">
  <main class="login-shell">
    <section class="login-hero">
      <div class="brand login-brand">
        <span>Ngun</span>juk
      </div>

      <h1>Point of Sale UMKM Ngunjuk</h1>

      <p>
        Kelola transaksi minuman, keranjang pesanan, dan riwayat order
        dalam satu tampilan kasir.
      </p>

      <div class="login-bubbles">
        <span>Kopi Susu</span>
        <span>Es Teh</span>
        <span>Yakult</span>
      </div>
    </section>

    <section class="login-card">
      <div class="login-card-head">
        <span class="eyebrow">Kasir Area</span>
        <h2>Login</h2>
        <p>Masuk menggunakan akun kasir.</p>
      </div>

      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="login-alert success">
          <?php echo e(session('success')); ?>

        </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="login-alert error">
          <?php echo e($errors->first()); ?>

        </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

      <form action="<?php echo e(route('login.process')); ?>" method="POST" class="login-form">
        <?php echo csrf_field(); ?>

        <label>
          <span>Email</span>
          <input
            name="email"
            type="email"
            placeholder="Masukkan email"
            autocomplete="email"
            value="<?php echo e(old('email')); ?>"
            required
          >
        </label>

        <label>
          <span>Password</span>
          <input
            name="password"
            type="password"
            placeholder="Masukkan password"
            autocomplete="current-password"
            required
          >
        </label>

        <label class="remember-row">
          <input type="checkbox" name="remember" value="1">
          <span>Ingat saya</span>
        </label>

        <button class="order-btn" type="submit">
          Masuk
        </button>

        <p class="login-hint">
          Demo: <strong>kasir@ngunjuk.id</strong> / <strong>12345</strong>
        </p>
      </form>
    </section>
  </main>
</body>
</html><?php /**PATH /var/www/html/resources/views/login.blade.php ENDPATH**/ ?>