<?php
include('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['transferid'])) {
    $transferId = $_GET['transferid'];

    // Retrieve the data for the specified ID from patientBooking table
    $selectSql = "SELECT * FROM `patientBooking` WHERE id = ?";
    $selectStmt = mysqli_prepare($con, $selectSql);
    mysqli_stmt_bind_param($selectStmt, 'i', $transferId);
    mysqli_stmt_execute($selectStmt);
    $selectResult = mysqli_stmt_get_result($selectStmt);

    if ($selectResult && $row = mysqli_fetch_assoc($selectResult)) {
        $name = $row['name'];
        $gender = $row['gender'];
        $doctor = $row['doctor'];
        $dateOfBirth = $row['dateOfBirth'];
        $address = $row['address'];
        $link = $row['link'];
        $mobileNo = $row['mobileNo'];
        $religion = $row['religion'];
        $occupation = $row['occupation'];
        $status = $row['status'];
        $history = $row['history'];
        $service = $row['service'];
        $schedule = $row['schedule'];
        $visit = $row['visit'];
        $feedback = $row['feedback'];

        // Check if the mobile number already exists in patientList table
        $checkSqlPatientList = "SELECT * FROM `patientList` WHERE mobileNo = ?";
        $checkStmtPatientList = mysqli_prepare($con, $checkSqlPatientList);
        mysqli_stmt_bind_param($checkStmtPatientList, 's', $mobileNo);
        mysqli_stmt_execute($checkStmtPatientList);
        $checkResultPatientList = mysqli_stmt_get_result($checkStmtPatientList);

        if ($checkResultPatientList && mysqli_num_rows($checkResultPatientList) > 0) {
            // Mobile number exists in patientList, update the record
            $updateSqlPatientList = "UPDATE `patientList` SET 
                                     name=?, gender=?, dateOfBirth=?, religion=?, occupation=?, link=?, address=?, doctor=?, 
                                     status=?, history=?, service=?, schedule=?, visit=?, feedback=?
                                     WHERE mobileNo=?";
            $updateStmtPatientList = mysqli_prepare($con, $updateSqlPatientList);
            mysqli_stmt_bind_param(
                $updateStmtPatientList,
                'sssssssssssssss',
                $name,
                $gender,
                $dateOfBirth,
                $religion,
                $occupation,
                $link,
                $address,
                $doctor,
                $status,
                $history,
                $service,
                $schedule,
                $visit,
                $feedback,
                $mobileNo
            );
            mysqli_stmt_execute($updateStmtPatientList);
        } else {
            // Mobile number does not exist in patientList, insert a new record
            $insertSqlPatientList = "INSERT INTO `patientList` (name, gender, mobileNo, dateOfBirth, religion, occupation, link, address, doctor, status, history, service, schedule, visit, feedback) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmtPatientList = mysqli_prepare($con, $insertSqlPatientList);
            mysqli_stmt_bind_param(
                $insertStmtPatientList,
                'sssssssssssssss',
                $name,
                $gender,
                $mobileNo,
                $dateOfBirth,
                $religion,
                $occupation,
                $link,
                $address,
                $doctor,
                $status,
                $history,
                $service,
                $schedule,
                $visit,
                $feedback
            );
            mysqli_stmt_execute($insertStmtPatientList);
        }

        // Check if the mobile number already exists in patientApt table
        $checkSqlPatientApt = "SELECT * FROM `patientApt` WHERE mobileNo = ?";
        $checkStmtPatientApt = mysqli_prepare($con, $checkSqlPatientApt);
        mysqli_stmt_bind_param($checkStmtPatientApt, 's', $mobileNo);
        mysqli_stmt_execute($checkStmtPatientApt);
        $checkResultPatientApt = mysqli_stmt_get_result($checkStmtPatientApt);

        if ($checkResultPatientApt && mysqli_num_rows($checkResultPatientApt) > 0) {
            // Mobile number exists in patientApt, update the record
            $updateSqlPatientApt = "UPDATE `patientApt` SET 
                                    name=?, gender=?, dateOfBirth=?, religion=?, occupation=?, link=?, address=?, doctor=?, 
                                    status=?, history=?, service=?, schedule=?, visit=?, feedback=?
                                    WHERE mobileNo=?";
            $updateStmtPatientApt = mysqli_prepare($con, $updateSqlPatientApt);
            mysqli_stmt_bind_param(
                $updateStmtPatientApt,
                'sssssssssssssss',
                $name,
                $gender,
                $dateOfBirth,
                $religion,
                $occupation,
                $link,
                $address,
                $doctor,
                $status,
                $history,
                $service,
                $schedule,
                $visit,
                $feedback,
                $mobileNo
            );
            mysqli_stmt_execute($updateStmtPatientApt);
        } else {
            // Mobile number does not exist in patientApt, insert a new record
            $insertSqlPatientApt = "INSERT INTO `patientApt` (name, gender, mobileNo, dateOfBirth, religion, occupation, link, address, doctor, status, history, service, schedule, visit, feedback) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmtPatientApt = mysqli_prepare($con, $insertSqlPatientApt);
            mysqli_stmt_bind_param(
                $insertStmtPatientApt,
                'sssssssssssssss',
                $name,
                $gender,
                $mobileNo,
                $dateOfBirth,
                $religion,
                $occupation,
                $link,
                $address,
                $doctor,
                $status,
                $history,
                $service,
                $schedule,
                $visit,
                $feedback
            );
            mysqli_stmt_execute($insertStmtPatientApt);
        }

        // Delete the row from the original table (patientBooking)
        $deleteSql = "DELETE FROM `patientBooking` WHERE id = ?";
        $deleteStmt = mysqli_prepare($con, $deleteSql);

        if ($deleteStmt) {
            mysqli_stmt_bind_param($deleteStmt, 'i', $transferId);
            mysqli_stmt_execute($deleteStmt);

            // Redirect back to the original page after successful deletion
            header("Location: pl.php");
            exit();
        } else {
            echo "Error in prepared statement for delete: " . mysqli_error($con);
        }
    }
}
?>
