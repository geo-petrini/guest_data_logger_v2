<div class="imgcontainer">
    <img src="application/images/adminLogin.png" alt="Avatar" class="avatar">
</div>
<div class="container">
    <h3>Pannello admin</h3>
    <form action="<?php echo URL?>administrator/users" method="post"> 
        <button type="submit" name="buttonUsers">Utenti</button>
    </form>
    <form action="<?php echo URL?>administrator/stands" method="post"> 
        <button type="submit" name="buttonStands">Stand</button>
    </form>
</div>