<?php 
$dbuser = 'larmuser'; 
$dbpass = 'Midsommar45!'; 
$dbname = 'larm'; 
$dbhost = 'localhost'; 
$dbtable = 'strandnas';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    error_log("Database Connection Error: " . mysqli_connect_error());
    exit; // Exit to avoid further execution on error
}
?>
