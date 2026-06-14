<div class="ng-profile-card ng-profile-card-session">
    <div class="ng-profile-side">
        <div>
            <div class="ng-profile-badge">
                <span></span>
                Active Sessions
            </div>

            <h2 class="ng-profile-title">
                Browser Sessions
            </h2>

            <p class="ng-profile-desc">
                Pantau perangkat yang sedang aktif menggunakan akun ini dan keluar dari sesi lain jika diperlukan.
            </p>
        </div>

        <div class="ng-profile-mini">
            <span>Keamanan Login</span>
            <strong>Dipantau</strong>
            <small>Kelola sesi browser aktif</small>
        </div>
    </div>

    <div class="ng-profile-form">
        <?php echo e($this->form); ?>


        <?php if (isset($component)) { $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-actions::components.modals','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-actions::modals'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $attributes = $__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__attributesOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758)): ?>
<?php $component = $__componentOriginal028e05680f6c5b1e293abd7fbe5f9758; ?>
<?php unset($__componentOriginal028e05680f6c5b1e293abd7fbe5f9758); ?>
<?php endif; ?>
    </div>
</div><?php /**PATH /var/www/html/resources/views/vendor/filament-breezy/livewire/browser-sessions.blade.php ENDPATH**/ ?>