<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

if (!isset($_GET["id"])) {
    die("Package ID missing.");
}

$package_id = (int)$_GET["id"];
$customer_id = $_SESSION["user_id"];
$date = date("Y-m-d");

// Check if already booked
$check_sql = "SELECT * FROM bookings WHERE customer_id = ? AND package_id = ?";
$check_stmt = mysqli_prepare($conn, $check_sql);
mysqli_stmt_bind_param($check_stmt, "ii", $customer_id, $package_id);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    $_SESSION['msg'] = "You have already booked this package!";
    header("Location: dashboard");
    exit();
}

// Insert new booking
$sql = "INSERT INTO bookings (customer_id, package_id, book_date, pay_status) VALUES (?, ?, ?, 'Pending')";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "iis", $customer_id, $package_id, $date);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Booking successful!";
        // After successful booking
        $note = "New booking by user ID $customer_id for package ID $package_id.";
        mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$note')");

        header("Location: dashboard");
        exit();
    } else {
        die("Error while booking: " . mysqli_stmt_error($stmt));
    }
} else {
    die("Database error: " . mysqli_error($conn));
}


