<?php
// Questo file non ha output HTML, quindi Bootstrap non è necessario qui.
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $users = file_exists('../users.json') ? json_decode(file_get_contents('../users.json'), true) : [];

    // Admin login (non cifrato, ma solo se non esiste in users.json)
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['username'] = 'admin';
        $_SESSION['type'] = 'admin';
        header('Location: dashboard.php');
        exit();
    }

    // Sicurezza: limita tentativi di login
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    if ($_SESSION['login_attempts'] > 10) {
        header('Location: index.php?error=Troppi%20tentativi%20falliti');
        exit();
    }

    // Sicurezza: password_hash, password_verify, hash_hmac per ruolo
    $pepper = 'P3pp3rS3gr3t0!';
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $salt = $user['salt'];
            $pwd_peppered = hash_hmac('sha256', $password, $pepper);
            if (password_verify($salt . $pwd_peppered, $user['password'])) {
                // Decodifica tipo account
                $types = ['base', 'premium'];
                $type = null;
                foreach ($types as $t) {
                    if (hash_hmac('sha256', $salt . $t, $pepper) === $user['type']) {
                        $type = $t;
                        break;
                    }
                }
                if ($type !== null) {
                    $_SESSION['username'] = $username;
                    $_SESSION['type'] = $type;
                    $_SESSION['login_attempts'] = 0;
                    header('Location: dashboard.php');
                    exit();
                }
            }
        }
    }
    $_SESSION['login_attempts']++;
    header('Location: index.php?error=Credenziali%20non%20valide');
    exit();
} else {
    header('Location: index.php');
    exit();
}
