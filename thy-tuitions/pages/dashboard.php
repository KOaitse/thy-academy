<?php
$pageTitle = "Dashboard";
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/auth_functions.php';

check_login();

require_once __DIR__ . '/../../lib/Database.php';
$db = new Database($pdo);

// Get user data
$user = $db->get_user_by_id($_SESSION['user_id']);

// Get recent activity
$recentSubjects = $db->get_recent_activity($_SESSION['user_id'], 5);

// Get progress summary
$progressSummary = $db->get_progress_summary($_SESSION['user_id']);
?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4"><i class="fas fa-tachometer-alt text-primary me-2"></i>Dashboard</h1>
            <p class="lead">Welcome back, <?php echo htmlspecialchars($user['username']); ?>!</p>
        </div>
    </div>

    <div class="row">
        <!-- Quick Stats -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">Subjects</h6>
                            <h2 class="mb-0"><?php echo count($recentSubjects); ?></h2>
                        </div>
                        <div class="icon-circle bg-white text-primary">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">Avg. Progress</h6>
                            <h2 class="mb-0"><?php echo $progressSummary['average'] ?? 0; ?>%</h2>
                        </div>
                        <div class="icon-circle bg-white text-success">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">Completed</h6>
                            <h2 class="mb-0"><?php echo $progressSummary['completed'] ?? 0; ?></h2>
                        </div>
                        <div class="icon-circle bg-white text-info">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-0">In Progress</h6>
                            <h2 class="mb-0"><?php echo $progressSummary['in_progress'] ?? 0; ?></h2>
                        </div>
                        <div class="icon-circle bg-white text-warning">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Activity</h4>
                </div>
                <div class="card-body">
                    <?php if (count($recentSubjects) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Progress</th>
                                        <th>Last Accessed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentSubjects as $subject): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subject['name']); ?></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: <?php echo $subject['progress']; ?>%" 
                                                     aria-valuenow="<?php echo $subject['progress']; ?>" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <?php echo $subject['progress']; ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo date('M j, Y', strtotime($subject['last_accessed'])); ?></td>
                                        <td>
                                            <a href="/pages/subjects/view.php?id=<?php echo $subject['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                               Continue
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No recent activity found. Start learning to see your progress!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-bullseye me-2"></i>Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/pages/subjects/bgcse.php" class="btn btn-outline-primary text-start">
                            <i class="fas fa-book me-2"></i>BGCSE Subjects
                        </a>
                        <a href="/pages/subjects/jce.php" class="btn btn-outline-primary text-start">
                            <i class="fas fa-book-open me-2"></i>JCE Subjects
                        </a>
                        <a href="/pages/progress.php" class="btn btn-outline-primary text-start">
                            <i class="fas fa-chart-line me-2"></i>View Progress
                        </a>
                        <a href="/pages/profile.php" class="btn btn-outline-primary text-start">
                            <i class="fas fa-user-cog me-2"></i>Edit Profile
                        </a>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mb-3">Recommended Subjects</h5>
                    <div class="list-group">
                        <?php 
                        $recommended = array_slice($recentSubjects, 0, 3);
                        foreach ($recommended as $subject): 
                        ?>
                            <a href="/pages/subjects/view.php?id=<?php echo $subject['id']; ?>" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                               <?php echo htmlspecialchars($subject['name']); ?>
                               <span class="badge bg-primary rounded-pill"><?php echo $subject['progress']; ?>%</span>
                            </a>
                        <?php endforeach; ?>
                        
                        <?php if (count($recommended) === 0): ?>
                            <div class="alert alert-info mb-0">
                                Complete subjects to get recommendations
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>