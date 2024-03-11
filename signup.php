<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["user"];
  $password = $_POST["pass"];

  $sql = "INSERT INTO logins (username, password) VALUES ('$username', '$password')";

  if ($con->query($sql) === TRUE) {
    header('location: registerconfirm.php');;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html>

<body>
  <link rel="stylesheet" href="loginstyles.css">
  <div class="form shadow-sm p-3 mb-5 bg-white rounded">
    <img src="imgs/dslilogo.png" class="logo">
    <form id="survey-form" method="POST" action="signup.php">
      <fieldset>
        <label for="user"><b>Enter your user name</b></label>
        <input required id="user" name="user" type="text" placeholder="Username">
        <label for="pass"><b>Enter your password</b></label>
        <input required id="pass" name="pass" type="password" placeholder="Password">
      </fieldset>
      <button id="submit" type="submit" value="login">Submit</button>
    </form>
  </div>
</body>

</html>