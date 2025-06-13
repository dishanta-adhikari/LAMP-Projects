<?php
include 'db.php';
include 'includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login");
    exit();
}


$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $id = (int)($_POST['id'] ?? 0);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float)$_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle image uploads
    $imageNames = [];

    if (!empty($_FILES['images']['name'][0])) { // Check if at least one file was uploaded
        $uploadDir = 'uploads/packages/';  // Make sure this directory exists and is writable

        foreach ($_FILES['images']['name'] as $key => $imageName) {
            $tmpName = $_FILES['images']['tmp_name'][$key];
            $error = $_FILES['images']['error'][$key];

            if ($error === UPLOAD_ERR_OK) {
                // Generate a unique filename to avoid overwrites
                $ext = pathinfo($imageName, PATHINFO_EXTENSION);
                $newFileName = uniqid('pkg_', true) . '.' . $ext;

                // Move the uploaded file
                if (move_uploaded_file($tmpName, $uploadDir . $newFileName)) {
                    $imageNames[] = $uploadDir . $newFileName;
                }
            }
        }
    }

    if ($id > 0) {
        // Editing existing package

        // Fetch existing images to append new or replace (your logic)
        $res = mysqli_query($conn, "SELECT image FROM packages WHERE package_id = $id");
        $row = mysqli_fetch_assoc($res);
        $existingImages = $row ? explode(',', $row['image']) : [];

        // Merge existing images with new ones
        $allImages = array_merge($existingImages, $imageNames);

        // Optionally remove duplicates and trim spaces
        $allImages = array_unique(array_map('trim', $allImages));
        $imageString = implode(',', $allImages);

        // Update query
        $sql = "UPDATE packages SET
                    name = '$name',
                    price = $price,
                    description = '$description',
                    image = '$imageString'
                WHERE package_id = $id";
        mysqli_query($conn, $sql);
    } else {
        // Adding new package
        $imageString = implode(',', $imageNames);

        $sql = "INSERT INTO packages (name, price, description, image)
                VALUES ('$name', $price, '$description', '$imageString')";
        mysqli_query($conn, $sql);
        $_SESSION['success1'] = "Package saved successfully!";
    }

    header("Location: admin");
    exit;
}


$name = $_POST["name"] ?? '';
$price = $_POST["price"] ?? '';
$id = $_POST["id"] ?? '';

$description = $_POST["description"] ?? '';
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir);
    $targetFile = $targetDir . time() . "_" . $imageName;

    if (move_uploaded_file($imageTmp, $targetFile)) {
        $imagePath = $targetFile;
    }
}



// Handle Create & Update for packages
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $id = $_POST["id"] ?? '';

    try {
        if ($id) {
            if ($imagePath) {
                $sql = "UPDATE packages SET name=?, price=?, description=?, image=? WHERE package_id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sddsi", $name, $price, $description, $imagePath, $id);
            } else {
                $sql = "UPDATE packages SET name=?, price=?, description=? WHERE package_id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sddi", $name, $price, $description, $id);
            }
            mysqli_stmt_execute($stmt);
            $message = "Package updated.";
        } else {
            $sql = "INSERT INTO packages (name, price, description, image) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sdds", $name, $price, $description, $imagePath);
            mysqli_stmt_execute($stmt);
            $message = "Package added.";
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Delete Package
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = mysqli_prepare($conn, "DELETE FROM packages WHERE package_id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $message = "Package deleted.";
    } catch (Exception $e) {
        $error = "Error deleting: " . $e->getMessage();
    }
}

// Export to CSV
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="packages.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Name', 'Price']);
    $res = mysqli_query($conn, "SELECT * FROM packages");
    while ($row = mysqli_fetch_assoc($res)) {
        fputcsv($output, [$row['package_id'], $row['name'], $row['price']]);
    }
    fclose($output);
    exit();
}

// Handle fake payment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_now'])) {
    $bookingId = $_POST['booking_id'];
    try {
        $stmt = mysqli_prepare($conn, "UPDATE bookings SET pay_status = 'Paid' WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $bookingId);
        mysqli_stmt_execute($stmt);
        $message = "Payment successful for Booking #$bookingId.";
    } catch (Exception $e) {
        $error = "Payment update failed: " . $e->getMessage();
    }
}

// Handle Booking Cancellation
if (isset($_POST['cancel_booking'])) {
    $bookingId = $_POST['booking_id'];
    try {
        $stmt = mysqli_prepare($conn, "DELETE FROM bookings WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $bookingId);
        mysqli_stmt_execute($stmt);
        $message = "Booking cancelled. Money will be refunded to your bank in 3 working days.";
    } catch (Exception $e) {
        $error = "Error cancelling booking: " . $e->getMessage();
    }
}

// Load packages with payment summary
$packages = [];
$sql = "
    SELECT 
        p.*, 
        MAX(b.pay_status) AS payment_status
    FROM packages p
    LEFT JOIN bookings b ON p.package_id = b.package_id
    GROUP BY p.package_id
    ORDER BY p.package_id DESC
";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $packages[] = $row;
}

