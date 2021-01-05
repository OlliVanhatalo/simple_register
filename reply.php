<?php 
  include "javascript.php";
?>

  <!-- Buttons to reveal either reply or quote form -->
  <div id="<?php echo $thread ?>buttons" style="display:block">
    <button id="<?php echo $thread ?>reply" onclick="revealReplyForm()">Vastaa</button>
    <button id="<?php echo $thread ?>quote" onclick="revealQuoteForm()">Vastaa lainaten</button>
  </div>

  <!-- Reply form -->
  <div id="<?php echo $thread ?>reply-form" style="display:none">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='thread' value='<?php echo $thread ?>'>
      <textarea rows=3 cols=40 name=reply></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>

  <!-- Quote form -->
  <div id="<?php echo $thread ?>quote-form" style="display:none">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='quote' value='<?php echo $messID1 ?>'>
      <input style='display:none' type='text' name='thread' value='<?php echo $thread ?>'>
      <textarea rows=3 cols=40 name=quote></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>

  <!-- Cancel button hides any revealed form -->
  <button id="<?php echo $thread ?>cancel" style="display:none" onclick="hideForm()">Peruuta</button>