<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $booking_id = (int)$_GET['id'];
    $query = "UPDATE bookings SET pay_status='Paid' WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $booking_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "Payment marked as paid.";
    } else {
        echo "Error updating payment status.";
    }
} else {
    echo "Invalid request.";
}
