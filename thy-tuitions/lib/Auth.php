<?php
class Auth {
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function register(string $username, string $email, string $password, string $role = 'student'): bool {
        // Validate inputs
        if (empty($username) || empty($email) || empty($password)) {
            throw new InvalidArgumentException('All fields are required');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }
        
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters');
        }
        
        // Check if email already exists
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            throw new RuntimeException('Email already registered');
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$username, $email, $hashedPassword, $role]);
    }
    
    public function login(string $email, string $password): ?array {
        // Find user by email
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }
        
        // Update last login time
        $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
        
        return $user;
    }
    
    public function logout(): void {
        $_SESSION = [];
        session_destroy();
    }
    
    public function resetPassword(string $email): bool {
        // Generate token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiration
        
        // Store token in database
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);
        
        if ($stmt->rowCount() === 0) {
            return false;
        }
        
        // Send email with reset link
        $resetLink = "https://yourdomain.com/pages/auth/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $resetLink";
        
        // In a real application, use a proper mailer
        return mail($email, $subject, $message);
    }
    
    public function validateResetToken(string $token): bool {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()");
        $stmt->execute([$token]);
        return $stmt->rowCount() > 0;
    }
    
    public function updatePasswordWithToken(string $token, string $newPassword): bool {
        // Validate token first
        if (!$this->validateResetToken($token)) {
            return false;
        }
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password and clear token
        $stmt = $this->pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?");
        return $stmt->execute([$hashedPassword, $token]);
    }
}
?>