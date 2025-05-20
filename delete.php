<?php
require_once('database.php');

if (!isset($_GET['houseID']) || !is_numeric($_GET['houseID'])) {
    die("Invalid request.");
}

$houseID = intval($_GET['houseID']); // Sanitize input

$db = new Db();
$conn = $db->connect();

// Perform deletion
if ($db->delhouByID($conn, $houseID)) {
    header("Location: index.php");
    exit();
} else {
    echo "<div class='alert alert-danger'>Error deleting record.</div>";
}
?>
