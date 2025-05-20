<?php
session_start();
require_once('database.php');

$db = new Db();
$conn = $db->connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/icons/toothicon.ico">
    <title>Signup</title>
</head>

<body>
    <div>
        <a href="login.php">
            <img src="assets/icons/logos.jpg" alt="Dental Studio" style="width: 12em;height: auto;margin: 0.25em;transition: 0.3s;transform: scale(1.2);">
        </a>
    </div>
    
    <div class="d-flex align-items-center vh-100">
        <div class="container">
            <h1 class="text-center">Sign up</h1>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="bookname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Surname</label>
                    <input type="text" class="form-control" name="booksurname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Number</label>
                    <input type="number" class="form-control" name="booknumber" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gender:</label>
                    <select name="bookgender" class="form-select">
                        <?php
                        $ddRows = $db->gentypeDb($conn);
                        while ($row = mysqli_fetch_assoc($ddRows)) {
                        ?>
                            <option value="<?php echo $row['genID'] ?>">
                                <?php echo htmlspecialchars($row['descgen']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="bookemail" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="bookpassword" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Choose a profile picture:</label>
                    <input type="file" name="faceimage" class="form-control" required>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Sign Up" name="submit">
                </div>
                <div class="text-center mt-2">
                    <a href="login.php">Login</a>
                </div>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                $bookemail = trim($_POST['bookemail']);
                $bookpassword = trim($_POST['bookpassword']);
                $bookname = trim($_POST['bookname']);
                $booksurname = trim($_POST['booksurname']);
                $booknumber = trim($_POST['booknumber']);
                $bookgender = trim($_POST['bookgender']);

                // Handle file upload
                $uploadDir = 'faceimages/';
                $facepath = $uploadDir . basename($_FILES['faceimage']['name']);

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['faceimage']['type'], $allowedTypes)) {
                    echo "<div class='alert alert-danger'>Only JPG, PNG, and GIF files are allowed.</div>";
                    exit;
                }

                if (!move_uploaded_file($_FILES['faceimage']['tmp_name'], $facepath)) {
                    echo "<div class='alert alert-danger'>Error uploading file.</div>";
                    exit;
                }

                // Hash password securely
                $hashedpassword = password_hash($bookpassword, PASSWORD_DEFAULT);

                // Insert user into database
                if ($db->inserUser($conn, $bookemail, $hashedpassword, $facepath, $bookname, $booksurname, $booknumber, $bookgender)) {
                    $_SESSION['bookname'] = $bookname;
                    header("Location: homesee.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Error creating account.</div>";
                }
            }
            ?>
        </div>
    </div>
    <footer style="    display: flex;  flex-direction: row-reverse;justify-content: space-between;align-items: flex-start;flex-wrap: wrap;     padding: 10px;     background: #fff;color: darkblue">
        <div class="social" style=" display: flex;  flex-direction: column;justify-content: flex-start;align-items: flex-end; margin: 1em;">
            <p class="social" style="    display: flex;  flex-direction: column;justify-content: flex-start;align-items: flex-end; margin: 1em;">find us on:</p>
            <div class="social-icon">
                <a href="https://www.facebook.com" target="_blank"><img style="width: 3em;height: auto;margin: 0.25em;transition: 0.3s;transform: scale(1.2);" src="assets/logos/facebook.png" alt="Facebook"></a>
                <a href="https://www.tiktok.com" target="_blank"><img style="width: 3em;height: auto;margin: 0.25em;transition: 0.3s;transform: scale(1.2);" src="assets/logos/tiktok.png" alt="TikTok"></a>
                <a href="https://www.instagram.com" target="_blank"><img style="width: 3em;height: auto;margin: 0.25em;transition: 0.3s;transform: scale(1.2);" src="assets/logos/ins.png" alt="Instagram"></a>
            </div>
        </div>
        <div class="legal">
            <p class="legal">&copy; 2025 Dental Studio, Sliema, Malta. All Rights Reserved..</p>
            <p class="legal">Legal Policies</p>
            <p class="legal">Powered by Pavel</p>
        </div>

    </footer>
    <script src="scripts/script.js" async defer></script>
</body>

</html>