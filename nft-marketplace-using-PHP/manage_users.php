<?php
include "db.php";
include "header.php";

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "<div class='alert alert-danger text-center'>Access Denied</div>";
    exit;
}

// Handle role change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['new_role'])) {
    $stmt = $pdo->prepare("UPDATE user SET role = ? WHERE user_id = ?");
    $stmt->execute([$_POST['new_role'], $_POST['user_id']]);
    echo "<script>location.href='manage_users';</script>";
    exit;
}

// Fetch all users except current admin
$stmt = $pdo->prepare("SELECT user_id, name, email, role FROM user WHERE user_id != ?");
$stmt->execute([$_SESSION['user_id']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="./css/manage_users.css">
<div class="container my-5">
    <h2 class="mb-4 text-center fw-bold" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        Manage Users
    </h2>

    <!-- Search bar -->
    <div class="mb-4 d-flex justify-content-center">
        <input id="searchInput" type="search" class="form-control form-control-lg w-50 shadow-sm" placeholder="Search users by name or email..." aria-label="Search Users">
    </div>

    <?php if (count($users) === 0): ?>
        <div class="alert alert-info text-center fs-5">
            No other users found.
        </div>
    <?php else: ?>
        <div id="usersContainer" class="row g-4 justify-content-center">
            <?php foreach ($users as $user): ?>
                <div class="col-12 col-md-6 col-lg-4 user-card-wrapper" data-name="<?= strtolower(htmlspecialchars($user['name'])) ?>" data-email="<?= strtolower(htmlspecialchars($user['email'])) ?>">
                    <div class="card user-card glass-card shadow rounded-4 overflow-hidden p-3">
                        <div class="card-body d-flex flex-column justify-content-between h-100">
                            <div>
                                <h5 class="card-title text-gradient fw-bold mb-2">
                                    <i class="bi bi-person-circle me-2"></i> <?= htmlspecialchars($user['name']) ?>
                                </h5>
                                <p class="card-text text-muted mb-1">
                                    <i class="bi bi-envelope-fill me-1"></i> <?= htmlspecialchars($user['email']) ?>
                                </p>
                                <p class="card-text mb-3">
                                    Role:
                                    <span class="badge role-badge <?= $user['role'] === 'admin' ? 'admin-role' : 'user-role' ?>">
                                        <?= htmlspecialchars(ucfirst($user['role'])) ?>
                                    </span>
                                </p>
                            </div>

                            <form method="post" class="d-flex gap-2 align-items-center role-form" onsubmit="return confirmRoleChange(this);">
                                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                                <select name="new_role" class="form-select form-select-sm flex-grow-1" required>
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>

                                <button type="submit" class="btn btn-sm btn-outline-success" title="Update Role">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmRoleChange(form) {
        const select = form.querySelector('select[name="new_role"]');
        const role = select.options[select.selectedIndex].text;
        return confirm(`Are you sure you want to change the role to "${role}"?`);
    }

    // Real-time search filtering
    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const users = document.querySelectorAll('.user-card-wrapper');

        users.forEach(user => {
            const name = user.getAttribute('data-name');
            const email = user.getAttribute('data-email');
            if (name.includes(query) || email.includes(query)) {
                user.style.display = '';
                user.classList.add('fade-in');
            } else {
                user.style.display = 'none';
                user.classList.remove('fade-in');
            }
        });
    });
</script>


<?php include "footer.php"; ?>