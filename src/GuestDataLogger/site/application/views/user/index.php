<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="application/js/jquery.tabledit.js"></script>
<script type="text/javascript" src="application/js/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
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
    <button type="submit" name="buttonMore" id="bMore" onclick="more()">+</button>

    <button type="submit" name="buttonLess" id="bLess" style="display:none" onclick="less()">-</button>
    <br>
    <table class="contentTable" border="0" cellspacing="2" cellpadding="2" id="t11" style="display:none">
        <thead>
            <tr>
                <th> <font face="Arial">Username</font> </th>
                <th> <font face="Arial">Name</font> </th>
                <th> <font face="Arial">Surname</font> </th> 
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td><?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?></td>
                    <td><?php if(isset($info[0]['nome'])) echo $info[0]['nome']; ?></td>
                    <td><?php if(isset($info[0]['cognome'])) echo $info[0]['cognome']; ?></td>
                </tr>
        </tbody>
    </table>

    <form method="post"> 
        <button type="submit" name="buttonLogout" id="logout">Logout</button>
    </form>
    
</div>
<script>

function more(){
    document.getElementById("bMore").style.display = "none";
    document.getElementById("bLess").style.display = "inline";
    document.getElementById("t11").style.display = "inline";
}

function less(){
    document.getElementById("bMore").style.display = "inline";
    document.getElementById("bLess").style.display = "none";
    document.getElementById("t11").style.display = "none";
}

$(document).ready(function(){
	$('#t11').Tabledit({
			deleteButton: false,
			editButton: false,
			columns: {
					identifier: [0, 'username'],
					editable: [[1, 'nome'], [2, 'cognome']]
			},
			hideIdentifier: true,
            url: "<?php echo URL?>application/scripts/user_edit.php",
	});
});
</script>