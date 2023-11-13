<?php require_once 'config.php';

   if(! $conn ) {
      die('Could not connect: ' . mysqli_error());
   }

$sql = "SELECT * FROM $dbtable ORDER BY id DESC LIMIT 1";

 mysqli_select_db($conn,$dbname);
  $retval = mysqli_query( $conn,$sql );

while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {

$search = array("\n", "=", "C3A5", "C3A4", "C3B6", "C384", "C385", "C396");
$replace = array("", "", "&aring;", "&auml;", "&ouml;", "&Auml;", "&Aring;", "&Ouml;");
$row = str_replace($search, $replace, $row);

if(strpos($row['message'], "Flag") !==false){
$test = strstr($row["message"], "Flag");
$test = substr($test,8);
} else{
$test=$row['message'];
}
$delimiter = '_';
$words = explode($delimiter, $test);

$search2 = array("900", "400", "401", "402", "410", "411", "412", "413", "414","415", "416", "417", "418", "419", "420", "421", "422","423", "424", "425", "430", "431", "432", "433", "440", "441");
$replace2 = array("Provalarm", "Personsökaralarm", "Personsökaralarm - Hissalarm", "Personsökaralarm - Djurräddning", "Litet Alarm", "Litet Alarm - Automatalarm", "Litet Alarm - Byggnadsbrand", "Litet Alarm - Markbrand", "Litet Alarm - Fordonsbrand", "Litet Alarm - Båtbrand","Litet Alarm - Brand i elapparat","Litet Alarm - Soteld","Litet Alarm - Djurräddning","Litet Alarm – Kontrolluppdrag","Grundalarm","Grundalarm - Automatalarm","Grundalarm - Byggnadsbrand","Grundalarm - Markbrand","Grundalarm - Fordonsbrand","Grundalarm - Båt-/Fartygsbrand","Räddning - Assistans","Räddning - Fastklämd","Räddning - Dykalarm","Räddning – Kemalarm","Förstärkningsalarm","Beredskapsalarm");
$row2 = str_replace($search2, $replace2, $words[2]);

echo "<p style=text-align:center> <span style='font-size:40px'><strong>{$words[0]} - $row2</strong></span></p>";
echo "<p style=text-align:center> <span style='font-size:55px'><strong>{$words[4]}</strong></span></p>";
echo "<p style=text-align:center> <span style='font-size:30px'><strong>{$words[3]} - {$row['logged_at']}</strong></span></p>";
echo "<p style=text-align:right> <span style='font-size:14px'>WeGo från Strandnäs FBK, Daniel Tildeman</span></p>";

   }
mysqli_close($conn);
?>
