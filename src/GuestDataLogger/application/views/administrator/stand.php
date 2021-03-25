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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php if(isset($stand['nome'])) echo $stand['nome']; ?></td>
                <td><?php if(isset($stand['luogo'])) echo $stand['luogo']; ?></td>
                <td><?php if(isset($stand['data_inizio'])) echo $stand['data_inizio']; ?></td>
                <td><?php if(isset($stand['data_fine'])) echo $stand['data_fine']; ?></td>
                <td><?php if(isset($stand['proprietario'])) echo $stand['proprietario']; ?></td>
                <td><?php if(isset($stand['isPublic'])) echo $stand['isPublic']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="container">
    <form action="<?php echo URL?>administrator/updateStand" method="post">
        <p>Nome</p>
        <input type="text" name="newNome" value="<?php echo $stand['nome']?>" required>
        <p>Luogo</p>
        <input type="text" name="newLuogo" value="<?php echo $stand['luogo']?>" required>
        <br>
        <button type="submit" name="buttonAggiorna">Aggiorna</button>
        <input type="hidden" name="id" value="<?php echo $stand['id'];?>">
    </form>
    <form action="<?php echo URL?>administrator/deleteStand" method="post"> 
        <button type="submit" name="buttonElimina" style="background-color: #FF3232">Elimina</button>
        <input type="hidden" name="id" value="<?php echo $stand['id'];?>">
    </form>
</div>