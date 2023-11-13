#!/usr/bin/php -q
<?php
$dbtable = 'strandnas';
$dbuser = 'larmuser';
$dbpass = 'Midsommar45!';
$dbname = 'larm';
$dbhost = 'server.fbkwego.xyz';
$notify= 'daniel@tildeman.ax'; // an email address required in case of errors
// read from stdin
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd)) {
    $email .= fread($fd, 1024);
}
fclose($fd);
// handle email
$lines = explode("\n", $email);
// empty vars
$from = "";
$subject = "";
$headers = "";
$message = "";
$splittingheaders = true;
for ($i=0; $i < count($lines); $i++) {
    if ($splittingheaders) {
        // this is a header
        $headers .= $lines[$i]."\n";
        // look out for special headers
        if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
            $subject = $matches[1];
        }
        if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
            $from = $matches[1];
        }
        if (preg_match("/^To: (.*)/", $lines[$i], $matches)) {
            $to = $matches[1];
        }
    } else {
        // not a header, but message
        $message .= $lines[$i]."\n";
    }
    if (trim($lines[$i])=="") {
        // empty line, header section has ended
        $splittingheaders = false;
    }
}
if ($conn = mysqli_connect($dbhost,$dbuser,$dbpass, $dbname, '32400')) {
  if(!@mysqli_select_db($conn,$dbname))
    mail($email,'Email Logger Error',"There was an error selecting the Strandnas email logger database.\n\n".mysqli_error($conn));
  $from    = mysqli_real_escape_string($conn,$from);
  $to    = mysqli_real_escape_string($conn,$to);
  $subject = mysqli_real_escape_string($conn,$subject);
  $headers = mysqli_real_escape_string($conn,$headers);
  $message = mysqli_real_escape_string($conn,$message);
  $email   = mysqli_real_escape_string($conn,$email);
  $result = mysqli_query($conn,"INSERT INTO strandnas (`to`,`from`,`subject`,`headers`,`message`,`source`) VALUES('$to','$from','$subject','$headers','$message','$email')");
  if (mysqli_affected_rows($conn) == 0)
    mail($notify,'Email Logger Error',"There was an error inserting into the Strandnas database.\n\n".mysqli_error($conn));
} else {
  mail($notify,'Email Logger Error',"There was an error connecting the Strandnas database.\n\n".mysqli_error($conn));
}
?>