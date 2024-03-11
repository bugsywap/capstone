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
    username TEXT DEFAULT NULL,
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
    name TEXT DEFAULT NULL,
    gender TEXT DEFAULT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT DEFAULT NULL,
    religion TEXT DEFAULT NULL,
    occupation TEXT DEFAULT NULL,
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
    name TEXT DEFAULT NULL,
    gender TEXT DEFAULT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT DEFAULT NULL,
    religion TEXT DEFAULT NULL,
    occupation TEXT DEFAULT NULL,
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
    name TEXT DEFAULT NULL,
    gender TEXT DEFAULT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT DEFAULT NULL,
    religion TEXT DEFAULT NULL,
    occupation TEXT DEFAULT NULL,
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
    name TEXT DEFAULT NULL,
    gender TEXT DEFAULT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT DEFAULT NULL,
    religion TEXT DEFAULT NULL,
    occupation TEXT DEFAULT NULL,
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
    name TEXT DEFAULT NULL,
    gender TEXT DEFAULT NULL,
    doctor VARCHAR(255) NOT NULL,
    dateOfBirth DATE NOT NULL,
    address VARCHAR(250) NOT NULL,
    link VARCHAR(255) NOT NULL,
    mobileNo TEXT DEFAULT NULL,
    religion TEXT DEFAULT NULL,
    occupation TEXT DEFAULT NULL,
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
    name TEXT DEFAULT NULL,
    mobileNo TEXT DEFAULT NULL,
    q1 TEXT DEFAULT NULL,
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
        tt55 TEXT DEFAULT NULL,pt55 TEXT DEFAULT NULL,
        tt54 TEXT DEFAULT NULL,pt54 TEXT DEFAULT NULL,
        tt53 TEXT DEFAULT NULL,pt53 TEXT DEFAULT NULL,
        tt52 TEXT DEFAULT NULL,pt52 TEXT DEFAULT NULL,
        tt51 TEXT DEFAULT NULL,pt51 TEXT DEFAULT NULL,
        tt61 TEXT DEFAULT NULL,pt61 TEXT DEFAULT NULL,
        tt62 TEXT DEFAULT NULL,pt62 TEXT DEFAULT NULL,
        tt63 TEXT DEFAULT NULL,pt63 TEXT DEFAULT NULL,
        tt64 TEXT DEFAULT NULL,pt64 TEXT DEFAULT NULL,
        tt65 TEXT DEFAULT NULL,pt65 TEXT DEFAULT NULL,
        tt18 TEXT DEFAULT NULL,pt18 TEXT DEFAULT NULL,
        tt17 TEXT DEFAULT NULL,pt17 TEXT DEFAULT NULL,
        tt16 TEXT DEFAULT NULL,pt16 TEXT DEFAULT NULL,
        tt15 TEXT DEFAULT NULL,pt15 TEXT DEFAULT NULL,
        tt14 TEXT DEFAULT NULL,pt14 TEXT DEFAULT NULL,
        tt13 TEXT DEFAULT NULL,pt13 TEXT DEFAULT NULL,
        tt12 TEXT DEFAULT NULL,pt12 TEXT DEFAULT NULL,
        tt11 TEXT DEFAULT NULL,pt11 TEXT DEFAULT NULL,
        tt21 TEXT DEFAULT NULL,pt21 TEXT DEFAULT NULL,
        tt22 TEXT DEFAULT NULL,pt22 TEXT DEFAULT NULL,
        tt23 TEXT DEFAULT NULL,pt23 TEXT DEFAULT NULL,
        tt24 TEXT DEFAULT NULL,pt24 TEXT DEFAULT NULL,
        tt25 TEXT DEFAULT NULL,pt25 TEXT DEFAULT NULL,
        tt26 TEXT DEFAULT NULL,pt26 TEXT DEFAULT NULL,
        tt27 TEXT DEFAULT NULL,pt27 TEXT DEFAULT NULL,
        tt28 TEXT DEFAULT NULL,pt28 TEXT DEFAULT NULL,
        tt48 TEXT DEFAULT NULL,pt48 TEXT DEFAULT NULL,
        tt47 TEXT DEFAULT NULL,pt47 TEXT DEFAULT NULL,
        tt46 TEXT DEFAULT NULL,pt46 TEXT DEFAULT NULL,
        tt45 TEXT DEFAULT NULL,pt45 TEXT DEFAULT NULL,
        tt44 TEXT DEFAULT NULL,pt44 TEXT DEFAULT NULL,
        tt43 TEXT DEFAULT NULL,pt43 TEXT DEFAULT NULL,
        tt42 TEXT DEFAULT NULL,pt42 TEXT DEFAULT NULL,
        tt41 TEXT DEFAULT NULL,pt41 TEXT DEFAULT NULL,
        tt31 TEXT DEFAULT NULL,pt31 TEXT DEFAULT NULL,
        tt32 TEXT DEFAULT NULL,pt32 TEXT DEFAULT NULL,
        tt33 TEXT DEFAULT NULL,pt33 TEXT DEFAULT NULL,
        tt34 TEXT DEFAULT NULL,pt34 TEXT DEFAULT NULL,
        tt35 TEXT DEFAULT NULL,pt35 TEXT DEFAULT NULL,
        tt36 TEXT DEFAULT NULL,pt36 TEXT DEFAULT NULL,
        tt37 TEXT DEFAULT NULL,pt37 TEXT DEFAULT NULL,
        tt38 TEXT DEFAULT NULL,pt38 TEXT DEFAULT NULL,
        tt85 TEXT DEFAULT NULL,pt85 TEXT DEFAULT NULL,
        tt84 TEXT DEFAULT NULL,pt84 TEXT DEFAULT NULL,
        tt83 TEXT DEFAULT NULL,pt83 TEXT DEFAULT NULL,
        tt82 TEXT DEFAULT NULL,pt82 TEXT DEFAULT NULL,
        tt81 TEXT DEFAULT NULL,pt81 TEXT DEFAULT NULL,
        tt71 TEXT DEFAULT NULL,pt71 TEXT DEFAULT NULL,
        tt72 TEXT DEFAULT NULL,pt72 TEXT DEFAULT NULL,
        tt73 TEXT DEFAULT NULL,pt73 TEXT DEFAULT NULL,
        tt74 TEXT DEFAULT NULL,pt74 TEXT DEFAULT NULL,
        tt75 TEXT DEFAULT NULL,pt75 TEXT DEFAULT NULL
    )";

if ($con->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error creating table $dbname: " . $con->error . "\n";
}


// Close connection
$con->close();
