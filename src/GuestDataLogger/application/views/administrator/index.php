<div class="imgcontainer">
    <img src="application/images/adminLogin.png" alt="Avatar" class="avatar">
</div>
<div class="container">
    <h3>Pannello admin</h3>
    <form action="<?php echo URL?>administrator/users" method="post"> 
        <button type="submit" name="buttonUsers">Users</button>
    </form>
    <form action="<?php echo URL?>administrator/stands" method="post"> 
        <button type="submit" name="buttonStands">Stands</button>
    </form>
</div>