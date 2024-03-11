<?php
include 'loginAuth.php';
?>
<!DOCTYPE html>
<html>

<body>
  <link rel="stylesheet" href="loginstyles.css">
  <div class="form shadow-sm p-3 mb-5 bg-white rounded">
    <img src="imgs/dslilogo.png" class="logo">
    <form id="survey-form" name="f1" action="loginAuth.php" onsubmit="return validation()" method="POST">
      <fieldset>
        <input required id="name" name="name" type="text" placeholder="Username">
        <input required id="pass" name="pass" type="password" placeholder="Password">
      </fieldset>
      <!-- <div class="checkbox-row">
        <label class="checkbox-label">
          <input type="checkbox">
          <span class="checkmark"></span>
          <span class="remember-text">Remember me</span>
        </label>
        <a class="forgot" href="#">Forgot password?</a>
      </div> -->
      <button id="submit" type="submit" value="login">Login</button>
    </form>
  </div>

  <script>
    function validation() {
      var id = document.f1.name.value;
      var ps = document.f1.pass.value;
      if (id.length == "" && ps.length == "") {
        alert("User Name and Password fields are empty");
        return false;
      } else {
        if (id.length == "") {
          alert("User Name is empty");
          return false;
        }
        if (ps.length == "") {
          alert("Password field is empty");
          return false;
        }
      }
    }
  </script>
</body>

</html>