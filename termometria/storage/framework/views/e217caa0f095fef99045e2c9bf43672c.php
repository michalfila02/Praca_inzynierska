<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termometria</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <br>
    <h2 class="text-center">Termometria</h2>
    <br>

    

    <div class="row align-items-start">
            <div class="col-4">
                <?php echo $chart1->render(); ?>

            </div>
            <div class="col-4">
                <?php echo $chart2->render(); ?>

            </div>
            <div class="col-4">
                <?php echo $chart3->render(); ?>

            </div>
    </div>
    <br>
    <br>
    <div class="container my-5">
        <button class="btn btn-primary" onclick="fetch('<?php echo e(url('/esp-decider/snowball_1')); ?>')">
        Prześlij pomiar
        </button>

        <form method="GET" action="<?php echo e(url('/')); ?>" class="mb-5">
            <div class="input-group">
                <select name="range" class="form-select" onchange="this.form.submit()">
                    <?php $__currentLoopData = $RANGES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e($range === $key ? 'selected' : ''); ?>>
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Data</th>
                        <th>Temperatura</th>
                        <th>Wilgotność</th>
                        <th>Ciśnienie</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row["Date"]); ?></td>
                            <td><?php echo e($row["Temperature"]); ?></td>
                            <td><?php echo e($row["Pressure"]); ?></td>
                            <td><?php echo e($row["Humidity"]); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.5.0/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@latest"></script>

</body>
</html><?php /**PATH C:\xampp\htdocs\termometria\resources\views/welcome.blade.php ENDPATH**/ ?>