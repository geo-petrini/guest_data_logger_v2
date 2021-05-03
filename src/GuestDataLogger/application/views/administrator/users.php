<div class="container">
<h3>Utenti</h3>
<table class="contentTable" border="0" cellspacing="2" cellpadding="2">
    <thead>
        <tr>
            <th>Username</th> 
            <th>Nome</th> 
            <th>Cognome</th> 
            <th>isOwner</th>
            <th>isAdmin</th> 
            <th>Modifica</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $utente): ?>
        <tr>
            <td><?php if(isset($utente['username'])) echo $utente['username']; ?></td>
            <td><?php if(isset($utente['nome'])) echo $utente['nome']; ?></td>
            <td><?php if(isset($utente['cognome'])) echo $utente['cognome']; ?></td>
            <td><?php if(isset($utente['isOwner'])) echo $utente['isOwner']; ?></td>
            <td><?php if(isset($utente['isAdmin'])) echo $utente['isAdmin']; ?></td>
            <td>
                <form action="<?php echo URL?>administrator/modifyUser" method="post"> 
                    <button type="submit" name="buttonModify">Modifica</button>
                    <input type="hidden" name="username" value="<?php echo $utente['username']?>">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>