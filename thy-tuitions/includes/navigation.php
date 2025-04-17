<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-graduation-cap me-2"></i>Thy Tuitions
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="fas fa-home me-1"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages\subjects\bgcse.php"><i class="fas fa-book me-1"></i> BGCSE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages\subjects\jce.php"><i class="fas fa-book-open me-1"></i> JCE</a>
                </li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/pages/progress.php"><i class="fas fa-chart-line me-1"></i> Progress</a>
                </li>
                <?php endif; ?>
            </ul>
            
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-outline-light me-2" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/pages/profile.php"><i class="fas fa-user me-1"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="/pages/dashboard.php"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/pages/auth/logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="/pages/auth/login.php" class="btn btn-light me-2"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                    <a href="/pages/auth/register.php" class="btn btn-outline-light"><i class="fas fa-user-plus me-1"></i> Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>