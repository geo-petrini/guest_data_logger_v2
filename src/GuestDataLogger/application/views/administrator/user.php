<div class="container">
<h3>Modify user</h3>
<table border="0" cellspacing="2" cellpadding="2">
    <thead>
        <tr>
            <th>Username</th> 
            <th>Nome</th> 
            <th>Cognome</th> 
            <th>isOwner</th>
            <th>isAdmin</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php if(isset($user['username'])) echo $user['username']; ?></td>
            <td><?php if(isset($user['nome'])) echo $user['nome']; ?></td>
            <td><?php if(isset($user['cognome'])) echo $user['cognome']; ?></td>
            <td><?php if(isset($user['isOwner'])) echo $user['isOwner']; ?></td>
            <td><?php if(isset($user['isAdmin'])) echo $user['isAdmin']; ?></td>
        </tr>
    </tbody>
</table>
<div class="container">
        <form action="<?php echo URL?>administrator/updateUser" method="post">
            <p>Username</p>
            <input type="text" name="newUsername" value="<?php echo $user['username'];?>" required>
            <p>Nome</p>
            <input type="text" name="newNome" value="<?php echo $user['nome'];?>">
            <p>Cognome</p>
            <input type="text" name="newCognome" value="<?php echo $user['cognome'];?>">
            <p>isAdmin (1 = true)</p>
            <input type="number" name="newIsAdmin" value="<?php echo $user['isAdmin'];?>" min="0" max="1">
            <br>
            <button type="submit" name="buttonAggiorna">Aggiorna</button>
            <input type="hidden" name="username" value="<?php echo $user['username'];?>">
        </form>
        <form action="<?php echo URL?>administrator/deleteUser" method="post"> 
            <button type="submit" name="buttonElimina" style="background-color: #FF3232">Elimina</button>
            <input type="hidden" name="username" value="<?php echo $user['username'];?>">
        </form>
</div>