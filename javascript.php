<script>

  var buttons = document.getElementById("<?php echo $thread?>buttons");
  var replyForm = document.getElementById("<?php echo $thread?>reply-form");
  var quoteForm = document.getElementById("<?php echo $thread?>quote-form");
  var cancel = document.getElementById("<?php echo $thread?>cancel");

  // var buttons = document.getElementById("buttons");
  // var replyForm = document.getElementById("reply-form");
  // var quoteForm = document.getElementById("quote-form");
  // var cancel = document.getElementById("cancel");
  

  function revealReplyForm() {
    console.log("reveal reply function triggered")
    buttons.style.display = "none";
    replyForm.style.display = "block";
    quoteForm.style.display = "none";
    cancel.style.display = "block";
  }

  function revealQuoteForm() {
    console.log("reveal quote function triggered")
    buttons.style.display = "none";
    replyForm.style.display = "none";
    quoteForm.style.display = "block";
    cancel.style.display = "block";
  }

  function hideForm() {
    console.log("hide function triggered")
    buttons.style.display = "block";
    replyForm.style.display = "none";
    quoteForm.style.display = "none";
    cancel.style.display = "none";
  }

</script>