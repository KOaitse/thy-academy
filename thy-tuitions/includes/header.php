<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Thy Academic Tuitions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Thy Tuitions</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/subjects/bgcse.php">BGCSE</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/subjects/jce.php">JCE</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pages/progress.php">My Progress</a></li>
                </ul>
                <div class="d-flex">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="/pages/profile.php" class="btn btn-light me-2">Profile</a>
                        <a href="/pages/auth/logout.php" class="btn btn-outline-light">Logout</a>
                    <?php else: ?>
                        <a href="/pages/auth/login.php" class="btn btn-light me-2">Login</a>
                        <a href="/pages/auth/register.php" class="btn btn-outline-light">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>