<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["booking_id"])) {
    $booking_id = (int)$_POST["booking_id"];

    $stmt = mysqli_prepare($conn, "DELETE FROM bookings WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $booking_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Booking deleted! Refund will be processed within 3 working days.";
        $note = "Booking ID $booking_id was cancelled by customer ID $user_id.";
        mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$note')");
    } else {
        $_SESSION['msg'] = "Error deleting booking.";
    }
}

header("Location: dashboard");
exit();
