<script>

  function revealReplyForm(threadNum) {
    console.log("reveal reply function triggered")

    var buttons = document.getElementById(threadNum + "buttons");
    var replyForm = document.getElementById(threadNum + "reply-form");
    var quoteForm = document.getElementById(threadNum + "quote-form");
    var cancel = document.getElementById(threadNum + "cancel");

    buttons.style.display = "none";
    replyForm.style.display = "block";
    quoteForm.style.display = "none";
    cancel.style.display = "block";
  }

  function revealQuoteForm(threadNum2) {
    console.log("reveal quote function triggered")

    var buttons = document.getElementById(threadNum2 + "buttons");
    var replyForm = document.getElementById(threadNum2 + "reply-form");
    var quoteForm = document.getElementById(threadNum2 + "quote-form");
    var cancel = document.getElementById(threadNum2 + "cancel");

    buttons.style.display = "none";
    replyForm.style.display = "none";
    quoteForm.style.display = "block";
    cancel.style.display = "block";
  }

  function hideForm(threadNum3) {
    console.log("hide function triggered")

    var buttons = document.getElementById(threadNum3 + "buttons");
    var replyForm = document.getElementById(threadNum3 + "reply-form");
    var quoteForm = document.getElementById(threadNum3 + "quote-form");
    var cancel = document.getElementById(threadNum3 + "cancel");
    
    buttons.style.display = "block";
    replyForm.style.display = "none";
    quoteForm.style.display = "none";
    cancel.style.display = "none";
  }
</script>