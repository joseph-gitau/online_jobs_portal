<?php
// database connection file
$server = "Localhost";
$username = "root";
$password = "";
$dbname = "online_jobs_portal";

// Create connection
$conn = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
