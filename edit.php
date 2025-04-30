<?php
require_once('database.php');
session_start();

$db = new Db();
$conn = $db->connect();

// Check if `faceID` is provided in the URL
if (!isset($_GET['faceID'])) {
    die("Invalid Request. No ID provided.");
}

// Get the faceID from the URL
$faceID = $_GET['faceID'];

// Retrieve existing user data from the database using faceID
$query = "SELECT * FROM tbl_users WHERE faceID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $faceID);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

$bookname = $userData['name'];
$booksurname = $userData['surname'];
$booknumber = $userData['number'];
$bookgender = $userData['gender_fk'];

// Handle form submission for updating the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookname = mysqli_real_escape_string($conn, trim($_POST['bookname']));
    $booksurname = mysqli_real_escape_string($conn, trim($_POST['booksurname']));
    $booknumber = mysqli_real_escape_string($conn, trim($_POST['booknumber']));
    $bookgender = mysqli_real_escape_string($conn, trim($_POST['genderadd']));

    // Ensure all fields are filled
    if (empty($bookname) || empty($booksurname) || empty($booknumber) || empty($bookgender)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        // Update the database with the new values
        $updateQuery = "UPDATE tbl_users SET name = ?, surname = ?, number = ?, gender_fk = ? WHERE faceID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sssii", $bookname, $booksurname, $booknumber, $bookgender, $faceID);
        
        if ($updateStmt->execute()) {
            echo "<div class='alert alert-success'>Profile updated successfully!</div>";
            header("Location: loginprofile.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error updating profile: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-xl navbar-light bg-light">
        <a class="navbar-brand">Property For Sale</a>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Edit Profile</h1>

        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" class="form-control" name="bookname" value="<?php echo htmlspecialchars($bookname); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Surname:</label>
                <input type="text" class="form-control" name="booksurname" value="<?php echo htmlspecialchars($booksurname); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Number:</label>
                <input type="text" class="form-control" name="booknumber" value="<?php echo htmlspecialchars($booknumber); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender:</label>
                <select name="genderadd" class="form-select" required>
                    <?php 
                    $ddRows = $db->gentypeDb($conn);
                    while ($row = mysqli_fetch_assoc($ddRows)) { 
                        $selected = ($row['genID'] == $bookgender) ? 'selected' : ''; 
                    ?>
                        <option value="<?php echo $row['genID']; ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($row['descgen']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Update</button>
        </form>
    </div>

    <footer class="text-center mt-4">
        <div class="p-3 bg-light">
            <p>&copy; 2023 Property For Sale. Pavel Gontcharov</p>
        </div>
    </footer>
</body>
</html>
