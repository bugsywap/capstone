<?php
include('config.php');
include 'session_timeout.php';
include 'idleWarning.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Delete appointments that have already passed
$currentDateTime = date('Y-m-d H:i:s');
$deleteSql = "DELETE FROM `patientApt` WHERE schedule < '$currentDateTime'";
if(mysqli_query($con, $deleteSql)) {
    echo "";
} else {
    echo " " . mysqli_error($con);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <title>Appointments</title>
</head>

<body>
   <div id="header">
      <div class="container">
         <nav class="navbar">
            <a href="index.php"><img src="imgs/ds.png" class="logo"></a>
            <ul class="navlinks">
               <li><a href="index.php" class="active">Dashboard</a></li>
               <li><a href="pl.php">Patient List</a></li>
               <li><a href="calendar.php">Calendar</a></li>
               <li><a href="dg.php">Dental Gallery</a></li>
               <li><a href="appointments.php">Appointments</a></li>
               <li>
                  <button class="logout-button" onclick="logout()">Logout</button>
               </li>
            </ul>
            <div class="menubtn">
               <i class="fa-solid fa-bars"></i>
            </div>
         </nav>
         <div class="dropdown-cont">
            <div class="dropdown-nav">
               <li><a href="index.php" class="active">Dashboard</a></li>
               <li><a href="pl.php">Patient List</a></li>
               <li><a href="calendar.php">Calendar</a></li>
               <li><a href="dg.php">Dental Gallery</a></li>
               <li><a href="appointments.php">Appointments</a></li>
               <li>
                  <button class="logout-button" onclick="logout()">Logout</button>
               </li>
            </div>
         </div>
      <script>
         const toggleBtn = document.querySelector('.menubtn');
         const toggleBtnIcon = document.querySelector('.menubtn i');
         const dropdownNav = document.querySelector('.dropdown-nav');

         toggleBtn.onclick = function() {
            dropdownNav.classList.toggle('open')
            const isOpen = dropdownNav.classList.contains('open')

            toggleBtnIcon.classList = isOpen ?
               'fa-solid fa-xmark' :
               'fa-solid fa-bars'

         }
      </script>
      <!----------Title---------->
      <!----------START OF DESKTOP VIEW FOR PATIENT LIST---------->
      <div class="apt-desktop-cont">
         <div class="header-text">
            <section id="reminder-section" class="welcome-section">
               <h1>Appointments</h1>
            </section>
         </div>
         <!----------end-of-title---------->
         <div class="box">
            <div class="row">
               <div class="container-table">
                  <table>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Dr. Assigned</th>
                        <th>Schedule</th>
                        <th>Service</th>
                        <th>More Information</th>
                     </tr>
                     <?php
                     $sql = "SELECT * FROM `patientApt`";
                     $result = mysqli_query($con, $sql);
                     if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                           $id = $row['id'];
                           $name = $row['name'];
                           $mobileNo = $row['mobileNo'];
                           $doctor = $row['doctor'];
                           $schedule = $row['schedule'];
                           $service = $row['service'];



                           echo '<tr>
                                <th scope="row">' . $id . '</th>
                                <td>' . $name . '</td>
                                <td>' . $mobileNo . '</td>
                                <td>' . $doctor . '</td>
                                <td>' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</td>
                                <td>' . $service . '</td>
                                <td>
                                <button class="details"><a href="patientArchive.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark"> More Details</a></button>
                                </td>
                            </tr>';
                        }
                     }
                     ?>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <!----------START OF TABLET VIEW FOR PATIENT LIST---------->
      <div class="apt-tablet-cont">
         <div class="header-text">
            <section id="reminder-section" class="welcome-section">
               <h1>Appointments</h1>
            </section>
         </div>
         <!----------end-of-title---------->
         <div class="box">
            <div class="row">
               <div class="container-table">
                  <table>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Schedule</th>
                        <th>Service</th>
                        <th>More Information</th>
                     </tr>
                     <?php
                     $sql = "SELECT * FROM `patientApt`";
                     $result = mysqli_query($con, $sql);
                     if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                           $id = $row['id'];
                           $name = $row['name'];
                           $schedule = $row['schedule'];
                           $service = $row['service'];



                           echo '<tr>
                                <th scope="row">' . $id . '</th>
                                <td>' . $name . '</td>
                                <td>' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</td>
                                <td>' . $service . '</td>
                                <td>
                                <button class="details"><a href="patientArchive.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark"> More Details</a></button>
                                </td>
                            </tr>';
                        }
                     }
                     ?>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <!----------START OF PHONE VIEW FOR PATIENT LIST---------->
      <div class="apt-phone-cont">
         <div class="header-text">
            <section id="reminder-section" class="welcome-section">
               <h1>Appointments</h1>
            </section>
         </div>
         <!----------end-of-title---------->
         <div class="box">
            <div class="row">
               <div class="container-table">
                  <table>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Dr. Assigned</th>
                        <th>Schedule</th>
                        <th>Service</th>
                        <th>More Information</th>
                     </tr>
                     <?php
                     $sql = "SELECT * FROM `patientApt`";
                     $result = mysqli_query($con, $sql);
                     if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                           $id = $row['id'];
                           $name = $row['name'];
                           $mobileNo = $row['mobileNo'];
                           $doctor = $row['doctor'];
                           $schedule = $row['schedule'];
                           $service = $row['service'];



                           echo '<tr>
                                <th scope="row">' . $id . '</th>
                                <td>' . $name . '</td>
                                <td>' . $mobileNo . '</td>
                                <td>' . $doctor . '</td>
                                <td>' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</td>
                                <td>' . $service . '</td>
                                <td>
                                <button class="details"><a href="patientArchive.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark"> More Details</a></button>
                                </td>
                            </tr>';
                        }
                     }
                     ?>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script>
      function logout() {
         // Send a request to the server to log out the user
         // You can use AJAX or fetch() to send a request to a PHP logout endpoint

         // Example using fetch() to send a POST request to a PHP logout endpoint
         fetch('logout.php', {
               method: 'POST'
            })
            .then(response => {
               // Handle the response from the server
               // You can redirect the user to a login page or perform any other desired action
               window.location.href = 'login.php'; // Redirect to a login page
            })
            .catch(error => {
               console.log('Error logging out:', error);
            });
      }
   </script>
</body>
</php>