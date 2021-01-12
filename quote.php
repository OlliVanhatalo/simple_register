<?php 
  // include "javascript.php";
  echo "Nämä on quote.php:n sisällä<br>";
  echo "thread2 = " . $thread . "<br>";
  echo "messID2 = " . $id . "<br>";
?>

<!-- Button to reveal quote form -->
    <div id='<?php echo $thread ?>button' style='display:block'>
      <button id='<?php echo $thread ?>quote' onclick="revealQuoteForm()">Vastaa lainaten</button>
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
  
    <!-- Cancel button hides revealed form -->
    <button id='<?php echo $thread ?>cancel' style='display:block' onclick='hideForm()'>Peruuta</button>
