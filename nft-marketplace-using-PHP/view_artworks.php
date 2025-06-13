<?php
include "db.php";
include "header.php";

// Handle enable/disable and edit actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_status']) && isset($_POST['artwork_id'])) {
        $artworkId = intval($_POST['artwork_id']);
        $currentStatus = $_POST['current_status'] === 'active' ? 'disabled' : 'active';

        $stmt = $pdo->prepare("UPDATE artwork SET Status = ? WHERE Artwork_ID = ?");
        $stmt->execute([$currentStatus, $artworkId]);
        $_SESSION['message'] = "Artwork status updated.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['edit_artwork'])) {
        $artworkId = intval($_POST['artwork_id']);
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = floatval($_POST['price']);
        $artistId = intval($_POST['artist_id']);

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $tmpName = $_FILES['photo']['tmp_name'];
            $filename = basename($_FILES['photo']['name']);
            $targetFile = $uploadDir . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
            move_uploaded_file($tmpName, $targetFile);

            $stmt = $pdo->prepare("UPDATE artwork SET Title = ?, Description = ?, Price = ?, Photo = ?, Artist_ID = ? WHERE Artwork_ID = ?");
            $stmt->execute([$title, $description, $price, $targetFile, $artistId, $artworkId]);
        } else {
            $stmt = $pdo->prepare("UPDATE artwork SET Title = ?, Description = ?, Price = ?, Artist_ID = ? WHERE Artwork_ID = ?");
            $stmt->execute([$title, $description, $price, $artistId, $artworkId]);
        }

        $_SESSION['message'] = "Artwork updated successfully.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch all artists
$artistStmt = $pdo->query("SELECT Artist_ID, Name FROM artist ORDER BY Name ASC");
$allArtists = $artistStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle search and filter
$searchTerm = $_GET['search'] ?? '';
$statusFilter = $_GET['status'] ?? 'all';

$query = "
    SELECT a.*, ar.Name AS ArtistName,
           COALESCE(nft.Is_Paid, 0) AS Is_Paid
    FROM artwork a
    JOIN artist ar ON a.Artist_ID = ar.Artist_ID
    LEFT JOIN nft ON a.Artwork_ID = nft.Artwork_ID
    WHERE 1
";

$params = [];

