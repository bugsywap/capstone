<?php
include('config.php');
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
    <script src="script.js"></script>
    <title>Dental Gallery</title>
</head>
<body-dg>
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
                    <h1>Dental Gallery</h1>
                </section>
            </div>
            <!----------end-of-title---------->
            <!----------Cards---------->
            <div class="card-container-dg">
                <div class="card-dg" onclick="openCardModal('vids/dnb.mp4')">
                    <div class="card-image-dg">
                        <img src="imgs/dnb.png" />
                    </div>
                    <p class="card-title-dg">Dentures and Bridges</p>
                    <p class="card-body-dg">
                        Dentures are removable prosthetics for replacing all or some missing teeth, while bridges are fixed structures anchored to adjacent natural teeth, aiming to restore oral function and appearance.
                    </p>
                    <button class="App-button" onclick="openModal('vids/dnb.mp4')">Watch</button>
                    <p class="footer-dg">Powered by <span class="by-name">DentaSync 2023</span></p>
                </div>

                <div class="card-dg" onclick="openCardModal('vids/os.mp4')">
                    <div class="card-image-dg">
                        <img src="imgs/os.png" />
                    </div>
                    <p class="card-title-dg">Oral Surgery</p>
                    <p class="card-body-dg">
                        Oral surgery refers to any surgical procedure performed on your teeth, gums, jaws or other oral structures. This includes extractions, implants, gum grafts and jaw surgeries.
                    </p>
                    <button class="App-button" onclick="openModal('vids/os.mp4')">Watch</button>
                    <p class="footer-dg">Powered by <span class="by-name">DentaSync 2023</span></p>
                </div>

                <div class="card-dg" onclick="openCardModal('vids/orth.mp4')">
                    <div class="card-image-dg">
                        <img src="imgs/orth.png" />
                    </div>
                    <p class="card-title-dg">Orthodontics</p>
                    <p class="card-body-dg">
                        Orthodontics is a branch of dentistry that focuses on the diagnosis, prevention, correction of misaligned teeth and jaws crooked, typically using braces or aligners to improve oral health and aesthetics.
                    </p>
                    <button class="App-button" onclick="openModal('vids/orth.mp4')">Watch</button>
                    <p class="footer-dg">Powered by <span class="by-name">DentaSync 2023</span></p>
                </div>

                <div class="card-dg" onclick="openCardModal('vids/rc.mp4')">
                    <div class="card-image-dg">
                        <img src="imgs/pnp.png" />
                    </div>
                    <p class="card-title-dg">Periodontics and Preventive Dentistry</p>
                    <p class="card-body-dg">
                        Periodontics involves the treatment of diseases & conditions affecting the gums, while preventive dentistry focuses on measures to maintain oral health & prevent dental issues.
                    </p>
                    <button class="App-button" onclick="openModal('vids/rc.mp4')">Watch</button>
                    <p class="footer-dg">Powered by <span class="by-name">DentaSync 2023</span></p>
                </div>

                <div class="card-dg" onclick="openCardModal('vids/cleaning.mp4')">
                    <div class="card-image-dg">
                        <img src="imgs/rnc.png" />
                    </div>
                    <p class="card-title-dg">Restoration and Cosmetic Dentistry</p>
                    <p class="card-body-dg">
                        Restoration dentistry involves repairing and replacing damaged or missing teeth for functional purposes, while cosmetic dentistry focuses on enhancing the aesthetics of the teeth and smile.
                    </p>
                    <button class="App-button" onclick="openModal('vids/cleaning.mp4')">Watch</button>
                    <p class="footer-dg">Powered by <span class="by-name">DentaSync 2023</span></p>
                </div>

                <div class="card-dg" onclick="openCardModal('vids/rct.mp4')">
                    <div class="card-image-dg">
                        <img src="imgs/rc.png" />
                    </div>
                    <p class="card-title-dg">Root Canal Treatment</p>
                    <p class="card-body-dg">
                        Root canal treatment involves removing infected or damaged pulp from the inside of a tooth, cleaning and sealing the space, to save the tooth and alleviate pain or infection.
                    </p>
                    <button class="App-button" onclick="openModal('vids/rct.mp4')">Watch</button>
                    <p class="footer-dg">Powered by <span class="by-name">DentaSync 2023</span></p>
                </div>
            </div>

            <!----------end-of-cards---------->

            <!---script onclick watch-->

            <script>
                function openPagednb() {
                    window.open("vids/dnb.mp4", "_blank");
                }

                function openPagerc() {
                    window.open("vids/rc.mp4", "_blank");
                }

                function openPageos() {
                    window.open("vids/os.mp4", "_blank");
                }

                function openPagernc() {
                    window.open("vids/rct.mp4", "_blank");
                }

                function openPageorth() {
                    window.open("vids/orth.mp4", "_blank");
                }

                function openPageppd() {
                    window.open("vids/cleaning.mp4", "_blank");
                }
            </script>
            <!---end ofscript onclick watch-->



        </div>
    </div>

</body-dg>

<div id="videoModal" class="modal-dg">
    <div class="modal-content-dg">
        <span class="close" onclick="closeModal()">&times;</span>
        <video controls id="modalVideo">
            <!-- Your video source will be added dynamically with JavaScript -->
        </video>
    </div>
</div>

<script>
    function openModal(videoSrc) {
        var modal = document.getElementById('videoModal');
        var video = document.getElementById('modalVideo');

        video.src = videoSrc; // Set the video source
        modal.style.display = 'block'; // Display the modal

        // Add event listener to close modal when clicking outside of it
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    function closeModal() {
        var modal = document.getElementById('videoModal');
        var video = document.getElementById('modalVideo');

        video.pause(); // Pause the video
        video.currentTime = 0; // Reset video time
        modal.style.display = 'none'; // Hide the modal
    }

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

    // Function to open modal when clicking the entire card
    function openCardModal(videoSrc) {
        openModal(videoSrc);
    }
</script>


</html>