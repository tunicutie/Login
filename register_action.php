<?php
// Questo file non ha output HTML, quindi Bootstrap non è necessario qui.
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $type = $_POST['type'];
    $users = file_exists('../users.json') ? json_decode(file_get_contents('../users.json'), true) : [];

    // Username rules
    if ($username === 'admin') {
        header('Location: register.php?error=Username%20non%20disponibile');
        exit();
    }
    if ($type === 'premium' && !in_array($username, ['rick', 'ilyas', 'teramo'])) {
        header('Location: register.php?error=Username%20premium%20non%20valido');
        exit();
    }
    if ($type === 'base' && in_array($username, ['rick', 'ilyas', 'teramo'])) {
        header('Location: register.php?error=Username%20riservato%20ai%20premium');
        exit();
    }
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            header('Location: register.php?error=Username%20gi%C3%A0%20esistente');
            exit();
        }
    }
    // Salt, pepper, password_hash, hash_hmac
    $salt = bin2hex(random_bytes(8));
    $pepper = 'P3pp3rS3gr3t0!';
    $pwd_peppered = hash_hmac('sha256', $password, $pepper);
    $password_hash = password_hash($salt . $pwd_peppered, PASSWORD_DEFAULT);
    $type_hash = hash_hmac('sha256', $salt . $type, $pepper);

    $users[] = [
        'username' => $username,
        'password' => $password_hash,
        'type' => $type_hash,
        'salt' => $salt
    ];
    file_put_contents('../users.json', json_encode($users, JSON_PRETTY_PRINT));
    $_SESSION['username'] = $username;
    $_SESSION['type'] = $type;
    header('Location: dashboard.php');
    exit();
} else {
    header('Location: register.php');
    exit();
}
