<center><h2>Login</h2></center>

<form action="<?php echo URL?>login/checkLogin" method="post">
    <div class="imgcontainer">
    <img src="application/images/adminLogin.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
    <label for="username"><b>Username</b></label><br>
    <input type="text" placeholder="Enter Username" name="username" required><br>

    <label for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" required><br>
        
    <button type="submit">Login</button>
    </div>
</form>