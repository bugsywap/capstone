<?php
include 'config.php';
include 'session_timeout.php';
include 'idleWarning.php';

// Use Composer to manage your PHP library dependency
require __DIR__ . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
// Use the SearchApi class for searching assets
use Cloudinary\Api\Search\SearchApi;
// Use the AdminApi class for managing assets
use Cloudinary\Api\Admin\AdminApi;
// Use the UploadApi class for uploading assets
use Cloudinary\Api\Upload\UploadApi;

Configuration::instance('cloudinary://385881596145311:ThUGCBXJKc2Ei2WGFN6GrfXpeJs@dmmf2gbut?secure=true');

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="script.js"></script>
    <title>Treatment Record</title>
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
            <button class="previous" onclick="history.go(-1)">
            ← Back</button>

                    <div class="tRecord">
                        <section id="reminder-section" class="welcome-section">
                            <h1>📋 Treatment Record</h1>
                        </section>
                    </div>
                    <table id="record-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Last Appointment</th>
                                <th>Procedure</th>
                                <th>Dentist</th>
                                <th>Gender</th>
                                <th>Dental Images</th>
                            </tr>
                            <?php

                            $sql = "SELECT * FROM `patientList`";
                            $result = mysqli_query($con, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $schedule = $row['schedule'];
                                    $name = $row['name'];
                                    $dateOfBirth = $row['dateOfBirth'];
                                    $service = $row['service'];
                                    $doctor = $row['doctor'];
                                    $gender = $row['gender'];

                                    // Calculate age based on date of birth
                                    $dob = new DateTime($dateOfBirth);
                                    $today = new DateTime();
                                    $age = $dob->diff($today)->y;

                                    echo '<tr>
                                    <td>' . $id . '</td>
                                    <td>' . $name . '</td>
                                    <td>' . $age . '</td>
                                    <td>' . date("F j, Y g:i A", strtotime($row['schedule'])) . '</td>
                                    <td>' . $service . '</td>
                                    <td>' . $doctor . '</td>
                                    <td>' . $gender . '</td>
                                    <td>
                                    <div class="more-info-btn" style="font-size: 1.1rem; color:#039be5; cursor: pointer;" data-id="' . $id . '">
                                    <i class="fa-solid fa-circle-info"></i> More Info
                                    </div>
                                    </td>
                                    </tr>';
                                    echo '<div id="myModal_' . $id . '" class="modal-tr" style="display: none;">
                                    <div class="modal-content-tr">
                                        <div class="modal-header-tr">
                                            <span class="close-tr">&times;</span>
                                            <h2>Patient Files Gallery</h2>
                                        </div>
                                        <div class="modal-body-img">
                                            <h1>Choose an image to upload</h1>
                                            <button id="upload_widget_' . $id . '" class="cloudinary-button" data-patient-id="' . $id . '">Upload files</button>
                                            <div id="my-gallery_' . $id . '" style="max-width:100%;margin:auto">
                                                <!-- Gallery content will be rendered here -->
                                            </div>
                                            <!-- The modal for displaying larger images -->
                                            <div id="myModal-img-tr_' . $id . '" class="modal-img-tr">
                                                <span class="close-img">&times;</span>
                                                <img class="modal-content-img" id="img01_' . $id . '" />
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                            }
                            ?>
                            <script src="https://product-gallery.cloudinary.com/all.js" type="text/javascript"></script>
                            <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
                            <script>
                                // Get all the buttons for displaying modals
                                var buttons = document.querySelectorAll('.more-info-btn');

                                // Attach event listeners to each button
                                buttons.forEach(function(button) {
                                    button.addEventListener('click', function() {
                                        var id = this.getAttribute('data-id');
                                        var modal = document.getElementById('myModal_' + id);
                                        var closeBtn = modal.querySelector('.close-tr');

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


                                        // Initialize Cloudinary widget for this modal
                                        const cloudName = "dmmf2gbut"; // replace with your own cloud name
                                        const uploadPreset = "dskafagway"; // replace with your own upload preset\
                                        const folderName = "patient_" + id; // folder name based on the patient's ID
                                        const tag = "patient_" + id + "_Dental-Images"; // unique tag for the patient
                                        const myWidget = cloudinary.createUploadWidget({
                                            cloudName: cloudName,
                                            uploadPreset: uploadPreset,
                                            folder: folderName, // set the folder name based on the patient's ID
                                            tags: [tag], // add unique tag for the patient
                                            context: {
                                                alt: "user_uploaded"
                                            } // add context data to the uploaded files if needed
                                        }, (error, result) => {
                                            if (!error && result && result.event === "success") {
                                                console.log("Done! Here is the image info: ", result.info);
                                                // Handle successful upload here
                                            }
                                        });

                                        // Open Cloudinary widget when the upload button is clicked
                                        document.getElementById("upload_widget_" + id).addEventListener("click", function() {
                                            myWidget.open();
                                        }, false);

                                        // Initialize and render Cloudinary Gallery Widget
                                        var myGallery = cloudinary.galleryWidget({
                                            container: "#my-gallery_" + id,
                                            cloudName: "dmmf2gbut",
                                            tag: "patient_" + id + "_Dental-Images", // specify the unique tag for the patient
                                            mediaAssets: [{
                                                tag: "patient_" + id + "_Dental-Images" // use the same unique tag for filtering
                                            }]
                                        });

                                        myGallery.render();
                                    });
                                });
                            </script>
                        </thead>
                        <tbody id="record-table-body">
                            <!-- Table body will be populated dynamically -->
                        </tbody>
                    </table>
</body>

</html>