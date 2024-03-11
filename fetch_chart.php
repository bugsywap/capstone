<?php
include('config.php');
include 'session_timeout.php';


// Check if data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Decode JSON data received from JavaScript
  $data = json_decode(file_get_contents("php://input"));

  // Extract data
  $toothNumber = $data->toothNumber;
  $type = $data->type;
  $value = $data->value;
  $patientId = $data->showid; // Retrieve patient ID from the request

  // Determine the column name based on tooth number and type
  $columnName = $type . $toothNumber;

  // Prepare SQL statement to check if a row exists for the patient
  $checkStmt = $con->prepare("SELECT COUNT(*) as count FROM dChartTable WHERE id = ?");
  $checkStmt->bind_param("i", $patientId);
  $checkStmt->execute();
  $result = $checkStmt->get_result();
  $row = $result->fetch_assoc();
  $rowCount = $row['count'];

  if ($rowCount > 0) {
    // If a row exists, update the existing row
    $updateStmt = $con->prepare("UPDATE dChartTable SET $columnName = ? WHERE id = ?");
    $updateStmt->bind_param("si", $value, $patientId);
    if ($updateStmt->execute()) {
      $response = ['success' => true];
    } else {
      $response = ['success' => false, 'error' => $con->error];
    }
  } else {
    // If no row exists, insert a new row
    $insertStmt = $con->prepare("INSERT INTO dChartTable (id, $columnName) VALUES (?, ?)");
    $insertStmt->bind_param("is", $patientId, $value);
    if ($insertStmt->execute()) {
      $response = ['success' => true];
    } else {
      $response = ['success' => false, 'error' => $con->error];
    }
  }

  // Encode the response as JSON
  header('Content-Type: application/json');
  echo json_encode($response);
}
