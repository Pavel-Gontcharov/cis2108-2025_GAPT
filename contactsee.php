<?php

require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/nav_bar_menusee.php';
require_once __DIR__ . '/database.php';

// Global variable for the title in the <head>.
$twig->addGlobal('title', "Contact");

/*  
    Checks the request method.
    If it is a POST request, checks the value of the submit.
    And executes the corresponding form submission procedures.
    Otherwise, renders the contact page normally.
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['submit'] == "booking") {
        $nameErr = $surnameErr = $emailErr = $mobileErr = $amountErr =  $dateErr = $commentsErr = "";
        $name = $surname = $email = $mobile = $amount = $date = $comments = "";

        $validationsBooking['pagemessage'] = "Successful";

        // Data Validation and Data Sanitization.
        if (!empty($_POST['name'])) {
            $name = clean_input($_POST['name']);
        } else {
            $nameErr = "Name is required";
            $validationsBooking['nameError'] = $nameErr;
        }

        if (!empty($_POST['surname'])) {
            $surname = clean_input($_POST['surname']);
        } else {
            $surnameErr = "Surname is required";
            $validationsBooking['surnameError'] = $surnameErr;
        }

        if (!empty($_POST['email'])) {
            $email = clean_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = 'You did not enter a valid email.';
                $validationsBooking['emailError'] = $emailErr;
            }
        } else {
            $emailErr = "Email is required";
            $validationsBooking['emailError'] = $emailErr;
        }

        if (!empty($_POST['mobile'])) {
            $mobile = clean_input($_POST['mobile']);
            if (!preg_match("/^\d{8}$/", $mobile)) {
                $mobileErr = "Invalid mobile number format";
                $validationsBooking['mobileError'] = $mobileErr;
            }
        } else {
            $mobileErr = "Mobile number is required";
            $validationsBooking['mobileError'] = $mobileErr;
        }

        if (!empty($_POST['amount'])) {
            $amount = clean_input($_POST['amount']);
            if (!preg_match("/^\d+$/", $mobile)) {
                $amountErr = "Only numbers accepted";
                $validationsBooking['amountError'] = $amountErr;
            }
        } else {
            $amountErr = "Number of people is required";
            $validationsBooking['amountError'] = $amountErr;
        }

        if (!empty($_POST['date'])) {
            $date = clean_input($_POST['date']);
        } else {
            $dateErr = "Date is required";
            $validationsBooking['dateError'] = $dateErr;
        }

        $comments = clean_input($_POST['comments']);
        $children = isset($_POST['amount-children']) ? $_POST['amount-children'] : null;
        $highchairs = isset($_POST['amount-highchairs']) ? $_POST['amount-highchairs'] : null;

        /*  
            If the data is clean proceed with database and email procedures.
            Otherwise, render the contact page with error warnings.
        */
        if (empty($nameErr) && empty($surnameErr) && empty($emailErr) && empty($mobileErr) && empty($amountErr) && empty($dateErr) && empty($commentsErr)) {
            $conn = new mysqli('localhost', 'restaurantu', 'restaurantp', 'restaurant');
            if ($conn->connect_error) {
                die('Connection Failed: ' . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO bookings (name, surname, email, mobile, amount, date, children, highchairs, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $name, $surname, $email, $mobile, $amount, $date, $children, $highchairs, $comments);
            $stmt->execute();
            $conn->close();
            $stmt->close();

            send_email($email, 'Booking Confirmation', "Dear $name $surname,<br><br>Thank you for booking with us. Your booking details are as follows:<br>Name: $name $surname<br>Mobile: $mobile<br>Number of people: $amount<br>Date: $date<br>Children: $children<br>Highchairs: $highchairs<br>Comments: $comments<br><br>We look forward to seeing you!", $twig, $categories);
        } else {
            $formBookingValues['name'] = $name;
            $formBookingValues['surname'] = $surname;
            $formBookingValues['email'] = $email;
            $formBookingValues['mobile'] = $mobile;
            $formBookingValues['amount'] = $amount;
            $formBookingValues['date'] = $date;
            $formBookingValues['comments'] = $comments;
            $validationsBooking['pagemessage'] = "There are some issues with this form";
            echo $twig->render('contact.html', ['categories' => $categories, 'validationsBooking' => $validationsBooking, 'formBookingValues' => $formBookingValues,]);
        }
    } else if (($_POST["submit"] == "issue")) {
        $typeErr = $nameErr = $surnameErr = $mobileErr = $emailErr = $messageErr = "";
        $type = $name = $surname = $mobile = $email = $message = "";

        $validationsIssue['pagemessage'] = "Successful";

        // Data Validation and Data Sanitization.
        if (!empty($_POST['type'])) {
            $type = clean_input($_POST['type']);
            if ($type != "Query" && $type != "Complaint") {
                $typeErr = "Type is either 'Query' or 'Complaint'";
                $validationsIssue['typeError'] = $typeErr;
            }
        } else {
            $typeErr = "Type is required";
            $validationsIssue['typeError'] = $typeErr;
        }

        if (!empty($_POST['name'])) {
            $name = clean_input($_POST['name']);
        } else {
            $nameErr = "Name is required";
            $validationsIssue['nameError'] = $nameErr;
        }

        if (!empty($_POST['surname'])) {
            $surname = clean_input($_POST["surname"]);
        } else {
            $surnameErr = "Surname is required";
            $validationsIssue['surnameError'] = $surnameErr;
        }

        if (!empty($_POST['mobile'])) {
            $mobile = clean_input($_POST['mobile']);
            if (!preg_match("/^\d{8}$/", $mobile)) {
                $mobileErr = "Invalid mobile number format";
                $validationsIssue['mobileError'] = $mobileErr;
            }
        } else {
            $mobileErr = "Mobile number is required";
            $validationsIssue['mobileError'] = $mobileErr;
        }

        if (!empty($_POST['email'])) {
            $email = clean_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = 'You did not enter a valid email.';
                $validationsIssue['emailError'] = $emailErr;
            }
        } else {
            $emailErr = "Email is required";
            $validationsIssue['emailError'] = $emailErr;
        }

        if (!empty($_POST['message'])) {
            $message = clean_input($_POST['message']);
        } else {
            $messageErr = "Message is required";
            $validationsIssue['messageError'] = $messageErr;
        }

        /*  
            If the data is clean proceed with database and email procedures.
            Otherwise, render the contact page with error warnings.
        */
        if (empty($typeErr) && empty($nameErr) && empty($surnameErr) && empty($emailErr) && empty($mobileErr) && empty($messageErr)) {
            $conn = new mysqli('localhost', 'restaurantu', 'restaurantp', 'restaurant');
            if ($conn->connect_error) {
                die('Connection Failed: ' . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO issues (type, name, surname, telephone, email, message) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $type, $name, $surname, $mobile, $email, $message);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            send_email($email, 'Issue Confirmation', "Dear $name $surname,<br><br>Thank you for contacting us. Your information details are as follows:<br>Name: $name $surname<br>Mobile: $mobile<br>Messages: $message<br><br>Our staff will follow this up and contact you back!", $twig, $categories);
        } else {
            $formIssueValues['type'] = $type;
            $formIssueValues['name'] = $name;
            $formIssueValues['surname'] = $surname;
            $formIssueValues['email'] = $email;
            $formIssueValues['mobile'] = $mobile;
            $formIssueValues['message'] = $message;
            $validationsIssue['pagemessage'] = "There are some issues with this form";
            echo $twig->render('contact.html', ['categories' => $categories, 'validationsIssue' => $validationsIssue, 'formIssueValues' => $formIssueValues,]);
        }
    }
} else {
    echo $twig->render('contactsee.html', ['categories' => $categories]);
}
