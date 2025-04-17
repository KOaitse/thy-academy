<?php
$pageTitle = "My Profile";
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/auth_functions.php';

check_login();

require_once __DIR__ . '/../../lib/Database.php';
$db = new Database($pdo);
$user = $db->get_user_by_id($_SESSION['user_id']);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    
    // Basic validation
    if (empty($username) || empty($email)) {
        $error = "Username and email are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Check if email is being changed
        if ($email !== $user['email']) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $user['id']]);
            
            if ($stmt->rowCount() > 0) {
                $error = "Email already in use by another account";
            }
        }
        
        // If no errors, proceed with update
        if (!isset($error)) {
            $updateData = [
                'username' => $username,
                'email' => $email,
                'id' => $user['id']
            ];
            
            $sql = "UPDATE users SET username = :username, email = :email";
            $params = $updateData;
            
            // Handle password change if provided
            if (!empty($currentPassword)) {
                if (empty($newPassword)) {
                    $error = "New password is required";
                } elseif (strlen($newPassword) < 8) {
                    $error = "New password must be at least 8 characters";
                } elseif (!password_verify($currentPassword, $user['password'])) {
                    $error = "Current password is incorrect";
                } else {
                    $sql .= ", password = :password";
                    $params['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                }
            }
            
            if (!isset($error)) {
                $sql .= " WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                
                if ($stmt->execute($params)) {
                    // Update session data
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    
                    $success = "Profile updated successfully";
                    $user = $db->get_user_by_id($user['id']); // Refresh user data
                } else {
                    $error = "Failed to update profile. Please try again.";
                }
            }
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Profile</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="/assets/images/avatar.png" class="rounded-circle" width="150" height="150" alt="Profile Picture">
                    </div>
                    <h4><?php echo htmlspecialchars($user['username']); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="text-muted">Member since: <?php echo date('M Y', strtotime($user['created_at'])); ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php elseif (isset($success)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            <div class="invalid-feedback">Please enter a username</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            <div class="invalid-feedback">Please enter a valid email</div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3">Change Password</h5>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <div class="form-text">Leave blank to keep current password</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                            <div class="form-text">At least 8 characters</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>