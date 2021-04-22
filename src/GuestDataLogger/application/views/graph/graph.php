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
            <?php foreach ($datasets as $dataset): ?>
            datasets: [{
                    label: '# di persone per webcam <?php echo $num_webcam;?>',
                    data: [ <?php echo $dataset; ?> ],

                    // Generic Style
                    borderColor: <?php echo $rgba; ?>,
                    backgroundColor: <?php echo $bgrgba; ?>,
                    borderWidth: 2,

                    // Line chart Style
                    pointBackgroundColor: <?php echo $rgba; ?>,
                    lineTension: 0,

                    // Pie chart Style
                    hoverOffset: 21
                },
            ],
            <?php endforeach ?>
        },
        options: {
            responsive: true,
            <?php if($type != "pie"): ?>
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
            <?php endif ?>
        }
    });
</script>