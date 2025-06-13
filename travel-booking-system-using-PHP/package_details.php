<?php
include 'db.php';

if (!isset($_GET["id"])) {
    die("Package ID missing.");
}
$package_id = (int)$_GET["id"];

$query = "SELECT places.name, places.guide, hotels.name AS hotel_name, hotels.address
          FROM package_place
          JOIN places ON package_place.place_id = places.place_id
          JOIN hotels ON hotels.place_id = places.place_id
          WHERE package_place.package_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $package_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

echo "<h2>Places & Hotels for Package #$package_id</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='card mb-3 p-3'>
            <strong>Place:</strong> {$row['name']}<br>
            <strong>Guide:</strong> {$row['guide']}<br>
            <strong>Hotel:</strong> {$row['hotel_name']}<br>
            <strong>Hotel Address:</strong> {$row['address']}
          </div>";
}