if (!empty($searchTerm)) {
    $query .= " AND (a.Title LIKE ? OR a.Description LIKE ? OR ar.Name LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}

if ($statusFilter === 'active') {
    $query .= " AND a.Status = 'active'";
} elseif ($statusFilter === 'disabled') {
    $query .= " AND a.Status = 'disabled'";
}

$query .= " ORDER BY a.Created_At DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$artworks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="./css/view_artworks.css">

<div class="container my-5" style="color: var(--color-text-light);">
    <h2 class="mb-4 text-center" style="color: var(--color-secondary); font-weight: 700;">Explore NFT Artworks</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success" style="background-color: var(--color-card-bg); color: var(--color-text-light); border-radius: 8px;">
            <?= htmlspecialchars($_SESSION['message']);
            unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <div class="row mb-4 g-2">
        <div class="col-md-6">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search title, description, or artist"
                    value="<?= htmlspecialchars($searchTerm) ?>"
                    style="border-color: var(--color-secondary); color: var(--color-text-light); background: var(--color-card-bg);">
                <button class="btn" type="submit"
                    style="background-color: var(--color-secondary); color: var(--color-text-light); font-weight: 600; border:none;">Search</button>
            </form>
        </div>

        <div class="col-md-4">
            <form method="GET" id="statusForm">
                <input type="hidden" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
                <select name="status" class="form-select" onchange="document.getElementById('statusForm').submit()"
                    style="border-color: var(--color-secondary); background: var(--color-card-bg); color: var(--color-text-light); font-weight: 600;">
                    <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All Statuses</option>
                    <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Enabled</option>
                    <option value="disabled" <?= $statusFilter === 'disabled' ? 'selected' : '' ?>>Disabled</option>
                </select>
            </form>
        </div>
    </div>

    <?php if (count($artworks) === 0): ?>
        <div class="alert alert-info" style="background-color: var(--color-card-bg); color: var(--color-text-muted); border-radius: 8px;">
            No artworks found.
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach ($artworks as $art): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm" style="background-color: var(--color-card-bg); color: var(--color-text-light); border-radius: 12px;">
                    <img src="<?= htmlspecialchars($art['Photo']) ?>" class="card-img-top"
                        alt="<?= htmlspecialchars($art['Title']) ?>" style="height: 250px; object-fit: cover; border-radius: 12px 12px 0 0;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color: var(--color-secondary); font-weight: 700;"><?= htmlspecialchars($art['Title']) ?></h5>
                        <p class="card-text text-muted" style="color: var(--color-text-muted);">By: <?= htmlspecialchars($art['ArtistName']) ?></p>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars($art['Description']) ?></p>
                        <p class="fw-bold text-success" style="color: var(--color-primary);">$<?= number_format($art['Price'], 2) ?></p>

                        <p>
                            <?php if (!empty($art['Is_Paid']) && $art['Is_Paid'] == 1): ?>
                                <span class="badge bg-danger"
                                    style=" font-weight: 600; font-size: 0.9rem; padding: 0.4em 0.7em;">
                                    Paid
                                </span>
                            <?php else: ?>
                                <span class="badge <?= $art['Status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"
                                    style="font-weight: 600; font-size: 0.9rem; padding: 0.4em 0.7em;">
                                    <?= ucfirst($art['Status']) ?>
                                </span>
                            <?php endif; ?>
                        </p>

                        <form method="POST" class="mb-3">
                            <input type="hidden" name="artwork_id" value="<?= $art['Artwork_ID'] ?>">
                            <input type="hidden" name="current_status" value="<?= $art['Status'] ?>">
                            <button type="submit" name="toggle_status" class="btn btn-sm <?= $art['Status'] === 'active' ? 'btn-warning' : 'btn-success' ?>"
                                style="font-weight: 600; width: 100%;">
                                <?= $art['Status'] === 'active' ? 'Disable' : 'Enable' ?>
                            </button>
                        </form>

                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $art['Artwork_ID'] ?>" style="font-weight: 600; width: 100%;">
                            Edit Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal<?= $art['Artwork_ID'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $art['Artwork_ID'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" enctype="multipart/form-data" class="modal-content" style="background-color: var(--color-card-bg); color: var(--color-text-light); border-radius: 12px;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel<?= $art['Artwork_ID'] ?>" style="color: var(--color-secondary); font-weight: 700;">Edit Artwork</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="artwork_id" value="<?= $art['Artwork_ID'] ?>">
                            <div class="mb-3">
                                <label for="title<?= $art['Artwork_ID'] ?>" class="form-label">Title</label>
                                <input type="text" name="title" id="title<?= $art['Artwork_ID'] ?>" class="form-control" value="<?= htmlspecialchars($art['Title']) ?>" required style="background: var(--color-card-bg); color: var(--color-text-light); border-color: var(--color-secondary);">
                            </div>
                            <div class="mb-3">
                                <label for="description<?= $art['Artwork_ID'] ?>" class="form-label">Description</label>
                                <textarea name="description" id="description<?= $art['Artwork_ID'] ?>" class="form-control" required style="background: var(--color-card-bg); color: var(--color-text-light); border-color: var(--color-secondary);"><?= htmlspecialchars($art['Description']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price<?= $art['Artwork_ID'] ?>" class="form-label">Price</label>
                                <input type="number" name="price" id="price<?= $art['Artwork_ID'] ?>" class="form-control" value="<?= htmlspecialchars($art['Price']) ?>" step="0.01" required style="background: var(--color-card-bg); color: var(--color-text-light); border-color: var(--color-secondary);">
                            </div>
                            <div class="mb-3">
                                <label for="artist<?= $art['Artwork_ID'] ?>" class="form-label">Artist</label>
                                <select name="artist_id" id="artist<?= $art['Artwork_ID'] ?>" class="form-select" required style="background: var(--color-card-bg); color: var(--color-text-light); border-color: var(--color-secondary);">
                                    <?php foreach ($allArtists as $artist): ?>
                                        <option value="<?= $artist['Artist_ID'] ?>" <?= $artist['Artist_ID'] == $art['Artist_ID'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($artist['Name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="photo<?= $art['Artwork_ID'] ?>" class="form-label">Change Photo</label>
                                <input type="file" name="photo" id="photo<?= $art['Artwork_ID'] ?>" class="form-control" accept="image/*" style="background: var(--color-card-bg); color: var(--color-text-light); border-color: var(--color-secondary);">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="edit_artwork" class="btn btn-success" style="font-weight: 600;">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-weight: 600;">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>