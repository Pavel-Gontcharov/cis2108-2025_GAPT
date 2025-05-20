<?php
require_once('database.php');

if (!isset($_GET['faceID']) || !is_numeric($_GET['faceID'])) {
    die("Invalid request.");
}

$db = new Db();
$conn = $db->connect();
$faceID = intval($_GET['faceID']);

if ($db->delface($conn, $faceID)) {
    header("Location: loginprofile.php");
    exit();
} else {
    echo "<div class='alert alert-danger'>Error deleting user.</div>";
}
?>
