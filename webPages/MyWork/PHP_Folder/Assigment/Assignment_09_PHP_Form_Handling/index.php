<?php
// Assignment 9: PHP Form Handling - Registration Form
// Student: Kheni Urval | ID: 24CE055 | Course: WDF: ITUE203

// Initialize variables for sticky form values
$name = $_GET['name'] ?? '';
$email = $_GET['email'] ?? '';
$age = $_GET['age'] ?? '';
$errors = $_GET['errors'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form - Kheni Urval (24CE055)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Student Info Header -->
    <header class="student-header">
        <div class="container">
            <h1>PHP Registration Form</h1>
            <p><strong>Student:</strong> Kheni Urval | <strong>ID:</strong> 24CE055 | <strong>Course:</strong> WDF: ITUE203</p>
            <p><em>Server-side validation with sticky form values</em></p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="form-container">
                <h2>User Registration</h2>
                <p class="form-description">
                    Fill out the form below to register. All fields are required and validated server-side.
                </p>

                <?php if (!empty($errors)): ?>
                    <div class="error-summary">
                        <h3>⚠ Please correct the following errors:</h3>
                        <ul>
                            <?php foreach ($errors as $field => $error): ?>
                                <li><strong><?php echo ucfirst($field); ?>:</strong> <?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Registration Form -->
                <form action="submit.php" method="POST" class="registration-form" novalidate>
                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="<?php echo htmlspecialchars($name); ?>"
                            class="<?php echo isset($errors['name']) ? 'error' : ''; ?>"
                            placeholder="Enter your full name"
                        >
                        <?php if (isset($errors['name'])): ?>
                            <div class="error-message">
                                <i class="error-icon">⚠</i>
                                <?php echo htmlspecialchars($errors['name']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo htmlspecialchars($email); ?>"
                            class="<?php echo isset($errors['email']) ? 'error' : ''; ?>"
                            placeholder="Enter your email address"
                        >
                        <?php if (isset($errors['email'])): ?>
                            <div class="error-message">
                                <i class="error-icon">⚠</i>
                                <?php echo htmlspecialchars($errors['email']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Age Field -->
                    <div class="form-group">
                        <label for="age">Age *</label>
                        <input 
                            type="number" 
                            id="age" 
                            name="age" 
                            value="<?php echo htmlspecialchars($age); ?>"
                            class="<?php echo isset($errors['age']) ? 'error' : ''; ?>"
                            placeholder="Enter your age"
                            min="1"
                            max="120"
                        >
                        <?php if (isset($errors['age'])): ?>
                            <div class="error-message">
                                <i class="error-icon">⚠</i>
                                <?php echo htmlspecialchars($errors['age']); ?>
                            </div>
                        <?php endif; ?>
                        <small class="help-text">Must be 17 or older to register</small>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="<?php echo isset($errors['password']) ? 'error' : ''; ?>"
                            placeholder="Enter your password"
                        >
                        <?php if (isset($errors['password'])): ?>
                            <div class="error-message">
                                <i class="error-icon">⚠</i>
                                <?php echo htmlspecialchars($errors['password']); ?>
                            </div>
                        <?php endif; ?>
                        <small class="help-text">Minimum 6 characters required</small>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password *</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="<?php echo isset($errors['confirm_password']) ? 'error' : ''; ?>"
                            placeholder="Confirm your password"
                        >
                        <?php if (isset($errors['confirm_password'])): ?>
                            <div class="error-message">
                                <i class="error-icon">⚠</i>
                                <?php echo htmlspecialchars($errors['confirm_password']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="submit-btn">
                            Register Account
                        </button>
                        <button type="reset" class="reset-btn">
                            Clear Form
                        </button>
                    </div>

                    <!-- Form Requirements -->
                    <div class="form-requirements">
                        <h4>Registration Requirements:</h4>
                        <ul>
                            <li>All fields are required</li>
                            <li>Name: 2-50 characters, letters and spaces only</li>
                            <li>Email: Valid email format</li>
                            <li>Age: Must be 17 or older</li>
                            <li>Password: Minimum 6 characters</li>
                            <li>Server-side validation only (no JavaScript)</li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Assignment 9: PHP Form Handling | Student: Kheni Urval (24CE055) | Course: WDF: ITUE203</p>
            <p><em>This form demonstrates server-side validation, sticky form values, and proper PHP form handling.</em></p>
        </div>
    </footer>
</body>
</html>
