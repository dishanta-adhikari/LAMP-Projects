<?php
include 'conn.php';
session_start();

if (!isset($_SESSION['author_id'])) {
    header("Location: login_author");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $vol = $_POST['vol'];
    $author_id = $_SESSION['author_id'];

    // Handle file uploads
    $img_name = $_FILES['cover']['name'];
    $pdf_name = $_FILES['pdf']['name'];

    $img_tmp = $_FILES['cover']['tmp_name'];
    $pdf_tmp = $_FILES['pdf']['tmp_name'];

    $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    $pdf_ext = strtolower(pathinfo($pdf_name, PATHINFO_EXTENSION));

    $allowed_img = ['jpg', 'jpeg', 'png'];
    $allowed_pdf = ['pdf'];

    if (in_array($img_ext, $allowed_img) && in_array($pdf_ext, $allowed_pdf)) {
        $img_new = uniqid() . '.' . $img_ext;
        $pdf_new = uniqid() . '.' . $pdf_ext;

        move_uploaded_file($img_tmp, "uploads/$img_new");
        move_uploaded_file($pdf_tmp, "uploads/$pdf_new");

        $stmt = $conn->prepare("INSERT INTO books (name, vol, author_id, img, pdf) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiss", $name, $vol, $author_id, $img_new, $pdf_new);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'></div>";
            echo "<div class='alert alert-success'>Book added successfully! Redirecting...</div>";
            header("refresh:1;url=dashboard_author");
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Invalid file type. Upload JPG/PNG for image and PDF only.</div>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Add Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 card shadow p-4">
        <h2 class="mb-4">Add New Book</h2>

        <?php echo $message; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Book Name</label>
                <input type="text" name="name" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>Volume</label>
                <input type="number" name="vol" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>Cover Image (JPG/PNG)</label>
                <input type="file" name="cover" class="form-control" accept="image/*" required />
            </div>

            <div class="mb-3">
                <label>Book PDF</label>
                <input type="file" name="pdf" class="form-control" accept="application/pdf" required />
            </div>

            <button class="btn btn-primary">Add Book</button>
        </form>
    </div>
</body>

</html>