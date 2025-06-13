<?php
include 'db.php';
include 'includes/header.php';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $password = hash('sha256', $_POST["password"]);

        $sql = "INSERT INTO customers (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $address, $password);
            if (mysqli_stmt_execute($stmt)) {
                $message = "Registration successful. <a href='login' class='btn btn-sm btn-success mt-2'>Login Now</a>";
            } else {
                throw new Exception("Execution failed: " . mysqli_stmt_error($stmt));
            }
        } else {
            throw new Exception("Preparation failed: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Travel Booking</title>
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

        .register-wrapper {
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
    <div class="register-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card p-4">
                        <div class="gradient-header">
                            <h2 class="text-center mb-4 text-white">Create Account</h2>
                        </div>

                        <?php if (!empty($message)) : ?>
                            <div class="alert alert-success"><?= $message ?></div>
                        <?php endif; ?>

                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input name="phone" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>

                        <p class="text-center mt-3">
                            Already have an account? <a href="login" class="text-primary">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>