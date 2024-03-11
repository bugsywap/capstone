<?php
include('config.php');

if (isset($_POST['check'])) {
    $mobileNo = $_POST['mobileNo'];

    // Query to check if mobile number exists in the database
    $query = "SELECT * FROM patientList WHERE mobileNo = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $mobileNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mobile number exists, redirect to oldPatientSched.php with mobile number parameter
        header("Location: oldPatientSched.php?mobileNo=" . urlencode($mobileNo));
        exit();
    } else {
        // Mobile number does not exist, display error message
        echo '<script>alert("Mobile number not found in the database.");</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

</head>



<body>
    <h1 class="text-center my-5">Number Verification</h1>
    <div class="container my-5">
        <form method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label><b>Mobile Number</b></label>
                <input type="text" class="form-control" placeholder="Enter your number" name="mobileNo" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary my-3" name="check">Check Mobile Number</button>
        </form>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-btQv55TK1/8Hq6aU/paMaAhp3C9aFfC6ZxJz8fRn2w4+oMn/6Z7QvK1uO2gOiKP" crossorigin="anonymous"></script>
    <script>
        function validateForm() {
            // Get values from form fields
            var mobileNo = document.getElementsByName("mobileNo")[0].value;

            // Perform validation
            if (mobileNo === "") {
                alert("Please fill in the required field.");
                return false;
            }

            // Validate mobile number format (11 digits)
            var mobileDefault = /^\d{11}$/;
            if (!mobileNo.match(mobileDefault)) {
                alert("Please enter a valid 11-digit mobile number.");
                return false;
            }
            return true;

            return true;
        }
    </script>
</body>

</html>