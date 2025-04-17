<?php
$pageTitle = "Forgot Password";
require_once __DIR__ . '/../../includes/header.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

// Handle password reset request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../lib/Auth.php';
    require_once __DIR__ . '/../../lib/Mailer.php';
    
    $email = trim($_POST['email']);
    $auth = new Auth($pdo);
    
    try {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + PASSWORD_RESET_EXPIRY);
        
        // Store token in database
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);
        
        if ($stmt->rowCount() > 0) {
            // Send email
            $mailer = new Mailer([
                'host' => MAIL_HOST,
                'port' => MAIL_PORT,
                'username' => MAIL_USERNAME,
                'password' => MAIL_PASSWORD,
                'encryption' => MAIL_ENCRYPTION,
                'from_address' => MAIL_FROM_ADDRESS,
                'from_name' => MAIL_FROM_NAME
            ]);
            
            if ($mailer->sendPasswordReset($email, $token)) {
                $success = "Password reset link has been sent to your email.";
            } else {
                $error = "Failed to send password reset email. Please try again.";
            }
        } else {
            $error = "If an account exists with this email, a reset link has been sent.";
        }
    } catch (Exception $e) {
        $error = "An error occurred. Please try again.";
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow animate-fade">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-key me-2"></i>Forgot Password</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php elseif (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php else: ?>
                        <p>Enter your email address and we'll send you a link to reset your password.</p>
                    <?php endif; ?>
                    
                    <form id="forgotPasswordForm" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Please enter a valid email address</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <p class="text-center mb-0">
                        Remember your password? <a href="/pages/auth/login.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>