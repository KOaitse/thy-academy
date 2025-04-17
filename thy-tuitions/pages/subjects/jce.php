<?php
$pageTitle = "JCE Subjects";
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/auth_functions.php';

check_login();

require_once __DIR__ . '/../../lib/Database.php';
$db = new Database($pdo);
$subjects = $db->get_subjects('jce');
?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4"><i class="fas fa-book-open text-primary me-2"></i>JCE Subjects</h1>
            <p class="lead">Select a subject to access learning materials</p>
        </div>
        <div class="col-auto">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Search subjects...">
                <button class="btn btn-primary" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4" id="subjectsContainer">
        <?php foreach ($subjects as $subject): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card subject-card h-100">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="fas fa-<?php echo get_subject_icon($subject['name']); ?> me-2"></i>
                        <?php echo htmlspecialchars($subject['name']); ?>
                    </h3>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo htmlspecialchars($subject['description'] ?? 'Comprehensive study materials for this subject'); ?></p>
                    
                    <?php
                    $progress = $db->get_user_progress($_SESSION['user_id'], $subject['id']);
                    $progressValue = $progress ? $progress['progress'] : 0;
                    ?>
                    <div class="mb-3">
                        <small class="text-muted">Your progress:</small>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?php echo $progressValue; ?>%" 
                                 aria-valuenow="<?php echo $progressValue; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                <?php echo $progressValue; ?>%
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="/pages/subjects/view.php?id=<?php echo $subject['id']; ?>" 
                       class="btn btn-primary w-100">
                       <i class="fas fa-arrow-right me-2"></i>View Materials
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const subjectsContainer = document.getElementById('subjectsContainer');
    
    function filterSubjects() {
        const searchTerm = searchInput.value.toLowerCase();
        const cards = subjectsContainer.querySelectorAll('.col-md-6');
        
        cards.forEach(card => {
            const title = card.querySelector('.card-header h3').textContent.toLowerCase();
            const description = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterSubjects);
    searchBtn.addEventListener('click', filterSubjects);
});

function get_subject_icon(subjectName) {
    const icons = {
        'Mathematics': 'calculator',
        'English': 'language',
        'Science': 'flask',
        'History': 'landmark',
        'Geography': 'globe-africa',
        'Setswana': 'language',
        'French': 'language',
        'Art': 'palette',
        'Music': 'music',
        'Physical Education': 'running'
    };
    
    // Default to book icon if not found
    return icons[subjectName] || 'book';
}
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>