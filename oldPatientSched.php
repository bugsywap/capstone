<?php
include('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['mobileNo'])) {
    $mobileNo = $_GET['mobileNo'];

    // Retrieve patient information from the database based on the mobile number
    $query = "SELECT * FROM patientList WHERE mobileNo = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $mobileNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch patient details
        $patient = $result->fetch_assoc();
    } else {
        // Handle case where mobile number does not exist
        echo "Patient not found.";
        exit;
    }
} else {
    // Redirect if mobile number is not provided
    header("Location: oldPatient.php");
    exit;
}

// Update schedule, visit, service, and history in the database on form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $schedule = $_POST['schedule'];
    $visit = $_POST['visit'];
    $service = $_POST['service'];
    $formattedSchedule = date('Y-m-d H:i:s', strtotime($schedule));
    $feedback = $_POST['feedback'];


    // Update database with new values in patientList table
    $update_query = "UPDATE patientList SET schedule = ?, visit = ?, service = ?, feedback = ? WHERE mobileNo = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("sssss", $formattedSchedule, $visit, $service, $feedback, $mobileNo);
    $update_stmt->execute();

    // Update database with new values in patientList table
    $update_query = "UPDATE `patientBooking` SET 
                          name=?, gender=?, dateOfBirth=?, religion=?, occupation=?, link=?, address=?, doctor=?, 
                          status=?, history=?, service=?, schedule=?, visit=?, feedback=?
                          WHERE mobileNo=?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param(
        "sssssssssssssss",
        $patient['name'],
        $patient['gender'],
        $patient['dateOfBirth'],
        $patient['religion'],
        $patient['occupation'],
        $patient['link'],
        $patient['address'],
        $patient['doctor'],
        $patient['status'],
        $patient['history'],
        $service,
        $formattedSchedule,
        $visit,
        $feedback,
        $mobileNo

    );
    $update_stmt->execute();

    // Insert updated data into patientApt table
    $insert_query = "INSERT INTO patientBooking (name, gender, doctor, dateOfBirth, address, link, mobileNo, religion, occupation, status, service, history, schedule, visit,feedback) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $con->prepare($insert_query);
    $insert_stmt->bind_param("sssssssssssssss", $patient['name'], $patient['gender'], $patient['doctor'], $patient['dateOfBirth'], $patient['address'], $patient['link'], $patient['mobileNo'], $patient['religion'], $patient['occupation'], $patient['status'], $patient['service'], $patient['history'], $formattedSchedule, $visit, $feedback);
    $insert_stmt->execute();

    header("Location: confirmations.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="formstyle.css">
    <script defer src="script.js"></script>

<body>
    <div class="form-cont">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center pt-5 mb-4">Appointment Booking</h1>
                </div>
                <div class="card-body">
                    <form method="POST" onsubmit="return validateForm()">
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const scheduleInput = document.querySelector('input[name="schedule"]');
                                scheduleInput.addEventListener('change', function() {
                                    const selectedDate = new Date(scheduleInput.value);
                                    const today = new Date();
                                    today.setHours(0, 0, 0, 0); // Set today's date to midnight

                                    if (selectedDate < today) {
                                        alert("Please select a valid schedule.");
                                        scheduleInput.value = ''; // Clear the input
                                    }
                                });

                                // Prevent form submission if schedule is in the past
                                const form = document.querySelector('form');
                                form.addEventListener('submit', function(event) {
                                    const selectedDate = new Date(scheduleInput.value);
                                    const today = new Date();
                                    today.setHours(0, 0, 0, 0); // Set today's date to midnight

                                    if (selectedDate < today) {
                                        event.preventDefault(); // Prevent form submission
                                        alert("Please select a valid schedule.");
                                        scheduleInput.value = ''; // Clear the input
                                    }
                                });
                            });

                            document.addEventListener("DOMContentLoaded", function() {
                                $('#datetimepickerSchedule').datetimepicker({
                                    format: 'YYYY-MM-DD hh:mm A',
                                    enabledHours: [9, 10, 11, 12, 13, 14, 15, 16, 17],
                                    stepping: 60 // Set the interval to 30 minutes
                                });
                            });
                        </script>
                        <div class="form-group mb-3">
                            <div class=" input-group date" id="datetimepickerSchedule" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input py-3" data-target="#datetimepickerSchedule" name="schedule" autocomplete="off" onclick="openDatePicker('#datetimepickerSchedule')" />
                                <div class="input-group-append" data-target="#datetimepickerSchedule" data-toggle="datetimepicker" onclick="openDatePicker('#datetimepickerSchedule')">
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="visitSelect" name="visit" onchange="toggleSpecifyField()">
                                <option selected>Please select your answer: </option>
                                <option value="within_last_3_months">Within the Last 3 Months</option>
                                <option value="3_to_6_months_ago">3-6 Months Ago</option>
                                <option value="6_to_12_months_ago">6-12 Months Ago</option>
                                <option value="1_to_2years_ago">1-2 Years Ago</option>
                                <option value="more_than_2ears_ago">More Than 2 Years Ago</option>
                                <option value="dont_remember">I Don't Remember</option>
                                <option value="emergency_visit">Emergency Visit Only</option>
                                <option value="regular_checkup">Regular Check-up (No issues)</option>
                                <option value="other">Other (Please Specify)</option>
                            </select>
                            <label for="floatingSelect">Your last visit<FONT COLOR=RED> *</FONT></label>
                            <div id="specifyField" style="display: none;">
                                <label for="otherSpecify">Please Specify:</label>
                                <input type="text" class="form-control py-3" id="otherSpecify" name="other_specify" placeholder="Specify here">
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="select" name="service">
                                <option selected>What's your desired service?</option>
                                <option value="Dental Cleaning">Dental Cleaning</option>
                                <option value="Tooth Extraction">Tooth Extraction</option>
                                <option value="Teeth Whitening">Teeth Whitening</option>
                                <option value="Wisdom Tooth Extraction (Surgery)">Wisdom Tooth Extraction (Surgery)</option>
                                <option value="Crown / Veneers">Crown / Veneers</option>
                                <option value="Dentures">Dentures</option>
                                <option value="Tooth Restoration">Tooth Restoration</option>
                                <option value="Root Canal Treatment">Root Canal Treatment</option>
                                <option value="Orthodontics (Braces)">Orthodontics (Braces)</option>
                            </select>
                            <label for="floatingSelect">Service<FONT COLOR=RED> *</FONT></label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="feedback" name="feedback" autocomplete="off">
                            <label for="floatingInput">You can leave a note here: </label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary my-3 d-grid gap-2 col-6 mx-auto" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
        function validateForm() {
            // Get values from form fields
            var schedule = document.getElementsByName("schedule")[0].value;
            var visit = document.getElementsByName("visit")[0].value;
            var service = document.getElementsByName("service")[0].value;
            var history = document.getElementsByName("history")[0].value;

            // Perform validation

            if (visit === "" || service === "" || schedule === "" || history === "") {
                alert("Please fill in all required fields.");
                return false;
            }
            // Validate visit selection
            if (visit === "other") {
                var otherSpecify = document.getElementById("otherSpecify").value;
                if (otherSpecify.trim() === "") {
                    alert("Please specify the visit option.");
                    return false;
                }
            }

            return true; // If all validations pass
        }

        function toggleSpecifyField() {
            var selectElement = document.getElementById("visitSelect");
            var specifyField = document.getElementById("specifyField");

            if (selectElement.value === "other") {
                specifyField.style.display = "block";
            } else {
                specifyField.style.display = "none";
            }
        }

        function openDatePicker(target) {
            $(target).datetimepicker('show');
        }

        function openDatePicker(target) {
            $(target).datetimepicker('show');
        }
        // Toggle specify field visibility on checkbox change
        $('#otherCheckbox').on('change', togglehistoryField);

        // Wait for the document to be ready before initializing datepickers
        $(document).ready(function() {
            // Initialize datepicker for elements with the 'datepicker' class
            $('#datetimepickerBirth').datetimepicker({
                format: 'YYYY-MM-DD',
                viewMode: 'days',
            });
            $('#datetimepickerSchedule').datetimepicker({
                format: 'YYYY-MM-DD hh:mm A',
            });
        });
    </script>
</body>

</html>