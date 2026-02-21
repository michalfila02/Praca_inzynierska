<?php if (! $__env->hasRenderedOnce('556f37d8-112e-4b77-9eb6-d93dfc95a222')): $__env->markAsRenderedOnce('556f37d8-112e-4b77-9eb6-d93dfc95a222'); ?>
    <?php if($delivery == 'cdn'): ?>
            <?php if($version == 4): ?>
                <script src="https://cdn.jsdelivr.net/npm/chart.js@^4"></script>
                <?php if($date_adapter == 'moment'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
                <?php elseif($date_adapter == 'luxon'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>
                <?php elseif($date_adapter == 'date-fns'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/date-fns@^3/index.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
                <?php endif; ?>
                <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
            <?php elseif($version == 3): ?>
                <script src="https://cdn.jsdelivr.net/npm/chart.js@^3"></script>
                <?php if($date_adapter == 'moment'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
                <?php elseif($date_adapter == 'luxon'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>
                <?php elseif($date_adapter == 'date-fns'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/date-fns@^3/index.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
                <?php endif; ?>
                <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
            <?php else: ?>
                <script src="https://cdn.jsdelivr.net/npm/chart.js@^2"></script>
                <?php if($date_adapter == 'moment'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^0.1.2"></script>
                <?php elseif($date_adapter == 'luxon'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>
                <?php elseif($date_adapter == 'date-fns'): ?>
                    <script src="https://cdn.jsdelivr.net/npm/date-fns@^3/index.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
                <?php endif; ?>
                <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
            <?php endif; ?>
            <?php if(Config::get('chartjs.custom_chart_types')): ?>
                    <?php $__currentLoopData = Config::get('chartjs.custom_chart_types'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $cdn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <script src="<?php echo e($cdn); ?>"></script>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
    <?php elseif($delivery == 'publish'): ?>
        <?php if($version == 4): ?>
            <script type="module" src="<?php echo e(asset('vendor/laravelchartjs/chart.js')); ?>"></script>
        <?php elseif($version == 3): ?>
            <script src="<?php echo e(asset('vendor/laravelchartjs/chart3.js')); ?>"></script>
        <?php else: ?>
            <script src="<?php echo e(asset('vendor/laravelchartjs/chart2.bundle.js')); ?>"></script>
        <?php endif; ?>
    <?php elseif($delivery == 'binary'): ?>
        <?php if($version == 4): ?>
            <script><?php echo $chartJsScriptv4; ?></script>
        <?php elseif($version == 3): ?>
            <script><?php echo $chartJsScriptv3; ?></script>
        <?php else: ?>
            <script><?php echo $chartJsScriptv2; ?></script>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<canvas id="<?php echo $element; ?>" width="<?php echo $size['width']; ?>" height="<?php echo $size['height']; ?>">
    <script>
        (function() {
            var init = function() {
                "use strict";
                var ctx = document.getElementById("<?php echo $element; ?>");
                window.<?php echo $element; ?> = new Chart(ctx, {
                    type: <?php echo \Illuminate\Support\Js::from($type)->toHtml() ?>,
                    data: {
                        labels: <?php echo $labels; ?>,
                        datasets: <?php echo $datasets; ?>

                    },
                    options: <?php echo $options; ?>

                });
            };
    
            if (document.readyState !== 'loading') {
                init();
            } else {
                document.addEventListener("DOMContentLoaded", init);
            }
        })();
    </script>
</canvas><?php /**PATH C:\xampp\htdocs\termometria\vendor\icehouse-ventures\laravel-chartjs\src\Providers/../resources/views/chart-template.blade.php ENDPATH**/ ?>