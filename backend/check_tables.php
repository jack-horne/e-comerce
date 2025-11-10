<?php
require_once 'connection.php';

$result = mysqli_query($conn, "SHOW TABLES");
if ($result) {
    echo "Tables in database:\n";
    while ($row = mysqli_fetch_array($result)) {
        echo "- " . $row[0] . "\n";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
