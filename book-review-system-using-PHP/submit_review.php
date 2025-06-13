<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $book_id = $_POST["book_id"];
    $user_name = $_POST["user_name"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    $stmt = $conn->prepare("INSERT INTO reviews (book_id, user_name, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $book_id, $user_name, $rating, $comment);

    if ($stmt->execute()) {
        // Redirect back with success message and anchor to book card
        header("Location: index?review_submitted=1#book$book_id");
        exit();
    } else {
        echo "Error submitting review.";
    }

    $stmt->close();
}
