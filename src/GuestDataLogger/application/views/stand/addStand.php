<center><h3>Aggiungi stand<h3></center>
<form action="<?php echo URL?>stand/addStand" method="post">
    <div class="container">
        <label><b>Nome stand</b></label><br>
        <input type="text" name="nome" required><br>

        <label><b>Luogo</b></label><br>
        <input type="text" name="luogo" required><br>

        <label><b>Data di inizio</b></label><br>
        <input type="date" name="data_inizio" required><br>

        <label><b>Data di fine</b></label><br>
        <input type="date" name="data_fine" required><br>

        <input type="hidden" name="proprietario" value="<?php echo $_SESSION['username']; ?>">

        <button type="submit">Aggiungi</button>
    </div>
</form>