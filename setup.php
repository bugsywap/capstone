<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dskafagway";

// Create connection
$con = new mysqli($servername, $username, $password);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating database: " . $con->error . "\n";
}

// Switch to the created database
$con->select_db("$dbname");


$sql = "CREATE TABLE IF NOT EXISTS logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username TEXT NOT NULL,
    password VARCHAR(255) NOT NULL
     
)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}
$sql = "CREATE TABLE IF NOT EXISTS todo_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    phase VARCHAR(50),
    task TEXT,
    datetime DATETIME
)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}
// Create Patient table
$sql = "CREATE TABLE IF NOT EXISTS patientList (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    gender TEXT NOT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT NOT NULL,
    religion TEXT NOT NULL,
    occupation TEXT NOT NULL,
    status VARCHAR(255) NOT NULL,
    service VARCHAR(255) NOT NULL,
    schedule DATETIME NOT NULL,
    visit varchar(255) NOT NULL,
    history varchar(255) NOT NULL,
    feedback VARCHAR (255) NOT NULL

)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}

// Create Patient table
$sql = "CREATE TABLE IF NOT EXISTS patientApt (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    gender TEXT NOT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT NOT NULL,
    religion TEXT NOT NULL,
    occupation TEXT NOT NULL,
    status VARCHAR(255) NOT NULL,
    service VARCHAR(255) NOT NULL,
    schedule DATETIME NOT NULL,
    visit varchar(255) NOT NULL,
    history varchar(255) NOT NULL,
    feedback VARCHAR (255) NOT NULL
)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}

$sql = "CREATE TABLE IF NOT EXISTS patientBooking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    gender TEXT NOT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT NOT NULL,
    religion TEXT NOT NULL,
    occupation TEXT NOT NULL,
    status VARCHAR(255) NOT NULL,
    service VARCHAR(255) NOT NULL,
    schedule DATETIME NOT NULL,
    visit varchar(255) NOT NULL,
    history varchar(255) NOT NULL,
    feedback VARCHAR (255) NOT NULL
)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}


$sql = "CREATE TABLE IF NOT EXISTS patientResched (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    gender TEXT NOT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT NOT NULL,
    religion TEXT NOT NULL,
    occupation TEXT NOT NULL,
    status VARCHAR(255) NOT NULL,
    service VARCHAR(255) NOT NULL,
    schedule DATETIME NOT NULL,
    visit varchar(255) NOT NULL,
    history varchar(255) NOT NULL,
    feedback VARCHAR (255) NOT NULL
)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}

$sql = "CREATE TABLE IF NOT EXISTS patientArchive (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    gender TEXT NOT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT NOT NULL,
    religion TEXT NOT NULL,
    occupation TEXT NOT NULL,
    status VARCHAR(255) NOT NULL,
    service VARCHAR(255) NOT NULL,
    schedule DATETIME NOT NULL,
    visit varchar(255) NOT NULL,
    history varchar(255) NOT NULL,
    feedback VARCHAR (255) NOT NULL
)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}
$sql = "CREATE TABLE IF NOT EXISTS historyQuestions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    mobileNo TEXT NOT NULL,
    q1 TEXT NOT NULL,
    q2 VARCHAR(255) NOT NULL,
    q3 VARCHAR(255) NOT NULL,
    q4 VARCHAR(255) NOT NULL,
    q5 VARCHAR(255) NOT NULL,
    q6 VARCHAR(255) NOT NULL,
    q7 VARCHAR(255) NOT NULL,
    q8 VARCHAR(255) NOT NULL,
    q9 VARCHAR(255) NOT NULL,
    q101 VARCHAR(255) NOT NULL,
    q102 VARCHAR(255) NOT NULL,
    q103 VARCHAR(255) NOT NULL,
    q11 VARCHAR(255) NOT NULL,
    q12 VARCHAR(255) NOT NULL

)";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}


