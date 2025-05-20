<?php
require_once('database.php');
session_start();

$db = new Db();
$conn = $db->connect();

// Validate houseID
if (!isset($_GET['houseID']) || !is_numeric($_GET['houseID'])) {
    die("Invalid Request.");
}

$houseID = intval($_GET['houseID']);

// Retrieve the property listing from the database
$result = $db->getHouseByID($conn, $houseID);
$listing = $result->fetch_assoc();

// If no data found, exit
if (!$listing) {
    die("Listing not found.");
}

// Fetch category list
$categoryResult = $db->catetypeDd($conn);

if (isset($_POST['submit'])) {
    $bookname = trim($_POST['bookname']);
    $bookemail = trim($_POST['bookemail']);
    $bookphone = trim($_POST['bookphone']);
    $bookcategory = intval($_POST['bookcategory']);
    $bookdate = trim($_POST['bookdate']);
    $booksubject = trim($_POST['booksubject']);
    $bookmessage = trim($_POST['bookmessage']);

    if (!empty($bookname) && !empty($bookemail) && !empty($bookphone) && !empty($bookcategory) && !empty($bookdate) && !empty($booksubject) && !empty($bookmessage)) {
        if ($db->updateHouseBook($conn, $houseID, $bookname, $bookemail, $bookphone, $bookcategory, $bookdate, $booksubject, $bookmessage)) {
            echo "<div class='alert alert-success'>Listing updated successfully!</div>";
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error updating listing.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="text-center">Edit Property Listing</h2>
    <form method="post" class="border p-4 bg-light shadow rounded">
        <div class="mb-3">
            <label class="form-label">Full Name:</label>
            <input type="text" class="form-control" name="bookname" value="<?php echo htmlspecialchars($listing['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address:</label>
            <input type="email" class="form-control" name="bookemail" value="<?php echo htmlspecialchars($listing['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone:</label>
            <input type="text" class="form-control" name="bookphone" value="<?php echo htmlspecialchars($listing['phone']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Service:</label>
            <select name="bookcategory" class="form-select">
                <?php while ($row = mysqli_fetch_assoc($categoryResult)) { ?>
                    <option value="<?php echo $row['Id']; ?>" <?php echo ($row['Id'] == $listing['category_fk']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['description']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date:</label>
            <input type="date" class="form-control" name="bookdate" value="<?php echo htmlspecialchars($listing['date']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subject:</label>
            <input type="text" class="form-control" name="booksubject" value="<?php echo htmlspecialchars($listing['subject']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Message:</label>
            <textarea class="form-control" name="bookmessage" rows="4" required><?php echo htmlspecialchars($listing['message']); ?></textarea>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-success" value="Update" name="submit">
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</body>
</html>
