<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login</h2>
                <?php if ($error): ?>
                    <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="post" action="login.php">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="mt-3 text-center">Non hai un account? <a href="register.php">Registrati</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>