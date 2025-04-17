<?php
$pageTitle = "Home";
require_once __DIR__ . '/includes/header.php';
?>

  <!-- Hero Section -->
  <section class="py-5 text-center bg-primary text-white">
    <div class="container">
      <h1 class="display-4 fw-bold">Empower Your Learning</h1>
      <p class="lead">Master BGCSE & JCE with interactive study materials, trusted tutors, and real-time progress tracking.</p>
      <a href="auth/register.php" class="btn btn-light btn-lg mt-3">Get Started</a>
    </div>
  </section>

  <!-- Image Carousel -->
  <section class="py-5">
    <div class="container">
      <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="assets/images/slide1.png" class="d-block w-100 carousel-img" alt="Slide 1">
          </div>
          <div class="carousel-item">
            <img src="assets/images/slide2.png" class="d-block w-100 carousel-img" alt="Slide 2">
          </div>
          <div class="carousel-item">
            <img src="assets/images/slide3.png" class="d-block w-100 carousel-img" alt="Slide 3">
          </div>
          <div class="carousel-item">
            <img src="assets/images/slide4.png" class="d-block w-100 carousel-img" alt="Slide 4">
          </div>
          <div class="carousel-item">
            <img src="assets/images/slide5.png" class="d-block w-100 carousel-img" alt="Slide 5">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row text-center">
        <h2 class="text-center mb-5">Why Choose Thy Academic Tuitions?</h2>
        <div class="col-md-4 mb-4">
          <i class="fas fa-user-graduate fa-2x mb-3 text-primary"></i>
          <h5>Personalized Learning</h5>
          <p>Access topic-based notes, past papers, and video tutorials tailored for your success.</p>
        </div>
        <div class="col-md-4 mb-4">
          <i class="fas fa-chart-line fa-2x mb-3 text-primary"></i>
          <h5>Track Your Progress</h5>
          <p>Use your dashboard to monitor completed lessons, quiz scores, and more.</p>
        </div>
        <div class="col-md-4 mb-4">
          <i class="fas fa-chalkboard-teacher fa-2x mb-3 text-primary"></i>
          <h5>Find Expert Tutors</h5>
          <p>Connect with subject specialists for online or in-person sessions based on availability.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Our Students Say</h2>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <img src="/assets/images/student1.jpg" class="rounded-circle mb-3 mb-md-0 img-fluid" width="150" height="150" alt="Student">
                                        </div>
                                        <div class="col-md-8">
                                            <p class="lead mb-4">"Thy Academic Tuitions helped me improve my Mathematics grade from a D to an A in just 3 months. The tutors are amazing!"</p>
                                            <h5 class="mb-1">Tshepo M.</h5>
                                            <p class="text-muted">BGCSE Student, Gaborone</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="row align-items-center flex-row-reverse">
                                        <div class="col-md-4">
                                            <img src="/assets/images/student2.jpg" class="rounded-circle mb-3 mb-md-0 img-fluid" width="150" height="150" alt="Student">
                                        </div>
                                        <div class="col-md-8">
                                            <p class="lead mb-4">"The Setswana lessons were so helpful. I finally understand the grammar rules that confused me in class."</p>
                                            <h5 class="mb-1">Amantle K.</h5>
                                            <p class="text-muted">JCE Student, Francistown</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <img src="/assets/images/student3.jpg" class="rounded-circle mb-3 mb-md-0 img-fluid" width="150" height="150" alt="Student">
                                        </div>
                                        <div class="col-md-8">
                                            <p class="lead mb-4">"I love being able to learn at my own pace. The video lessons make difficult concepts so much easier to understand."</p>
                                            <h5 class="mb-1">Kagiso P.</h5>
                                            <p class="text-muted">BGCSE Student, Maun</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-primary rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-primary rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

  <!-- Call to Action -->
  <section class="py-5 bg-white text-center">
    <div class="container">
      <h2 class="fw-bold mb-3">Ready to Elevate Your Learning?</h2>
      <p class="mb-4">Join thousands of students using Thy Academy to prepare smarter.</p>
      <a href="auth/register.php" class="btn btn-primary btn-lg">Sign Up Now</a>
    </div>
  </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>