<?php
// Questo file non ha output HTML, quindi Bootstrap non è necessario qui.
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $users = file_exists('../users.json') ? json_decode(file_get_contents('../users.json'), true) : [];

    // Admin login
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['username'] = 'admin';
        $_SESSION['type'] = 'admin';
        header('Location: dashboard.php');
        exit();
    }

    // Check other users
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $_SESSION['username'] = $username;
            $_SESSION['type'] = $user['type'];
            header('Location: dashboard.php');
            exit();
        }
    }
    header('Location: index.php?error=Credenziali%20non%20valide');
    exit();
} else {
    header('Location: index.php');
    exit();
}
