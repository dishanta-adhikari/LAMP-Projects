<?php
include 'conn.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $conn->real_escape_string($_POST['name']);
    $email    = $conn->real_escape_string($_POST['email']);
    $phone    = (int)$_POST['phone'];
    $address  = $conn->real_escape_string($_POST['address']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if email already exists
    $check = $conn->query("SELECT * FROM authors WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Email already registered.</div>";
    } else {
        $sql = "INSERT INTO authors (name, email, phone, address, password, created_at)
                VALUES ('$name', '$email', $phone, '$address', '$password', NOW())";
        if ($conn->query($sql) === TRUE) {
            $message = "<div class='alert alert-success'>Registration successful. <a href='login_author'>Login Now</a></div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Author Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 card shadow p-4">
        <h2 class="mb-4">Author Registration</h2>

        <?php echo $message; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="number" name="phone" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-success">Register</button>
            <a href="login_author" class="btn btn-secondary">Back to Login</a>
        </form>
    </div>
</body>

</html>