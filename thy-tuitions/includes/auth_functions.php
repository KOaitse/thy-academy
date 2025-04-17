<?php
function check_login(): void {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /pages/auth/login.php');
        exit;
    }
}

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function get_current_user_id(): ?int {
    return $_SESSION['user_id'] ?? null;
}

function get_current_user_role(): ?string {
    return $_SESSION['role'] ?? null;
}

function require_role(string $role): void {
    check_login();
    
    if ($_SESSION['role'] !== $role) {
        header('HTTP/1.0 403 Forbidden');
        echo "You don't have permission to access this page.";
        exit;
    }
}

function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function redirect(string $location): void {
    header("Location: $location");
    exit;
}

function get_user_data(PDO $pdo, int $userId): ?array {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch() ?: null;
}
?>