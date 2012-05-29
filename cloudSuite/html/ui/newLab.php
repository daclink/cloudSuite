<?php
if (!isset($_SESSION)){
    session_start();
} else {
    $uname = $_SESSION['cs']['username'];
}
?>

<script>
 
 function getNewForm(){
    
 }
 
</script>
<?php
    if (isset($_SESSION['cs']['username'])){

    
?>
<form name="newLabForm" action="javascript:getNewForm();">
    <div class="status-bar-item labDisplay newLabForm">
        Lab Name : <input id="labName" type="text" />        
    </div> 
    <div class="status-bar-item labDisplay newLabForm">
        Lab Description : <input id="labDesc" type="text" size="75"/>
    </div> 
    

    <div id="newLabButton" class="status-bar-item chiClick csshadow labDisplay" type="submit">
            Create Lab
    </div>
</form>

<?php

} else {
    echo "<div class='status-bar-item labDisplay newLabForm'>You must be logged in to create a new lab.</div> ";
}
?>
<script>


    $("#newLabButton").mouseup(function() {
          
          returnLab();
          $('#lab').load('./rest.php?newLab='+encodeURIComponent($('#labName').val())
              +"&labDesc="+ encodeURIComponent($('#labDesc').val()));
          
    });
</script>


<?php


/*
<html>
<head>
  <style>

  p { margin:0; color:blue; }
  div,p { margin-left:10px; }
  span { color:red; }
  </style>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
  <p>Type 'correct' to validate.</p>
  <form action="javascript:alert('success!');">
    <div>
      <input type="text" />

      <input type="submit" />
    </div>
  </form>
  <span></span>
<script>

    $("form").submit(function() {
      if ($("input:first").val() == "correct") {
        $("span").text("Validated...").show();
        return true;
      }
      $("span").text("Not valid!").show().fadeOut(1000);
      return false;
    });
</script>

</body>
</html>

*/

?>