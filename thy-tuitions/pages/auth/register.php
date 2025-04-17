<?php
$pageTitle = "Register";
$customJS = "auth.js";
require_once __DIR__ . '/../../includes/header.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../lib/Auth.php';
    $auth = new Auth($pdo);
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = 'student'; // Default role
    
    try {
        $success = $auth->register($username, $email, $password, $role);
        
        if ($success) {
            $_SESSION['success_message'] = "Registration successful! Please login.";
            header('Location: /pages/auth/login.php');
            exit;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow animate-fade">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create Your Account</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <form id="registerForm" method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <div class="invalid-feedback">Please choose a username</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary password-toggle" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Please enter a password</div>
                            
                            <div class="password-strength mt-2">
                                <div id="password-strength-bar" class="password-strength-bar"></div>
                            </div>
                            
                            <div class="password-hints mt-2">
                                <small>Password must contain:</small>
                                <ul class="list-unstyled">
                                    <li class="password-hint" data-rule="length" data-message="At least 8 characters">
                                        <i class="fas fa-circle"></i> At least 8 characters
                                    </li>
                                    <li class="password-hint" data-rule="uppercase" data-message="At least 1 uppercase letter">
                                        <i class="fas fa-circle"></i> At least 1 uppercase letter
                                    </li>
                                    <li class="password-hint" data-rule="lowercase" data-message="At least 1 lowercase letter">
                                        <i class="fas fa-circle"></i> At least 1 lowercase letter
                                    </li>
                                    <li class="password-hint" data-rule="number" data-message="At least 1 number">
                                        <i class="fas fa-circle"></i> At least 1 number
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback">Passwords must match</div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="/terms.php" target="_blank">Terms and Conditions</a>
                            </label>
                            <div class="invalid-feedback">You must agree to the terms</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <p class="text-center mb-0">Already have an account? <a href="/pages/auth/login.php">Login here</a></p>
                    
                    <div class="social-auth mt-4">
                        <p class="text-center text-muted">Or register with</p>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="social-btn google">
                                <i class="fab fa-google"></i>
                            </a>
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>