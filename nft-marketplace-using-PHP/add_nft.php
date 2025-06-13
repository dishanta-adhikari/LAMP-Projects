<?php
session_start();
include "db.php";

// Only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login");
    exit;
}

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $artist_id = $_POST['artist_id'];
    $photo_path = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $photo_path = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photo_path);
    }

    if ($title && $price && $artist_id && $photo_path) {
        $stmt = $pdo->prepare("INSERT INTO artwork (Title, Price, Photo, Description, Artist_ID) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $price, $photo_path, $description, $artist_id]);
        $success = "NFT artwork added successfully.";
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<?php include "header.php"; ?>
<link rel="stylesheet" href="./css/add_nft.css">


<div class="container my-5">
    <h2>Add New NFT Artwork</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="card shadow-sm">
        <div class="mb-3">
            <label class="form-label" for="title">Title *</label>
            <input type="text" id="title" name="title" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label" for="price">Price (USD) *</label>
            <input type="number" id="price" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="photo">Artwork Image *</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">Description</label>
            <textarea id="description" name="description" rows="3" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="artist_id">Select Artist *</label>
            <select id="artist_id" name="artist_id" class="form-select" required>
                <option value="">-- Select Artist --</option>
                <?php
                $artists = $pdo->query("SELECT * FROM artist")->fetchAll();
                foreach ($artists as $artist) {
                    echo "<option value=\"" . htmlspecialchars($artist['Artist_ID']) . "\">" . htmlspecialchars($artist['Name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Add NFT</button>
    </form>
</div>

<?php include "footer.php"; ?>