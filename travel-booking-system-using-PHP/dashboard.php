<?php
include 'db.php';
include 'includes/header.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$user_id = $_SESSION["user_id"];
$message = "";
$error = "";

// Fetch user info
try {
    $stmt = mysqli_prepare($conn, "SELECT * FROM customers WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $user_result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($user_result);
} catch (Exception $e) {
    $error = "User fetch error: " . $e->getMessage();
}

// Filter Packages
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

try {
    $sql = "SELECT * FROM packages $where ORDER BY name";
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $packages_result = mysqli_stmt_get_result($stmt);
} catch (Exception $e) {
    $error = "Package filter error: " . $e->getMessage();
}

// Fetch bookings
try {
    $stmt = mysqli_prepare($conn, "SELECT b.id, b.package_id, b.pay_status, p.name AS package_name, b.book_date 
        FROM bookings b 
        JOIN packages p ON b.package_id = p.package_id 
        WHERE b.customer_id = ? 
        ORDER BY b.book_date DESC");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $bookings_result = mysqli_stmt_get_result($stmt);
} catch (Exception $e) {
    $error = "Booking fetch error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
            color: #333;
        }

        .dashboard-header {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .table thead {
            background-color: #e2e8f0;
        }

        .card {
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .btn-outline-light,
        .btn-outline-warning,
        .btn-outline-danger {
            border-width: 1.5px;
        }

        .btn-outline-light:hover,
        .btn-outline-warning:hover,
        .btn-outline-danger:hover {
            opacity: 0.9;
        }

        .input-group .form-control {
            min-width: 150px;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="dashboard-header mb-4 p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-1">Welcome, <?= htmlspecialchars($user['name']) ?>!</h3>
                    <p class="mb-0">Email: <?= htmlspecialchars($user['email']) ?> | Phone: <?= htmlspecialchars($user['phone']) ?></p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="edit_profile" class="btn btn-outline-light btn-sm me-2">Edit Profile</a>
                    <a href="change_password" class="btn btn-outline-light btn-sm me-2">Change Password</a>
                </div>
            </div>
        </div>

        <?php if (!empty($_SESSION['msg'])): ?>
            <div class="alert alert-info"><?= $_SESSION['msg'] ?></div>
            <?php unset($_SESSION['msg']); ?>
        <?php elseif ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search package by name...">
                <input type="number" name="min_price" class="form-control" placeholder="Min Price">
                <input type="number" name="max_price" class="form-control" placeholder="Max Price">
                <button class="btn btn-primary" type="submit">Filter</button>
                <a href="dashboard" class="btn btn-secondary">Clear</a>
            </div>
        </form>

        <div class="card mb-4 p-3">
            <h4>Available Packages</h4>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Price (₹)</th>
                        <th>Description</th>
                        <th>Book</th>
                        <th>Info</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $modals = "";
                    while ($row = mysqli_fetch_assoc($packages_result)) :
                        $id = $row['package_id'];
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td>₹<?= number_format($row['price'], 2) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($row['description'], 0, 50, "...")) ?></td>
                            <td><a href='book?id=<?= $id ?>' class='btn btn-success btn-sm'>Book Now</a></td>
                            <td><button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal<?= $id ?>">Info</button></td>
                        </tr>

                        <?php
                        // Prepare carousel images from comma-separated URLs
                        $images = !empty($row['image']) ? explode(',', $row['image']) : [];

                        if (count($images) > 0) {
                            $carouselId = 'carousel' . $id;
                            $carouselIndicators = '';
                            $carouselItems = '';

                            foreach ($images as $index => $img) {
                                $activeClass = ($index === 0) ? 'active' : '';
                                $safeImg = htmlspecialchars(trim($img));

                                $carouselIndicators .= '
                                <button type="button" data-bs-target="#' . $carouselId . '" data-bs-slide-to="' . $index . '" class="' . $activeClass . '" aria-current="true" aria-label="Slide ' . ($index + 1) . '"></button>';

                                $carouselItems .= '
                                <div class="carousel-item ' . $activeClass . '">
                                    <img src="' . $safeImg . '" class="d-block w-100 rounded" style="max-height: 500px; object-fit: cover;" alt="Image ' . ($index + 1) . '">
                                </div>';
                            }

                            $imageTag = '
                            <div id="' . $carouselId . '" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">' . $carouselIndicators . '</div>
                                <div class="carousel-inner">' . $carouselItems . '</div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#' . $carouselId . '" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>';
                        } else {
                            $imageTag = '<p class="text-muted">No images available.</p>';
                        }

                        $modals .= '
                        <div class="modal fade" id="infoModal' . $id . '" tabindex="-1" aria-labelledby="infoModalLabel' . $id . '" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="infoModalLabel' . $id . '">' . htmlspecialchars($row['name']) . ' - ₹' . number_format($row['price'], 2) . '</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body row g-4">
                                        <div class="col-md-6">' . $imageTag . '</div>
                                        <div class="col-md-6">
                                            <h6>Description:</h6>
                                            <p>' . nl2br(htmlspecialchars($row['description'])) . '</p>
                                            <hr>
                                            <p><strong>Price:</strong> ₹' . number_format($row['price'], 2) . '</p>
                                            <p><strong>Package ID:</strong> ' . htmlspecialchars($row['package_id']) . '</p>
                                            <a href="book?id=' . $id . '" class="btn btn-primary mt-2">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        ?>

                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>

        <?= $modals ?>

        <div class="card p-3 mb-5">
            <h4>Your Bookings</h4>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Pay</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($bookings_result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['package_name']) ?></td>
                            <td><?= htmlspecialchars($row['book_date']) ?></td>
                            <td><span class="badge bg-<?= $row['pay_status'] == 'Paid' ? 'success' : 'warning' ?>"><?= $row['pay_status'] ?></span></td>
                            <td>
                                <?php if ($row['pay_status'] != 'Paid'): ?>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal" data-booking-id="<?= $row['id'] ?>">Pay</button>
                                <?php else: ?>
                                    <span class="text-muted">Done</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" action="delete_booking" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="fake_pay">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Simulate Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>You're about to make a fake payment for your booking.</p>
                        <input type="hidden" name="booking_id" id="modalBookingId">
                        <div class="mb-3">
                            <label for="card" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="card" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" placeholder="123" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiry" class="form-label">Expiry</label>
                            <input type="text" class="form-control" id="expiry" placeholder="MM/YY" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Confirm Payment</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const paymentModal = document.getElementById('paymentModal');
        paymentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const bookingId = button.getAttribute('data-booking-id');
            document.getElementById('modalBookingId').value = bookingId;
        });

        // AJAX filtering DISABLED as requested.
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>

<?php include 'includes/footer.php'; ?>