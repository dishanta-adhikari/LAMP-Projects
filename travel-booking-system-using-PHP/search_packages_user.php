<?php
include 'db.php';

$where = "WHERE 1";
$params = [];
$types = "";

if (!empty($_GET['search'])) {
    $where .= " AND name LIKE ?";
    $params[] = "%" . $_GET['search'] . "%";
    $types .= "s";
}
if (!empty($_GET['min_price'])) {
    $where .= " AND price >= ?";
    $params[] = $_GET['min_price'];
    $types .= "d";
}
if (!empty($_GET['max_price'])) {
    $where .= " AND price <= ?";
    $params[] = $_GET['max_price'];
    $types .= "d";
}

$sql = "SELECT * FROM packages $where ORDER BY name";
$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>₹<?= number_format($row['price'], 2) ?></td>
                <td><a href='book?id=<?= $row['package_id'] ?>' class='btn btn-success btn-sm'>Book Now</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>