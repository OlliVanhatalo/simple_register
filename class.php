<?php

class messageBlock {
  public $id;
  public $thread;

  function __constructor ($id, $thread) {
    $this->id = $id;
    $this->thread = $thread;
  }

  function replyBlock ($id, $thread) {

    include 'displayFormJs.php';
    include 'reply.php';
  }

  function quoteBlock ($id2, $thread2) {
    include 'displayFormJs.php';
    include 'quote.php';
  }
  
}

?>