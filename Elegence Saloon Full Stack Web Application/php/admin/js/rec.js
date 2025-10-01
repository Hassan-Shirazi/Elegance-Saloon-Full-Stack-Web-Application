document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('receptionistForm');
            const passwordToggle = document.getElementById('passwordToggle');
            const passwordInput = document.getElementById('password');
            const successMessage = document.getElementById('successMessage');
            const cancelBtn = document.getElementById('cancelBtn');
            const shiftOptions = document.querySelectorAll('.shift-option');
            
            // Toggle password visibility
            passwordToggle.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggle.classList.remove('fa-eye');
                    passwordToggle.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordToggle.classList.remove('fa-eye-slash');
                    passwordToggle.classList.add('fa-eye');
                }
            });
            
            // Shift selection styling
            shiftOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    shiftOptions.forEach(opt => opt.classList.remove('selected'));
                    // Add selected class to clicked option
                    this.classList.add('selected');
                    // Check the radio button
                    this.querySelector('input').checked = true;
                });
            });
            
            // Cancel button action
            cancelBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                    window.location.href = '#'; // Replace with your actual cancel URL
                }
            });
            
            // Set today's date as default hire date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('hireDate').value = today;
            
            // Form validation and submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Reset previous errors
                resetErrors();
                
                // Get form values
                const fullName = document.getElementById('fullName').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const password = document.getElementById('password').value;
                const shiftSelected = document.querySelector('input[name="shift"]:checked');
                
                let isValid = true;
                
                // Validate full name
                if (fullName === '' || fullName.length < 2) {
                    showError('fullName', 'nameError');
                    isValid = false;
                }
                
                // Validate email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showError('email', 'emailError');
                    isValid = false;
                }
                
                // Validate phone (simple validation for demo)
                const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                const cleanPhone = phone.replace(/\D/g, '');
                if (!phoneRegex.test(cleanPhone)) {
                    showError('phone', 'phoneError');
                    isValid = false;
                }
                
                // Validate password
                if (password.length < 8) {
                    showError('password', 'passwordError');
                    isValid = false;
                }
                
                // Validate shift selection
                if (!shiftSelected) {
                    document.getElementById('shiftError').style.display = 'block';
                    isValid = false;
                }
                
                // If form is valid, show success message
                if (isValid) {
                    successMessage.style.display = 'block';
                    form.reset();
                    
                    // Reset shift selection styling
                    shiftOptions.forEach(opt => opt.classList.remove('selected'));
                    
                    // Reset hire date to today
                    document.getElementById('hireDate').value = today;
                    
                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 5000);
                }
            });
            
            // Helper function to show error
            function showError(inputId, errorId) {
                const inputElement = document.getElementById(inputId);
                if (inputElement) {
                    inputElement.classList.add('error');
                }
                document.getElementById(errorId).style.display = 'block';
            }
            
            // Helper function to reset errors
            function resetErrors() {
                const errorInputs = document.querySelectorAll('.error');
                const errorMessages = document.querySelectorAll('.error-message');
                
                errorInputs.forEach(input => {
                    input.classList.remove('error');
                });
                
                errorMessages.forEach(message => {
                    message.style.display = 'none';
                });
                
                successMessage.style.display = 'none';
            }
            
            // Real-time validation for better UX
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('error');
                    const errorId = this.id + 'Error';
                    if (document.getElementById(errorId)) {
                        document.getElementById(errorId).style.display = 'none';
                    }
                });
            });
        });