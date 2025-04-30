<?php
session_start();
require_once('database.php');


$db = new Db();
$conn = $db->connect();

// Function to sanitize input data
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to check if user exists in DB and validate password securely
function isUserInDB($conn, $email, $password) {
    $sql = "SELECT password FROM tbl_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        return password_verify($password, $row['password']); // Check hashed password
    }
    return false;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (isUserInDB($conn, $email, $password)) {
        $_SESSION['email'] = $email;
        header("Location: homesee.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/icons/toothicon.ico">
    <title>Login</title>


</head>
<body>
    <nav>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"  >

    

    <div class="d-flex align-items-center vh-100" style="display: flex !important
;
    flex-direction: column;">
        <div>
        <a href="login.php">
            <img src="assets/icons/logos.jpg" alt="Dental Studio" style="transform: scale(0.5);">
        </a>
            
        </div>
        <div class="container">
            <h1 class="text-center">Login</h1>
            <form method="post" action="login.php">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Login" name="submit">
                </div>
                <div class="text-center mt-2">
                    <a href="signup.php">Sign up</a>
                </div>
                <?php if (isset($error)): ?>
                    <div class="text-center text-danger mt-2">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    </nav>


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