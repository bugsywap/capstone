<?php  
session_start();

$host = "localhost";
$user = "root";
$password = '';
$db_name = "dskafagway";

$con = mysqli_connect($host, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("Failed to connect with MySQL: " . mysqli_connect_error());
}

// Check if the user is already authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Redirect to the restricted page or dashboard
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $password = $_POST['pass'];

    // To prevent mysqli injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $sql = "SELECT * FROM logins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($con));
    }

    $count = mysqli_num_rows($result);

    if ($count == 1) {
        // Authentication successful, create session variable
        $_SESSION['authenticated'] = true;

        // Redirect to the restricted page or dashboard
        header("Location: index.php");
        exit();
    } else {
        echo "<h1>Login failed. Invalid username or password.</h1>";
    }
}
?>