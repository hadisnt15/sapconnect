<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['active' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['active' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<a <?php echo e($attributes); ?>

    class="<?php echo e($active ? 'bg-red-500 text-white' : 'text-white hover:bg-red-700 hover:text-white'); ?> rounded-md px-2 py-2 text-sm font-medium "
    aria-current="<?php echo e($active ? 'page' : false); ?>"> <?php echo e($slot); ?>

</a>
<?php /**PATH C:\laragon\www\sapconnect\resources\views/components/nav-link.blade.php ENDPATH**/ ?>