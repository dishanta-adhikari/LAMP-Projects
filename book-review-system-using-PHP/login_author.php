<?php
include 'conn.php';
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <title>Author Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 card pb-3 shadow p-4">
        <h2 class="mb-4">Author Login</h2>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Prepared statement (optional for now, but safer)
            $stmt = $conn->prepare("SELECT * FROM authors WHERE email = ? AND password = ?");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $author = $result->fetch_assoc();
                $_SESSION['author'] = $email;
                $_SESSION['author_id'] = $author['id'];
                $_SESSION['author_name'] = $author['name'];
                echo "<div class='alert alert-success'>Login successful. Redirecting...</div>";
                header("refresh:1;url=dashboard_author");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Invalid credentials.</div>";
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
            <a href="register_author" class="btn btn-link">Register as a new author</a>
        </form>
    </div>
</body>

</html>