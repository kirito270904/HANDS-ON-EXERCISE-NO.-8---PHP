<?php
$pageTitle = "Login - MyApp";

$errors = [];
$email = '';
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($password === '') {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }
}

$success = $submitted && count($errors) === 0;

function old($val) {
    return htmlspecialchars($val, ENT_QUOTES);
}

require 'includes/header.php';
?>

<div class="page-wrap">
    <div class="card">
        <h1>Login</h1>
        <p class="desc">Enter your credentials to access your account.</p>

        <?php if ($success): ?>
            <div class="success-box">
                &#10003; Login form validated successfully! (Connect this to a
                database in Output #3/#4 to authenticate for real.)
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" novalidate>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="juan@example.com"
                       class="<?= isset($errors['email']) ? 'input-error' : '' ?>"
                       value="<?= old($email) ?>">
                <?php if (isset($errors['email'])): ?><span class="error"><?= $errors['email'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password"
                       class="<?= isset($errors['password']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['password'])): ?><span class="error"><?= $errors['password'] ?></span><?php endif; ?>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="form-footer">
            <a href="forgot-password.php">Forgot your password?</a><br><br>
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>