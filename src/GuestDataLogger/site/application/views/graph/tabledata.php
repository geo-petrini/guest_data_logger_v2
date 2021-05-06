<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<table class="contentTable" border="0" cellspacing="2" cellpadding="2">
    <thead>
        <tr>
            <th>Data</th> 
            <th>Numero di persone</th> 
            <th>Numero webcam</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($stats as $stat): ?>
        <tr>
            <td><?php echo $stat['data']; ?></td>
            <td><?php echo $stat['numero_persone']; ?></td>
            <td><?php echo $stat['num_webcam']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<button id="jsonButton">JSON</button>
<div class="messagepop pop">
</div>
<script>
    $("#jsonButton").click(function() {
        if($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $('.pop').css("display", "none");
        } else {
            $(this).addClass('selected');
            $.get('http://samtinfo.ch/gdl/scripts/jsondata.php',{ stand_id:<?php echo $_SESSION['post']['id'];?>, data:"<?php echo $datetime;?>" }, function(result){
                var link = "<?php echo "http://samtinfo.ch/gdl/scripts/jsondata.php?stand_id=" . $_SESSION['post']['id'] . "&data=$datetime";?>";
                $('.pop').html(result + "<br><br>" + "<a href=" + link + ">" + link + "</a>");
            });
            $('.pop').css("display", "block");
        }
        return false;
    });
</script>