<?php
class Mailer {
    private $host;
    private $port;
    private $username;
    private $password;
    private $encryption;
    private $fromAddress;
    private $fromName;
    
    public function __construct(array $config) {
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->encryption = $config['encryption'];
        $this->fromAddress = $config['from_address'];
        $this->fromName = $config['from_name'];
    }
    
    public function send(string $to, string $subject, string $body, bool $isHtml = true): bool {
        // Create the Transport
        $transport = (new Swift_SmtpTransport($this->host, $this->port, $this->encryption))
            ->setUsername($this->username)
            ->setPassword($this->password);
        
        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        
        // Create a message
        $message = (new Swift_Message($subject))
            ->setFrom([$this->fromAddress => $this->fromName])
            ->setTo([$to])
            ->setBody($body, $isHtml ? 'text/html' : 'text/plain');
        
        // Send the message
        return $mailer->send($message) > 0;
    }
    
    public function sendPasswordReset(string $email, string $token): bool {
        $subject = PASSWORD_RESET_SUBJECT;
        $resetLink = "https://yourdomain.com/pages/auth/reset_password.php?token=$token";
        
        $body = <<<HTML
        <html>
        <body>
            <h2>Password Reset Request</h2>
            <p>You requested to reset your password. Click the link below to proceed:</p>
            <p><a href="$resetLink">Reset Password</a></p>
            <p>This link will expire in 1 hour.</p>
            <p>If you didn't request this, please ignore this email.</p>
        </body>
        </html>
        HTML;
        
        return $this->send($email, $subject, $body);
    }
    
    public function sendVerificationEmail(string $email, string $token): bool {
        $subject = VERIFICATION_SUBJECT;
        $verifyLink = "https://yourdomain.com/pages/auth/verify.php?token=$token";
        
        $body = <<<HTML
        <html>
        <body>
            <h2>Verify Your Account</h2>
            <p>Thank you for registering! Please verify your email by clicking the link below:</p>
            <p><a href="$verifyLink">Verify Email</a></p>
            <p>This link will expire in 24 hours.</p>
        </body>
        </html>
        HTML;
        
        return $this->send($email, $subject, $body);
    }
}
?>