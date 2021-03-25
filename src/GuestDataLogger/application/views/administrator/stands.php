<div class="container">
<h3>Stands</h3>
<table border="0" cellspacing="2" cellpadding="2">
    <thead>
        <tr>
            <th>Nome</th> 
            <th>Luogo</th> 
            <th>Data di inizio</th> 
            <th>Data di fine</th>
            <th>Proprietario</th> 
            <th>isPublic</th>
            <th>Modifica</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($stands as $stand): ?>
        <tr>
            <td><?php if(isset($stand['nome'])) echo $stand['nome']; ?></td>
            <td><?php if(isset($stand['luogo'])) echo $stand['luogo']; ?></td>
            <td><?php if(isset($stand['data_inizio'])) echo $stand['data_inizio']; ?></td>
            <td><?php if(isset($stand['data_fine'])) echo $stand['data_fine']; ?></td>
            <td><?php if(isset($stand['proprietario'])) echo $stand['proprietario']; ?></td>
            <td><?php if(isset($stand['isPublic'])) echo $stand['isPublic']; ?></td>
            <td>
                <form action="<?php echo URL?>administrator/modifyStand" method="post"> 
                    <button type="submit" name="buttonModify">Modifica</button>
                    <input type="hidden" name="id" value="<?php echo $stand['id']?>">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>