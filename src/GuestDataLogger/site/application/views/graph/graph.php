<script src="<?php echo URL;?>application/js/Chart.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<canvas id="chart<?php echo $num_webcam;?>"></canvas>
<?php if($type != "pie" && $type != "doughnut" && $type != "polarArea"){
    $_SESSION['button'] = true;
    ?>
    <div class="divbtn">
        <button id="jsonButton<?php echo $num_webcam;?>">JSON</button>
        <div class="messagepop pop<?php echo $num_webcam;?>">
        </div>
    </div>
    
<?php } ?>
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
            <?php if($type != "pie" && $type != "doughnut" && $type != "polarArea"): ?>
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
    <?php if($type != "pie" && $type != "doughnut" && $type != "polarArea"){?>
    $("#jsonButton<?php echo $num_webcam;?>").click(function() {
        if($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $('.pop<?php echo $num_webcam;?>').css("display", "none");
        } else {
            $(this).addClass('selected');
            $.get('http://samtinfo.ch/gdl/scripts/jsondata.php',{ stand_id:<?php echo $_SESSION['post']['id'];?>, num_webcam:<?php echo $num_webcam;?>, data:"<?php echo $datetime;?>" }, function(result){
                var link = "<?php echo "http://samtinfo.ch/gdl/scripts/jsondata.php?stand_id=" . $_SESSION['post']['id'] . "&num_webcam=" . $num_webcam . "&data=$datetime";?>";
                $('.pop<?php echo $num_webcam;?>').html(result + "<br><br>" + "<a href=" + link + ">" + link + "</a>");
            });
            $('.pop<?php echo $num_webcam;?>').css("display", "block");
        }
        return false;
    });
    <?php } ?>
</script>