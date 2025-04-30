<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function clean_input($data)
{
    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);
    return $data;
}

function send_email($email, $subject, $body, $twig, $categories)
{   
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    $config = parse_ini_file('./config.ini');
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $config['email_host'];
        $mail->SMTPAuth   = $config['email_SMTPAuth'];
        $mail->Username   = $config['email_username'];
        $mail->Password   = $config['email_password'];
        $mail->SMTPSecure = $config['email_SMTPSecure'];
        $mail->Port       = $config['email_port'];

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('laffrescoassignment@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        echo $twig->render('confirmation.html', ['categories' => $categories]);
    } catch (Exception $e) {
        echo $twig->render('404.html', ['categories' => $categories]);
    }
}
