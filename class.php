<?php

class messageBlock {
  public $id;
  public $thread;

  function __constructor ($id, $thread) {
    $this->id = $id;
    $this->thread = $thread;
  }

  function replyBlock ($id, $thread) {
    include 'reply.php';
  }

  function quoteBlock ($id, $thread) {
    include 'quote.php';
  }
  
}

?>