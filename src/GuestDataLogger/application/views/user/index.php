<div class="imgcontainer">
    <img src="application/images/adminLogin.png" alt="Avatar" class="avatar">
</div>

<div class="container">
    <label for="username"><b>Username</b></label><br>
    <p name="username"><?php echo $_SESSION['username']?></p><br>

    <label for="type"><b>User type</b></label><br>
    <p name="type"><?php 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
            echo "Admin";
        }else if(isset($_SESSION['owner']) && $_SESSION['owner'] == TRUE){
            echo "Stand owner";
        }else{
            echo "User";
        }
    ?></p>
    <br>

    <?php
    if(array_key_exists('buttonLogout', $_POST)) { 
        session_destroy();
        header("location: ".URL);
    }
    ?> 

    <form method="post"> 
        <button type="submit" name="buttonLogout" id="logout">Logout</button>
    </form>
    
</div>