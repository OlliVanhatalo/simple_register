<?php 
  include "javascript.php";
?>
  <!-- Button to reveal quote form -->
  <div id="<?php echo $thread ?>button" style="display:block">
    <button id="<?php echo $thread ?>quote">Vastaa lainaten</button>
  </div>

  <!-- Quote form -->
  <div id="<?php echo $thread ?>quote-form" style="display:none">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='quote' value='<?php echo $$messID2 ?>'>
      <input style='display:none' type='text' name='thread' value='<?php echo $thread ?>'>
      <textarea rows=3 cols=40 name=quote></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>

  <!-- Cancel button hides revealed form -->
  <button id="<?php echo $thread ?>cancel" style="display:none">Peruuta</button>