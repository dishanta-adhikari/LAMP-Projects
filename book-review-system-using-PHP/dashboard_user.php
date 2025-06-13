<?php
include 'conn.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login_user");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>User Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>

<body>
    <header class="bg-dark text-white text-center py-3 mb-4">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        <div class="mt-2">
            <a href="logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </header>

    <main class="container">
        <div class="row">
            <?php
            $sql = "SELECT books.id, books.name AS book_name, books.vol, books.img, books.pdf, authors.name AS author_name
                    FROM books
                    JOIN authors ON books.author_id = authors.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $book_id = $row["id"];
                    $book_name = htmlspecialchars($row["book_name"]);
                    $author_name = htmlspecialchars($row["author_name"]);
                    $volume = htmlspecialchars($row["vol"]);
                    $coverImage = !empty($row["img"]) ? 'uploads/' . htmlspecialchars($row["img"]) : 'https://via.placeholder.com/300x180?text=No+Image';
                    $pdfLink = !empty($row["pdf"]) ? 'uploads/' . htmlspecialchars($row["pdf"]) : '';

                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100 d-flex flex-column">
                            <img src="' . $coverImage . '" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Book Cover">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">' . $book_name . '</h5>
                                <h6 class="card-subtitle mb-2 text-muted">by ' . $author_name . '</h6>
                                <p class="card-text">Volume: ' . $volume . '</p>';

                    if ($pdfLink) {
                        echo '
                                <div class="d-grid gap-2 mb-3">
                                    <a href="' . $pdfLink . '" class="btn btn-outline-primary btn-sm" target="_blank">Read Online</a>
                                    <a href="' . $pdfLink . '" class="btn btn-outline-success btn-sm" download>Download PDF</a>
                                </div>';
                    }

                    echo '
                                <button class="btn btn-outline-secondary btn-sm mt-auto" type="button" data-bs-toggle="collapse" data-bs-target="#expand' . $book_id . '">
                                    Show More
                                </button>

                                <div class="collapse mt-3" id="expand' . $book_id . '">
                                    <form class="review-form" data-book-id="' . $book_id . '">
                                        <input type="hidden" name="book_id" value="' . $book_id . '">
                                        <input type="hidden" name="user_name" value="' . htmlspecialchars($_SESSION['user_name']) . '">
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

                                    <h6 class="mt-3">Recent Reviews:</h6>';

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
                    </div>';
                }
            } else {
                echo '<div class="col-12"><p>No books available.</p></div>';
            }
            ?>
        </div>
    </main>

    <footer class="bg-light text-center py-3 mt-4">
        &copy; <?php echo date("Y"); ?> Book Review System (BRS)
    </footer>

    <!-- Review Success Modal -->
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

    <!-- JS scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        document.querySelectorAll('.review-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch('submit_review', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        const modal = new bootstrap.Modal(document.getElementById('reviewSuccessModal'));
                        modal.show();
                        form.reset();
                    })
                    .catch(error => {
                        alert('Error submitting review');
                        console.error(error);
                    });
            });
        });
    </script>
</body>

</html>