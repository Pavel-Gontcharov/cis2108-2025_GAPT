<?php
session_start();
require_once('database.php'); 
require_once('bootstrap.php'); // Assuming this initializes Twig
$twig->addGlobal('title', "DBMS");


$db = new Db();
$conn = $db->connect();

// Fetch property data
$result = $db->showCars($conn);
$properties = [];
while ($row = mysqli_fetch_assoc($result)) {
    $properties[] = $row;
}

// Check if the user is logged in
$sessionName = isset($_SESSION['bookname']) ? $_SESSION['bookname'] : "Guest";

echo $twig->render('index.html', [
    'properties' => $properties,
    'sessionName' => $sessionName
]);
