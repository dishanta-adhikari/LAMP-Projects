<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    $stmt = mysqli_prepare($conn, "UPDATE bookings SET pay_status = 'Paid' WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $booking_id);
    mysqli_stmt_execute($stmt);

    $_SESSION['msg'] = "Payment successful!";
}
header("Location: dashboard");
exit();