$sql = "CREATE TABLE IF NOT EXISTS dChartTable (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tt55 TEXT NOT NULL,pt55 TEXT NOT NULL,
        tt54 TEXT NOT NULL,pt54 TEXT NOT NULL,
        tt53 TEXT NOT NULL,pt53 TEXT NOT NULL,
        tt52 TEXT NOT NULL,pt52 TEXT NOT NULL,
        tt51 TEXT NOT NULL,pt51 TEXT NOT NULL,
        tt61 TEXT NOT NULL,pt61 TEXT NOT NULL,
        tt62 TEXT NOT NULL,pt62 TEXT NOT NULL,
        tt63 TEXT NOT NULL,pt63 TEXT NOT NULL,
        tt64 TEXT NOT NULL,pt64 TEXT NOT NULL,
        tt65 TEXT NOT NULL,pt65 TEXT NOT NULL,
        tt18 TEXT NOT NULL,pt18 TEXT NOT NULL,
        tt17 TEXT NOT NULL,pt17 TEXT NOT NULL,
        tt16 TEXT NOT NULL,pt16 TEXT NOT NULL,
        tt15 TEXT NOT NULL,pt15 TEXT NOT NULL,
        tt14 TEXT NOT NULL,pt14 TEXT NOT NULL,
        tt13 TEXT NOT NULL,pt13 TEXT NOT NULL,
        tt12 TEXT NOT NULL,pt12 TEXT NOT NULL,
        tt11 TEXT NOT NULL,pt11 TEXT NOT NULL,
        tt21 TEXT NOT NULL,pt21 TEXT NOT NULL,
        tt22 TEXT NOT NULL,pt22 TEXT NOT NULL,
        tt23 TEXT NOT NULL,pt23 TEXT NOT NULL,
        tt24 TEXT NOT NULL,pt24 TEXT NOT NULL,
        tt25 TEXT NOT NULL,pt25 TEXT NOT NULL,
        tt26 TEXT NOT NULL,pt26 TEXT NOT NULL,
        tt27 TEXT NOT NULL,pt27 TEXT NOT NULL,
        tt28 TEXT NOT NULL,pt28 TEXT NOT NULL,
        tt48 TEXT NOT NULL,pt48 TEXT NOT NULL,
        tt47 TEXT NOT NULL,pt47 TEXT NOT NULL,
        tt46 TEXT NOT NULL,pt46 TEXT NOT NULL,
        tt45 TEXT NOT NULL,pt45 TEXT NOT NULL,
        tt44 TEXT NOT NULL,pt44 TEXT NOT NULL,
        tt43 TEXT NOT NULL,pt43 TEXT NOT NULL,
        tt42 TEXT NOT NULL,pt42 TEXT NOT NULL,
        tt41 TEXT NOT NULL,pt41 TEXT NOT NULL,
        tt31 TEXT NOT NULL,pt31 TEXT NOT NULL,
        tt32 TEXT NOT NULL,pt32 TEXT NOT NULL,
        tt33 TEXT NOT NULL,pt33 TEXT NOT NULL,
        tt34 TEXT NOT NULL,pt34 TEXT NOT NULL,
        tt35 TEXT NOT NULL,pt35 TEXT NOT NULL,
        tt36 TEXT NOT NULL,pt36 TEXT NOT NULL,
        tt37 TEXT NOT NULL,pt37 TEXT NOT NULL,
        tt38 TEXT NOT NULL,pt38 TEXT NOT NULL,
        tt85 TEXT NOT NULL,pt85 TEXT NOT NULL,
        tt84 TEXT NOT NULL,pt84 TEXT NOT NULL,
        tt83 TEXT NOT NULL,pt83 TEXT NOT NULL,
        tt82 TEXT NOT NULL,pt82 TEXT NOT NULL,
        tt81 TEXT NOT NULL,pt81 TEXT NOT NULL,
        tt71 TEXT NOT NULL,pt71 TEXT NOT NULL,
        tt72 TEXT NOT NULL,pt72 TEXT NOT NULL,
        tt73 TEXT NOT NULL,pt73 TEXT NOT NULL,
        tt74 TEXT NOT NULL,pt74 TEXT NOT NULL,
        tt75 TEXT NOT NULL,pt75 TEXT NOT NULL
    )";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}


// Close connection
$con->close();
