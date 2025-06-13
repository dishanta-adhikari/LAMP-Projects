<?php
include 'conn.php';
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 card pb-3 shadow p-4">
        <h2 class="mb-4">User Login</h2>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows == 1) {
                $user = $result->fetch_assoc();

                // For future: password should be hashed
                if ($password === $user['password']) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    echo "<div class='alert alert-success'>Login successful. Redirecting...</div>";
                    header("refresh:1;url=dashboard_user");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Invalid password.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>User not found.</div>";
            }

            $stmt->close();
        }
        ?>

        <form method="post">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required />
            </div>
            <button class="btn btn-primary">Login</button>
            <a href="register_user" class="btn btn-link">Register as a new user</a>
        </form>
    </div>
</body>

</html>