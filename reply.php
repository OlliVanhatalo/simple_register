<?php 
  // include "javascript.php";
  echo "Nämä on reply.php:n sisällä<br>";
  echo "thread = " . $thread . "<br>";
  echo "messID = " . $id . "<br>";
?>

  <!-- Buttons to reveal either reply or quote form -->
  <div id="<?php echo $thread ?>buttons" style="display:block">
    <button id="<?php echo $thread ?>reply" onclick="revealReplyForm()">Vastaa</button>
    <button id="<?php echo $thread ?>quote" onclick="revealQuoteForm()">Vastaa lainaten</button>
  </div>

  <!-- Reply form -->
  <p>Vastaa kenttä</p>
  <div id="reply-form" style="display:block">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='thread' value='<?php echo $thread ?>'>
      <textarea rows=3 cols=40 name=mess></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>

  <!-- Quote form -->
  <p>Vastaa lainaten kenttä</p>
  <div id="quote-form" style="display:block">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='thread' value='<?php echo $thread ?>'>
      <input style='display:none' type='text' name='quote' value='<?php echo $id ?>'>
      <textarea rows=3 cols=40 name=mess></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>

  <!-- Cancel button hides any revealed form -->
  <button id="<?php echo $thread ?>cancel" style="display:block" onclick="hideForm()">Peruuta</button>