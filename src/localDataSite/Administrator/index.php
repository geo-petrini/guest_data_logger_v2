<?php 
	session_start(); 
	$route = include('./../Configuration/config.php');
	$adminUserCredential = include('./../Configuration/adminUser.php');
	if($_SESSION['admin'] == true){
?>
<!DOCTYPE html>
<html>
<head>
	<title>People table</title>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		tr:hover {background-color:#f5f5f5;}

		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			background-color: #333;
		}

		li {
			float: left;
		}

		li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		li a:hover {
			background-color: #4CAF50;
		}
		#login {
			float: right;
		}
	</style>
	<script>
	function searchByValue() {
		var input, filter, table, tr, td, i, txtValue;
		input = document.getElementById("inputSearchValue");
		filter = input.value.toUpperCase();
		table = document.getElementById("dataTable");
		tr = table.getElementsByTagName("tr");
		selectedSearch = document.getElementById("searchBy").value;
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[selectedSearch];
			if (td) {
				if(document.querySelector('#searchContains').checked){
					txtValue =  td.textContent || td.innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = "";
					} else {
						tr[i].style.display = "none";
					}
				}else{
					txtValue =  td.textContent || td.innerText;
					if (txtValue == input.value || input.value == "") {
						tr[i].style.display = "";
					} else {
						tr[i].style.display = "none";
					}
				}
				
			}       
		}
	}
	</script>
</head>
<body>
	<?php
		#Connessione al Database.
		$mysqli = new mysqli("".$_SESSION['host'], $adminUserCredential[0], $adminUserCredential[1], "".$_SESSION['database']);
		#Query effettuata al Database.
		$table = $_SESSION['table'];
		$query = "SELECT * FROM $table";
	?>
<ul id="ulist">
        <li class="list"><a class="alink" href="<?php echo $route?>">Home</a></li>
        
        <?php
            if(isset($_SESSION['loggedin'])){
        ?>
        <li class="list"><a class="alink" href="<?php echo $route?>/Graphs/">Graphs</a></li>
        <?php
            }
        ?> 
        <?php
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){
        ?>
        
        <li class="list"><a class="alink" href="<?php echo $route?>/Administrator/">Data</a></li>
        <li class="list"><a class="alink" href="<?php echo $route?>/Modify/">Modify</a></li>
        <?php
            }
        ?>
        <li class="list"><a class="alink" href="<?php echo $route?>/About/">About</a></li>
        <?php 
            if(!isset($_SESSION['loggedin'])){
        ?>
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/Login/">Login</a></li>
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/Register/">Register</a></li>
        <?php
            }else{
        ?>
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/User/"><?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE){echo "Admin ";} echo $_SESSION['username'];?></a>
        <?php 
            }
        ?>
    </ul>
	<h1><center><b> Database Output</b></h1></center>  <br> <br>
	<?php	
		if ($result = $mysqli->query($query)) {
	?>
	<input type="text" id="inputSearchValue" onkeyup="searchByValue()" placeholder="Cerca...">
	<label for="searchBy">Search by:</label>
	<select id="searchBy" onChange="searchByValue()">
		<option value="0">Id</option>
		<option value="1">Date</option>
		<option value="2">Hours</option>
		<option value="3">Minutes</option>
		<option value="4">Seconds</option>
	</select>
	<input type="checkbox" id="searchContains" onChange="searchByValue()" name="search" value="true">
  	<label for="searchContains">Contains</label><br>
	<table id="dataTable">
	<tr>
		<th>Id</th>
		<th>Date</th>
		<th>Hours</th>
		<th>Minutes</th>
		<th>Seconds</th>
	</tr>
	<?php
			while ($row = $result->fetch_assoc()) {
				$id = $row["id"];
				$date = $row["date"];
				$hours = $row["hours"];
				$minutes = $row["minutes"];
				$seconds = $row["seconds"];
	?>
	<tr>
		<td><?php echo $id ?></td>
		<td><?php echo $date ?></td>
		<td><?php echo $hours ?></td>
		<td><?php echo $minutes ?></td>
		<td><?php echo $seconds ?></td>
	</tr>
	<?php	
			}
		
			/*freeresultset*/
			$result->free();
		}else{
			echo "Unable to make the query!";
		}
	?>
	</table>
</body>
</html>
<?php 
	}else{
?>
	<!DOCTYPE html>
	<head>
		<style>
			button {
				background-color: #4CAF50;
				color: white;
				padding: 14px 20px;
				margin: 8px 0;
				border: none;
				cursor: pointer;
        	}

			button:hover {
            	opacity: 0.8;
        	}

			.container {
				padding: 16px;
				text-align: center;
        	}
		</style>
	</head>
	<body>
	<form action="<?php echo $route?>/Login/" method="post">
		<div class="container">
			<p><b>Access denied!</b><br><br>You must be an administrator to watch this page</p>
			<button type="submit">Back</button>
		</div>
	</form>
	</body>
<?php
	}
?>