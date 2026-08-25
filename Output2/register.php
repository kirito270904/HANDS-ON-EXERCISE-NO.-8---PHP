<?php
$pageTitle = "Register - MyApp";

$errors = [];
$data = [
    'fullname' => '',
    'age' => '',
    'gender' => '',
    'email' => '',
    'address' => '',
    'contact' => '',
    'password' => '',
    'confirm_password' => ''
];
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;

    $data['fullname'] = trim($_POST['fullname'] ?? '');
    $data['age']      = trim($_POST['age'] ?? '');
    $data['gender']   = trim($_POST['gender'] ?? '');
    $data['email']    = trim($_POST['email'] ?? '');
    $data['address']  = trim($_POST['address'] ?? '');
    $data['contact']  = trim($_POST['contact'] ?? '');
    $data['password'] = trim($_POST['password'] ?? '');
    $data['confirm_password'] = trim($_POST['confirm_password'] ?? '');

    if ($data['fullname'] === '') {
        $errors['fullname'] = 'Full name is required.';
    } elseif (!preg_match('/^[a-zA-Z\s\.\-]+$/', $data['fullname'])) {
        $errors['fullname'] = 'Full name must contain letters only.';
    }

    if ($data['age'] === '') {
        $errors['age'] = 'Age is required.';
    } elseif (!ctype_digit($data['age']) || (int)$data['age'] < 1 || (int)$data['age'] > 120) {
        $errors['age'] = 'Enter a valid age (1-120).';
    }

    $allowedGenders = ['Male', 'Female', 'Other'];
    if ($data['gender'] === '' || !in_array($data['gender'], $allowedGenders)) {
        $errors['gender'] = 'Please select a gender.';
    }

    if ($data['email'] === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($data['address'] === '' || strlen($data['address']) < 5) {
        $errors['address'] = 'Please enter a complete address.';
    }

    if ($data['contact'] === '') {
        $errors['contact'] = 'Contact number is required.';
    } elseif (!preg_match('/^09\d{9}$/', $data['contact'])) {
        $errors['contact'] = 'Enter a valid 11-digit mobile number (e.g. 09123456789).';
    }

    if ($data['password'] === '') {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($data['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }

    if ($data['confirm_password'] === '') {
        $errors['confirm_password'] = 'Please confirm your password.';
    } elseif ($data['confirm_password'] !== $data['password']) {
        $errors['confirm_password'] = 'Passwords do not match.';
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
        <h1>Create an Account</h1>
        <p class="desc">Fill in your details below to register.</p>

        <?php if ($success): ?>
            <div class="success-box">
                &#10003; Registered successfully! You may now
                <a href="login.php">login</a>.
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" novalidate>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" placeholder="Juan Dela Cruz"
                       class="<?= isset($errors['fullname']) ? 'input-error' : '' ?>"
                       value="<?= old($data['fullname']) ?>">
                <?php if (isset($errors['fullname'])): ?><span class="error"><?= $errors['fullname'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" min="1" max="120" placeholder="e.g. 21"
                       class="<?= isset($errors['age']) ? 'input-error' : '' ?>"
                       value="<?= old($data['age']) ?>">
                <?php if (isset($errors['age'])): ?><span class="error"><?= $errors['age'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="<?= isset($errors['gender']) ? 'input-error' : '' ?>">
                    <option value="">-- Select Gender --</option>
                    <option value="Male" <?= $data['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $data['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= $data['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
                <?php if (isset($errors['gender'])): ?><span class="error"><?= $errors['gender'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="juan@example.com"
                       class="<?= isset($errors['email']) ? 'input-error' : '' ?>"
                       value="<?= old($data['email']) ?>">
                <?php if (isset($errors['email'])): ?><span class="error"><?= $errors['email'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2" placeholder="House No., Street, Barangay, City"
                          class="<?= isset($errors['address']) ? 'input-error' : '' ?>"><?= old($data['address']) ?></textarea>
                <?php if (isset($errors['address'])): ?><span class="error"><?= $errors['address'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="tel" name="contact" maxlength="11" placeholder="09123456789"
                       class="<?= isset($errors['contact']) ? 'input-error' : '' ?>"
                       value="<?= old($data['contact']) ?>">
                <?php if (isset($errors['contact'])): ?><span class="error"><?= $errors['contact'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="At least 6 characters"
                       class="<?= isset($errors['password']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['password'])): ?><span class="error"><?= $errors['password'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Re-enter your password"
                       class="<?= isset($errors['confirm_password']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['confirm_password'])): ?><span class="error"><?= $errors['confirm_password'] ?></span><?php endif; ?>
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="form-footer">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>