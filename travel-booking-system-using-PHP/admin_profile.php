<?php
include 'db.php';
include 'includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$message = "";
$error = "";

// Update profile info
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];

    $stmt = mysqli_prepare($conn, "UPDATE admins SET name = ?, email = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $admin_id);
    if (mysqli_stmt_execute($stmt)) {
        $message = "Profile updated successfully.";
    } else {
        $error = "Failed to update profile.";
    }
}

// Change password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $old = hash('sha256', $_POST["old_password"]);
    $new = hash('sha256', $_POST["new_password"]);

    $res = mysqli_query($conn, "SELECT password FROM admins WHERE id = $admin_id");
    $row = mysqli_fetch_assoc($res);
    if ($row && $row['password'] === $old) {
        mysqli_query($conn, "UPDATE admins SET password = '$new' WHERE id = $admin_id");
        $message = "Password changed successfully.";
    } else {
        $error = "Old password is incorrect.";
    }
}

// Fetch admin details
$res = mysqli_query($conn, "SELECT * FROM admins WHERE id = $admin_id");
$admin = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #eef2f7;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .profile-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 600px;
            position: relative;
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

        .form-label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #667eea;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5a67d8;
        }

        .btn-warning {
            background-color: #f6ad55;
            border: none;
        }

        .btn-warning:hover {
            background-color: #ed8936;
        }

        a.btn-link {
            color: #667eea;
            text-decoration: none;
        }

        a.btn-link:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body>
    <div class="profile-wrapper">
        <div class="card shadow-sm p-4 rounded-4 w-100">
            <div class="gradient-header">
                <h2 class="text-center mb-4 text-white">Admin Profile</h2>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success"><?= $message ?></div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <!-- Update Profile -->
            <form method="POST" class="mb-4">
                <input type="hidden" name="update_profile" value="1">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" value="<?= htmlspecialchars($admin['name']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" value="<?= htmlspecialchars($admin['email']) ?>" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            </form>

            <!-- Change Password -->
            <form method="POST">
                <input type="hidden" name="change_password" value="1">
                <h5 class="mb-3 text-secondary">Change Password</h5>
                <div class="mb-3">
                    <label class="form-label">Old Password</label>
                    <input name="old_password" type="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input name="new_password" type="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Change Password</button>
            </form>

            <div class="text-center mt-4">
                <a href="admin" class="btn btn-link">← Back to Dashboard</a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>