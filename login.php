<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicationdiary";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Login validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $password1 = $_POST['password1'];

    $sql = "SELECT * FROM register WHERE username='$Username' AND password1='$password1'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Start the session
        session_start();

        // Store username and role in session variables
        $_SESSION['Username'] = $Username;
        $_SESSION['typeselect'] = $row['typeselect'];

        // Redirect based on role
        if ($row['typeselect'] == 'Patient') {
            header("Location: Patientpage.html");
            exit();
        } elseif ($row['typeselect'] == 'Doctor') {
            header("Location: D.html");
            exit();
        } elseif ($row['typeselect'] == 'Nurse') {
            header("Location: gpsphoto.html");
            exit();
        }
    } else {
        echo "Invalid username or password";
    }
}
mysqli_close($conn);
?>


