<?php 
	session_start(); 
    $route = include('./../Configuration/config.php');
    $normalUserCredential = include('./../Configuration/normalUser.php');
    function returnQuery($col, $table){
        if($col == "date"){
            $query = "SELECT `date`, count(`date`) as count from $table GROUP BY `date` ORDER BY `date`";
        }elseif($col == "hours"){
            $query = "SELECT `date`, $col, count(`date`) as count from $table GROUP BY `date`,$col ORDER BY `date`";
        }elseif($col == "minutes"){
            $query = "SELECT `date`, `hours`, $col, count(`date`) as count from $table GROUP BY `date`,`hours`, $col ORDER BY `date`";
        }else{
            $query = "SELECT `date`, `hours`, `minutes`, $col, count(`date`) as count from $table GROUP BY `date`,`hours`,`minutes`,$col ORDER BY `date`";
        }
        return $query;
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="<?php echo $route?>/Graphs/Lib/Chart.min.js"></script>
    <link rel="stylesheet" href="<?php echo $route?>/Graphs/Lib/bootstrap.min.css">
  <title>People graphs</title>
  <style>
    #ulist {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    .list {
        float: left;
    }

    .list .alink {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .list .alink:hover {
        background-color: #4CAF50;
    }
    #login {
        float: right;
    }
  </style>
