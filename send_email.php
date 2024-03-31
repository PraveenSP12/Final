<?php
// Your email sending code here
// Example using PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'D:\/Docu/User/Database_Xampp/Xampp files/htdocs/Medication-Diary-main/PHPMailer-master/src/PHPMailer.php';
require 'D:\/Docu/User/Database_Xampp/Xampp files/htdocs/Medication-Diary-main/PHPMailer-master/src/SMTP.php';
require 'D:\/Docu/User/Database_Xampp/Xampp files/htdocs/Medication-Diary-main/PHPMailer-master/src/Exception.php';

$mail = new PHPMailer(true);

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "medicationdiary";

// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//$typeselect = 1; Example user ID, you may change it based on your requirements
$sql = "SELECT email FROM register WHERE typeselect = 2"; // Modify the query as per your database schema

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the email address
    $row = $result->fetch_assoc();
    $recipientEmail = $row["email"];
} else {
    echo "No recipient found";
    exit; // Stop execution if no recipient found
}

// Close database connection
$conn->close();

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '---@gmail.com';
    $mail->Password   = 'app';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('---@gmail.com', 'name');
    $mail->addAddress( $recipientEmail );

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Needed to take Medicine Time is up!!';
    $mail->Body    = 'Needed to take Medicine soon...';
    $mail->send();
    echo 'Email has been sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
