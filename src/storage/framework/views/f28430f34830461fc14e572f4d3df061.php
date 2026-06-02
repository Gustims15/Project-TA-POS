<?php if (isset($component)) { $__componentOriginal97ecd73d071389d6ed328606dc37ae79 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97ecd73d071389d6ed328606dc37ae79 = $attributes; } ?>
<?php $component = DutchCodingCompany\FilamentDeveloperLogins\View\Components\DeveloperLogins::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-developer-logins::developer-logins'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\DutchCodingCompany\FilamentDeveloperLogins\View\Components\DeveloperLogins::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97ecd73d071389d6ed328606dc37ae79)): ?>
<?php $attributes = $__attributesOriginal97ecd73d071389d6ed328606dc37ae79; ?>
<?php unset($__attributesOriginal97ecd73d071389d6ed328606dc37ae79); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97ecd73d071389d6ed328606dc37ae79)): ?>
<?php $component = $__componentOriginal97ecd73d071389d6ed328606dc37ae79; ?>
<?php unset($__componentOriginal97ecd73d071389d6ed328606dc37ae79); ?>
<?php endif; ?><?php /**PATH /var/www/html/storage/framework/views/ab7480cfbc6892aaf71cf0d2c3b8814c.blade.php ENDPATH**/ ?>