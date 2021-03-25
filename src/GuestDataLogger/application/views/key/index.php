<div class="container">
<h3>Le tue chiavi</h3>
<table border="0" cellspacing="2" cellpadding="2" id="t1">
    <thead>
        <tr>
            <th> <font face="Arial">Nome</font> </th> 
            <th> <font face="Arial">Luogo</font> </th>
            <th> <font face="Arial">Id stand</font> </th>
            <th> <font face="Arial"># Webcam</font> </th> 
            <th> <font face="Arial">Chiave</font> </th> 
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
            <td><?php if(isset($key['chiave'])) echo $key['chiave']; ?></td>
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