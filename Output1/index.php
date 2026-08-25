<?php
$errors = [];
$data = [
    'fullname' => '',
    'age' => '',
    'gender' => '',
    'email' => '',
    'address' => '',
    'contact' => ''
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

    if ($data['fullname'] === '') {
        $errors['fullname'] = 'Full name is required.';
    } elseif (!preg_match('/^[a-zA-Z\s\.\-]+$/', $data['fullname'])) {
        $errors['fullname'] = 'Full name must contain letters only.';
    }

    if ($data['age'] === '') {
        $errors['age'] = 'Age is required.';
    } elseif (!ctype_digit($data['age'])) {
        $errors['age'] = 'Age must be a whole number.';
    } elseif ((int)$data['age'] < 1 || (int)$data['age'] > 120) {
        $errors['age'] = 'Please enter a realistic age (1-120).';
    }

    $allowedGenders = ['Male', 'Female', 'Other'];
    if ($data['gender'] === '') {
        $errors['gender'] = 'Please select a gender.';
    } elseif (!in_array($data['gender'], $allowedGenders)) {
        $errors['gender'] = 'Invalid gender selected.';
    }

    if ($data['email'] === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if ($data['address'] === '') {
        $errors['address'] = 'Address is required.';
    } elseif (strlen($data['address']) < 5) {
        $errors['address'] = 'Address seems too short.';
    }

    if ($data['contact'] === '') {
        $errors['contact'] = 'Contact number is required.';
    } elseif (!preg_match('/^09\d{9}$/', $data['contact'])) {
        $errors['contact'] = 'Enter a valid 11-digit mobile number (e.g. 09123456789).';
    }
}

$hasErrors = count($errors) > 0;
$success = $submitted && !$hasErrors;

function old($val) {
    return htmlspecialchars($val, ENT_QUOTES);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP Output #1 - Personal Information Form</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Personal Information Form</h1>
    <p class="subtitle">PHP Basics - Output #1 (Fields + Validation)</p>

    <?php if ($success): ?>
        <div class="success-box">
            <h3>&#10003; Submitted Successfully!</h3>
            <p><strong>Full Name:</strong> <?= old($data['fullname']) ?></p>
            <p><strong>Age:</strong> <?= old($data['age']) ?></p>
            <p><strong>Gender:</strong> <?= old($data['gender']) ?></p>
            <p><strong>Email:</strong> <?= old($data['email']) ?></p>
            <p><strong>Address:</strong> <?= old($data['address']) ?></p>
            <p><strong>Contact Number:</strong> <?= old($data['contact']) ?></p>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST" novalidate>

        <div class="form-group">
            <label>Full Name <span class="required">*</span></label>
            <input type="text" name="fullname" placeholder="Juan Dela Cruz"
                   class="<?= isset($errors['fullname']) ? 'input-error' : '' ?>"
                   value="<?= old($data['fullname']) ?>">
            <?php if (isset($errors['fullname'])): ?>
                <span class="error"><?= $errors['fullname'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Age <span class="required">*</span></label>
            <input type="number" name="age" placeholder="e.g. 21" min="1" max="120"
                   class="<?= isset($errors['age']) ? 'input-error' : '' ?>"
                   value="<?= old($data['age']) ?>">
            <?php if (isset($errors['age'])): ?>
                <span class="error"><?= $errors['age'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Gender <span class="required">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Male" <?= $data['gender'] === 'Male' ? 'checked' : '' ?>> Male</label>
                <label><input type="radio" name="gender" value="Female" <?= $data['gender'] === 'Female' ? 'checked' : '' ?>> Female</label>
                <label><input type="radio" name="gender" value="Other" <?= $data['gender'] === 'Other' ? 'checked' : '' ?>> Other</label>
            </div>
            <?php if (isset($errors['gender'])): ?>
                <span class="error"><?= $errors['gender'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Email Address <span class="required">*</span></label>
            <input type="email" name="email" placeholder="juan@example.com"
                   class="<?= isset($errors['email']) ? 'input-error' : '' ?>"
                   value="<?= old($data['email']) ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error"><?= $errors['email'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Address <span class="required">*</span></label>
            <textarea name="address" rows="2" placeholder="House No., Street, Barangay, City"
                      class="<?= isset($errors['address']) ? 'input-error' : '' ?>"><?= old($data['address']) ?></textarea>
            <?php if (isset($errors['address'])): ?>
                <span class="error"><?= $errors['address'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Contact Number <span class="required">*</span></label>
            <input type="tel" name="contact" placeholder="09123456789" maxlength="11"
                   class="<?= isset($errors['contact']) ? 'input-error' : '' ?>"
                   value="<?= old($data['contact']) ?>">
            <?php if (isset($errors['contact'])): ?>
                <span class="error"><?= $errors['contact'] ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>