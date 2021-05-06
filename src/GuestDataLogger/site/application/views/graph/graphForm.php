<nav class="btn-pluss-wrapper">
 <div href="#" class="btn-pluss">
  <ul>
    <li>
        <form id="graphForm1" action="<?php echo URL?>graph/showGraph" method="post">
            <input type="radio" id="tabledata" name="type" value="tabledata" <?php if($type == 'tabledata') echo 'checked'?> onclick="document.getElementById('graphForm1').submit();">
            <label for="tabledata">In tabella</label>
            <input type="radio" id="line" name="type" value="line" <?php if($type == 'line') echo 'checked'?> onclick="document.getElementById('graphForm1').submit();">
            <label for="line">A linee</label>
            <input type="radio" id="bar" name="type" value="bar" <?php if($type == 'bar') echo 'checked'?> onclick="document.getElementById('graphForm1').submit();">
            <label for="bar">A barre</label>
            <input type="radio" id="pie" name="type" value="pie" <?php if($type == 'pie') echo 'checked'?> onclick="document.getElementById('graphForm1').submit();">
            <label for="pie">A torta</label>
            <input type="radio" id="doughnut" name="type" value="doughnut" <?php if($type == 'doughnut') echo 'checked'?> onclick="document.getElementById('graphForm1').submit();">
            <label for="doughnut">Ad anello</label>
            <input type="radio" id="polarArea" name="type" value="polarArea" <?php if($type == 'polarArea') echo 'checked'?> onclick="document.getElementById('graphForm1').submit();">
            <label for="polarArea">Ad area polare</label>
            <input type="hidden" name="datetime" value="<?php echo $datetime ?>"/>
            <input type="hidden" name="refresh" value="<?php echo $refresh ?>"/>
            <input type="hidden" name="id" value="<?php echo $stand_id?>">
        </form>
    </li>
    <li>
        <form id="graphForm2" action="<?php echo URL?>graph/showGraph" method="post">
            <?php if($type != "pie" && $type != "doughnut" && $type != "polarArea"): ?>
            <input type="radio" id="year" name="datetime" value="YEAR" <?php if($datetime == 'YEAR') echo 'checked'?> onclick="document.getElementById('graphForm2').submit();">
            <label for="year">Per anno</label>
            <input type="radio" id="month" name="datetime" value="MONTH" <?php if($datetime == 'MONTH') echo 'checked'?> onclick="document.getElementById('graphForm2').submit();">
            <label for="month">Per mese</label>
            <input type="radio" id="day" name="datetime" value="DATE" <?php if($datetime == 'DATE') echo 'checked'?> onclick="document.getElementById('graphForm2').submit();">
            <label for="day">Per giorno</label>
            <input type="radio" id="hour" name="datetime" value="HOUR" <?php if($datetime == 'HOUR') echo 'checked'?> onclick="document.getElementById('graphForm2').submit();">
            <label for="hour">Per ora</label>
            <input type="radio" id="minute" name="datetime" value="MINUTE" <?php if($datetime == 'MINUTE') echo 'checked'?> onclick="document.getElementById('graphForm2').submit();">
            <label for="minute">Per minuto</label>
            <input type="radio" id="default" name="datetime" value="default" <?php if($datetime == 'default') echo 'checked'?> onclick="document.getElementById('graphForm2').submit();">
            <label for="default">Per data e orario</label>
            <input type="hidden" name="type" value="<?php echo $type ?>"/>
            <input type="hidden" name="refresh" value="<?php echo $refresh ?>"/>
            <input type="hidden" name="id" value="<?php echo $stand_id?>">
            <?php endif ?>
        </form>
    </li>
    <li>
        <form id="graphForm3" action="<?php echo URL?>graph/showGraph" method="post">
            <input type="radio" id="ref" name="refresh" value="yes" <?php if($refresh == 'yes') echo 'checked'?> onclick="document.getElementById('graphForm3').submit();">
            <label for="ref">Ricarica automaticamente</label>
            <input type="radio" id="noref" name="refresh" value="no" <?php if($refresh == 'no') echo 'checked'?> onclick="document.getElementById('graphForm3').submit();">
            <label for="noref">Non ricaricare</label>
            <input type="hidden" name="id" value="<?php echo $stand_id?>">
            <input type="hidden" name="datetime" value="<?php echo $datetime ?>"/>
            <input type="hidden" name="type" value="<?php echo $type ?>"/>
        </form>
    </li>
  </ul>
 </div>
</nav>