</head>
<body>
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
            if(isset($_SESSION['admin'])){
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
        <li id="login" class="list"><a class="alink" href="<?php echo $route?>/User/"><?php if(isset($_SESSION['admin'])){echo "Admin ";} echo $_SESSION['username'];?></a>
        <?php 
            }
        ?>
    </ul>
    <br><br>
    <?php
        if($_SESSION["loggedin"]){

            $col = "minutes"; 
            if(isset($_POST["rangeGraph"])){
                $unit =$_POST["rangeGraph"];
                $col = $unit;
            }
            #Connessione al Database.
            $mysqli = new mysqli($_SESSION['host'], $normalUserCredential[0], $normalUserCredential[1],$_SESSION['database']);
            #Query effettuata al Database.
            $table = $_SESSION['table'];
            $query = returnQuery("$col", "".$_SESSION['table']);
            $date = array();
            $count = array();
            if ($result = $mysqli->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $dateRow = $row["date"];
                    $countRow = $row["count"];
                    $date[sizeof($date)] = $dateRow;
                    $count[sizeof($count)] = $countRow;
                    if($col == "hours"){
                        $hoursRow = $row["hours"];
                        $hours[sizeof($hours)] = $hoursRow;
                    }elseif($col == "minutes"){
                        $hoursRow = $row["hours"];
                        $hours[sizeof($hours)] = $hoursRow;
                        $minutesRow = $row["minutes"];
                        $minutes[sizeof($minutes)] = $minutesRow;
                    }elseif($col == "seconds"){
                        $hoursRow = $row["hours"];
                        $hours[sizeof($hours)] = $hoursRow;
                        $minutesRow = $row["minutes"];
                        $minutes[sizeof($minutes)] = $minutesRow;
                        $secondsRow = $row["seconds"];
                        $seconds[sizeof($seconds)] = $secondsRow;
                    }
                }
            
    ?>
    <label for="typeGraph">Select type of the graph:</label>
	<select id="typeGraph" onChange="createGraph(value)">
		<option id="barOption" value="bar">Bar</option>
		<option id="horizontalBarOption" value="horizontalBar">Horizontal Bar</option>
		<option id="pieOption" value="pie">Pie</option>
		<option id="lineOption" value="line">Line</option>
		<option id="doughnutOption" value="doughnut">Doughnut</option>
        <option id="radarOption" value="radar">Radar</option>
        <option id="polarAreaOption" value="polarArea">Polar Area</option>
    </select>
    <form method="Post">
    <label for="rangeGraph">Select the range of the graph:</label>
        <select id="rangeGraph" name="rangeGraph" onChange="this.form.submit()">
            <option value="date" <?php  if($col == "date"){echo "selected";} ?>>Days</option>
            <option value="hours" <?php  if($col == "hours"){echo "selected";} ?>>Hours</option>
            <option value="minutes" <?php  if($col == "minutes"){echo "selected";} ?>>Minutes</option>
            <option value="seconds" <?php  if($col == "seconds"){echo "selected";} ?>>Seconds</option>
        </select>
    </form>
    <div class="container">
        <canvas id="myChart"></canvas>
    </div>
    <script>
    window.onload = setDefaultGraph();

    function setDefaultGraph(){
        if(localStorage.getItem("type") === null){
            createGraph('bar');
        }else{
            createGraph(localStorage.getItem("type"));
        }
    }


    function createGraph(type) {
        localStorage.setItem("type",type);
        var myChart = document.getElementById("myChart").getContext("2d");
        document.getElementById(type + "Option").selected = true;
        if(window.bar != undefined) 
            window.bar.destroy(); 
        
        // Global Options
        Chart.defaults.global.defaultFontFamily = 'Lato';
        Chart.defaults.global.defaultFontSize = 18;
        Chart.defaults.global.defaultFontColor = '#777';
        if(type == "bar" || type == "horizontalBar" || type == "line"){
            window.bar = new Chart(myChart, {
                type: type, // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:[<?php
                                for($i = 0 ; $i < sizeof($date) ; $i++){
                                    $text = "";
                                    if($i != sizeof($date)-1){
                                        $text.= "'".$date[$i];
                                        if($hours){
                                            $text.= " ".$hours[$i];
                                            if($minutes){
                                                $text.= ":".$minutes[$i];
                                                if($seconds){
                                                    $text.= ":".$seconds[$i];
                                                }
                                            }else{
                                                $text .= ":00";
                                            }
                                        }
                                        $text.= "',";
                                    }else{
                                        $text.= "'".$date[$i];
                                        if($hours){
                                            $text.= " ".$hours[$i];
                                            if($minutes){
                                                $text.= ":".$minutes[$i];
                                                if($seconds){
                                                    $text.= ":".$seconds[$i];
                                                }
                                            }else{
                                                $text .= ":00";
                                            }
                                        }
                                        $text.= "'";
                                    }
                                    echo $text;
                                }
                            ?>],
                    datasets:[{
                    label:'Persone',
                    data:[<?php
                            for($i = 0 ; $i < sizeof($count) ; $i++){
                                if($i != sizeof($count)-1){
                                    echo $count[$i].",";
                                }else{
                                    echo $count[$i];
                            
                                }
                            }
                        ?>],
                    backgroundColor :[
                        <?php
                            for($i = 0 ; $i < sizeof($date) ; $i++){
                                if($i != sizeof($date)-1){
                                    echo "'rgba(".random_int(0,255).", ".random_int(0,255).", ".random_int(0,255).", ".(rand(0, 10) / 10)."',";
                                }else{
                                    echo "'rgba(".random_int(0,255).", ".random_int(0,255).", ".random_int(0,255).", ".(rand(0, 10) / 10)."'";
                                }
                            }
                        ?>
                    ],
                    borderWidth:1,
                    borderColor:'#777',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                    display:true,
                    text:'Persone presenti alla tua postazione',
                    fontSize:25
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                min: 0
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                min: 0
                            }
                        }]
                    },
                    legend:{
                    display:true,
                    position:'right',
                    labels:{
                        fontColor:'#000',
                    }
                    },
                    layout:{
                    padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                    }
                    },
                    tooltips:{
                    enabled:true
                    }
                }
            });
        }else{
            window.bar = new Chart(myChart, {
                type: type, // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:[<?php
                                for($i = 0 ; $i < sizeof($date) ; $i++){
                                    $text = "";
                                    if($i != sizeof($date)-1){
                                        $text.= "'".$date[$i];
                                        if($hours){
                                            $text.= " ".$hours[$i];
                                            if($minutes){
                                                $text.= ":".$minutes[$i];
                                                if($seconds){
                                                    $text.= ":".$seconds[$i];
                                                }
                                            }else{
                                                $text .= ":00";
                                            }
                                        }
                                        $text.= "',";
                                    }else{
                                        $text.= "'".$date[$i];
                                        if($hours){
                                            $text.= " ".$hours[$i];
                                            if($minutes){
                                                $text.= ":".$minutes[$i];
                                                if($seconds){
                                                    $text.= ":".$seconds[$i];
                                                }
                                            }else{
                                                $text .= ":00";
                                            }
                                        }
                                        $text.= "'";
                                    }
                                    echo $text;
                                }
                            ?>],
                    datasets:[{
                    label:'Persone',
                    data:[<?php
                            for($i = 0 ; $i < sizeof($count) ; $i++){
                                if($i != sizeof($count)-1){
                                    echo $count[$i].",";
                                }else{
                                    echo $count[$i];
                            
                                }
                            }
                        ?>],
                    backgroundColor :[
                        <?php
                            for($i = 0 ; $i < sizeof($date) ; $i++){
                                if($i != sizeof($date)-1){
                                    echo "'rgba(".random_int(0,255).", ".random_int(0,255).", ".random_int(0,255).", ".(rand(0, 10) / 10)."',";
                                }else{
                                    echo "'rgba(".random_int(0,255).", ".random_int(0,255).", ".random_int(0,255).", ".(rand(0, 10) / 10)."'";
                                }
                            }
                        ?>
                    ],
                    borderWidth:1,
                    borderColor:'#777',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                    display:true,
                    text:'Persone presenti alla tua postazione',
                    fontSize:25
                    },
                    legend:{
                    display:true,
                    position:'right',
                    labels:{
                        fontColor:'#000',
                    }
                    },
                    layout:{
                    padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                    }
                    },
                    tooltips:{
                    enabled:true
                    }
                }
            });
        }
        
    }
        
    </script>
    <?php
            }else{
                echo "Unable to do the query";
            }
        }else{
            echo "non sei loggato";
        }    
    ?>
</body>
</html>
