<?php
// määritetään kunkin syklin viestiketjun threadID, sidotaan sen arvo stmt2 kyselyn ":thread" arvoon
        // ja suoritetaan tietokantakysely
        echo "messageID = " . $messID1 = $output->id . "<br>";
        $thread = $output->thread;

        echo "threadID = " . $thread . "<br>";
        echo "quote = " . $output->quote . "<br>";

        $stmt2->bindValue(":thread", $thread);
        $stmt2->execute();

        echo "<div class='thread'>";
        echo "<font size=2><b>";
        echo $output->username . "</b> kirjoitti ";
        echo $output->date . " klo " . substr($output->time, 0, 8);

        echo "</font><p><b>";
        echo $output->mess;
        echo "</b></p>";

        $block = new messageBlock($messID1, $thread);
        echo $block->block();

        while ( $output2 = $stmt2->fetchObject() ) {
          
          $messID2 = $output2->id;
          echo "messageID = " . $messID2 . "<br>";

          $thread2 = $output2->thread;
          echo "threadID = " . $thread2 . "<br>";
          $quote = $output2->quote;
          echo "quote = " . $quote . "<br>";
          $stmt3->bindValue(":quote", $quote);

          echo "<div class='reply'>";
          echo "<font size=2><b>";
          echo $output2->username . "</b> vastasi ";
          echo $output2->date . " klo " . substr($output2->time, 0, 8);

          if ($quote != NULL) {
            $stmt2->closeCursor();            
            $stmt3->execute();
            $output3 = $stmt3->fetchObject();

            echo "<div class='quote'>";
            echo "<font size=1><b><q>";
            echo $output3->username . "</b> vastasi ";
            echo $output3->date . " klo " . substr($output3->time, 0, 8);
  
            echo "</font><p><b>";
            echo $output3->mess;
            echo "</q></b></p></div>";
            $stmt3->closeCursor();
          }

          echo "</font><p><b>";
          echo $output2->mess;
          echo "</b></p>";
          
          include 'quote.php';

          echo "</div>";
        }
 
        echo "</div>";
        echo "<HR>";
   
?>