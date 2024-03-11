<?php
include('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['rescheduleid'])) {
    $rescheduleid = $_GET['rescheduleid'];

    // Retrieve the data for the specified ID from patientBooking table
    $selectSql = "SELECT * FROM `patientBooking` WHERE id = ?";
    $selectStmt = mysqli_prepare($con, $selectSql);
    mysqli_stmt_bind_param($selectStmt, 'i', $rescheduleid);
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

        // Check if the mobile number already exists in patientResched table
        $checkSql = "SELECT * FROM `patientResched` WHERE mobileNo = ?";
        $checkStmt = mysqli_prepare($con, $checkSql);
        mysqli_stmt_bind_param($checkStmt, 's', $mobileNo);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            // Mobile number exists, update the record in patientResched table
            $updateSql = "UPDATE `patientResched` SET 
                          name=?, gender=?, dateOfBirth=?, religion=?, occupation=?, link=?, address=?, doctor=?, 
                          status=?, history=?, service=?, schedule=?, visit=?, feedback=?
                          WHERE mobileNo=?";
            $updateStmt = mysqli_prepare($con, $updateSql);
            mysqli_stmt_bind_param(
                $updateStmt,
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
            mysqli_stmt_execute($updateStmt);
        } else {
            // Mobile number doesn't exist, insert into patientResched table
            $insertSqlpatientResched = "INSERT INTO `patientResched` (name, gender, mobileNo, dateOfBirth, religion, occupation, link, address, doctor, status, history, service, schedule, visit, feedback) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?, ?)";
            $insertStmtpatientResched = mysqli_prepare($con, $insertSqlpatientResched);

            if ($insertStmtpatientResched) {
                mysqli_stmt_bind_param(
                    $insertStmtpatientResched,
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
                mysqli_stmt_execute($insertStmtpatientResched);
            } else {
                echo "Error in prepared statement for insert into patientResched: " . mysqli_error($con);
            }
        }

                // Delete the row from the original table
                $deleteSql = "DELETE FROM `patientBooking` WHERE id = ?";
                $deleteStmt = mysqli_prepare($con, $deleteSql);

                if ($deleteStmt) {
                    mysqli_stmt_bind_param($deleteStmt, 'i', $rescheduleid);
                    mysqli_stmt_execute($deleteStmt);
                } else {
                    echo "Error in prepared statement for delete: " . mysqli_error($con);
                }

                // Redirect back to the original page
                header("Location: pl.php");
                exit();
        }
}

