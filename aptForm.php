<?php
include('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Manila');

if (isset($_POST['submit'])) {

    // Assign values from $_POST
    $status = "New Patient";
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $doctor = $_POST["doctor"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $address = $_POST["address"];
    $link = $_POST["link"];
    $mobileNo = $_POST["mobileNo"];
    $religion = $_POST["religion"];
    $occupation = $_POST["occupation"];
    $service = $_POST["service"];
    $schedule = $_POST["schedule"];
    $visit = $_POST["visit"];
    $history = isset($_POST["history"]) ? implode(', ', $_POST["history"]) : '';
    $feedback = $_POST["feedback"];
    $q1 = isset($_POST["q1"]) ? $_POST["q1"] : '';
    $q2 = isset($_POST["q2"]) ? $_POST["q2"] : '';
    $q3 = isset($_POST["q3"]) ? $_POST["q3"] : '';
    $q4 = isset($_POST["q4"]) ? $_POST["q4"] : '';
    $q5 = isset($_POST["q5"]) ? $_POST["q5"] : '';
    $q6 = isset($_POST["q6"]) ? $_POST["q6"] : '';
    $q7 = isset($_POST["q7"]) ? $_POST["q7"] : '';
    $q8 = isset($_POST["q8"]) ? $_POST["q8"] : '';
    $q9 = isset($_POST["q9"]) ? $_POST["q9"] : '';
    $q101 = isset($_POST["q101"]) ? $_POST["q101"] : '';
    $q102 = isset($_POST["q102"]) ? $_POST["q102"] : '';
    $q103 = isset($_POST["q103"]) ? $_POST["q103"] : '';
    $q11 = isset($_POST["q11"]) ? $_POST["q11"] : '';
    $q12 = isset($_POST["q12"]) ? $_POST["q12"] : '';


    // Convert schedule input to 12-hour format with AM/PM
    $formattedSchedule = date('Y-m-d H:i:s', strtotime($schedule));

    // If the selected visit option is "other", use the specified value
    if ($visit === "other") {
        $visit = $_POST["other_specify"];
    }

    if ($history === "other") {
        $history = $_POST["history_field"];
    }

    // Inside your PHP code where you process the form submission
    if ($q2 === "Yes") {
        // If "Yes" is selected for q2, store the value of q2_condition
        $q2_value = "Yes: " . $_POST["q2_condition"];
    } else {
        // If "No" is selected for q2, set q2_value to "No"
        $q2_value = "No";
    }
    if ($q3 === "Yes") {
        // If "Yes" is selected for q2, store the value of q2_condition
        $q3_value = "Yes: " . $_POST["q3_condition"];
    } else {
        // If "No" is selected for q2, set q2_value to "No"
        $q3_value = "No";
    }
    if ($q4 === "Yes") {
        // If "Yes" is selected for q2, store the value of q2_condition
        $q4_value = "Yes: " . $_POST["q4_condition"];
    } else {
        // If "No" is selected for q2, set q2_value to "No"
        $q4_value = "No";
    }
    if ($q5 === "Yes") {
        // If "Yes" is selected for q2, store the value of q2_condition
        $q5_value = "Yes: " . $_POST["q5_condition"];
    } else {
        // If "No" is selected for q2, set q2_value to "No"
        $q5_value = "No";
    }

    if ($q8 === "Yes") {
        // If "Yes" is selected for q2, store the value of q2_condition
        $q8_value = "Yes: " . $_POST["q8_condition"];
    } else {
        // If "No" is selected for q2, set q2_value to "No"
        $q8_value = "No";
    }

    // Check if the schedule already exists in the database
    $checkScheduleQuery = $con->prepare("SELECT * FROM patientApt WHERE schedule = ?");
    $checkScheduleQuery->bind_param("s", $schedule);
    $checkScheduleQuery->execute();
    $result = $checkScheduleQuery->get_result();

    if ($result->num_rows > 0) {
        // Schedule already exists, show alert
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                alert("Sorry, the selected schedule is already taken. Please choose another time.");
            });
          </script>';
    } else {

        // Update existing record
        $updateSql = $con->prepare("
        UPDATE `patientBooking` 
        SET name=?, gender=?, doctor=?, dateOfBirth=?, address=?, link=?, religion=?, occupation=?, status=?, service=?, schedule=?, visit=?, history=?, feedback=?
        WHERE mobileNo = ?
    ");

        $updateSql->bind_param("sssssssssssssss", $name, $gender, $doctor, $dateOfBirth, $address, $link,  $religion, $occupation,  $status, $service, $formattedSchedule, $visit, $history, $feedback, $mobileNo);
        $updateSql->execute();

        if ($updateSql->affected_rows > 0) {
            // If the update was successful, redirect to confirmations.php
            header('location: confirmations.php');
            exit(); // Exit after redirect
        } else {

            // If no records were updated, insert a new record
            $insertSql = $con->prepare("
            INSERT INTO `patientBooking` (name, gender, doctor, dateOfBirth, address, link, mobileNo, religion,occupation, status, service, schedule, visit, history, feedback)
            VALUES (UPPER(?),?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

            $insertSql->bind_param("sssssssssssssss", $name, $gender, $doctor, $dateOfBirth, $address, $link, $mobileNo, $religion, $occupation,  $status, $service, $formattedSchedule, $visit, $history, $feedback);
            $insertSql->execute();
            // Insert into historyQuestions table
            $insertHistorySql = $con->prepare("
    INSERT INTO `historyQuestions` (name, q1, q2, q3, q4, q5, q6, q7, q8, q9, q101, q102, q103, q11, q12, mobileNo)
    VALUES (UPPER(?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
");
            $insertHistorySql->bind_param("ssssssssssssssss", $name, $q1, $q2_value, $q3_value, $q4_value, $q5_value, $q6, $q7, $q8_value, $q9, $q101, $q102, $q103, $q11, $q12, $mobileNo);
            $insertHistorySql->execute();

            // Check if the insertion was successful
            if ($insertSql->affected_rows > 0 && $insertHistorySql->affected_rows > 0) {
                // If successful, redirect to confirmations.php
                header('location: confirmations.php');
                exit(); // Exit after redirect
            } else {
                // Handle error
                echo "Error: " . $con->error;
            }
        }
    }
    $checkScheduleQuery->close(); // Close the prepared statement
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

</head>

<body>
    <div class="form-cont">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center pt-5 mb-4">Appointment Booking</h1>
                </div>
                <div class="card-body">
                    <form method="POST" onsubmit="return validateForm()">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name" name="name" autocomplete="off">
                            <label for="floatingInput">Name<FONT COLOR=RED> *</FONT></label>
                        </div>
                        <div class="mb-3">
                            <label for="dateOfBirth" class="col-sm-3 col-form-label">Date of Birth<FONT COLOR=RED> *</FONT></label>
                            <div class="form-group">
                                <div class=" input-group date" id="datetimepickerBirth" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input py-3" data-target="#datetimepickerBirth" name="dateOfBirth" autocomplete="off" max="<?php echo date('Y-m-d'); ?>" required />
                                    <div class="input-group-append" data-target="#datetimepickerBirth" data-toggle="datetimepicker" onclick="openDatePicker('#datetimepickerBirth')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="address" name="address" autocomplete="off">
                            <label for="floatingInput">Address<FONT COLOR=RED> *</FONT></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Enter your number" name="mobileNo" autocomplete="off">
                            <label for="floatingInput">Mobile Number<FONT COLOR=RED> *</FONT></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="religion" name="religion" autocomplete="off">
                            <label for="floatingInput">Religion<FONT COLOR=RED> *</FONT></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="What's your occupation?" name="occupation" autocomplete="off">
                            <label for="floatingInput">Occupation <I>
                                    <FONT COLOR=GREY> (optional)</FONT>
                                </I></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="link" class="form-control" id="floatingInput" placeholder="Enter your link" name="link" autocomplete="off">
                            <label for="floatingInput">Facebook link
                                <FONT COLOR=GREY> <I>(If Available, leave blank if none)</FONT></I>
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="select" name="gender">
                                <option selected style> Please select your answer:</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Rather Not say">I'd rather not say</option>
                            </select>
                            <label for="floatingSelectt">Gender<FONT COLOR=RED> *</FONT></label>
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
                            <select class="form-select" id="floatingSelect" aria-label="select" name="doctor">
                                <option selected>Please select your answer: </option>
                                <option value="Dr. Joshua Bantic">Dr. Joshua Bantic</option>
                                <option value="Dr. Colleen Esteras">Dr. Colleen Esteras</option>
                                <option value="Dr. Caren Bugtong">Dr. Caren Bugtong</option>
                                <option value="Dr. Rio Ramolete">Dr. Rio Ramolete</option>
                            </select>
                            <label for="floatingSelect">Choose a Doctor<FONT COLOR=RED> *</FONT></label>
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
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const scheduleInput = document.querySelector('input[name="schedule"]');
                                scheduleInput.addEventListener('change', function() {
                                    const selectedDateTime = new Date(scheduleInput.value);
                                    const currentDateTime = new Date();

                                    if (selectedDateTime < currentDateTime) {
                                        alert("Please select a valid schedule.");
                                        scheduleInput.value = ''; // Clear the input
                                    }
                                });

                                // Prevent form submission if schedule is in the past
                                const form = document.querySelector('form');
                                form.addEventListener('submit', function(event) {
                                    const selectedDateTime = new Date(scheduleInput.value);
                                    const currentDateTime = new Date();

                                    if (selectedDateTime < currentDateTime) {
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
                        <div class="form-group">
                            <div class=" input-group date" id="datetimepickerSchedule" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input py-3" data-target="#datetimepickerSchedule" name="schedule" autocomplete="off" onclick="openDatePicker('#datetimepickerSchedule')" />
                                <div class="input-group-append" data-target="#datetimepickerSchedule" data-toggle="datetimepicker" onclick="openDatePicker('#datetimepickerSchedule')">
                                </div>
                            </div>
                        </div>
                </div>

                <div class="mb-3 ms-3">
                    <label>Medical History<FONT COLOR=RED> *</FONT></label>
                </div>
                <div class="w-100"></div>
                <div class="mb-3 ms-3">
                    <label>1. Are you in good health?
                        <font color="blue">(YES/NO)</font>
                        <font color="red"> *</font>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q1_yes" name="q1">
                        <label class="form-check-label" for="q1_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q1_no" name="q1">
                        <label class="form-check-label" for="q1_no">No</label>
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>2. Are you under medical treatment now?
                        <font color="blue"> (YES/NO)</font> If yes, what is the condition being treated?<font color="red"> *</font>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q2_yes" name="q2" onclick="showQ2ConditionField()">
                        <label class="form-check-label" for="q2_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q2_no" name="q2" onclick="hideQ2ConditionField()">
                        <label class="form-check-label" for="q2_no">No</label>
                    </div>
                    <div id="condition_field_1" style="display: none;">
                        <input type="text" class="form-control py-3" placeholder="Condition being treated" name="q2_condition" autocomplete="off">
                    </div>
                </div>

                <script>
                    function showQ2ConditionField() {
                        document.getElementById('condition_field_1').style.display = 'block';
                        document.querySelector('input[name="q2_condition"]').setAttribute('required', 'required');
                        document.querySelector('input[name="q2_condition"]').setAttribute('data-error', 'Please specify the condition being treated');
                    }

                    function hideQ2ConditionField() {
                        document.getElementById('condition_field_1').style.display = 'none';
                        document.querySelector('input[name="q2_condition"]').removeAttribute('required');
                        document.querySelector('input[name="q2_condition"]').removeAttribute('data-error');
                    }

                    function showQ3ConditionField() {
                        document.getElementById('condition_field_2').style.display = 'block';
                        document.querySelector('input[name="q3_condition"]').setAttribute('required', 'required');
                        document.querySelector('input[name="q3_condition"]').setAttribute('data-error', 'Please specify the condition being treated');
                    }

                    function hideQ3ConditionField() {
                        document.getElementById('condition_field_2').style.display = 'none';
                        document.querySelector('input[name="q3_condition"]').removeAttribute('required');
                        document.querySelector('input[name="q3_condition"]').removeAttribute('data-error');
                    }

                    function showQ4ConditionField() {
                        document.getElementById('condition_field_3').style.display = 'block';
                        document.querySelector('input[name="q4_condition"]').setAttribute('required', 'required');
                        document.querySelector('input[name="q4_condition"]').setAttribute('data-error', 'Please specify the condition being treated');
                    }

                    function hideQ4ConditionField() {
                        document.getElementById('condition_field_3').style.display = 'none';
                        document.querySelector('input[name="q4_condition"]').removeAttribute('required');
                        document.querySelector('input[name="q4_condition"]').removeAttribute('data-error');
                    }

                    function showQ5ConditionField() {
                        document.getElementById('condition_field_4').style.display = 'block';
                        document.querySelector('input[name="q5_condition"]').setAttribute('required', 'required');
                        document.querySelector('input[name="q5_condition"]').setAttribute('data-error', 'Please specify the condition being treated');
                    }

                    function hideQ5ConditionField() {
                        document.getElementById('condition_field_4').style.display = 'none';
                        document.querySelector('input[name="q5_condition"]').removeAttribute('required');
                        document.querySelector('input[name="q5_condition"]').removeAttribute('data-error');
                    }

                    function showQ8ConditionField() {
                        document.getElementById('condition_field_5').style.display = 'block';
                        document.querySelector('input[name="q8_condition"]').setAttribute('required', 'required');
                        document.querySelector('input[name="q8_condition"]').setAttribute('data-error', 'Please specify the condition being treated');
                    }

                    function hideQ8ConditionField() {
                        document.getElementById('condition_field_5').style.display = 'none';
                        document.querySelector('input[name="q8_condition"]').removeAttribute('required');
                        document.querySelector('input[name="q8_condition"]').removeAttribute('data-error');
                    }
                </script>
                <div class="mb-3 ms-3">
                    <label>3. Have you ever had serious illness or surgical operation?
                        <FONT COLOR=BLUE> (YES/NO)</FONT> If yes, what illness or operation?<FONT COLOR=RED> *</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q3_yes" name="q3" onclick="showQ3ConditionField()">
                        <label class="form-check-label" for="q2_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q3_no" name="q3" onclick="hideQ3ConditionField()">
                        <label class="form-check-label" for="q2_no">No</label>
                    </div>
                    <div id="condition_field_2" style="display: none;">
                        <input type="text" class="form-control py-3" placeholder="What illness or operation?" name="q3_condition" autocomplete="off">
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>4. Have you ever been hospitalized
                        <FONT COLOR=BLUE> (YES/NO)</FONT> If yes, when and why?<FONT COLOR=RED> *</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q4_yes" name="q4" onclick="showQ4ConditionField()">
                        <label class="form-check-label" for="q4_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q4_no" name="q4" onclick="hideQ4ConditionField()">
                        <label class="form-check-label" for="q4_no">No</label>
                    </div>
                    <div id="condition_field_3" style="display: none;">
                        <input type="text" class="form-control py-3" placeholder="When and why?" name="q4_condition" autocomplete="off">
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>5. Are you taking any prescription/non-prescription medication?
                        <FONT COLOR=BLUE> (YES/NO)</FONT> If yes, please specify:<FONT COLOR=RED> *</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q5_yes" name="q5" onclick="showQ5ConditionField()">
                        <label class="form-check-label" for="q5_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q5_no" name="q5" onclick="hideQ5ConditionField()">
                        <label class="form-check-label" for="q5_no">No</label>
                    </div>
                    <div id="condition_field_4" style="display: none;">
                        <input type="text" class="form-control py-3" placeholder="Please Specify: " name="q5_condition" autocomplete="off">
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>6. Do you use tobacco products?
                        <FONT COLOR=BLUE> (YES/NO)</FONT>
                        <FONT COLOR=RED> *</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q6_yes" name="q6">
                        <label class="form-check-label" for="q6_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q6_no" name="q6">
                        <label class="form-check-label" for="q6_no">No</label>
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>7. Do you use alcohol, cocaine or other dangerous drugs?
                        <FONT COLOR=BLUE> (YES/NO)</FONT>
                        <FONT COLOR=RED> *</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q7_yes" name="q7">
                        <label class="form-check-label" for="q7_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q7_no" name="q7">
                        <label class="form-check-label" for="q7_no">No</label>
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>8. Are you allergic to any of the following? <I>(Local Anesthetic, Sulfa Drugs, Aspirin, Pencillin, Antiobiotics, Latex, Others)</I>
                        <FONT COLOR=BLUE> (YES/NO)</FONT> Please specify your allergy:<FONT COLOR=RED> *</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q8_yes" name="q8" onclick="showQ8ConditionField()">
                        <label class="form-check-label" for="q8_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q8_no" name="q8" onclick="hideQ8ConditionField()">
                        <label class="form-check-label" for="q8_no">No</label>
                    </div>
                    <div id="condition_field_5" style="display: none;">
                        <input type="text" class="form-control py-3" placeholder="Please Specify: " name="q8_condition" autocomplete="off">
                    </div>
                </div>
                <div class="form-floating mb-3 mx-3">
                    <input type="text" class="form-control " id="floatingInput" placeholder="name" name="q9" autocomplete="off">
                    <label for="floatingInput">9. Bleeding Time</label>
                </div>
                <div class=" mx-auto">
                    <label class="mb-3 ms-3"><I>
                            <h4>10. For Women Only:</h4>
                        </I></label>
                </div>

                <div class="w-100"></div>
                <div class="mb-3 ms-3">
                    <label>10.1 Are you pregnant? <I></I>
                        <FONT COLOR=BLUE> (YES/NO)</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q101_yes" name="q101">
                        <label class="form-check-label" for="q101_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q101_no" name="q101">
                        <label class="form-check-label" for="q101_no">No</label>
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>10.2 Are you nursing? <I></I>
                        <FONT COLOR=BLUE> (YES/NO)</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q102_yes" name="q102">
                        <label class="form-check-label" for="q102_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q102_no" name="q102">
                        <label class="form-check-label" for="q102_no">No</label>
                    </div>
                </div>
                <div class="mb-3 ms-3">
                    <label>10.3 Are you taking birth control pills? <I></I>
                        <FONT COLOR=BLUE> (YES/NO)</FONT>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="Yes" id="q103_yes" name="q103">
                        <label class="form-check-label" for="q103_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="No" id="q103_no" name="q103">
                        <label class="form-check-label" for="q103_no">No</label>
                    </div>
                </div>
                <div class="form-floating mb-3 mx-3">
                    <select class="form-select" id="floatingSelect" aria-label="select" name="q11">
                        <option selected>What's your blood type?</option>
                        <option value="O Negative (O-)">O Negative (O-)</option>
                        <option value="O Positive (O+)">O Positive (O+)</option>
                        <option value="A Negative (A-) ">A Negative (A-) </option>
                        <option value="A Positive (A+)">A Positive (A+)</option>
                        <option value="B Negative (B-)">B Negative (B-)</option>
                        <option value="B Positive (B+)">B Positive (B+)</option>
                        <option value="AB Negative (AB-)">AB Negative (AB-)</option>
                        <option value="AB Positive (AB+)">AB Positive (AB+)</option>
                        <option value="I don't know my blood type.">I don't know my blood type.</option>
                    </select>
                    <label for="floatingSelect">11. Blood Type<FONT COLOR=RED> *</FONT></label>
                </div>
                <div class="form-floating mb-3 mx-3">
                    <input type="text" class="form-control " id="floatingInput" placeholder="q12" name="q12" autocomplete="off">
                    <label for="floatingInput">12. Blood Pressure<FONT COLOR=RED> *</FONT></label>
                </div>
                <div class="ms-3">
                    <label class="mt-3"> 13. Do you have or have you had any of the following? Check which apply<FONT COLOR=RED> *</FONT></label>
                </div>

                <div class="mb-3 mx-3">
                    <div class="mt-3 row">
                        <!-- MEDICAL HISTORY -->
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="High Blood Pressure" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    High Blood Pressure
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Low Blood Pressure" id="flexCheckDefault2" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault2">
                                    Low Blood Pressure
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Epilepsy / Convulsions" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Epilepsy / Convulsions
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="AIDS or HIV Infection" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    AIDS or HIV Infection
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Sexually Transmitted disease" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Sexually Transmitted disease
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Stomach Troubles / Ulcers" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Stomach Troubles / Ulcers
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Fainting Seizure" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Fainting Seizure
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Rapid Weight Loss" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Rapid Weight Loss
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Radiation Therapy" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Radiation Therapy
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Joint Replacement / Implant" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Joint Replacement / Implant
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Heart Surgery" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Heart Surgery
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Heart Attack" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Heart Attack
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Thyroid Problem" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Thyroid Problem
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Heart Disease" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Heart Disease
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Heart Murmur" id="flexCheckDefault2" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault2">
                                    Heart Murmur
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Hepatitis / Liver Disease" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Hepatitis / Liver Disease
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Rheumatic Fever" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Rheumatic Fever
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Hay Fever / Allergies" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Hay Fever / Allergies
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Respiratory Problems" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Respiratory Problems
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Hepatitis / Jaundice" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Hepatitis / Jaundice
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Tuberculosiss" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Tuberculosis
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Swollen ankles" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Swollen ankles
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Kidney disease" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Kidney disease
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Diabetes" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Diabetes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Chest pain" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Chest pain
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Stroke" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Stroke
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Cancer / Tumors" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Cancer / Tumors
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Anemia" id="flexCheckDefault2" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault2">
                                    Anemia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Angina" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Angina
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Asthma" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Asthma
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Emphysema" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Emphysema
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Bleeding Problems" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Bleeding Problems
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Blood Diseases" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Blood Diseases
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Head Injuries" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Head Injuries
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Arthritis / Rheumatism" id="flexCheckDefault1" name="history[]">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Arthritis / Rheumatism
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="other" id="otherCheckbox" name="history[]">
                                <label class="form-check-label" for="otherCheckbox">
                                    Other (Please Specify)
                                </label>
                            </div>
                            <!-- Specify field for "other" in medical history -->
                            <div id="anotherOne" style="display: none;">
                                <label for="historyField">Please Specify:</label>
                                <input type="text" class="form-control py-3" id="historyField" name="history_field" placeholder="Specify here">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-floating mb-3 mx-3 ">
                    <input type="text" class="form-control" id="floatingInput" placeholder="feedback" name="feedback" autocomplete="off">
                    <label for="floatingInput">You can leave a note here: </label>
                </div>
                <div class="container">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary my-3 d-grid gap-2 col-6 mx-auto" name="submit">Submit</button>
                    </div>
                </div>
                </form>
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
            var name = document.getElementsByName("name")[0].value;
            var dateOfBirth = document.getElementsByName("dateOfBirth")[0].value;
            var address = document.getElementsByName("address")[0].value;
            var mobileNo = document.getElementsByName("mobileNo")[0].value;
            var religion = document.getElementsByName("religion")[0].value;
            var gender = document.getElementsByName("gender")[0].value;
            var visit = document.getElementsByName("visit")[0].value;
            var doctor = document.getElementsByName("doctor")[0].value;
            var service = document.getElementsByName("service")[0].value;
            var schedule = document.getElementsByName("schedule")[0].value;
            var q1 = document.getElementsByName("q1")[0].value;
            var q2 = document.getElementsByName("q2")[0].value;
            var q3 = document.getElementsByName("q3")[0].value;
            var q4 = document.getElementsByName("q4")[0].value;
            var q5 = document.getElementsByName("q5")[0].value;
            var q6 = document.getElementsByName("q6")[0].value;
            var q7 = document.getElementsByName("q7")[0].value;
            var q8 = document.getElementsByName("q8")[0].value;
            var q11 = document.getElementsByName("q11")[0].value;
            var q12 = document.getElementsByName("q12")[0].value;


            // Perform validation
            if (name === "" || dateOfBirth === "" || address === "" || mobileNo === "" || religion === "" || gender === "" || visit === "" || doctor === "" || service === "" || schedule === "" ||
                q1 === "" || q2 === "" || q3 === "" || q4 === "" || q5 === "" || q6 === "" || q7 === "" || q8 === "" || q11 === "" || q12 === "") {
                alert("Please fill in all required fields.");
                return false;
            }

            // Validate mobile number format (11 digits)
            var mobileDefault = /^\d{11}$/;
            if (!mobileNo.match(mobileDefault)) {
                alert("Please enter a valid 11-digit mobile number.");
                return false;
            }
            return true;
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

        function togglehistoryField() {
            var otherCheckbox = document.getElementById("otherCheckbox");
            var anotherOne = document.getElementById("anotherOne");

            if (otherCheckbox.checked) {
                anotherOne.style.display = "block";
            } else {
                anotherOne.style.display = "none";
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