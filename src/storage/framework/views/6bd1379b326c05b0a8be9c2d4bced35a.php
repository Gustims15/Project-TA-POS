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
        .role-lux-wrapper {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            margin-bottom: 22px;
        }

        .role-lux-hero {
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

        .role-lux-hero::before {
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

        .role-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .role-lux-badge {
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

        .role-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .role-lux-title {
            margin: 16px 0 0;
            font-size: 34px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .role-lux-desc {
            margin: 12px 0 0;
            max-width: 780px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .role-lux-mini {
            min-width: 260px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .role-lux-mini span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .role-lux-mini strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 24px;
            line-height: 1.15;
            font-weight: 950;
        }

        .role-lux-mini small {
            display: block;
            margin-top: 8px;
            color: rgba(255,255,255,0.82);
            font-size: 12px;
            font-weight: 700;
        }

        .role-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .role-lux-card {
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

        .role-lux-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .role-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .role-lux-card.roles::after { background: #10b981; }
        .role-lux-card.permission::after { background: #3b82f6; }
        .role-lux-card.guard::after { background: #f97316; }
        .role-lux-card.security::after { background: #8b5cf6; }

        .role-lux-card-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .role-lux-card-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .role-lux-card-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .roles .role-lux-card-caption { background: #ecfdf5; color: #047857; }
        .permission .role-lux-card-caption { background: #eff6ff; color: #1d4ed8; }
        .guard .role-lux-card-caption { background: #fff7ed; color: #c2410c; }
        .security .role-lux-card-caption { background: #f5f3ff; color: #6d28d9; }

        @media (max-width: 1100px) {
            .role-lux-hero-top {
                flex-direction: column;
            }

            .role-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .role-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .role-lux-title {
                font-size: 28px;
            }

            .role-lux-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="role-lux-wrapper">
        <section class="role-lux-hero">
            <div class="role-lux-hero-top">
                <div>
                    <div class="role-lux-badge">
                        <span class="role-lux-dot"></span>
                        Ngunjuk POS Access Control
                    </div>

                    <h2 class="role-lux-title">
                        Role & Permission Analytics
                    </h2>

                    <p class="role-lux-desc">
                        Kelola hak akses pengguna, role admin, role karyawan, guard, dan permission sistem.
                        Halaman ini mengatur batasan akses fitur agar sistem POS tetap aman dan terkontrol.
                    </p>
                </div>

                <div class="role-lux-mini">
                    <span>Role dengan Permission Terbanyak</span>
                    <strong><?php echo e(\Illuminate\Support\Str::headline($summary['top_role_name'])); ?></strong>
                    <small><?php echo e(number_format($summary['top_role_permissions'], 0, ',', '.')); ?> permission</small>
                </div>
            </div>
        </section>

        <div class="role-lux-grid">
            <div class="role-lux-card roles">
                <p class="role-lux-card-label">Total Roles</p>
                <p class="role-lux-card-value">
                    <?php echo e(number_format($summary['total_roles'], 0, ',', '.')); ?>

                </p>
                <p class="role-lux-card-caption">Semua role sistem</p>
            </div>

            <div class="role-lux-card permission">
                <p class="role-lux-card-label">Total Permissions</p>
                <p class="role-lux-card-value">
                    <?php echo e(number_format($summary['total_permissions'], 0, ',', '.')); ?>

                </p>
                <p class="role-lux-card-caption">Hak akses tersedia</p>
            </div>

            <div class="role-lux-card guard">
                <p class="role-lux-card-label">Guard Web</p>
                <p class="role-lux-card-value">
                    <?php echo e(number_format($summary['web_roles'], 0, ',', '.')); ?>

                </p>
                <p class="role-lux-card-caption">Role guard web</p>
            </div>

            <div class="role-lux-card security">
                <p class="role-lux-card-label">Access Control</p>
                <p class="role-lux-card-value">
                    Shield
                </p>
                <p class="role-lux-card-caption">Filament permission</p>
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
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/roles/widgets/role-analytics-widget.blade.php ENDPATH**/ ?>