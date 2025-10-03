<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
$type = $_SESSION['type'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow mx-auto" style="max-width: 400px;">
            <div class="card-body text-center">
                <h2 class="card-title mb-3">Benvenuto, <?= htmlspecialchars($username) ?>!</h2>
                <p class="mb-2">Tipo account: <span class="fw-bold text-primary"><?= htmlspecialchars($type) ?></span></p>
                <?php if ($type === 'admin'): ?>
                    <div class="alert alert-danger">Sei l'amministratore.</div>
                <?php elseif ($type === 'premium'): ?>
                    <div class="alert alert-success">Hai accesso premium!</div>
                <?php else: ?>
                    <div class="alert alert-secondary">Account base.</div>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-outline-danger mt-3">Logout</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
