<?php
include 'conn.php';

$showSuccessModal = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $book_id = $_POST["book_id"];
    $user_name = $_POST["user_name"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    $stmt = $conn->prepare("INSERT INTO reviews (book_id, user_name, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $book_id, $user_name, $rating, $comment);

    if ($stmt->execute()) {
        $showSuccessModal = true;
    }

    $stmt->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Books Library</title>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" crossorigin="anonymous" />
</head>

<body>
    <header class="bg-dark text-white text-center py-3 mb-4">
        <h1>Books Library</h1>
        <div class="mt-2">
            <a href="login_user" class="btn btn-outline-light btn-sm me-2">User Login</a>
            <a href="login_author" class="btn btn-outline-light btn-sm me-2">Author Login</a>
        </div>
    </header>

    <main class="container">
        <div class="row">
            <?php
            $sql = "SELECT books.id, books.name AS book_name, books.vol, books.img, authors.name AS author_name, books.pdf
                    FROM books
                    JOIN authors ON books.author_id = authors.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $book_id = $row["id"];
                    $coverImage = !empty($row["img"]) ? 'uploads/' . htmlspecialchars($row["img"]) : 'https://via.placeholder.com/300x180?text=No+Image';

                    echo '
                    <div class="col-md-4 mb-4" id="book' . $book_id . '">
                        <div class="card shadow h-100 d-flex flex-column">
                            <img src="' . $coverImage . '" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Book Cover">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row["book_name"]) . '</h5>
                                <h6 class="card-subtitle mb-2 text-muted">by ' . htmlspecialchars($row["author_name"]) . '</h6>
                                <p class="card-text">Volume: ' . htmlspecialchars($row["vol"]) . '</p>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#readModal' . $book_id . '">Read Online</button>
                                    <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#readModal' . $book_id . '">Download PDF</button>
                                </div>

                                <!-- Review Form -->
                                <form action="" method="post" class="mt-3">
                                    <input type="hidden" name="book_id" value="' . $book_id . '">
                                    <div class="mb-2">
                                        <input type="text" name="user_name" class="form-control" placeholder="Your Name" required>
                                    </div>
                                    <div class="mb-2">
                                        <select name="rating" class="form-select" required>
                                            <option value="">Rating</option>
                                            <option value="5">★★★★★</option>
                                            <option value="4">★★★★☆</option>
                                            <option value="3">★★★☆☆</option>
                                            <option value="2">★★☆☆☆</option>
                                            <option value="1">★☆☆☆☆</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="comment" class="form-control" placeholder="Write a review..." rows="2" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Submit Review</button>
                                </form>

                                <!-- Show Reviews -->
                                <button class="btn btn-outline-secondary btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#reviews' . $book_id . '">
                                    Show Reviews
                                </button>
                                <div class="collapse mt-3" id="reviews' . $book_id . '">
                                    <h6>Recent Reviews:</h6>';

                    $review_sql = "SELECT * FROM reviews WHERE book_id = $book_id ORDER BY created_at DESC LIMIT 3";
                    $reviews = $conn->query($review_sql);

                    if ($reviews->num_rows > 0) {
                        while ($review = $reviews->fetch_assoc()) {
                            echo '
                                <div class="border rounded p-2 mb-2">
                                    <strong>' . htmlspecialchars($review["user_name"]) . '</strong>
                                    <span class="text-warning">' . str_repeat("★", $review["rating"]) . str_repeat("☆", 5 - $review["rating"]) . '</span><br>
                                    <small>' . htmlspecialchars($review["comment"]) . '</small>
                                </div>';
                        }
                    } else {
                        echo '<p class="text-muted">No reviews yet.</p>';
                    }

                    echo '
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Login Modal -->
                    <div class="modal fade" id="readModal' . $book_id . '" tabindex="-1" aria-labelledby="readModalLabel' . $book_id . '" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title" id="readModalLabel' . $book_id . '">Login Required</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Please login to access reading or downloading this book.
                                </div>
                                <div class="modal-footer">
                                    <a href="login_user?message=Please+login+to+read&book_id=' . $book_id . '" class="btn btn-primary">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center"><p>No books found.</p></div>';
            }
            ?>
        </div>
    </main>

    <footer class="bg-light text-center py-3 mt-4">
        &copy; <?php echo date("Y"); ?> BRS
    </footer>

    <!-- Success Modal -->
    <div class="modal fade" id="reviewSuccessModal" tabindex="-1" aria-labelledby="reviewSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="reviewSuccessModalLabel">Review Submitted</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ✅ Thank you! Your review has been successfully submitted.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <?php if ($showSuccessModal): ?>
        <script>
            var successModal = new bootstrap.Modal(document.getElementById('reviewSuccessModal'));
            window.addEventListener('load', function() {
                successModal.show();
            });
        </script>
    <?php endif; ?>
</body>

</html>