<?php 
  // echo "Nämä on reply.php:n sisällä<br>";
  // echo "thread = " . $thread . "<br>";
  // echo "messID = " . $id . "<br>";
?>

  <!-- Buttons to reveal either reply or quote form -->
  <div id="<?php echo $id ?>buttons" style="display:block">
    <button id="<?php echo $id ?>reply" onclick="revealReplyForm(<?php echo $id ?>)">Vastaa</button>
    <button id="<?php echo $id ?>quote" onclick="revealQuoteForm(<?php echo $id ?>)">Vastaa lainaten</button>
  </div>

  <!-- Reply form -->
  <div id="<?php echo $id ?>reply-form" style="display:none">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='thread' value='<?php echo $thread ?>'>
      <textarea rows=3 cols=40 name=mess></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>

  <!-- Quote form -->
  <div id="<?php echo $id ?>quote-form" style="display:none">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='thread' value='<?php echo $thread ?>'>
      <input style='display:none' type='text' name='quote' value='<?php echo $id ?>'>
      <textarea rows=3 cols=40 name=mess></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>

  <!-- Cancel button hides any revealed form -->
  <button id="<?php echo $id ?>cancel" style="display:none" onclick="hideForm(<?php echo $id ?>)">Peruuta</button>