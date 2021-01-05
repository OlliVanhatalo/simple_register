<?php
function messageForm() {
echo "<br><br><br>
<h2>Lisää uusi viesti</h2>

<form  method=post action=addMessage.php>

Viesti<br>
<textarea rows=5 cols=60 name=mess></textarea>
<br><br>
<input type=submit value='Lähetä'>

</form>";
}
?>