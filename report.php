<?php
require_once("vendor/autoload.php");
require_once("database.php");

// Setup Twig to load from the "templates" folder
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

// Fetch service totals
$db = new Db();
$conn = $db->connect();

$sql = "SELECT c.Id as category_id, c.description AS servicename, COUNT(*) AS total
        FROM tbl_housebooks h
        INNER JOIN tbl_categ c ON h.category_fk = c.Id
        GROUP BY c.Id, c.description
        ORDER BY total DESC";
$result = $conn->query($sql);
$services = [];
while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}

// Fetch all clients for each service
$clientsByService = [];
foreach ($services as $item) {
    $id = $item['category_id'];
    $sql2 = "SELECT name, email, phone, date, subject, message FROM tbl_housebooks WHERE category_fk = $id";
    $result2 = $conn->query($sql2);
    $clientsByService[$id] = $result2->fetch_all(MYSQLI_ASSOC);
}

$conn->close();

// Render report.html
echo $twig->render('report.html', [
    'services' => $services,
    'clientsByService' => $clientsByService
]);
