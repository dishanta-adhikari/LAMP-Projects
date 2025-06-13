<?php
session_start();
include "db.php";
include "header.php";

// Get user ID if logged in (optional, can be null)
$userID = $_SESSION['user_id'] ?? null;

// Handle search query
$search = $_GET['search'] ?? '';
$searchQuery = "%" . $search . "%";

if ($search) {
    $stmt = $pdo->prepare("SELECT a.*, ar.Name AS ArtistName 
                           FROM artwork a 
                           JOIN artist ar ON a.Artist_ID = ar.Artist_ID 
                           WHERE (a.Title LIKE ? OR a.Description LIKE ? OR ar.Name LIKE ?)
                           AND a.Status = 'active'");
    $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
} else {
    $stmt = $pdo->prepare("SELECT a.*, ar.Name AS ArtistName 
                           FROM artwork a 
                           JOIN artist ar ON a.Artist_ID = ar.Artist_ID 
                           WHERE a.Status = 'active'");
    $stmt->execute();
}
$artworks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NFT Marketplace - Artworks</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts: Poppins & Orbitron -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Poppins&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="./css/index.css">

    <style>
        .sold-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            /* Bootstrap danger red */
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            border-radius: 5px;
            font-size: 0.9rem;
            z-index: 10;
            user-select: none;
        }

        .card-img-top-wrapper {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h1>NFT Marketplace - Artworks</h1>

        <!-- Search Form -->
        <form method="GET" class="input-group mb-4" role="search" aria-label="Search artworks">
            <input type="text" name="search" class="form-control" placeholder="Search by title, artist, or description" value="<?= htmlspecialchars($search) ?>" />
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>

        <div class="row">
            <?php if (count($artworks) === 0): ?>
                <div class="col-12">
                    <div class="alert alert-warning">No artworks found for your search.</div>
                </div>
            <?php endif; ?>

            <?php foreach ($artworks as $art): ?>
                <?php
                $checkStmt = $pdo->prepare("SELECT 1 FROM nft WHERE Artwork_ID = ? AND Is_Paid = 1 LIMIT 1");
                $checkStmt->execute([$art['Artwork_ID']]);
                $isSold = $checkStmt->fetchColumn() ? true : false;
                echo "<!-- Artwork ID: {$art['Artwork_ID']} Sold? " . ($isSold ? 'YES' : 'NO') . " -->";
                ?>

                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm">
                        <img src="<?= htmlspecialchars($art['Photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($art['Title']) ?>" />
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($art['Title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($art['Description']) ?></p>
                            <p><strong>Artist:</strong> <?= htmlspecialchars($art['ArtistName']) ?></p>
                            <p><strong>Price:</strong> $<?= number_format($art['Price'], 2) ?></p>

                            <?php if ($isSold): ?>
                                <button class="btn btn-secondary w-100" disabled>Sold</button>
                            <?php else: ?>
                                <a href="artwork?id=<?= $art['Artwork_ID'] ?>" class="btn btn-primary w-100" aria-label="View and mint NFT <?= htmlspecialchars($art['Title']) ?>">View & Mint NFT</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php include "footer.php"; ?>