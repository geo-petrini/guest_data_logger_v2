<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="container">
<h3>Le mie chiavi</h3>
<table class="contentTable" id="keytable" border="0" cellspacing="2" cellpadding="2" id="t1">
    <thead>
        <tr>
            <th> <font face="Arial">Nome</font> </th> 
            <th> <font face="Arial">Luogo</font> </th>
            <th> <font face="Arial">Id stand</font> </th>
            <th> <font face="Arial"># Webcam</font> </th> 
            <th> <font face="Arial">Chiave (clicca per copiare)</font> </th> 
            <th> <font face="Arial">Elimina</font> </th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($keys as $key): ?>
        <tr>
            <td><?php if(isset($key['nome'])) echo $key['nome']; ?></td>
            <td><?php if(isset($key['luogo'])) echo $key['luogo']; ?></td>
            <td><?php if(isset($key['stand_id'])) echo $key['stand_id']; ?></td>
            <td><?php if(isset($key['num_webcam'])) echo $key['num_webcam']; ?></td>
            <td title="Copia"><?php if(isset($key['chiave'])) echo $key['chiave']; ?></td>
            <td>
                <form action="<?php echo URL?>key/deleteKey" method="POST"> 
                    <input type="image" src="application/images/cross.png" name="submit"/>
                    <input type="hidden" name="chiave" value="<?php echo $key['chiave']?>">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function(){
    var lastClicked = null;
    var lastRow;
    $('table tr td:nth-child(5)').click(function() {
        var row_num = parseInt( $(this).parent().index() )+1;
        var clicked = $("table tr:nth-child(" + row_num +") td:nth-child(5)");
        var copyText = clicked.html();
        var dummy = $('<input>');
        var keys = <?php echo json_encode($keys); ?>;
        dummy.val(copyText).appendTo('body').select();
        document.execCommand("copy");
        dummy.remove();
        if(lastClicked != null){
            $(lastClicked).html(keys[lastRow-1]['chiave']);
            $(lastClicked).css("pointer-events","auto");
            $(lastClicked).css("color", "black");
        }
        lastClicked = clicked;
        lastRow = row_num;
        clicked.html("Copiato");
        clicked.css("pointer-events","none");
        clicked.css("color", "green");
    });
});
</script>