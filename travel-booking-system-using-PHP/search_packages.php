<?php
include 'db.php';
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM packages WHERE name LIKE ? OR price LIKE ? ORDER BY package_id DESC";
$stmt = mysqli_prepare($conn, $sql);
$like = '%' . $search . '%';
mysqli_stmt_bind_param($stmt, "ss", $like, $like);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<h5 class="mb-3">Packages <span class="badge bg-secondary"><?= mysqli_num_rows($result) ?></span></h5>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price (₹)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pkg = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $pkg['package_id'] ?></td>
                    <td><?= htmlspecialchars($pkg['name']) ?></td>
                    <td><?= number_format($pkg['price'], 2) ?></td>
                    <td>
                        <a href="?edit=<?= $pkg['package_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?delete=<?= $pkg['package_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this package?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>