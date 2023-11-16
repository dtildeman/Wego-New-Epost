#!/usr/bin/php -q
<?php
require_once 'config.php';

// Function to safely get a specific header value
function get_header_value($header_name, $lines) {
    foreach ($lines as $line) {
        if (preg_match("/^" . $header_name . ": (.*)/", $line, $matches)) {
            return trim($matches[1]);
        }
    }
    return null;
}

// Read from stdin (the incoming email)
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd)) {
    $email .= fread($fd, 1024);
}
fclose($fd);

// Handle email
$lines = explode("\n", $email);

// Extracting headers and message
$from = get_header_value('From', $lines);
$subject = get_header_value('Subject', $lines);
$to = get_header_value('To', $lines);

// The rest of the email is the message
$splitting_point = array_search('', $lines);
$message = implode("\n", array_slice($lines, $splitting_point + 1));

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO $dbtable (`to`, `from`, `subject`, `headers`, `message`, `source`) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $to, $from, $subject, implode("\n", array_slice($lines, 0, $splitting_point)), $message, $email);

if ($stmt->execute()) {
    echo "Email logged successfully.";
} else {
    error_log("Error inserting email into the database: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
