<?php
require_once('database.php'); 
require_once('bootstrap.php'); // Assuming this initializes Twig
session_start();
$twig->addGlobal('title', "Appointment");

$db = new Db();
$conn = $db->connect();

// Get category options for the dropdown
$ddRows = $db->catetypeDd($conn);
$categories = [];
while ($row = mysqli_fetch_assoc($ddRows)) {
    $categories[] = $row;
}

$errors = [];
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['name', 'bookphone', 'email', 'bookcategory', 'bookdate', 'booksubject', 'bookmessage'];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "$field cannot be left empty";
        }
    }

    if (empty($errors)) {
        $bookname = mysqli_real_escape_string($conn, trim($_POST['name']));
        $bookphone = mysqli_real_escape_string($conn, trim($_POST['bookphone']));
        $bookemail = mysqli_real_escape_string($conn, trim($_POST['email']));
        $bookcategory = mysqli_real_escape_string($conn, trim($_POST['bookcategory']));
        $bookdate = mysqli_real_escape_string($conn, trim($_POST['bookdate']));
        $booksubject = mysqli_real_escape_string($conn, trim($_POST['booksubject']));
        $bookmessage = mysqli_real_escape_string($conn, trim($_POST['bookmessage']));

        // File upload handling
        $uploadDir = 'images/';
        $carImgUpPath = $uploadDir . basename($_FILES['carImgUp']['name']);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['carImgUp']['tmp_name'], $carImgUpPath)) {
            $successMessage = "File uploaded successfully.";
        } else {
            $errors[] = "File upload failed.";
        }

        // Insert into the database
        if ($db->housebook($conn, $bookphone, $bookname, $bookemail, $bookcategory, $bookdate, $booksubject, $bookmessage, $carImgUpPath)) {
            $successMessage = "Data added successfully!";
        } else {
            $errors[] = "Error inserting data.";
        }
    }
}

echo $twig->render('insertadd.html', [
    'categories' => $categories,
    'errors' => $errors,
    'successMessage' => $successMessage,
    'sessionName' => isset($_SESSION['bookname']) ? $_SESSION['bookname'] : "Guest"
]);
