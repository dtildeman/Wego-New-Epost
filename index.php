<!DOCTYPE html> 
<html> 
<head><meta charset="utf-8"> 
<title>E-post Larm</title> 
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.1.min.js"></script> 
</head> 
<div id="boxOfPoo"></div> <!-- Detta .r objektet som vi fyller med data sen. -->
  <script>
        $(document).ready(function() {
            $("#boxOfPoo").load("api.php");
            setInterval(function() {
                $("#boxOfPoo").load("api.php");
            }, 2000
  });
  </script>
</html>
