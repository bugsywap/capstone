<?php
include 'config.php';

if (isset($_GET['showid']) && isset($_GET['showname']))  {
    $patientId = mysqli_real_escape_string($con, $_GET['showid']);
    $patientName = mysqli_real_escape_string($con, trim($_GET['showname']));

    $sql = "SELECT * FROM patientResched WHERE id = $patientId";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $gender = $row['gender'];
        $dateOfBirth = $row['dateOfBirth'];
        $address = $row['address'];
        $link = $row['link'];
        $mobileNo = $row['mobileNo'];
        $religion = $row['religion'];
        $occupation = $row['occupation'];
        $service = $row['service'];
        $history = $row['history'];
    } else {
        echo "Patient not found";
        exit();
    }

    $sql = "SELECT * FROM historyQuestions WHERE name = '$patientName'";;
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $q1 = $row['q1'];
        $q2 = $row['q2'];
        $q3 = $row['q3'];
        $q4 = $row['q4'];
        $q5 = $row['q5'];
        $q6 = $row['q6'];
        $q7 = $row['q7'];
        $q8 = $row['q8'];
        $q9 = $row['q9'];
        $q101 = $row['q101'];
        $q102 = $row['q102'];
        $q103 = $row['q103'];
        $q11 = $row['q11'];
        $q12 = $row['q12'];
    } else {
        echo "Patient not found";
        exit();
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>More Details</title>
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
                <div class="menubtn pe-5 pt-2">
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
    <h1 class="text-center my-5">📑 Patient Information</h1>
    <form>
        <fieldset disabled>
            <div class="w-50 mx-auto mb-3">
                <label for="address" class="form-label"><b>Latest Treatment</b></label>
                <input type="text" id="service" name="service" class="form-control" value="<?php echo $service; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="address" class="form-label"><b>
                        <h3><I>Medical History</I>
                    </b></h3></label>
                <input type="text" id="history" name="history" class="form-control" value="<?php echo $history; ?>">
            </div>
            <div class="w-50 mx-auto">
                <label for="address" class="form-label"><b><I>
                            <h4>Medical History Questions</h4>
                        </I></b></label>
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>1. Are you in good health?</b></label>
                <input type="text" id="history" name="q1" class="form-control" value="<?php echo $q1; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>2. Are you under medical treatment now?</b></label>
                <input type="text" id="history" name="q2" class="form-control" value="<?php echo $q2; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>3. Have you ever had serious illness or surgical operation?</b></label>
                <input type="text" id="history" name="q3" class="form-control" value="<?php echo $q3; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>4. Have you ever been hospitalized</b></label>
                <input type="text" id="history" name="q4" class="form-control" value="<?php echo $q4; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>5. Are you taking any prescription/non-prescription medication?</b></label>
                <input type="text" id="history" name="q5" class="form-control" value="<?php echo $q5; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>6. Do you use tobacco products?</b></label>
                <input type="text" id="history" name="q6" class="form-control" value="<?php echo $q6; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>7. Do you use alcohol, cocaine or other dangerous drugs?</b></label>
                <input type="text" id="history" name="q7" class="form-control" value="<?php echo $q7; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>8. Are you allergic to any of the following? </b><I>(Local Anesthetic, Sulfa Drugs, Aspirin, Pencillin, Antiobiotics, Latex, Others)</label>
                <input type="text" id="history" name="q8" class="form-control" value="<?php echo $q8; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>9. Bleeding Time</b></label>
                <input type="text" id="history" name="q9" class="form-control" value="<?php echo $q9; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>10.1 Are you pregnant?</b></label>
                <input type="text" id="history" name="q101" class="form-control" value="<?php echo $q101; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>10.2 Are you nursing?</b></label>
                <input type="text" id="history" name="q102" class="form-control" value="<?php echo $q102; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>10.3 Are you taking birth control pills?</b></label>
                <input type="text" id="history" name="q103" class="form-control" value="<?php echo $q103; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>11. Blood Type</b></label>
                <input type="text" id="history" name="q11" class="form-control" value="<?php echo $q11; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label class="mt-3"><b>12. Blood Pressure</b></label>
                <input type="text" id="history" name="q12" class="form-control" value="<?php echo $q12; ?>">
            </div>
            <div class="w-50 mx-auto">
                <label for="address" class="form-label"><b>
                        <h3><I>Personal Information</I>
                    </b></h3></label>
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="name" class="form-label"><b>Name</b></label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="name" class="form-label"><b>Gender</b></label>
                <input type="text" id="name" name="gender" class="form-control" value="<?php echo $gender; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="dateOfBirth" class="form-label"><b>Date of Birth</b></label>
                <input type="text" id="dateOfBirth" name="dateOfBirth" class="form-control" value="<?php echo $dateOfBirth; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="address" class="form-label"><b>Address</b></label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo    $address; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="address" class="form-label"><b>Mobile Number</b></label>
                <input type="text" id="number" name="mobileNo" class="form-control" value="<?php echo $mobileNo; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="address" class="form-label"><b>Facebook Link</b></label>
                <input type="text" id="link" name="link" class="form-control" value="<?php echo $link; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="address" class="form-label"><b>Religion</b></label>
                <input type="text" id="religion" name="religion" class="form-control" value="<?php echo $religion; ?>">
            </div>
            <div class="w-50 mx-auto mb-3">
                <label for="address" class="form-label"><b>Occupation</b></label>
                <input type="text" id="occupation" name="occupation" class="form-control" value="<?php echo $occupation; ?>">
            </div>


        </fieldset>
    </form>
</body>

</html>