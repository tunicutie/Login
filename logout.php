<?php
// Questo file non ha output HTML, quindi Bootstrap non è necessario qui.
session_start();
session_destroy();
header('Location: index.php');
exit();
