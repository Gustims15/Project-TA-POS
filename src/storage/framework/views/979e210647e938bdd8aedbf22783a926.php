<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <style>
        .user-lux-wrapper {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            margin-bottom: 22px;
        }

        .user-lux-hero {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 30px;
            color: white;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.32), transparent 28%),
                radial-gradient(circle at bottom left, rgba(255,255,255,0.18), transparent 28%),
                linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #10b981 100%);
            box-shadow: 0 28px 70px rgba(15, 118, 110, 0.22);
            isolation: isolate;
        }

        .user-lux-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.09) 1px, transparent 1px);
            background-size: 34px 34px;
            opacity: 0.24;
            z-index: -1;
        }

        .user-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .user-lux-main {
            min-width: 0;
        }

        .user-lux-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            width: fit-content;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .user-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .user-lux-title {
            margin: 16px 0 0;
            font-size: 34px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .user-lux-desc {
            margin: 12px 0 0;
            max-width: 780px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .user-lux-action-panel {
            min-width: 260px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .user-lux-action-panel span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .user-lux-action-panel strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 24px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .user-lux-action-panel small {
            display: block;
            margin-top: 8px;
            color: rgba(255,255,255,0.82);
            font-size: 12px;
            line-height: 1.45;
            font-weight: 700;
        }

        .user-lux-create-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 16px;
            padding: 11px 16px;
            border-radius: 999px;
            color: #ffffff;
            background: linear-gradient(135deg, #fb923c 0%, #f97316 42%, #ea580c 100%);
            box-shadow:
                0 16px 34px rgba(234, 88, 12, 0.28),
                inset 0 1px 0 rgba(255,255,255,0.30);
            text-decoration: none;
            font-size: 13px;
            font-weight: 950;
            transition: 0.2s ease;
        }

        .user-lux-create-btn:hover {
            transform: translateY(-2px);
            box-shadow:
                0 20px 42px rgba(234, 88, 12, 0.36),
                inset 0 1px 0 rgba(255,255,255,0.34);
        }

        .user-lux-create-btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 999px;
            background: rgba(255,255,255,0.18);
            color: #ffffff;
            font-size: 18px;
            line-height: 1;
            font-weight: 900;
        }

        .user-lux-latest {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid rgba(255,255,255,0.20);
        }

        .user-lux-latest span {
            font-size: 11px;
            color: rgba(255,255,255,0.70);
        }

        .user-lux-latest strong {
            margin-top: 5px;
            font-size: 15px;
            line-height: 1.2;
        }

        .user-lux-latest small {
            margin-top: 4px;
            font-size: 11px;
        }

        .user-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .user-lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            min-height: 145px;
            transition: 0.25s ease;
        }

        .user-lux-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .user-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .user-lux-card.total::after {
            background: #10b981;
        }

        .user-lux-card.admin::after {
            background: #3b82f6;
        }

        .user-lux-card.staff::after {
            background: #f97316;
        }

        .user-lux-card.new::after {
            background: #8b5cf6;
        }

        .user-lux-card-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .user-lux-card-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .user-lux-card-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .total .user-lux-card-caption {
            background: #ecfdf5;
            color: #047857;
        }

        .admin .user-lux-card-caption {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .staff .user-lux-card-caption {
            background: #fff7ed;
            color: #c2410c;
        }

        .new .user-lux-card-caption {
            background: #f5f3ff;
            color: #6d28d9;
        }

        @media (max-width: 1100px) {
            .user-lux-hero-top {
                flex-direction: column;
            }

            .user-lux-action-panel {
                width: 100%;
                min-width: 0;
            }

            .user-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .user-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .user-lux-title {
                font-size: 28px;
            }

            .user-lux-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="user-lux-wrapper">
        <section class="user-lux-hero">
            <div class="user-lux-hero-top">
                <div class="user-lux-main">
                    <div class="user-lux-badge">
                        <span class="user-lux-dot"></span>
                        Ngunjuk POS User
                    </div>

                    <h2 class="user-lux-title">
                        User Management Analytics
                    </h2>

                    <p class="user-lux-desc">
                        Kelola akun pengguna sistem, role akses, admin, dan karyawan.
                        Halaman ini membantu super admin memantau seluruh user yang memiliki akses
                        ke sistem POS UMKM Ngunjuk.
                    </p>
                </div>

                <div class="user-lux-action-panel">
                    <span>Aksi Cepat User</span>

                    <strong>
                        Tambah User Baru
                    </strong>

                    <small>
                        Buat akun baru untuk super admin atau karyawan yang akan mengakses sistem POS Ngunjuk.
                    </small>

                    <a
                        href="<?php echo e(\App\Filament\Admin\Resources\Users\UserResource::getUrl('create')); ?>"
                        class="user-lux-create-btn"
                    >
                        <span class="user-lux-create-btn-icon">+</span>
                        Add New User
                    </a>

                    <div class="user-lux-latest">
                        <span>User terbaru</span>

                        <strong>
                            <?php echo e($summary['latest_user_name']); ?>

                        </strong>

                        <small>
                            <?php echo e($summary['latest_user_email']); ?>

                        </small>
                    </div>
                </div>
            </div>
        </section>

        <div class="user-lux-grid">
            <div class="user-lux-card total">
                <p class="user-lux-card-label">
                    Total Users
                </p>

                <p class="user-lux-card-value">
                    <?php echo e(number_format($summary['total_users'], 0, ',', '.')); ?>

                </p>

                <p class="user-lux-card-caption">
                    Semua akun sistem
                </p>
            </div>

            <div class="user-lux-card admin">
                <p class="user-lux-card-label">
                    Super Admin
                </p>

                <p class="user-lux-card-value">
                    <?php echo e(number_format($summary['super_admins'], 0, ',', '.')); ?>

                </p>

                <p class="user-lux-card-caption">
                    Akses penuh admin
                </p>
            </div>

            <div class="user-lux-card staff">
                <p class="user-lux-card-label">
                    Karyawan
                </p>

                <p class="user-lux-card-value">
                    <?php echo e(number_format($summary['karyawan'], 0, ',', '.')); ?>

                </p>

                <p class="user-lux-card-caption">
                    Akses kasir
                </p>
            </div>

            <div class="user-lux-card new">
                <p class="user-lux-card-label">
                    User Baru
                </p>

                <p class="user-lux-card-value">
                    <?php echo e(number_format($summary['new_users'], 0, ',', '.')); ?>

                </p>

                <p class="user-lux-card-caption">
                    30 hari terakhir
                </p>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/resources/users/widgets/user-analytics-widget.blade.php ENDPATH**/ ?>