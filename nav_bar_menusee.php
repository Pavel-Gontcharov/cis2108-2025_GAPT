<?php
// Start the session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/database.php';

// Initialize Database Connection
$db = new Db();
$categories = $db->select("SELECT category_id, category_name FROM categories ORDER BY category_id");

// Check if user is logged in
$bookname = isset($_SESSION['bookname']) ? $_SESSION['bookname'] : null;

// Pass categories and bookname to Twig
$twig->addGlobal('categories', $categories);
$twig->addGlobal('bookname', $bookname);
?>
