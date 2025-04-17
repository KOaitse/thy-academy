</main>
        
        <footer class="bg-dark text-white py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Thy Academic Tuitions</h5>
                        <p>Empowering students to excel in their academic journey through quality online education.</p>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/" class="text-white">Home</a></li>
                            <li><a href="/pages/subjects/bgcse.php" class="text-white">BGCSE Subjects</a></li>
                            <li><a href="/pages/subjects/jce.php" class="text-white">JCE Subjects</a></li>
                            <li><a href="/pages/contact.php" class="text-white">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Connect With Us</h5>
                        <div class="social-links">
                            <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <div class="mt-3">
                            <a href="mailto:info@thyacademictuitions.com" class="text-white"><i class="fas fa-envelope me-2"></i>info@thyacademictuitions.com</a>
                        </div>
                    </div>
                </div>
                <hr class="my-4 bg-light">
                <div class="text-center">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Thy Academic Tuitions. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Custom JS -->
        <script src="/assets/js/main.js"></script>
        <?php if(isset($customJS)): ?>
            <script src="/assets/js/<?php echo $customJS; ?>"></script>
        <?php endif; ?>
    </body>
</html>