// Load all bookings
$bookings = [];
$sql = "
    SELECT 
        b.id AS booking_id,
        c.name AS customer_name,
        p.name AS package_name,
        b.book_date,
        b.pay_status
    FROM bookings b
    JOIN customers c ON b.customer_id = c.id
    JOIN packages p ON b.package_id = p.package_id
    ORDER BY b.id DESC
";
$res = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $bookings[] = $row;
}

// Analytics data
$totalBookings = 0;
$paidBookings = 0;
$pendingBookings = 0;
$totalRevenue = 0;
$topPackages = [];

$res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings");
$totalBookings = mysqli_fetch_assoc($res)['total'];

$res = mysqli_query($conn, "SELECT COUNT(*) AS paid FROM bookings WHERE pay_status = 'Paid'");
$paidBookings = mysqli_fetch_assoc($res)['paid'];

$pendingBookings = $totalBookings - $paidBookings;

$res = mysqli_query($conn, "
    SELECT SUM(p.price) AS revenue
    FROM bookings b
    JOIN packages p ON b.package_id = p.package_id
    WHERE b.pay_status = 'Paid'
");
$row = mysqli_fetch_assoc($res);
$totalRevenue = $row['revenue'] ?? 0;

$res = mysqli_query($conn, "
    SELECT p.name, COUNT(*) AS count
    FROM bookings b
    JOIN packages p ON b.package_id = p.package_id
    GROUP BY b.package_id
    ORDER BY count DESC
    LIMIT 3
");
while ($row = mysqli_fetch_assoc($res)) {
    $topPackages[] = $row;
}

// Fetch unread notifications
$res = mysqli_query($conn, "SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC");
$notifications = mysqli_fetch_all($res, MYSQLI_ASSOC);


$customers = [];
$res = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($res)) {
    $customers[] = $row;
}


if (isset($_GET['delete_customer'])) {
    $cid = (int)$_GET['delete_customer'];
    try {
        mysqli_query($conn, "DELETE FROM customers WHERE id = $cid");
        $message = "Customer deleted successfully.";
    } catch (Exception $e) {
        $error = "Error deleting customer: " . $e->getMessage();
    }
}

mysqli_query($conn, "UPDATE notifications SET is_read = 1 WHERE is_read = 0");


?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Packages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #eef2f7;
        }

        .form-section,
        .card {
            border-radius: 12px;
        }

        .bg-header {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            border-radius: 12px;
        }

        body {
            background: #f1f5f9;
            color: #333;
        }

        .dashboard-header {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            border-radius: 12px;
        }

        .dashboard-header .btn-outline-light,
        .dashboard-header .btn-outline-danger {
            color: white;
            border-color: white;
        }

        .dashboard-header .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .dashboard-header .btn-outline-danger:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .table thead {
            background-color: #e2e8f0;
        }

        .card {
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="dashboard-header mb-4 p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-1">Admin - Package Management</h3>
                    <p class="mb-0">Manage all travel packages, search and export.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="admin_profile" class="btn btn-outline-light btn-sm me-2">
                        My Profile
                    </a>
                </div>
            </div>
        </div>



        <div class="alert alert-info">
            <h5>Notifications</h5>
            <?php if (count($notifications) == 0): ?>
                <p>No new notifications.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($notifications as $n): ?>
                        <li><?= htmlspecialchars($n['message']) ?> <small class="text-muted">(<?= $n['created_at'] ?>)</small></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php
        if (!empty($_SESSION['success1'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success1']) . '</div>';
            unset($_SESSION['success1']);
        } ?>

        <!-- Add/Edit Package Form -->
        <div class="form-section bg-white p-4 mb-4 shadow-sm">
            <h4><?= isset($_GET['edit']) ? 'Edit Package' : 'Add New Package' ?></h4>
            <?php
            $editPackage = ['package_id' => '', 'name' => '', 'price' => '', 'description' => '', 'image' => ''];

            if (isset($_GET['edit'])) {
                $id = (int)$_GET['edit'];
                $res = mysqli_query($conn, "SELECT * FROM packages WHERE package_id=$id");
                $editPackage = mysqli_fetch_assoc($res);
            }
            ?>
            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editPackage['package_id']) ?>">

                <div class="col-md-6">
                    <input name="name" class="form-control" value="<?= htmlspecialchars($editPackage['name']) ?>" placeholder="Package Name" required>
                </div>

                <div class="col-md-3">
                    <input name="price" type="number" step="0.01" class="form-control" value="<?= htmlspecialchars($editPackage['price']) ?>" placeholder="Price" required>
                </div>

                <div class="col-md-3">
                    <!-- Note the multiple attribute and name as array -->
                    <input name="images[]" type="file" class="form-control" multiple>
                    <small class="text-muted">You can select multiple images.</small>

                    <?php if (!empty($editPackage['image'])):
                        $existingImages = explode(',', $editPackage['image']);
                        foreach ($existingImages as $img): ?>
                            <img src="<?= htmlspecialchars(trim($img)) ?>" width="80" class="mt-2 me-2 rounded" alt="Package Image">
                    <?php endforeach;
                    endif ?>
                </div>

                <div class="col-md-12">
                    <textarea name="description" class="form-control" placeholder="Description"><?= htmlspecialchars($editPackage['description']) ?></textarea>
                </div>

                <div class="col-md-12 text-end">
                    <button name="save" class="btn btn-success"><?= isset($_GET['edit']) ? 'Update' : 'Add' ?></button>
                </div>
            </form>
        </div>


        <!-- Search & Export -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex w-75">
                <input type="text" id="searchBox" class="form-control me-2" placeholder="Search by name or price...">
            </div>
            <a href="?export=csv" class="btn btn-outline-success">Export CSV</a>
        </div>

        <!-- Package List -->
        <div class="card p-3 shadow-sm" id="result">
            <h5 class="mb-3">Packages <span class="badge bg-secondary"><?= count($packages) ?></span></h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price (₹)</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packages as $pkg): ?>
                            <tr>
                                <td><?= $pkg['package_id'] ?></td>
                                <td><?= htmlspecialchars($pkg['name']) ?></td>
                                <td><?= number_format($pkg['price'], 2) ?></td>
                                <td>
                                    <?php if ($pkg['payment_status'] === 'Paid'): ?>
                                        <span class='text-success'>Paid</span>
                                    <?php elseif ($pkg['payment_status'] === null): ?>
                                        <span class='text-muted'>No Booking</span>
                                    <?php else: ?>
                                        <span class='text-danger'>Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?edit=<?= $pkg['package_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="?delete=<?= $pkg['package_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this package?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Booking Table -->
        <div class="card mt-5 p-3 shadow-sm">
            <h5 class="mb-3">Bookings <span class="badge bg-info"><?= count($bookings) ?></span></h5>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Book Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b): ?>
                            <tr>
                                <td><?= $b['booking_id'] ?></td>
                                <td><?= htmlspecialchars($b['customer_name']) ?></td>
                                <td><?= htmlspecialchars($b['package_name']) ?></td>
                                <td><?= $b['book_date'] ?></td>
                                <td>
                                    <?php if ($b['pay_status'] === 'Paid'): ?>
                                        <span class="text-success fw-bold">Paid</span>
                                    <?php else: ?>
                                        <span class="text-danger">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($b['pay_status'] === 'Pending'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                                            <button type="submit" name="pay_now" class="btn btn-sm btn-success">Pay Now</button>
                                        </form>
                                    <?php elseif ($b['pay_status'] === 'Paid'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                                            <button type="submit" name="cancel_booking" class="btn btn-sm btn-danger" onclick="return confirm('Cancel this booking?')">Cancel Booking</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-5 p-3 shadow-sm">
            <h5 class="mb-3">Customers <span class="badge bg-primary"><?= count($customers) ?></span></h5>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Registered On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= htmlspecialchars($c['name']) ?></td>
                                <td><?= htmlspecialchars($c['email']) ?></td>
                                <td><?= htmlspecialchars($c['phone']) ?></td>
                                <td><?= $c['created_at'] ?? '-' ?></td>
                                <td>
                                    <a href="?delete_customer=<?= $c['id'] ?>" onclick="return confirm('Delete this customer?')" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Packages -->
        <div class="card mt-4 p-3 shadow-sm">
            <h5 class="mb-3">Top 3 Most Booked Packages</h5>
            <ul class="list-group">
                <?php foreach ($topPackages as $pkg): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?= htmlspecialchars($pkg['name']) ?>
                        <span class="badge bg-primary"><?= $pkg['count'] ?> bookings</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>


        <!-- Analytics -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-header p-3 text-center">
                    <h6>Total Packages</h6>
                    <h2><?= count($packages) ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark p-3 text-center">
                    <h6>Total Value</h6>
                    <h2>
                        ₹<?php
                            $total = array_sum(array_column($packages, 'price'));
                            echo number_format($total, 2);
                            ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="row mt-5 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white p-3 text-center">
                    <h6>Total Bookings</h6>
                    <h2><?= $totalBookings ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white p-3 text-center">
                    <h6>Paid Bookings</h6>
                    <h2><?= $paidBookings ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark p-3 text-center">
                    <h6>Pending Bookings</h6>
                    <h2><?= $pendingBookings ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white p-3 text-center">
                    <h6>Total Revenue</h6>
                    <h2>₹<?= number_format($totalRevenue, 2) ?></h2>
                </div>
            </div>
        </div>

    </div>


    <!-- Scripts -->
    <script>
        document.getElementById("searchBox").addEventListener("input", function() {
            const query = this.value;
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "search_packages?search=" + encodeURIComponent(query), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });
    </script>
</body>

</html>

<?php include 'includes/footer.php'; ?>