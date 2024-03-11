<?php
include 'config.php';
include 'session_timeout.php';
include 'idleWarning.php';
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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


            <!----------end-of-nav---------->

            <!----------Title---------->
            <div class="header-text">
                <section id="reminder-section" class="welcome-section">
                    <h1>Notifications</h1>
                </section>
            </div>
            <!----------end-of-title---------->


            <!---------START-of-Desktop-View---------->
            <!----------Cards---------->

            <div class="index-desktop-cont">
                <div class="card-container">
                    <?php
                    // Fetch today's doctor and bookings from the database
                    $today = date("Y-m-d");
                    $sql = "SELECT schedule, name, service, doctor FROM patientApt WHERE DATE(schedule) = '$today'";
                    $result = $con->query($sql);
                    $count = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($count >= 3) { // Check if count is already 3
                                break; // Exit the loop if count is already 3
                            }
                            echo '<div class="card">';
                            echo '<h3 class="card-title">' . $row['doctor'] . '</h3>';
                            echo '<p class="card__content">' . $row['name'] . '</p>';
                            echo '<p class="card__content-service">' . $row['service'] . '</p>';
                            echo '<div class="card__date">' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</div>'; // Include time format in 12-hour notation with AM/PM (g:i A)
                            echo '</div>';
                            $count++; // Increment count after displaying a card
                        }
                    } else {
                        echo '<div class="card">';
                        echo '<h2>No appointments today</h2>';
                        echo '</div>';
                    }
                    ?>

                </div>
                <!----------end-of-cards---------->

                <!----------Title---------->
                <div class="header-text-pending">
                    <section id="reminder-section" class="welcome-section">
                        <h1>Pending Booking</h1>
                    </section>
                </div>
                <!----------end-of-title---------->

                <!----------Pending Booking---------->
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
                                $sql = "SELECT * FROM `patientBooking`";
                                $result = mysqli_query($con, $sql);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $mobileNo = $row['mobileNo'];
                                        $address = $row['address'];
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
                                    <button class="goto btn-primary"><a href="transfer.php?transferid=' . $id . '">Confirm Patient</a></button>
                                    <button class="details"><a href="resched.php?rescheduleid=' . $id . '">Reschedule Patient</a></button>
                                </td>
                                
                            </tr>';
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                    <!---------end-of-pending booking---------->
                </div>
            </div>
            <!---------end-of-Desktop-View---------->

            <!---------START-of-INDEX-TABLET-VIEW---------->
            <div class="index-tablet-cont">
                <div class="card-container">
                    <?php
                    // Fetch today's doctor and bookings from the database
                    $today = date("Y-m-d");
                    $sql = "SELECT schedule, name, service, doctor FROM patientApt WHERE DATE(schedule) = '$today'";
                    $result = $con->query($sql);
                    $count = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($count >= 2) { // Check if count is already 3
                                break; // Exit the loop if count is already 3
                            }
                            echo '<div class="card">';
                            echo '<h3 class="card-title">' . $row['doctor'] . '</h3>';
                            echo '<p class="card__content">' . $row['name'] . '</p>';
                            echo '<p class="card__content-service">' . $row['service'] . '</p>';
                            echo '<div class="card__date">' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</div>'; // Include time format in 12-hour notation with AM/PM (g:i A)
                            echo '</div>';
                            $count++; // Increment count after displaying a card
                        }
                    } else {
                        echo '<div class="card">';
                        echo '<h2>No appointments today</h2>';
                        echo '</div>';
                    }
                    ?>

                </div>
                <!----------end-of-cards---------->

                <!----------Title---------->
                <div class="header-text-pending">
                    <section id="reminder-section" class="welcome-section">
                        <h1>Pending Booking</h1>
                    </section>
                </div>
                <!----------end-of-title---------->

                <!----------Pending Booking---------->
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
                                $sql = "SELECT * FROM `patientBooking`";
                                $result = mysqli_query($con, $sql);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $address = $row['address'];
                                        $schedule = date("F j, Y g:i A", strtotime($row['schedule']));
                                        $service = $row['service'];

                                        echo '<tr>
            <th scope="row">' . $id . '</th>
            <td>' . $name . '</td>
            <td>' . $schedule . '</td>
            <td>' . $service . '</td>
            <td>
                    <div class="more-info-btn" style="font-size: 1.1rem; color:#039be5; cursor: pointer;" data-id="' . $id . '">
                    <i class="fa-solid fa-circle-info"></i> More Info
                </div>
            </td>
        </tr>';

                                        // Modal for each record
                                        echo '<div id="myModal_' . $id . '" class="modal-index" style="display: none;">
            <div class="modal-content-index">
                <div class="modal-header-index">
                    <span class="close-index">&times;</span>
                    <h2>More Information</h2>
                </div>
                <div class="modal-body-index">
                    <form>
                    <fieldset>
                    <div class="input-fields">
                            <label for="schedule" class="form-label"><b>Schedule</b></label>
                            <input type="text" id="schedule" name="schedule" class="form-control" value="' . $schedule . '">
                        </div>
                         <div class="input-fields">
                            <label for="service" class="form-label"><b>Service</b></label>
                            <input type="text" id="service" name="service" class="form-control" value="' . $service . '">
                        </div>
                        <div class="input-fields">
                            <label for="name" class="form-label"><b>Name</b></label>
                            <input type="text" id="service" name="service" class="form-control" value="' . $name . '">
                        </div>
                        <div class="input-fields">
                            <label for="address" class="form-label"><b>Address</b></label>
                            <input type="text" id="address" name="address" class="form-control" value="' . $address . '">
                        </div>
                        <div class="input-fields">
                            <label for="mobileNo" class="form-label"><b>Mobile Number</b></label>
                            <input type="text" id="mobileNo" name="mobileNo" class="form-control" value="' . $mobileNo . '">
                        </div>
                        <div class="input-fields">
                            <label for="doctor" class="form-label"><b>Doctor Requested</b></label>
                            <input type="text" id="doctor" name="doctor" class="form-control" value="' . $doctor . '">
                        </div>
                    </form>
                    <button class="goto"><a href="transfer.php?transferid=' . $id . '">Confirm Patient</a></button>
                    <button class="details"><a href="resched.php?rescheduleid=' . $id . '">Reschedule Patient</a></button>
                    </fieldset>
                </div>
            </div>
        </div>';
                                    }
                                }
                                ?>

                                <script>
                                    // Get all the buttons for displaying modals
                                    var buttons = document.querySelectorAll('.more-info-btn');

                                    // Attach event listeners to each button
                                    buttons.forEach(function(button) {
                                        button.addEventListener('click', function() {
                                            var id = this.getAttribute('data-id');
                                            var modal = document.getElementById('myModal_' + id);
                                            var closeBtn = modal.querySelector('.close-index');

                                            // Display the modal
                                            modal.style.display = 'block';

                                            // Close the modal when the close button is clicked
                                            closeBtn.addEventListener('click', function() {
                                                modal.style.display = 'none';
                                            });

                                            // Close the modal when clicking outside the modal
                                            window.addEventListener('click', function(event) {
                                                if (event.target == modal) {
                                                    modal.style.display = 'none';
                                                }
                                            });
                                        });
                                    });
                                </script>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!---------end-of-INDEX-TABLET-VIEW---------->

            <!---------START-of-INDEX-PHONE-VIEW---------->
            <div class="index-phone-cont">
                <div class="card-container">
                    <?php
                    // Fetch today's doctor and bookings from the database
                    $today = date("Y-m-d");
                    $sql = "SELECT schedule, name, service, doctor FROM patientApt WHERE DATE(schedule) = '$today'";
                    $result = $con->query($sql);
                    $count = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($count >= 3) { // Check if count is already 3
                                break; // Exit the loop if count is already 3
                            }
                            echo '<div class="card">';
                            echo '<h3 class="card-title">' . $row['doctor'] . '</h3>';
                            echo '<p class="card__content">' . $row['name'] . '</p>';
                            echo '<p class="card__content-service">' . $row['service'] . '</p>';
                            echo '<div class="card__date">' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</div>'; // Include time format in 12-hour notation with AM/PM (g:i A)
                            echo '</div>';
                            $count++; // Increment count after displaying a card
                        }
                    } else {
                        echo '<div class="card">';
                        echo '<h2>No appointments today</h2>';
                        echo '</div>';
                    }
                    ?>

                </div>
                <!----------end-of-cards---------->

                <!----------Title---------->
                <div class="header-text-pending">
                    <section id="reminder-section" class="welcome-section">
                        <h1>Pending Booking</h1>
                    </section>
                </div>
                <!----------end-of-title---------->

                <!----------Pending Booking---------->
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
                                $sql = "SELECT * FROM `patientBooking`";
                                $result = mysqli_query($con, $sql);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $mobileNo = $row['mobileNo'];
                                        $address = $row['address'];
                                        $doctor = $row['doctor'];
                                        $schedule = $row['schedule'];
                                        $service = $row['service'];


                                        echo '<tr>
                                <th scope="row">' . $id . '</th>
                                <td>' . $name . '</td>
                                <td>' . $mobileNo . '</td>
                                <td>' . $doctor . '</td>
                                <td>' . $schedule . '</td>
                                <td>' . $service . '</td>
                                <td>
                                    <button class="goto btn-primary"><a href="transfer.php?transferid=' . $id . '">Confirm Patient</a></button>
                                </td>
                                <td>
                                    <button class="details"><a href="resched.php?rescheduleid=' . $id . '">Reschedule Patient</a></button>
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
            <!---------end-of-INDEX-PHONE-VIEW---------->
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

</html>