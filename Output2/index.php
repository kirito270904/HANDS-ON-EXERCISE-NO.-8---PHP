<?php
$pageTitle = "Home - MyApp";
require 'includes/header.php';
?>

<div class="page-wrap">
    <div class="hero">
        <h1>Welcome to MyApp</h1>
        <p>
            This is the Home Page for PHP Output #2. It demonstrates how a multi-page
            PHP site can be built using <strong>include</strong> and <strong>require</strong>
            to share a common header and footer across the Home, Register, Login,
            and Forgot Password pages.
        </p>
        <div class="actions">
            <a href="register.php" class="primary">Create an Account</a>
            <a href="login.php" class="secondary">Login</a>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>