<script src="<?php echo URL;?>application/js/Chart.min.js"></script>
<canvas id="chart<?php echo $num_webcam;?>"></canvas>
<script>
    var ctx = document.getElementById('chart<?php echo $num_webcam;?>');
    var chart = new Chart(ctx, {
    type: '<?php echo $type;?>',
    data: {
        labels: [
            <?php echo $labels;?>
        ],
        <?php $ciclo = 0; ?>
        <?php foreach ($datasets as $dataset): ?>
        datasets: [
            {
                label: '# di persone per webcam <?php echo $num_webcam[$ciclo];?>',
                data: [
                    <?php echo $dataset; ?>
                ],
                // Generic Style
                <?php
                    $red = rand(0, 127);
                    $green = rand(0, 127);
                    $blue = rand(0, 127);
                    $rgba = "rgba($red, $green, $blue, 255)";
                ?>
                borderColor: '<?php echo $rgba; ?>',
                backgroundColor: '<?php echo $rgba; ?>',
                borderWidth: 2,

                // Line chart Style
                pointBackgroundColor: '<?php echo $rgba; ?>',
                lineTension: 0,
            },
        ],
        <?php $ciclo = $ciclo + 1; ?>
        <?php endforeach ?>
    },
    options: { }
});
</script>