<?php
include 'db.php';
include 'includes/header.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$user_id = $_SESSION["user_id"];
$message = $error = "";

// Update user info
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    $stmt = mysqli_prepare($conn, "UPDATE customers SET name=?, email=?, phone=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $message = "Profile updated successfully.";
    } else {
        $error = "Failed to update profile.";
    }
}

// Fetch current data
$stmt = mysqli_prepare($conn, "SELECT * FROM customers WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
            color: #333;
        }

        .gradient-header {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            margin: -24px -24px 24px -24px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card py-4 px-4 rounded w-100" style="max-width: 500px;">
            <div class="gradient-header">
                <h3 class="mb-0">Edit Profile</h3>
            </div>

            <?php if ($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="dashboard" class="btn btn-secondary">Back</a>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php include 'includes/footer.php'; ?>