<?php
class messageBlock {
  function replyBlock ($id, $thread) {
    include 'displayFormJs.php';
    include 'reply.php';
  }
  function quoteBlock ($id, $thread) {
    include 'displayFormJs.php';
    include 'quote.php';
  }  
}
?>