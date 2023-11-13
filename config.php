<?php 
$dbuser = 'larmuser'; 
$dbpass = 'Midsommar45!'; 
$dbname = 'larm'; 
$dbhost = 'localhost'; 
$dbtable = 'strandnas';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysqli_error());
   }
?>
