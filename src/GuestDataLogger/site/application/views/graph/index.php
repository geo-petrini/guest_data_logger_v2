<div class="container">
<nav class="btn-pluss-wrapper">
 <div href="#" class="btn-pluss">
  <ul>
    <li>
        <form id="filterForm1" action="<?php echo URL?>graph" method="post">
            <input type="radio" id="stand" name="filter" value="id" <?php if($filter == 'id') echo 'checked'?> onclick="document.getElementById('filterForm1').submit();">
            <label for="tabledata">stand</label>
        </form>
    </li>
    <li>
        <form id="filterForm2" action="<?php echo URL?>graph" method="post">
            <input type="radio" id="nome" name="filter" value="nome" <?php if($filter == 'nome') echo 'checked'?> onclick="document.getElementById('filterForm2').submit();">
            <label for="tabledata">nome</label>
        </form>
    </li>
    <li>
        <form id="filterForm3" action="<?php echo URL?>graph" method="post">
            <input type="radio" id="luogo" name="filter" value="luogo" <?php if($filter == 'luogo') echo 'checked'?> onclick="document.getElementById('filterForm3').submit();">
            <label for="tabledata">luogo</label>
        </form>
    </li>
  </ul>
 </div>
</nav>
<h3>Seleziona grafico</h3>
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
            <td><?php if(isset($stand['nome'])) echo "<pre>".str_replace(",", "</pre><pre>", $stand['nome'])."</pre>"; ?></td>
            <td><?php if(isset($stand['luogo'])) echo "<pre>".str_replace(",", "</pre><pre>", $stand['luogo'])."</pre>"; ?></td>
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