<?php
$pageTitle = "Forgot Password - MyApp";

$errors = [];
$email = '';
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
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
        <h1>Forgot Password</h1>
        <p class="desc">Enter your registered email and we'll send you a reset link.</p>

        <?php if ($success): ?>
            <div class="success-box">
                &#10003; If an account exists for <strong><?= old($email) ?></strong>,
                a password reset link has been sent.
            </div>
        <?php endif; ?>

        <form action="forgot-password.php" method="POST" novalidate>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="juan@example.com"
                       class="<?= isset($errors['email']) ? 'input-error' : '' ?>"
                       value="<?= old($email) ?>">
                <?php if (isset($errors['email'])): ?><span class="error"><?= $errors['email'] ?></span><?php endif; ?>
            </div>

            <button type="submit">Send Reset Link</button>
        </form>

        <div class="form-footer">
            Remembered your password? <a href="login.php">Back to Login</a>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>