document.addEventListener('DOMContentLoaded', function() {
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength-bar');
    
    if (passwordInput && strengthBar) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            
            // Update strength bar
            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = 'password-strength-bar ' + strength.class;
            
            // Update hints
            const hints = document.querySelectorAll('.password-hint');
            hints.forEach(hint => {
                const rule = hint.dataset.rule;
                if (strength.rules[rule]) {
                    hint.classList.add('text-success');
                    hint.innerHTML = `<i class="fas fa-check-circle"></i> ${hint.dataset.message}`;
                } else {
                    hint.classList.remove('text-success');
                    hint.innerHTML = `<i class="fas fa-circle"></i> ${hint.dataset.message}`;
                }
            });
        });
    }
    
    // Confirm password validation
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            const password = document.getElementById('password').value;
            if (this.value !== password) {
                this.setCustomValidity("Passwords don't match");
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Calculate password strength
    function calculatePasswordStrength(password) {
        let strength = 0;
        const rules = {
            length: false,
            uppercase: false,
            lowercase: false,
            number: false,
            special: false
        };
        
        // Length check
        if (password.length >= 8) {
            strength += 20;
            rules.length = true;
        }
        
        // Uppercase check
        if (/[A-Z]/.test(password)) {
            strength += 20;
            rules.uppercase = true;
        }
        
        // Lowercase check
        if (/[a-z]/.test(password)) {
            strength += 20;
            rules.lowercase = true;
        }
        
        // Number check
        if (/\d/.test(password)) {
            strength += 20;
            rules.number = true;
        }
        
        // Special char check
        if (/[^A-Za-z0-9]/.test(password)) {
            strength += 20;
            rules.special = true;
        }
        
        // Determine strength class
        let strengthClass;
        if (strength < 40) {
            strengthClass = 'bg-danger';
        } else if (strength < 70) {
            strengthClass = 'bg-warning';
        } else {
            strengthClass = 'bg-success';
        }
        
        return {
            percentage: strength,
            class: strengthClass,
            rules: rules
        };
    }
    
    // Terms and conditions toggle
    const termsCheckbox = document.getElementById('terms');
    const submitButton = document.querySelector('button[type="submit"]');
    
    if (termsCheckbox && submitButton) {
        termsCheckbox.addEventListener('change', function() {
            submitButton.disabled = !this.checked;
        });
    }
});