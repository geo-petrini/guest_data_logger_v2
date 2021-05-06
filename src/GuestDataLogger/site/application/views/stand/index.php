<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="application/js/jquery.tabledit.js"></script>
<script type="text/javascript" src="application/js/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

<div class="container">
<h3>I miei stand</h3>
<table class="contentTable" border="0" cellspacing="2" cellpadding="2" id="t1">
    <thead>
        <tr>
            <th> <font face="Arial">ID</font> </th>
            <th> <font face="Arial">Nome</font> </th> 
            <th> <font face="Arial">Luogo</font> </th> 
            <th> <font face="Arial">Data di inizio</font> </th> 
            <th> <font face="Arial">Data di fine</font> </th> 
            <th> <font face="Arial">Grafico</font> </th> 
            <th> <font face="Arial">Ricevi chiave</font> </th>
            <th> <font face="Arial">Privacy</font> </th>
            <th> <font face="Arial">Elimina</font> </th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($stands as $stand): ?>
        <tr>
            <td><?php if(isset($stand['id'])) echo $stand['id']; ?></td>
            <td><?php if(isset($stand['nome'])) echo $stand['nome']; ?></td>
            <td><?php if(isset($stand['luogo'])) echo $stand['luogo']; ?></td>
            <td><?php if(isset($stand['data_inizio'])) echo substr($stand['data_inizio'],0,10); ?></td>
            <td><?php if(isset($stand['data_fine'])) echo substr($stand['data_fine'],0,10); ?></td>
            <td><?php if(in_array($stand['id'], $stand_ids)){?>
                <form action="<?php echo URL?>graph/showGraph" method="POST"> 
                    <input type="image" src="application/images/graph.png" name="submit"/>
                    <input type="hidden" name="id" value="<?php echo $stand['id']?>">
                    <input type="hidden" name="type" value="line">
                    <input type="hidden" name="datetime" value="default">
                    <input type="hidden" name="refresh" value="yes">
                </form>
            <?php }else{ ?>Dati non presenti<?php } ?></td>
            <td>
                <form action="<?php echo URL?>key/createKey" method="POST"> 
                    <button type="submit" name="getkey">Ricevi chiave</button>
                    <input type="hidden" name="id" value="<?php echo $stand['id']?>">
                </form>
            </td>
            <?php if($stand['isPublic'] == TRUE) { ?>
            <td>
                <span>
                    <img id="spanImg" src="application/images/globe.png"/>
                    <form action="<?php echo URL?>stand/togglePublic" method="POST">
                        <button type="submit" name="public">Rendi privato</button>
                        <input type="hidden" name="id" value="<?php echo $stand['id']?>">
                        <input type="hidden" name="val" value="0">
                    </form>
                </span>
            </td>
            <?php }else{?>
            <td>
                <span>
                    <img id="spanImg" src="application/images/lock.png"/>
                    <form action="<?php echo URL?>stand/togglePublic" method="POST">
                        <button type="submit" name="public">Rendi pubblico</button>
                        <input type="hidden" name="id" value="<?php echo $stand['id']?>">
                        <input type="hidden" name="val" value="1">
                    </form>
                </span>
            </td>
            <?php }?>
            <td>
                <form action="<?php echo URL?>stand/deleteStand" method="POST"> 
                    <input type="image" src="application/images/cross.png" name="submit" <?php if($_SESSION['first']):?>onclick="return confirm('Eliminando lo stand si perderanno gli eventuali dati associati ad esso, procedere?')"<?php endif?>/>
                    <input type="hidden" name="id" value="<?php echo $stand['id']?>">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready(function(){
	$('#t1').Tabledit({
			deleteButton: false,
			editButton: false,
			columns: {
					identifier: [0, 'id'],
					editable: [[1, 'nome'], [2, 'luogo'], [3, 'data_inizio'], [4, 'data_fine']]
			},
			hideIdentifier: true,
            url: "application/scripts/stand_edit.php",
            onDraw: function() {
                $('table tr td:nth-child(4) input').each(function() {
                    $(this).datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true
                    });
                });

                $('table tr td:nth-child(5) input').each(function() {
                    $(this).datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true
                    });
                });
            },
            onAjax: function(action, serialize) {
                if (action === 'edit') {
                    var start = new Array();
                    var end = new Array();
                    var validate = true;
                    var i = 0;
                    $("table tr td :input").each(function(){
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + '-' + mm + '-' + dd;
                        start[i] = $("table tr:nth-child(" + (i+1) + ") td:nth-child(4) :input").val()
                        end[i] = $("table tr:nth-child(" + (i+1) + ") td:nth-child(5) :input").val()
                        if(start[i] > end[i]){
                            alert("La data di inizio non può essere dopo quella di fine.");
                            validate = false;
                            return false;
                        }
                        i++;
                    });
                    if(!validate){
                        return false;
                    }
                    $('.datepicker').remove();
                }
            }
	});
});
</script>