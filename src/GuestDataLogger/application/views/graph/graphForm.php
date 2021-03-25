<form action="<?php echo URL?>graph/showGraph" method="post">
    <input type="radio" id="line" name="type" value="line" <?php if($type == 'line') echo 'checked'?>>
    <label for="line">A linee</label>
    <input type="radio" id="bar" name="type" value="bar" <?php if($type == 'bar') echo 'checked'?>>
    <label for="bar">A barre</label>
    <input type="radio" id="radar" name="type" value="radar" <?php if($type == 'radar') echo 'checked'?>>
    <label for="radar">A radar</label>
    <br>
    <input type="radio" id="default" name="datetime" value="default" <?php if($datetime == 'default') echo 'checked'?>>
    <label for="default">Per data e orario</label>
    <input type="radio" id="year" name="datetime" value="YEAR" <?php if($datetime == 'YEAR') echo 'checked'?>>
    <label for="year">Per anno</label>
    <input type="radio" id="month" name="datetime" value="MONTH" <?php if($datetime == 'MONTH') echo 'checked'?>>
    <label for="month">Per mese</label>
    <input type="radio" id="day" name="datetime" value="DATE" <?php if($datetime == 'DATE') echo 'checked'?>>
    <label for="day">Per giorno</label>
    <input type="radio" id="hour" name="datetime" value="HOUR" <?php if($datetime == 'HOUR') echo 'checked'?>>
    <label for="hour">Per ora</label>
    <input type="radio" id="minute" name="datetime" value="MINUTE" <?php if($datetime == 'MINUTE') echo 'checked'?>>
    <label for="minute">Per minuto</label>
    <br>
    <button type="submit" name="buttonGraph">Ricarica</button>
    <input type="hidden" name="id" value="<?php echo $stand_id?>">
</form>