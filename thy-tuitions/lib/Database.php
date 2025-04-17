<?php
class Database {
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function get_user_by_email(string $email): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }
    
    public function get_user_by_id(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    
    public function get_subjects(string $category = null): array {
        $sql = "SELECT * FROM subjects";
        $params = [];
        
        if ($category) {
            $sql .= " WHERE category = ?";
            $params[] = $category;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function get_subject_by_id(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    
    public function get_user_progress(int $userId, int $subjectId): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM user_progress WHERE user_id = ? AND subject_id = ?");
        $stmt->execute([$userId, $subjectId]);
        return $stmt->fetch() ?: null;
    }
    
    public function update_user_progress(int $userId, int $subjectId, int $progress): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO user_progress (user_id, subject_id, progress) 
             VALUES (?, ?, ?) 
             ON DUPLICATE KEY UPDATE progress = VALUES(progress), last_accessed = NOW()"
        );
        return $stmt->execute([$userId, $subjectId, $progress]);
    }
    
    public function get_materials(int $subjectId, string $type = null): array {
        $sql = "SELECT * FROM materials WHERE subject_id = ?";
        $params = [$subjectId];
        
        if ($type) {
            $sql .= " AND type = ?";
            $params[] = $type;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function search_materials(string $query): array {
        $stmt = $this->pdo->prepare(
            "SELECT m.*, s.name AS subject_name 
             FROM materials m
             JOIN subjects s ON m.subject_id = s.id
             WHERE m.title LIKE ? OR s.name LIKE ?"
        );
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function log_activity(int $userId, string $action, string $details = null): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO activity_log (user_id, action, details, ip_address, user_agent) 
             VALUES (?, ?, ?, ?, ?)"
        );
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        return $stmt->execute([$userId, $action, $details, $ip, $ua]);
    }
}
?>