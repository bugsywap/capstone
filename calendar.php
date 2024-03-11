<?php
include 'config.php';
include 'session_timeout.php';
include 'idleWarning.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    <title>Calendar</title>
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
            <div class="header-text">
                <section id="reminder-section" class="welcome-section">
                    <h1>Calendar</h1>
                </section>
            </div>
            <!----------end-of-title---------->
            <div class="calendar">
                <div class="container">
                    <iframe src="https://calendar.google.com/calendar/embed?height=768&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FManila&showPrint=0&showNav=1&showTabs=1&showTitle=0&showCalendars=1&src=YnVnc3l3YXBAZ21haWwuY29t&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4ucGhpbGlwcGluZXMjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%2333B679&color=%230B8043" style="border:solid 1px #777" width="1360" height="760" frameborder="0" scrolling="no">
                    </iframe>
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