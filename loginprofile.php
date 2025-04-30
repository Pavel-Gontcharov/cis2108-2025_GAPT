<?php
require_once('database.php');
require_once('bootstrap.php'); // Assuming this initializes Twig
session_start();
$twig->addGlobal('title', "Profile");

$db = new Db();
$conn = $db->connect();

// Get profile data
$result = $db->Showprofileface($conn);
$profiles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $profiles[] = $row;
}

echo $twig->render('loginprofile.html', [
    'profiles' => $profiles
]);
