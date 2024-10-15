<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection parameters
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'gcuems_db';

// Attempt to establish a connection to the database
$con = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
// if (!$con) {
//     echo 'Please check your Database connection';
// } else {
//     echo 'Connection Successful';
// }

// Now you can use the $con variable to perform database operations.
// For example, you can run queries like mysqli_query($con, "SELECT * FROM your_table");
