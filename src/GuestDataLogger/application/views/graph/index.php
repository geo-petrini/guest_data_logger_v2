<div class="container">
<h3>Seleziona stand</h3>
<table class="contentTable" border="0" cellspacing="2" cellpadding="2">
    <thead>
        <tr>
            <th>Nome</th> 
            <th>Luogo</th> 
            <th>Data di inizio</th> 
            <th>Data di fine</th>
            <th>Proprietario</th>
            <th>Grafico</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($stands as $stand): ?>
        <tr>
            <td><?php if(isset($stand['nome'])) echo $stand['nome']; ?></td>
            <td><?php if(isset($stand['luogo'])) echo $stand['luogo']; ?></td>
            <td><?php if(isset($stand['data_inizio'])) echo substr($stand['data_inizio'], 0, 10); ?></td>
            <td><?php if(isset($stand['data_fine'])) echo substr($stand['data_fine'], 0, 10); ?></td>
            <td><?php if(isset($stand['proprietario'])) echo $stand['proprietario']; ?></td>
            <td>
                <form action="<?php echo URL?>graph/showGraph" method="post"> 
                    <button type="submit" name="buttonGraph">Mostra grafici</button>
                    <input type="hidden" name="id" value="<?php echo $stand['id']?>">
                    <input type="hidden" name="type" value="line">
                    <input type="hidden" name="datetime" value="default">
                    <input type="hidden" name="refresh" value="yes">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>