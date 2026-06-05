<div class="ng-profile-card ng-profile-card-personal">
    <div class="ng-profile-side">
        <div>
            <div class="ng-profile-badge">
                <span></span>
                Profile Account
            </div>

            <h2 class="ng-profile-title">
                Personal Information
            </h2>

            <p class="ng-profile-desc">
                Kelola informasi akun admin yang digunakan untuk mengakses dashboard POS Ngunjuk.
            </p>
        </div>

        <div class="ng-profile-mini">
            <span>Status Akun</span>
            <strong>Aktif</strong>
            <small>Data profil utama pengguna</small>
        </div>
    </div>

    <div class="ng-profile-form">
        <form wire:submit.prevent="submit" class="space-y-5">
            <?php echo e($this->form); ?>


            <div class="ng-profile-action">
                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'submit','form' => 'submit','class' => 'ng-profile-submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','form' => 'submit','class' => 'ng-profile-submit']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    Update Profile
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
            </div>
        </form>
    </div>
</div><?php /**PATH /var/www/html/resources/views/vendor/filament-breezy/livewire/personal-info.blade.php ENDPATH**/ ?>