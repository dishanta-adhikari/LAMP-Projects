<?php
session_start();
include "db.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $isAdmin = isset($_POST['is_admin']);

    if (!$email || !$password) {
        $errors[] = "Email and password are required.";
    } else {
        $stmt = $pdo->prepare("SELECT User_ID, Name, Password, Role FROM user WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            if ($isAdmin && $user['Role'] !== 'admin') {
                $errors[] = "You are not authorized as an admin.";
            } else {
                $_SESSION['user_id'] = $user['User_ID'];
                $_SESSION['user_role'] = $user['Role'];
                $_SESSION['user_name'] = $user['Name'];

                if ($user['Role'] === 'admin') {
                    header("Location: admin_panel");
                } else {
                    header("Location: index");
                }
                exit;
            }
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<?php include "header.php"; ?>

<link rel="stylesheet" href="./css/login.css"> <!-- Reusing the same tube light style -->

<div id="login-page" class="container tubelight-box side-light mt-5" style="max-width: 480px;">
    <h2 class="mb-4 text-center">Login</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="login" novalidate>
        <div class="mb-3">
            <label for="login-email" class="form-label">Email *</label>
            <input type="email" id="login-email" name="email" class="form-control" required
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="username">
        </div>

        <div class="mb-3">
            <label for="login-password" class="form-label">Password *</label>
            <input type="password" id="login-password" name="password" class="form-control" required autocomplete="current-password">
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" class="form-check-input" id="login-is_admin" name="is_admin" <?= isset($_POST['is_admin']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="login-is_admin">Login as Admin</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <div class="mt-3 text-center">
            <a href="register" class="btn btn-link p-0">Don't have an account? Register</a>
        </div>
    </form>
</div>

<?php include "footer.php"; ?>