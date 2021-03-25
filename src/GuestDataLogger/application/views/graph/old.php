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
        datasets: [
            {
                label: '# di persone per webcam <?php echo $num_webcam;?>',
                data: [
                    <?php echo $dataset; ?>
                ],
                backgroundColor: 'rgba(0, 0, 0, 0)',
                <?php if($num_webcam == 1): ?>
                    borderColor: 'rgba(127, 0, 0, 255)',
                <?php elseif($num_webcam == 2): ?>
                    borderColor: 'rgba(0, 127, 0, 255)',
                <?php elseif($num_webcam == 3): ?>
                    borderColor: 'rgba(0, 0, 127, 255)',
                <?php else:
                    $red = rand(0, 127);
                    $green = rand(0, 127);
                    $blue = rand(0, 127);
                    echo "borderColor: 'rgba($red, $green, $blue, 255)',";
                ?>
                <?php endif; ?>
                borderWidth: 1,
                lineTension: 0,
            },
        ],
    },
    options: { }
});
</script>