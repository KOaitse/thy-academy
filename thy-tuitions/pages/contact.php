<?php
$pageTitle = "Contact Us";
require_once __DIR__ . '/../../includes/header.php';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    // Basic validation
    $errors = [];
    
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (empty($subject)) {
        $errors['subject'] = 'Subject is required';
    }
    
    if (empty($message)) {
        $errors['message'] = 'Message is required';
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        require_once __DIR__ . '/../../lib/Mailer.php';
        
        $mailer = new Mailer([
            'host' => MAIL_HOST,
            'port' => MAIL_PORT,
            'username' => MAIL_USERNAME,
            'password' => MAIL_PASSWORD,
            'encryption' => MAIL_ENCRYPTION,
            'from_address' => MAIL_FROM_ADDRESS,
            'from_name' => MAIL_FROM_NAME
        ]);
        
        // Email to admin
        $adminSubject = "New Contact Form Submission: $subject";
        $adminBody = "
        <html>
        <body>
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        </body>
        </html>
        ";
        
        // Email to user
        $userSubject = "Thank you for contacting us";
        $userBody = "
        <html>
        <body>
            <h2>Thank you for contacting Thy Academic Tuitions</h2>
            <p>We have received your message and will get back to you soon.</p>
            <p>Here's a copy of your message:</p>
            <blockquote>$message</blockquote>
            <p>Best regards,<br>The Thy Academic Tuitions Team</p>
        </body>
        </html>
        ";
        
        // Send emails
        $adminSent = $mailer->send(MAIL_FROM_ADDRESS, $adminSubject, $adminBody);
        $userSent = $mailer->send($email, $userSubject, $userBody);
        
        if ($adminSent && $userSent) {
            $success = "Thank you for your message! We'll get back to you soon.";
            // Clear form
            $name = $email = $subject = $message = '';
        } else {
            $error = "Failed to send your message. Please try again later.";
        }
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow animate-fade">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Us</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php elseif (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                                       id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                                <?php if (isset($errors['name'])): ?>
                                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['name']); ?></div>
                                <?php else: ?>
                                    <div class="invalid-feedback">Please enter your name</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                       id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['email']); ?></div>
                                <?php else: ?>
                                    <div class="invalid-feedback">Please enter a valid email</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control <?php echo isset($errors['subject']) ? 'is-invalid' : ''; ?>" 
                                   id="subject" name="subject" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required>
                            <?php if (isset($errors['subject'])): ?>
                                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['subject']); ?></div>
                            <?php else: ?>
                                <div class="invalid-feedback">Please enter a subject</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control <?php echo isset($errors['message']) ? 'is-invalid' : ''; ?>" 
                                      id="message" name="message" rows="5" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['message']); ?></div>
                            <?php else: ?>
                                <div class="invalid-feedback">Please enter your message</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="consent" name="consent" required>
                                <label class="form-check-label" for="consent">
                                    I consent to Thy Academic Tuitions collecting my details through this form
                                </label>
                                <div class="invalid-feedback">You must agree before submitting</div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>Our Location</h5>
                            <p class="mb-0">123 Education Street<br>Gaborone, Botswana</p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-phone-alt text-primary me-2"></i>Contact Info</h5>
                            <p class="mb-1"><strong>Email:</strong> info@thyacademictuitions.com</p>
                            <p class="mb-0"><strong>Phone:</strong> +267 123 4567</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>