<?php
include('config.php');
include 'session_timeout.php';
include 'idleWarning.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Patient List</title>
</head>

<body>
    <div id="header">
        <div class="container-nav">
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


            <!----------START OF DESKTOP VIEW FOR PATIENT LIST---------->
            <div class="pl-desktop-cont">
                <div class="tab">
                    <button class="tablinks" onclick="tabs(event, 'pListDesktop')">Patient List</button>
                    <button class="tablinks" onclick="tabs(event, 'pReschedDesktop')">For Rescheduling</button>
                </div>

                <div id="pListDesktop" class="tabcontent">
                    <!----------Title---------->
                    <div class="header-text">
                        <section id="reminder-section" class="welcome-section">
                            <h1>Patient List</h1>
                        </section>
                    </div>
                    <!----------end-of-title---------->
                    <!-- Add a search bar for filtering by name -->
                    <div class="search">
                        <input type="text" id="searchInput_pList" onkeyup="searchTable('pList')" placeholder="Search here">
                    </div>
                    <script>
                        function searchTable(tabId) {
                            var input, filter, table, tr, td, i, j, txtValue;
                            input = document.getElementById("searchInput_" + tabId);
                            filter = input.value.toUpperCase();
                            table = document.getElementById("patientTable_" + tabId);
                            tr = table.getElementsByTagName("tr");

                            // Loop through all table rows
                            for (i = 0; i < tr.length; i++) {
                                var found = false;
                                td = tr[i].getElementsByTagName("td");
                                // Loop through all table cells in the current row
                                for (j = 0; j < td.length; j++) {
                                    txtValue = td[j].textContent || td[j].innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        found = true;
                                        break;
                                    }
                                }
                                // Display or hide the row based on the search result
                                if (found) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    </script>

                    <div class="box">
                        <div class="row">
                            <div class="container-table">
                                <table id="patientTable_pList">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Dr. Assigned</th>
                                        <th>Status</th>
                                        <th>Latest Schedule</th>
                                        <th>Latest Treatment</th>
                                        <th>More Information</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM `patientList`";
                                    $result = mysqli_query($con, $sql);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $mobileNo = $row['mobileNo'];
                                            $doctor = $row['doctor'];
                                            $status = $row['status'];
                                            $service = $row['service'];
                                            $link = $row['link'];

                                            echo '<tr>
                                        <th scope="row">' . $id . '</th>
                                        <td>' . $name . '</td>
                                        <td>' . $mobileNo . '</td>
                                        <td>' . $doctor . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</td>
                                        <td>' . $service . '</td>
                                        <td>
                                            <button class="goto"><a href="chart.php?showid=' . $id . '&showname=' . $name . '" class="text-dark">🦷 Chart / Plan</a></button>
                                            <button class="goto"><a href="treatmentRecord.php?showid=' . $id . '" class="text-dark">📋 Treatment Record</a></button>
                                            <button class="details" onclick="contactPatient(\'' . $link . '\')" ><a class ="text-dark">💬 Chat via FB</a></button>
                                            <button class="details"><a href="patientArchive.php?showid=' . $id . '&showname=' . $name . '" class="text-dark">📑 More Details</a></button>
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

                <div id="pReschedDesktop" class="tabcontent">
                    <div class="header-text">
                        <section id="reminder-section" class="welcome-section">
                            <h1>For Rescheduling</h1>
                        </section>
                    </div>
                    <div class="search">
                        <input type="text" id="searchInput_pResched" onkeyup="searchTable('pResched')" placeholder="Search here">
                    </div>
                    <div class="box">
                        <div class="row">
                            <div class="container-table">
                                <table id="patientTable_pResched">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Latest Schedule</th>
                                        <th>Dr. requested</th>
                                        <th>Status</th>
                                        <th>Treatment Needed</th>
                                        <th>More Information</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM `patientResched`";
                                    $result = mysqli_query($con, $sql);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $mobileNo = $row['mobileNo'];
                                            $schedule = $row['schedule'];
                                            $doctor = $row['doctor'];
                                            $status = $row['status'];
                                            $service = $row['service'];

                                            echo '<tr>
                            <th scope="row">' . $id . '</th>
                            <td>' . $name . '</td>
                            <td>' . $mobileNo . '</td>
                            <td>' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</td>
                            <td>' . $doctor . '</td>
                            <td>' . $status . '</td>
                            <td>' . $service . '</td>
                            <td>
                            <button class="details" onclick="contactPatient(\'' . $link . '\')" ><a class ="text-dark">💬 Chat via FB</a></button>
                            <button class="details"><a href="reschedArchive.php?showid=' . $id . '&showname=' . $name . '" class="text-dark">📑 More Details</a></button>
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
            <!----------END OF DESKTOP VIEW FOR PATIENT LIST---------->

            <!----------START OF TABLET VIEW FOR PATIENT LIST---------->
            <div class="pl-tablet-cont">
                <div class="tab">
                    <button class="tablinks" onclick="tabs(event, 'pListTablet')">Patient List</button>
                    <button class="tablinks" onclick="tabs(event, 'pReschedTablet')">For Rescheduling</button>
                </div>

                <div id="pListTablet" class="tabcontent">
                    <!----------Title---------->
                    <div class="header-text">
                        <section id="reminder-section" class="welcome-section">
                            <h1>Patient List</h1>
                        </section>
                    </div>
                    <!----------end-of-title---------->
                    <!-- Add a search bar for filtering by name -->
                    <div class="search">
                        <input type="text" id="searchInput_pList" onkeyup="searchTable('pList')" placeholder="Search here">
                    </div>
                    <script>
                        function searchTable(tabId) {
                            var input, filter, table, tr, td, i, j, txtValue;
                            input = document.getElementById("searchInput_" + tabId);
                            filter = input.value.toUpperCase();
                            table = document.getElementById("patientTable_" + tabId);
                            tr = table.getElementsByTagName("tr");

                            // Loop through all table rows
                            for (i = 0; i < tr.length; i++) {
                                var found = false;
                                td = tr[i].getElementsByTagName("td");
                                // Loop through all table cells in the current row
                                for (j = 0; j < td.length; j++) {
                                    txtValue = td[j].textContent || td[j].innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        found = true;
                                        break;
                                    }
                                }
                                // Display or hide the row based on the search result
                                if (found) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    </script>

                    <div class="box">
                        <div class="row">
                            <div class="container-table">
                                <table id="patientTable_pList">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Dr. Assigned</th>
                                        <th>Status</th>
                                        <th>More Information</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM `patientList`";
                                    $result = mysqli_query($con, $sql);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $doctor = $row['doctor'];
                                            $status = $row['status'];
                                            $service = $row['service'];
                                            $link = $row['link'];

                                            echo '<tr>
                                        <th scope="row">' . $id . '</th>
                                        <td>' . $name . '</td>
                                        <td>' . $doctor . '</td>
                                        <td>' . $status . '</td>
                                        <td>
                                            <button class="goto"><a href="chart.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark">🦷 Chart / Plan</a></button>
                                            <button class="goto"><a href="treatmentRecord.php?showid    =' . $id . '" class="text-dark">📋 Treatment Record</a></button>
                                        </td>
                                        <td>
                                        <button class="details" onclick="contactPatient(\'' . $link . '\')" ><a class ="text-dark">💬 Chat via FB</a></button>
                                        <button class="details"><a href="patientArchive.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark">📑 More Details</a></button>
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

                <div id="pReschedTablet" class="tabcontent">
                    <div class="header-text">
                        <section id="reminder-section" class="welcome-section">
                            <h1>For Rescheduling</h1>
                        </section>
                    </div>
                    <div class="search">
                        <input type="text" id="searchInput_pResched" onkeyup="searchTable('pResched')" placeholder="Search here">
                    </div>
                    <div class="box">
                        <div class="row">
                            <div class="container-table">
                                <table id="patientTable_pResched">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Dr. requested</th>
                                        <th>Treatment Needed</th>
                                        <th>More Information</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM `patientResched`";
                                    $result = mysqli_query($con, $sql);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $doctor = $row['doctor'];
                                            $status = $row['status'];
                                            $service = $row['service'];
                                            $link = $row['link'];

                                            echo '<tr>
                                        <th scope="row">' . $id . '</th>
                                        <td>' . $name . '</td>
                                        <td>' . $doctor . '</td>
                                        <td>' . $service . '</td>
                                        <td>
                                            <button class="goto"><a href="chart.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark">🦷 Chart / Plan</a></button>
                                            <button class="goto"><a href="treatmentRecord.php?showid    =' . $id . '" class="text-dark">📋 Treatment Record</a></button>
                                        </td>
                                        <td>
                                        <button class="details" onclick="contactPatient(\'' . $link . '\')" ><a class ="text-dark">💬 Chat via FB</a></button>
                                        <button class="details"><a href="patientArchive.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark">📑 More Details</a></button>
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
            <!----------END OF TABLET VIEW FOR PATIENT LIST---------->

            <!----------START OF PHONE VIEW FOR PATIENT LIST---------->
            <div class="pl-phone-cont">
                <div class="tab">
                    <button class="tablinks" onclick="tabs(event, 'pListPhone')">Patient List</button>
                    <button class="tablinks" onclick="tabs(event, 'pReschedPhone')">For Rescheduling</button>
                </div>

                <div id="pListPhonet" class="tabcontent">
                    <!----------Title---------->
                    <div class="header-text">
                        <section id="reminder-section" class="welcome-section">
                            <h1>Patient List</h1>
                        </section>
                    </div>
                    <!----------end-of-title---------->
                    <!-- Add a search bar for filtering by name -->
                    <div class="search">
                        <input type="text" id="searchInput_pList" onkeyup="searchTable('pList')" placeholder="Search here">
                    </div>
                    <script>
                        function searchTable(tabId) {
                            var input, filter, table, tr, td, i, j, txtValue;
                            input = document.getElementById("searchInput_" + tabId);
                            filter = input.value.toUpperCase();
                            table = document.getElementById("patientTable_" + tabId);
                            tr = table.getElementsByTagName("tr");

                            // Loop through all table rows
                            for (i = 0; i < tr.length; i++) {
                                var found = false;
                                td = tr[i].getElementsByTagName("td");
                                // Loop through all table cells in the current row
                                for (j = 0; j < td.length; j++) {
                                    txtValue = td[j].textContent || td[j].innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        found = true;
                                        break;
                                    }
                                }
                                // Display or hide the row based on the search result
                                if (found) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    </script>

                    <div class="box">
                        <div class="row">
                            <div class="container-table">
                                <table id="patientTable_pList">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Dr. Assigned</th>
                                        <th>Status</th>
                                        <th>Latest Treatment</th>
                                        <th>More Information</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM `patientList`";
                                    $result = mysqli_query($con, $sql);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $mobileNo = $row['mobileNo'];
                                            $address = $row['address'];
                                            $doctor = $row['doctor'];
                                            $status = $row['status'];
                                            $service = $row['service'];
                                            $link = $row['link'];

                                            echo '<tr>
                                        <th scope="row">' . $id . '</th>
                                        <td>' . $name . '</td>
                                        <td>' . $mobileNo . '</td>
                                        <td>' . $address . '</td>
                                        <td>' . $doctor . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . $service . '</td>
                                        <td>
                                            <button class="goto"><a href="chart.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark">🦷 Chart / Plan</a></button>
                                            <button class="goto"><a href="treatmentRecord.php?showid    =' . $id . '" class="text-dark">📋 Treatment Record</a></button>
                                            <button class="details" onclick="contactPatient(\'' . $link . '\')" ><a class ="text-dark">💬 Chat via FB</a></button>
                                            <button class="details"><a href="patientArchive.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark">📑 More Details</a></button>
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

                <div id="pReschedPhone" class="tabcontent">
                    <div class="header-text">
                        <section id="reminder-section" class="welcome-section">
                            <h1>For Rescheduling</h1>
                        </section>
                    </div>
                    <div class="search">
                        <input type="text" id="searchInput_pResched" onkeyup="searchTable('pResched')" placeholder="Search here">
                    </div>
                    <div class="box">
                        <div class="row">
                            <div class="container-table">
                                <table id="patientTable_pResched">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Dr. requested</th>
                                        <th>Status</th>
                                        <th>Treatment Needed</th>
                                        <th>More Information</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM `patientResched`";
                                    $result = mysqli_query($con, $sql);
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $mobileNo = $row['mobileNo'];
                                            $address = $row['address'];
                                            $doctor = $row['doctor'];
                                            $status = $row['status'];
                                            $service = $row['service'];

                                            echo '<tr>
                            <th scope="row">' . $id . '</th>
                            <td>' . $name . '</td>
                            <td>' . $mobileNo . '</td>
                            <td>' . $address . '</td>
                            <td>' . $doctor . '</td>
                            <td>' . $status . '</td>
                            <td>' . $service . '</td>
                            <td>
                            <button class="details" onclick="contactPatient(\'' . $link . '\')" ><a class ="text-dark">💬 Chat via FB</a></button>
                            <button class="details"><a href="reschedArchive.php?showid=' . $id . ' & showname= ' . $name . '" class="text-dark">📑 More Details</a></button>
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
            <!----------END OF PHONE VIEW FOR PATIENT LIST---------->
            <script>
                function setDefaultTab() {
                    var url = window.location.href;
                    if (url.includes('pl.php')) {
                        var defaultTabDesktop = document.getElementById('pListDesktop');
                        var defaultTabTablet = document.getElementById('pListTablet');
                        var defaultTabPhone = document.getElementById('pListPhone')

                        defaultTabDesktop.style.display = 'block';
                        defaultTabTablet.style.display = 'block';

                        var tablinks = document.getElementsByClassName('tablinks');
                        for (var i = 0; i < tablinks.length; i++) {
                            tablinks[i].className = tablinks[i].className.replace(' active', '');
                        }

                        for (var i = 0; i < tablinks.length; i++) {
                            if (tablinks[i].innerHTML === 'Patient List') {
                                tablinks[i].className += ' active';
                            }
                        }
                    }
                }

                window.onload = setDefaultTab;

                function tabs(evt, tabId) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                    }
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(tabId).style.display = "block";
                    evt.currentTarget.className += " active";
                }

                function contactPatient(link) {
                    if (!link.trim()) {
                        alert("No facebook link provided");
                    } else {
                        // Check if the link starts with http:// or https://
                        if (!link.startsWith("http://") && !link.startsWith("https://")) {
                            // If not, prepend http:// to the link
                            link = "http://" + link;
                        }
                        // Open the link in a new window
                        window.open(link);
                    }
                }
            </script>
            <!----------endofcards---------->

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

</html>