<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginstyles.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (Optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>Appointments</title>
</head>

<body>
    <div class="form shadow-sm p-3 mb-5 bg-white rounded">
        <img src="imgs/dslilogo.png" class="logo">
        <form id="survey-form" name="f1" method="POST">
            <div class="header">
                <h1>Are you an: </h1>
            </div>
            <div class="button-container">
                <!-- Use anchor tags instead of buttons -->
                <a href="oldPatient.php">Old Patient</a>
                <h2>Or</h2>
                <a href="aptForm.php">New Patient</a>
            </div>
        </form>
    </div>
</body>

</html>