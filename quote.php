<?php 
  // include "javascript.php";
  // echo "Nämä on quote.php:n sisällä<br>";
  // echo "thread2 = " . $thread2 . "<br>";
  // echo "messID2 = " . $id2 . "<br>";
?>

<!-- Button to reveal quote form -->
    <div id="<?php echo $id2 ?>buttons" style='display:block'>
      <button id="<?php echo $id2 ?>quote" onclick="revealQuoteForm(<?php echo $id2 ?>)">Vastaa lainaten</button>
    </div>
  
  <!-- Quote form -->
  <div id="<?php echo $id2 ?>quote-form" style="display:none">
    <form  method=post action=addReply.php>

      <input style='display:none' type='text' name='thread' value='<?php echo $thread2 ?>'>
      <input style='display:none' type='text' name='quote' value='<?php echo $id2 ?>'>
      <textarea rows=3 cols=40 name=mess></textarea>
      <br><br>
      <input type=submit value='Lähetä'>

    </form>
  </div>
  
    <!-- Cancel button hides revealed form -->
    <button id="<?php echo $id2 ?>cancel" style='display:none' onclick='hideForm(<?php echo $id2 ?>)'>Peruuta</button>
