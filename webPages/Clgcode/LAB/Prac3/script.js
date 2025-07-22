// Student Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('studentForm');
    const displayArea = document.getElementById('displayArea');
    const displayContent = document.getElementById('displayContent');

    // Validation patterns
    const patterns = {
        fullName: /^[a-zA-Z\s]+$/,
        studentId: /^[a-zA-Z0-9]+$/,
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        username: /^[a-zA-Z0-9]{5,15}$/,
        password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
        phoneNumber: /^\d{10}$/
    };

    // Get all form inputs
    const inputs = form.querySelectorAll('input');
    
    // Add blur event listeners
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });

    // Add click event listener to submit button
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        validateForm();
    });

    // Reset form
    form.addEventListener('reset', function() {
        clearAllErrors();
        displayArea.style.display = 'none';
    });

    // Validate individual field
    function validateField(field) {
        const fieldName = field.name;
        const fieldValue = field.value.trim();
        
        clearError(field);
        
        let isValid = true;
        let errorMessage = '';

        if (!fieldValue) {
            errorMessage = getRequiredMessage(fieldName);
            isValid = false;
        } else {
            switch(fieldName) {
                case 'fullName':
                    if (!patterns.fullName.test(fieldValue)) {
                        errorMessage = 'Student name must contain only letters and spaces';
                        isValid = false;
                    }
                    break;
                    
                case 'studentId':
                    if (!patterns.studentId.test(fieldValue)) {
                        errorMessage = 'Student ID must contain only alphanumeric characters';
                        isValid = false;
                    }
                    break;
                    
                case 'email':
                    if (!patterns.email.test(fieldValue)) {
                        errorMessage = 'Please enter a valid email address';
                        isValid = false;
                    }
                    break;
                    
                case 'username':
                    if (!patterns.username.test(fieldValue)) {
                        errorMessage = 'Username must be alphanumeric and 5-15 characters long';
                        isValid = false;
                    }
                    break;
                    
                case 'password':
                    if (!patterns.password.test(fieldValue)) {
                        errorMessage = 'Password must be at least 8 characters with 1 letter, 1 digit, and 1 special character';
                        isValid = false;
                    }
                    // Re-validate confirm password if it has a value
                    const confirmPassword = document.getElementById('confirmPassword');
                    if (confirmPassword.value) {
                        validateField(confirmPassword);
                    }
                    break;
                    
                case 'confirmPassword':
                    const password = document.getElementById('password').value;
                    if (fieldValue !== password) {
                        errorMessage = 'Passwords do not match';
                        isValid = false;
                    }
                    break;
                    
                case 'phoneNumber':
                    if (!patterns.phoneNumber.test(fieldValue)) {
                        errorMessage = 'Phone number must be exactly 10 digits';
                        isValid = false;
                    }
                    break;
            }
        }

        if (!isValid) {
            showError(field, errorMessage);
        }
        
        return isValid;
    }

    // Get required field message
    function getRequiredMessage(fieldName) {
        const messages = {
            fullName: 'Student full name is required',
            studentId: 'Student ID is required',
            email: 'Email is required',
            username: 'Username is required',
            password: 'Password is required',
            confirmPassword: 'Please confirm your password',
            phoneNumber: 'Phone number is required'
        };
        return messages[fieldName];
    }

    // Validate entire form
    function validateForm() {
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!validateField(input)) {
                isFormValid = false;
            }
        });
        
        if (isFormValid) {
            displayFormData();
        }
    }

    // Show error message and highlight field
    function showError(field, message) {
        const errorElement = document.getElementById(field.name + '-error');
        if (errorElement) {
            errorElement.textContent = message;
            field.classList.add('error');
        }
    }

    // Clear error message and highlighting
    function clearError(field) {
        const errorElement = document.getElementById(field.name + '-error');
        if (errorElement) {
            errorElement.textContent = '';
            field.classList.remove('error');
        }
    }

    // Clear all errors
    function clearAllErrors() {
        const errorElements = form.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.textContent = '';
        });
        
        const errorFields = form.querySelectorAll('.error');
        errorFields.forEach(field => {
            field.classList.remove('error');
        });
    }

    // Display form data after successful validation
    function displayFormData() {
        const formData = new FormData(form);
        let displayHTML = '';
        
        displayHTML += `<div class="display-item"><strong>Student Full Name:</strong> ${formData.get('fullName')}</div>`;
        displayHTML += `<div class="display-item"><strong>Student ID:</strong> ${formData.get('studentId')}</div>`;
        displayHTML += `<div class="display-item"><strong>Email:</strong> ${formData.get('email')}</div>`;
        displayHTML += `<div class="display-item"><strong>Username:</strong> ${formData.get('username')}</div>`;
        displayHTML += `<div class="display-item"><strong>Phone Number:</strong> ${formData.get('phoneNumber')}</div>`;
        
        displayContent.innerHTML = displayHTML;
        displayArea.style.display = 'block';
        
        // Add success animation
        displayArea.classList.add('success-animation');
        
        // Remove animation class after animation completes
        setTimeout(() => {
            displayArea.classList.remove('success-animation');
        }, 600);
        
        // Scroll to display area
        displayArea.scrollIntoView({ behavior: 'smooth' });
    }
});