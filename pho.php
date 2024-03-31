<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'D:\/Docu/User/Database_Xampp/Xampp files/htdocs/Medication-Diary-main/PHPMailer-master/src/PHPMailer.php';
    require 'D:\/Docu/User/Database_Xampp/Xampp files/htdocs/Medication-Diary-main/PHPMailer-master/src/SMTP.php';
    require 'D:\/Docu/User/Database_Xampp/Xampp files/htdocs/Medication-Diary-main/PHPMailer-master/src/Exception.php';

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medicationdiary";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
    // Check if file was uploaded without errors
    if (isset($_FILES["upphoto"]) && $_FILES["upphoto"]["error"] == 0) {
        // Get file data
        $image_name = $_FILES["upphoto"]["name"];
        $image_type = $_FILES["upphoto"]["type"];
        $image_size = $_FILES["upphoto"]["size"];
        $image_tmp_name = $_FILES["upphoto"]["tmp_name"];

        // Read image data
        $image_data = file_get_contents($image_tmp_name);

        // Prepare SQL statement to insert image data into database
        $stmt = $conn->prepare("INSERT INTO images (image_name, image_type, image_size, image_data) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $image_name, $image_type, $image_size, $image_data);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "Image uploaded successfully.";

            $email = 'mailtrap@demomailtrap.com';
            $toEmail = 'kishorers5833@gmail.com';
            $emailSubject = 'Photo Uploaded';
            
            // Create a new PHPMailer instance
            $mail = new PHPMailer( exceptions: true);
            try {
                // Configure the PHPMailer Instance
                $mail->isSMTP();
                $mail->Host = 'live.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = 'api';
                $mail->Password = '8cd263620a3b1c728c84a4ae7d98e16e';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                // Set the sender, recipient, subject, and body of the message
                $mail->setFrom($email);
                $mail->addAddress($toEmail);
                $mail->Subject = $emailSubject;
                $mail->isHTML(isHtml: true);
                $mail->Body = "<p> Image has been uploaded </p>";
                
                // Send the message
                $mail->send();
                
                $successMessage = "<p>Thank you </p>";
            } catch (Exception $e) {
                $errorMessage = "<p style='color: red;'> Oops, something went wrong. Please try again later</p>";
            }
        } else {
            echo "Error uploading image.";
        }
        $stmt->close();
    } else {
        echo "Error: " . $_FILES["upphoto"]["error"];
    }
    $conn->close();
    }
?>