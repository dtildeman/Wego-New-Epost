<!DOCTYPE html> 
<html> 
<head> 
<title>Strandnas Larm Logg</title> 
</head> 
<?php
require_once 'config.php'; 

$sql = "SELECT * FROM $dbtable ORDER BY id DESC LIMIT 100";
  
 mysqli_select_db($conn,$dbname);
  $retval = mysqli_query( $conn, $sql );
   
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) { 
$search = array("=C3=A5", "=C3=A4", "=C3=B6", "=C3=84", "=C3=85", "=C3=96"); 
$replace = array("&aring;", "&auml;", "&ouml;", "&Auml;", "&Aring;", "&Ouml;"); 
$row = str_replace($search, $replace, $row); 

echo "{$row['logged_at']} - ".
        "{$row['message']}<br>".
         "<br>";
   }
mysqli_close($conn); 
?> 
</html>
