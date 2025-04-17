<?php
$pageTitle = "My Progress";
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/auth_functions.php';

check_login();

require_once __DIR__ . '/../../lib/Database.php';
$db = new Database($pdo);

// Get all subjects with progress
$subjects = $db->get_subjects();
$progressData = [];

foreach ($subjects as $subject) {
    $progress = $db->get_user_progress($_SESSION['user_id'], $subject['id']);
    if ($progress) {
        $progressData[] = [
            'subject' => $subject['name'],
            'progress' => $progress['progress'],
            'last_accessed' => $progress['last_accessed']
        ];
    }
}

// Sort by progress descending
usort($progressData, function($a, $b) {
    return $b['progress'] <=> $a['progress'];
});
?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4"><i class="fas fa-chart-line text-primary me-2"></i>My Progress</h1>
            <p class="lead">Track your learning journey across all subjects</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Progress Overview</h4>
                </div>
                <div class="card-body">
                    <canvas id="progressChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-trophy me-2"></i>Achievements</h4>
                </div>
                <div class="card-body">
                    <?php if (count($progressData) > 0): ?>
                        <div class="mb-3">
                            <h5>Top Subject</h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-medal text-warning fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0"><?php echo htmlspecialchars($progressData[0]['subject']); ?></h6>
                                    <div class="progress mt-2" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: <?php echo $progressData[0]['progress']; ?>%" 
                                             aria-valuenow="<?php echo $progressData[0]['progress']; ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted"><?php echo $progressData[0]['progress']; ?>% complete</small>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <h5>Recent Activity</h5>
                        <ul class="list-group list-group-flush">
                            <?php 
                            $recentSubjects = array_slice($progressData, 0, 3);
                            foreach ($recentSubjects as $subject): 
                            ?>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><?php echo htmlspecialchars($subject['subject']); ?></span>
                                        <span class="badge bg-primary rounded-pill"><?php echo $subject['progress']; ?>%</span>
                                    </div>
                                    <small class="text-muted">
                                        Last accessed: <?php echo date('M j, Y', strtotime($subject['last_accessed'])); ?>
                                    </small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No progress data available. Start learning to track your progress!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-list-check me-2"></i>Detailed Progress</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Progress</th>
                                    <th>Last Accessed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($progressData as $subject): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($subject['subject']); ?></td>
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
                                        <a href="/pages/subjects/view.php?subject=<?php echo urlencode($subject['subject']); ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                           <i class="fas fa-book-open me-1"></i>Continue
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (count($progressData) === 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No progress data available. Start learning to track your progress!
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressData = <?php echo json_encode($progressData); ?>;
    
    if (progressData.length > 0) {
        const ctx = document.getElementById('progressChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: progressData.map(item => item.subject),
                datasets: [{
                    label: 'Progress (%)',
                    data: progressData.map(item => item.progress),
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Completion Percentage'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Subjects'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            afterLabel: function(context) {
                                const data = progressData[context.dataIndex];
                                return `Last accessed: ${new Date(data.last_accessed).toLocaleDateString()}`;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>