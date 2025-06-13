<?php
include 'db.php';
include 'includes/header.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$user_id = $_SESSION["user_id"];
$message = $error = "";

// Handle password change
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old = $_POST["old_password"];
    $new = $_POST["new_password"];

    $stmt = mysqli_prepare($conn, "SELECT password FROM customers WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (hash('sha256', $old) === $user["password"]) {
        $new_hashed = hash('sha256', $new);
        $stmt = mysqli_prepare($conn, "UPDATE customers SET password = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $new_hashed, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Password updated successfully.";
        } else {
            $error = "Failed to update password.";
        }
    } else {
        $error = "Old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:rgb(162, 179, 196);
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
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="card shadow-sm p-4 rounded-4 w-100" style="max-width: 450px;">
            <div class="gradient-header">
                <h4 class="mb-0">Change Password</h4>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success"><?= $message ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Old Password</label>
                    <input type="password" name="old_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="dashboard" class="btn btn-outline-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php include 'includes/footer.php'; ?>