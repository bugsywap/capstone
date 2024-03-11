<?php
include('config.php');
include 'session_timeout.php';
include 'idleWarning.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Manila');


// Check if the 'showid' parameter is set in the URL
if (isset($_GET['showid']) && isset($_GET['showname'])) {
  $patientId = $_GET['showid'];
  $patientName = $_GET['showname'];


  // Fetch patient information from the database based on the 'showid'
  $sql = "SELECT * FROM `patientList` WHERE id = $patientId";
  $result = mysqli_query($con, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
  } else {
    // Patient not found, show an error message or redirect to another page
    echo "Patient not found.";
  }
} else {
  // If 'showid' parameter is not set, show an error message or redirect to another page
  echo "Patient ID not provided.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script defer src="script.js"></script>
  <title>Dental Record Chart</title>
  <script>

  </script>

</head>

<body>
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
      <button class="previous" onclick="history.go(-1)">
        ← Back</button>
      <div class="header-text">
        <section id="reminder-section" class="welcome-section">
          <h1>🦷 Chart <?php if ($result && mysqli_num_rows($result) > 0) {
                          // Patient found, display the chart for that patient
                          // You can include your existing chart code or any other chart display logic here

                          // For example, you can display the patient's name and other information
                          echo "<h1>($patientName)</h1>";
                        }
                        ?></h1>
        </section>
      </div>
      <!----------end-of-title---------->
      <div class="dchart-container">
        <form method="POST">
          <?php
          // Define the function to generate dropdowns
          function generateDropdowns($toothNumbers)
          {
            $dropdowns = '';

            // Loop through each tooth number and generate dropdowns accordingly
            foreach ($toothNumbers as $toothNumber) {
              $dropdowns .= '<div class="dchart">
                  <select id="select-tt" aria-label="select-tt" name="tt' . $toothNumber . '" onchange="insertData(this)">
                    <option value="" selected>Status: </option>
                    <optgroup label="Conditions">
                    <option value="Present Teeth">✓</option>
                    <option value="Decayed">D</option>
                    <option value="Decayed Class 1">D-1</option>
                    <option value="Decayed Class 2">D-2</option>
                    <option value="Decayed Class 3">D-3</option>
                    <option value="Decayed Class 4">D-4</option>
                    <option value="Decayed Class 5">D-5</option>
                    <option value="Missing Due to Caries">M</option>
                    <option value="Missing due to other causes">Mo</option>
                    <option value="Impacted Tooth">Im</option>
                    <option value="Supernumerary Tooth">Sp</option>
                    <option value="Roof Fragment">Rf</option>
                    <option value="Unerupted">Un</option>
                </optgroup>
                <optgroup label="Restorations & Prosthetics">
                    <option value="Amaigam Filling">Am</option>
                    <option value="Composite Filling">Co</option>
                    <option value="Jacket Crown">JC</option>
                    <option value="Abutment">Ab</option>
                    <option value="Attachement">Att</option>
                    <option value="Pontic">P</option>
                    <option value="Inlay">In</option>
                    <option value="Implant">Imp</option>
                    <option value="Sealants">S</option>
                    <option value="Removable Denture">Rm</option>
                </optgroup>
                <optgroup label="Surgery">
                    <option value="Extraction Due to Caries">X</option>
                    <option value="Extraction due to other causes">XO</option>
                </optgroup>
            </select>
            <select id="select-pt" aria-label="select-pt" name="pt' . $toothNumber . '" onchange="insertData(this)">
                <option value="" selected>Status: </option>
                <optgroup label="Conditions">
                    <option value="Present Teeth">✓</option>
                    <option value="Decayed">D</option>
                    <option value="Decayed Class 1">D-1</option>
                    <option value="Decayed Class 2">D-2</option>
                    <option value="Decayed Class 3">D-3</option>
                    <option value="Decayed Class 4">D-4</option>
                    <option value="Decayed Class 5">D-5</option>
                    <option value="Missing Due to Caries">M</option>
                    <option value="Missing due to other causes">Mo</option>
                    <option value="Impacted Tooth">Im</option>
                    <option value="Supernumerary Tooth">Sp</option>
                    <option value="Roof Fragment">Rf</option>
                    <option value="Unerupted">Un</option>
                </optgroup>
                <optgroup label="Restorations & Prosthetics">
                    <option value="Amaigam Filling">Am</option>
                    <option value="Composite Filling">Co</option>
                    <option value="Jacket Crown">JC</option>
                    <option value="Abutment">Ab</option>
                    <option value="Attachement">Att</option>
                    <option value="Pontic">P</option>
                    <option value="Inlay">In</option>
                    <option value="Implant">Imp</option>
                    <option value="Sealants">S</option>
                    <option value="Removable Denture">Rm</option>
                </optgroup>
                <optgroup label="Surgery">
                    <option value="Extraction Due to Caries">X</option>
                    <option value="Extraction due to other causes">XO</option>
                </optgroup>
            </select>
            <h2>' . $toothNumber . '</h2>
            <img src="imgs/dgchart.svg" class="dchart-box">
        </div>';
            }

            return $dropdowns;
          }

          // Define the tooth numbers as arrays for each section
          $chart_toothNumbers = ['55', '54', '53', '52', '51', '61', '62', '63', '64', '65'];
          $chart1_toothNumbers = ['18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28'];
          $chart2_toothNumbers = ['48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38'];
          $chart3_toothNumbers = ['85', '84', '83', '82', '81', '71', '72', '73', '74', '75'];

          // Generate the dropdowns for each section
          $chart_dropdowns = generateDropdowns($chart_toothNumbers);
          $chart1_dropdowns = generateDropdowns($chart1_toothNumbers);
          $chart2_dropdowns = generateDropdowns($chart2_toothNumbers);
          $chart3_dropdowns = generateDropdowns($chart3_toothNumbers);

          // Output the generated dropdowns for each section
          echo '<div class="chart-container">' . $chart_dropdowns . '</div>';
          echo '<div class="chart-container1">' . $chart1_dropdowns . '</div>';
          echo '<div class="chart-container2">' . $chart2_dropdowns . '</div>';
          echo '<div class="chart-container3">' . $chart3_dropdowns . '</div>';
          ?>
      </div>
      </form>
    </div>
    <script>
      function insertData(selectElement) {
        const selectedValue = selectElement.value;
        const toothNumber = selectElement.parentElement.querySelector('h2').textContent;
        const type = selectElement.id.startsWith('select-tt') ? 'tt' : 'pt'; // Determine if it's temporary or permanent
        const data = {
          toothNumber: toothNumber,
          type: type,
          value: selectedValue
        };

        // Send the selected value to the PHP script for insertion
        sendDataToPHP(data);
      }

      function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
          results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
      }

      function sendDataToPHP(data) {
        // Include the showid in the request body
        const patientId = getParameterByName('showid');
        data['showid'] = patientId;

        // Send data using fetch
        fetch('fetch_chart.php', {
            method: 'POST',
            headers: {
              Accept: 'application/json',
              "Content-Type": 'application/json',
            },
            body: JSON.stringify(data),
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
      }
    </script>
    <div class="inc-title-tt">
      <h2>Patient Status (Temporary Tooth / Upper box)</h2>
    </div>
    <?php
    // Fetch data from the dChartTable for columns that start with "tt"
    $sql = "SELECT * FROM dChartTable WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $_GET['showid']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
      // Initialize an array to store grouped values
      $groupedValues = [];

      // Loop through each row in the result set
      while ($row = $result->fetch_assoc()) {
        foreach ($row as $columnName => $columnValue) {
          // Check if the column starts with "tt" and has a non-empty value
          if (strpos($columnName, 'tt') === 0 && !empty($columnValue)) {
            // Extract the tooth number from the column name
            $toothNumber = str_replace('tt', '', $columnName);

            // Check if the value exists in the groupedValues array
            if (!isset($groupedValues[$columnValue])) {
              // If not, initialize the value count
              $groupedValues[$columnValue] = ['toothNumbers' => [], 'count' => 1];
            } else {
              // If exists, increment the value count
              $groupedValues[$columnValue]['count']++;
            }

            // Add the tooth number to the array
            $groupedValues[$columnValue]['toothNumbers'][] = $toothNumber;
          }
        }
      }

      // Display the grouped values in the table
      echo '<table id="inc-table-tt">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Option Value</th>';
      echo '<th>No. of Tooth to be fixed</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody id="inc-table-body-tt">';

      // Loop through the grouped values
      foreach ($groupedValues as $optionValue => $data) {
        $toothNumbers = implode(',', $data['toothNumbers']);
        $count = $data['count'];
        echo '<tr>';
        echo '<td>' . $optionValue . ' <font color="red">(' . $toothNumbers . ')</font></td>';
        echo '<td>' . $count . '</td>';
        echo '</tr>';
      }


      echo '</tbody>';
      echo '</table>';
    }
    ?>



    <div class="inc-title-pt">
      <h2>Patient Status (Permanent Tooth / Lower Box)</h2>
    </div>
    <?php
    // Fetch data from the dChartTable for columns that start with "tt"
    $sql = "SELECT * FROM dChartTable WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $_GET['showid']);
    $stmt->execute();
    $result = $stmt->get_result();


    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
      // Initialize an array to store grouped values
      $groupedValues = [];

      // Loop through each row in the result set
      while ($row = $result->fetch_assoc()) {
        foreach ($row as $columnName => $columnValue) {
          // Check if the column starts with "pt" and has a non-empty value
          if (strpos($columnName, 'pt') === 0 && !empty($columnValue)) {
            // Extract the tooth number from the column name
            $toothNumber = str_replace('pt', '', $columnName);

            // Check if the value exists in the groupedValues array
            if (!isset($groupedValues[$columnValue])) {
              // If not, initialize the value count
              $groupedValues[$columnValue] = ['toothNumbers' => [], 'count' => 1];
            } else {
              // If exists, increment the value count
              $groupedValues[$columnValue]['count']++;
            }

            // Add the tooth number to the array
            $groupedValues[$columnValue]['toothNumbers'][] = $toothNumber;
          }
        }
      }

      // Display the grouped values in the table
      echo '<table id="inc-table-pt">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Option Value</th>';
      echo '<th>No. of Tooth to be fixed</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody id="inc-table-body-pt">';

      // Loop through the grouped values
      foreach ($groupedValues as $optionValue => $data) {
        $toothNumbers = implode(',', $data['toothNumbers']);
        $count = $data['count'];
        echo '<tr>';
        echo '<td>' . $optionValue . ' <font color="red">(' . $toothNumbers . ')</font></td>';
        echo '<td>' . $count . '</td>';
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';
    }
    ?>
    </table>
    <button class="clear">
      <a href="delete_row.php?deleteid=<?php echo isset($_GET['showid']) ? $_GET['showid'] : ''; ?>">
        Clear and Reset Chart
      </a>
    </button>



    <div class="header-text">
      <section id="reminder-section" class="welcome-section">
        <h1>Treatment Plan</h1>
      </section>
    </div>
    <div class="todo-container">
      <div class="todo-sp">
        <h2>Treatment Plan - To-Do's</h2>
        <select id="phase-dropdown">
          <option value="Systemic" style="color: blue;">Systemic Phase</option>
          <option value="Acute Phase" style="color: red;">Acute Phase</option>
          <option value="Disease Control Phase" style="color: green;">Disease Control Phase</option>
          <option value="Definitive Phase" style="color: orange;">Definitive Phase</option>
          <option value="Maintenance Phase" style="color: purple;">Maintenance Phase</option>
        </select>
        <div class="todo-row">
          <input type="text" id="input-box-sp" placeholder="Add a task">
          <button class="todo-button" onclick="addTask()">Add</button>
        </div>
        <ul id="todolistCont-sp">
          <!-- <li class="todo-check"></li>-->
        </ul>
      </div>
    </div>

    <style>
      .edit {
        padding: 8px 15px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      button.edit {
        background-color: #007bff;
      }
    </style>

    <script>
      const inputBox = document.getElementById('input-box-sp');
      const todoList = document.getElementById('todolistCont-sp');


      function addTask() {
        const selectedPhase = document.getElementById('phase-dropdown').value;
        const inputValue = inputBox.value;
        if (inputValue === '') {
          alert("Write before adding another task!");
        } else {
          let li = document.createElement("li");
          let taskText = document.createTextNode(selectedPhase.replace('-', ' ') + ' : ' + inputValue);
          li.appendChild(taskText);
          li.classList.add(selectedPhase.replace(/\s+/g, '-').toLowerCase());
          let span = document.createElement("span");
          span.innerHTML = "\u00d7";
          li.appendChild(span);
          todoList.appendChild(li);

          // Save the task to the database
          saveTask(selectedPhase, inputValue);
          const currentDate = new Date().toISOString(); // Get current date and time
          const data = {
            phase: selectedPhase,
            task: inputValue,
            datetime: currentDate // Add current date and time to data
          };
          // Send task data to server using fetch
          sendDataToServer(data);

        }
        inputBox.value = '';
      }

      function formatDate(date) {
        return new Date(date).toLocaleString('en-US', {
          timeZone: 'Asia/Manila'
        });
      }

      function editTask(button) {
        var li = button.parentNode;
        var taskId = li.getAttribute("data-task-id"); // Get the task ID from the list item
        var taskText = li.firstChild.nodeValue; // Get the text content of the list item
        var taskWithoutPrefix = taskText.split(':')[1].split('(')[0].trim(); // Extract the task text without the prefix
        console.log("Task ID:", taskId);
        console.log("Original Task Text:", taskText);
        console.log("Task Text Without Prefix:", taskWithoutPrefix);
        var newTaskText = prompt("Edit task:", taskWithoutPrefix);
        if (newTaskText !== null && newTaskText.trim() !== "") {
          // Reconstruct the task text with the prefix and update the list item
          var currentDate = new Date().toISOString(); // Get current date and time
          console.log("New Task Text:", newTaskText);
          console.log("Current Date:", currentDate);
          li.firstChild.nodeValue = taskText.split(':')[0].trim() + ": " + newTaskText.trim() + " (" + formatDate(currentDate) + ")";
          console.log("Updated Task Text:", li.firstChild.nodeValue);

          // Send AJAX request to update task in the database
          updateTaskInDatabase(taskId, newTaskText, currentDate);

          // Alert "Edited Successfully!"
          alert("Edited Successfully!");
          location.reload();
        }
      }


      function updateTaskInDatabase(taskId, newTaskText, currentDate) {
        // Send AJAX request to update task in the database
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'edit_task.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.status === 200) {
            console.log('Task updated successfully:', xhr.responseText);
          } else {
            console.error('Error updating task:', xhr.statusText);
          }
        };
        xhr.send('task_id=' + taskId + '&task_text=' + encodeURIComponent(newTaskText) + '&datetime=' + encodeURIComponent(currentDate));
      }


      function sendDataToServer(data) {
        const patientID = getPatientIDFromURL();
        if (!patientID) {
          alert("Patient ID not found!");
          return;
        }

        // Send AJAX request to save task
        fetch(`save_task.php?showid=${patientID}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            // Reload the task list after adding a task
            loadTasks();
          })
          .catch(error => {
            console.error('There was a problem adding the task:', error);
          });
      }
      todoList.addEventListener("click", function(event) {
        if (event.target.tagName === "SPAN") {
          const taskId = event.target.parentElement.getAttribute("data-task-id");
          console.log(taskId); // Debugging
          deleteTask(taskId);
        }
      }, false);

      function deleteTask(taskId) {
        const patientId = getPatientIDFromURL();
        if (!patientId) {
          alert("Patient ID not found!");
          return;
        }

        // Send AJAX request to delete task from database
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `delete_task.php?task_id=${taskId}`);
        xhr.onload = function() {
          if (xhr.status === 200) {
            // Task deleted successfully
            alert("Task deleted successfully");
            // Refresh the page
            location.reload();
          } else {
            console.error('Error deleting task:', xhr.statusText);
            // Display error message in alert
            alert("Error deleting task. Please try again.");
          }
        };
        xhr.send();
      }

      function saveTask(phase, task) {
        const patientID = getPatientIDFromURL();
        if (!patientID) {
          alert("Patient ID not found!");
          return;
        }

        // Send AJAX request to save task
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `save_task.php?showid=${patientID}&phase=${phase}&task=${task}`);
        xhr.onload = function() {
          if (xhr.status === 200) {
            console.log(xhr.responseText);
          } else {
            console.error('Error saving task:', xhr.statusText);
          }
        };
        xhr.send();
      }

      function loadTasks() {
        const patientID = getPatientIDFromURL();
        const patientName = getPatientNameFromURL(); // Add this line to get the patient name
        if (!patientID || !patientName) {
          alert("Patient ID or name not found!");
          return;
        }

        // Send AJAX request to load tasks
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `load_task.php?showid=${patientID}`);
        xhr.onload = function() {
          if (xhr.status === 200) {
            todoList.innerHTML = xhr.responseText;
          } else {
            console.error('Error loading tasks:', xhr.statusText);
          }
        };
        xhr.send();
      }

      function getPatientIDFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('showid');
      }

      function getPatientNameFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('showname');
      }

      loadTasks();
    </script>
    <div class="header-text">
      <section id="reminder-section" class="welcome-section">
        <h1>Legends</h1>
      </section>
    </div>
    <div class="box-chart">
      <div class="row-chart">
        <div class="container-table">
          <table>
            <tr>
              <th>Legends</th>
              <th>Condition</th>
              <th>Restoration and Prosthetics</th>
              <th>Surgery</th>
            </tr>
            <tr>
              <td></td>
              <td><b>✓</b> Present Teeth</td>
              <td><b>AM</b> Amaigam Filling</td>
              <td><b>X</b> Extraction Due to Caries</td>
            </tr>
            <tr>
              <td></td>
              <td><b>D</b> Decayed (D1, D2, D3, D4, D5)</td>
              <td><b>CO</b> Composite Filling</td>
              <td><b>XO</b> Extraction Due to Other Causes</td>
            </tr>
            <tr>
              <td></td>
              <td><b>M</b> Missing Due to Caries</td>
              <td><b>JC</b> Jacket Crown</td>
            </tr>
            <tr>
              <td></td>
              <td><b>MO</b> Missing due to other causes</td>
              <td><b>Ab</b> Abutment</td>
            </tr>
            <tr>
              <td></td>
              <td><b>IM</b> Impacted Tooth</td>
              <td><b>Att</b> Attachment</td>
            </tr>
            <tr>
              <td></td>
              <td><b>Sp</b> Supernumerary Tooth</td>
              <td><b>P</b> Pontic</td>
            </tr>
            <tr>
              <td></td>
              <td><b>Rf</b> Root Fragment</td>
              <td><b>In</b> Inlay</td>
            </tr>
            <tr>
              <td></td>
              <td><b>Un</b> Unerupted</td>
              <td><b>Imp</b> Implant</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td><b>S</b> Sealants</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td><b>Rm</b> Removable Denture </td>
            </tr>
          </table>
        </div>
      </div>
      <!---------end-of-pending booking---------->

    </div>
    <script>
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
    </script>
</body>

</html>