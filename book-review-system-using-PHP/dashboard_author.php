<?php
include 'conn.php';
session_start();

if (!isset($_SESSION['author_id'])) {
    header("Location: login_author");
    exit();
}

$author_id = (int)$_SESSION['author_id'];
$alert = "";

// Handle Delete Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_book_id'])) {
    $book_id = (int)$_POST['delete_book_id'];
    $input_password = $_POST['confirm_password'];

    // Fetch the author's password
    $auth_sql = "SELECT password FROM authors WHERE id = $author_id LIMIT 1";
    $auth_result = $conn->query($auth_sql);
    $author = $auth_result->fetch_assoc();

    if ($author && $author['password'] === $input_password) {
        // Delete the book
        $conn->query("DELETE FROM books WHERE id = $book_id AND author_id = $author_id");
        $alert = "<div class='alert alert-success text-center'>Book deleted successfully.</div>";
    } else {
        $alert = "<div class='alert alert-danger text-center'>Invalid password. Book not deleted.</div>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Author Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" crossorigin="anonymous" />
</head>

<body>
    <header class="bg-dark text-white text-center py-3 mb-4">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['author_name']); ?>!</h2>
        <div class="mt-2">
            <a href="add_book" class="btn btn-success btn-sm me-2">Add New Book</a>
            <a href="logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </header>

    <main class="container">
        <?php echo $alert; ?>

        <h4 class="mb-4">Books Added by You</h4>
        <div class="row">
            <?php
            $sql = "SELECT id, name, vol, img, pdf FROM books WHERE author_id = $author_id ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($book = $result->fetch_assoc()) {
                    $book_id = $book["id"];
                    $coverImage = !empty($book["img"]) ? 'uploads/' . htmlspecialchars($book["img"]) : 'https://via.placeholder.com/300x180?text=No+Image';
                    $pdfLink = !empty($book["pdf"]) ? 'uploads/' . htmlspecialchars($book["pdf"]) : '';

                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100 d-flex flex-column">
                            <img src="' . $coverImage . '" class="card-img-top" style="height: 250px; object-fit: cover;" alt="Book Cover">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($book["name"]) . '</h5>
                                <p class="card-text">Volume: ' . htmlspecialchars($book["vol"]) . '</p>';

                    if ($pdfLink) {
                        echo '
                                <div class="mb-2">
                                    <a href="' . $pdfLink . '" target="_blank" class="btn btn-sm btn-outline-primary">Read Online</a>
                                    <a href="' . $pdfLink . '" download class="btn btn-sm btn-outline-success">Download PDF</a>
                                </div>';
                    }

                    // Show Reviews Button
                    echo '
                                <button class="btn btn-sm btn-outline-secondary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#reviews' . $book_id . '">
                                    Show Reviews
                                </button>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal' . $book_id . '">
                                    Delete Book
                                </button>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal' . $book_id . '" tabindex="-1" aria-labelledby="deleteModalLabel' . $book_id . '" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel' . $book_id . '">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the book "<strong>' . htmlspecialchars($book["name"]) . '</strong>"?</p>
                                                <div class="mb-3">
                                                    <label for="confirm_password' . $book_id . '" class="form-label">Enter your password to confirm:</label>
                                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password' . $book_id . '" required>
                                                    <input type="hidden" name="delete_book_id" value="' . $book_id . '">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete Book</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="collapse mt-3" id="reviews' . $book_id . '">
                                    <h6>Recent Reviews:</h6>';

                    $review_sql = "SELECT * FROM reviews WHERE book_id = $book_id ORDER BY created_at DESC LIMIT 3";
                    $reviews = $conn->query($review_sql);

                    if ($reviews && $reviews->num_rows > 0) {
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

                    echo '</div> <!-- End Collapse -->
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12"><p>You haven\'t added any books yet.</p></div>';
            }
            ?>
        </div>
    </main>

    <footer class="bg-light text-center py-3 mt-4">
        &copy; <?php echo date("Y"); ?> Book Review System (BRS)
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>