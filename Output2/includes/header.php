<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'PHP Output #2' ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="brand">MyApp</div>
    <nav>
        <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a>
        <a href="register.php" class="<?= $currentPage === 'register.php' ? 'active' : '' ?>">Register</a>
        <a href="login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">Login</a>
        <a href="forgot-password.php" class="<?= $currentPage === 'forgot-password.php' ? 'active' : '' ?>">Forgot Password</a>
    </nav>
</header>