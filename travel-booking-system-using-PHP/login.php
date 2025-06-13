<?php
include 'db.php';
include 'includes/header.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $hashed = hash("sha256", $password);

        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($admin = mysqli_fetch_assoc($result)) {
            if ($hashed === $admin["password"]) {
                $_SESSION["admin_id"] = $admin["id"];
                $_SESSION["admin_name"] = $admin["name"];
                header("Location: admin");
                exit();
            } else {
                $error = "Incorrect password for admin.";
            }
        } else {
            $sql = "SELECT * FROM customers WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($customer = mysqli_fetch_assoc($result)) {
                if ($hashed === $customer["password"]) {
                    $_SESSION["user_id"] = $customer["id"];
                    $_SESSION["name"] = $customer["name"];
                    header("Location: dashboard");
                    exit();
                } else {
                    $error = "Incorrect password for user.";
                }
            } else {
                $error = "No account found with that email.";
            }
        }
    } catch (Exception $e) {
        $error = "Login failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Travel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #eef2f7;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background-color: #ffffff;
            color: #333;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 100%;
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

        .text-primary {
            color: #667eea !important;
        }

        .text-primary:hover {
            color: #4c51bf !important;
        }

        a.text-primary {
            text-decoration: none;
        }

        a.text-primary:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: auto;
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
    <div class="login-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card p-4">
                        <div class="gradient-header">
                            <h2 class="text-center mb-4 text-white">Login</h2>
                        </div>

                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        <p class="text-center mt-3">
                            Don’t have an account?
                            <a href="register" class="text-primary">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>