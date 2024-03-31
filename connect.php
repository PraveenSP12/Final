<?php

$name1 = $_POST['name1'];
$email = $_POST['email'];
$Username = $_POST['Username'];
$password1 = $_POST['password1'];
$typeselect = $_POST['typeselect'];


if (!empty($name1) || !empty($email) || !empty($Username) || !empty($password1) || !empty($typeselect))
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "medicationdiary";

// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT email From register Where email = ? Limit 1";
  $INSERT = "INSERT Into register (name1 , email , Username , password1 , typeselect)values(?,?,?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
    if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssss", $name1,$email,$Username,$password1,$typeselect);
      $stmt->execute();
      echo '<script>alert("Registration successful\n\nName : ' . $name1 . '\nE-mail : ' . $email . '\nUsername : ' . $Username . '\nPassword : ' . $password1 . '");';
      echo 'window.location.href = "loginpage.html";</script>';
    } else {
      echo '<script>alert("Someone already registered using this email");</script>';
     }
     $stmt->close();
     $conn->close();
    }
} else {
  echo '<script>alert("All fields are required");</script>';
  die();
}
?>