// Validation Rules Object
const ValidationRules = {
    candidateName: {
        regex: /^[A-Za-z][A-Za-z\s]{2,}$/,
        message: 'Name must start with a letter, contain only letters and spaces, minimum 3 characters'
    },
    email: {
        regex: /^[\w.%+-]+@[\w.-]+\.[A-Za-z]{2,}$/,
        message: 'Please enter a valid email address'
    },
    username: {
        regex: /^[a-z0-9]{4,16}$/,
        message: 'Username must be 4-16 characters, lowercase letters and digits only'
    },
    password: {
        regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/,
        message: 'Password must be 8+ characters with uppercase, lowercase, digit, and special character'
    },
    phone: {
        regex: /^(\+91[-\s]?)?[6-9]\d{9}$/,
        message: 'Phone must be a valid Indian number (10 digits starting with 6-9, +91 optional)'
    },
    pincode: {
        regex: /^\d{6}$/,
        message: 'Pincode must be exactly 6 digits'
    },
    graduationYear: {
        regex: /^(202[0-9]|2030)$/,
        message: 'Graduation year must be between 2020 and 2030'
    },
    resumeUrl: {
        regex: /^https:\/\/[^\s]+$/,
        message: 'Resume URL must start with https://'
    }
};

// Mock data for async operations
const mockTakenUsernames = new Set([
    'john123', 'jane456', 'admin', 'user1', 'test123', 'developer', 'coder'
]);

const mockPincodeData = {
    '400001': { city: 'Mumbai', state: 'Maharashtra' },
    '110001': { city: 'Delhi', state: 'Delhi' },
    '560001': { city: 'Bangalore', state: 'Karnataka' },
    '600001': { city: 'Chennai', state: 'Tamil Nadu' },
    '500001': { city: 'Hyderabad', state: 'Telangana' },
    '700001': { city: 'Kolkata', state: 'West Bengal' },
    '411001': { city: 'Pune', state: 'Maharashtra' },
    '380001': { city: 'Ahmedabad', state: 'Gujarat' },
    '302001': { city: 'Jaipur', state: 'Rajasthan' },
    '395001': { city: 'Surat', state: 'Gujarat' }
};

// Candidate Class
class Candidate {
    constructor(data = {}) {
        this.candidateName = data.candidateName || '';
        this.email = data.email || '';
        this.username = data.username || '';
        this.phone = data.phone || '';
        this.pincode = data.pincode || '';
        this.city = data.city || '';
        this.state = data.state || '';
        this.graduationYear = data.graduationYear || '';
        this.resumeUrl = data.resumeUrl || '';
        this.timestamp = data.timestamp || new Date();
        this.id = data.id || this.generateId();
    }

    generateId() {
        return `JF-${Date.now()}-${Math.random().toString(36).substr(2, 5)}`;
    }

    validateAll() {
        const results = {};
        const fields = ['candidateName', 'email', 'username', 'phone', 'pincode', 'graduationYear', 'resumeUrl'];
        
        fields.forEach(field => {
            const rule = ValidationRules[field];
            if (rule) {
                const value = this[field];
                results[field] = {
                    valid: rule.regex.test(value),
                    message: rule.regex.test(value) ? '' : rule.message
                };
            }
        });

        // Additional validations for city and state
        results.city = { valid: this.city.trim().length > 0, message: this.city.trim().length > 0 ? '' : 'City is required' };
        results.state = { valid: this.state.trim().length > 0, message: this.state.trim().length > 0 ? '' : 'State is required' };

        return results;
    }

    toJSON() {
        return {
            id: this.id,
            candidateName: this.candidateName,
            email: this.email,
            username: this.username,
            phone: this.phone,
            pincode: this.pincode,
            city: this.city,
            state: this.state,
            graduationYear: this.graduationYear,
            resumeUrl: this.resumeUrl,
            timestamp: this.timestamp
        };
    }

    static fromJSON(json) {
        return new Candidate(json);
    }
}

// Directory Service Object
const DirectoryService = {
    async checkUsernameAvailability(username) {
        return new Promise((resolve) => {
            setTimeout(() => {
                const available = !mockTakenUsernames.has(username.toLowerCase());
                const suggestions = available ? [] : this.generateUsernameSuggestions(username);
                resolve({ available, suggestions });
            }, 800 + Math.random() * 700);
        });
    },

    generateUsernameSuggestions(username) {
        const base = username.replace(/\d+$/, '');
        const suggestions = [];
        
        for (let i = 1; i <= 3; i++) {
            const random = Math.floor(Math.random() * 999) + 1;
            suggestions.push(`${base}${random}`);
        }
        
        return suggestions.filter(s => s.length <= 16);
    },

    async lookupPincode(pincode) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                const data = mockPincodeData[pincode];
                if (data) {
                    resolve(data);
                } else {
                    reject(new Error('Pincode not found'));
                }
            }, 600 + Math.random() * 400);
        });
    },

    async verifyEmailDomain(email) {
        return new Promise((resolve) => {
            setTimeout(() => {
                const domain = email.split('@')[1]?.toLowerCase();
                
                // Mock logic for different domain types
                const academicDomains = ['edu', 'ac.in', 'university.edu', 'college.edu'];
                const disposableDomains = ['tempmail.com', '10minutemail.com', 'guerrillamail.com'];
                const invalidMXDomains = ['invalid-domain.com', 'fake-email.org'];
                
                const isAcademic = academicDomains.some(d => domain?.includes(d));
                const disposable = disposableDomains.includes(domain);
                const mxOk = !invalidMXDomains.includes(domain);
                
                resolve({
                    isAcademic,
                    mxOk,
                    disposable
                });
            }, 1000 + Math.random() * 1000);
        });
    }
};

// Draft Store Object
const DraftStore = {
    storageKey: 'jobfair-draft',
    
    save(data) {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify({
                ...data,
                timestamp: new Date().toISOString()
            }));
        } catch (error) {
            console.error('Failed to save draft:', error);
        }
    },

    restore() {
        try {
            const data = localStorage.getItem(this.storageKey);
            return data ? JSON.parse(data) : null;
        } catch (error) {
            console.error('Failed to restore draft:', error);
            return null;
        }
    },

    clear() {
        try {
            localStorage.removeItem(this.storageKey);
        } catch (error) {
            console.error('Failed to clear draft:', error);
        }
    }
};

// Form Manager Class
class JobFairFormManager {
    constructor() {
        this.form = document.getElementById('jobFairForm');
        this.submitBtn = document.getElementById('submitBtn');
        this.clearDraftBtn = document.getElementById('clearDraftBtn');
        
        this.sections = {
            identity: ['candidateName', 'username', 'password', 'confirmPassword'],
            contact: ['email', 'phone'],
            address: ['pincode', 'city', 'state'],
            academic: ['graduationYear', 'resumeUrl']
        };
        
        this.fieldStates = {};
        this.asyncStates = {};
        
        this.initializeForm();
        this.bindEvents();
        this.restoreDraft();
    }

    initializeForm() {
        // Initialize field states
        Object.values(this.sections).flat().forEach(field => {
            this.fieldStates[field] = { valid: false, touched: false };
        });
        
        // Initialize async states
        this.asyncStates = {
            username: { checked: false, available: false },
            email: { checked: false, valid: false },
            pincode: { checked: false, found: false }
        };
    }

    bindEvents() {
        // Form submission
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
        
        // Clear draft button
        this.clearDraftBtn.addEventListener('click', this.clearDraft.bind(this));
        
        // Field validation events
        Object.values(this.sections).flat().forEach(field => {
            this.bindFieldEvents(field);
        });
        
        // Auto-save on input
        this.form.addEventListener('input', this.debounce(this.saveDraft.bind(this), 1000));
    }

    bindFieldEvents(fieldName) {
        const field = document.getElementById(fieldName);
        if (!field) return;

        field.addEventListener('input', () => {
            this.validateField(fieldName);
            this.updateSectionStatus();
        });
        
        field.addEventListener('blur', () => {
            this.fieldStates[fieldName].touched = true;
            this.validateField(fieldName);
            
            // Async validations on blur
            switch (fieldName) {
                case 'username':
                    this.checkUsernameAvailability(field.value);
                    break;
                case 'email':
                    this.verifyEmailDomain(field.value);
                    break;
                case 'pincode':
                    this.lookupPincode(field.value);
                    break;
                case 'password':
                    this.validateField('confirmPassword'); // Re-validate confirm password
                    break;
            }
            
            this.updateSectionStatus();
        });
    }

    validateField(fieldName) {
        const field = document.getElementById(fieldName);
        const errorElement = document.getElementById(`${fieldName}-error`);
        const value = field.value.trim();

        let isValid = false;
        let message = '';

        // Special handling for confirm password
        if (fieldName === 'confirmPassword') {
            const password = document.getElementById('password').value;
            isValid = value === password && value.length > 0;
            message = isValid ? '' : 'Passwords do not match';
        } else if (fieldName === 'password') {
            // Update password strength
            this.updatePasswordStrength(value);
            // Regular validation
            const rule = ValidationRules[fieldName];
            if (rule) {
                isValid = rule.regex.test(value);
                message = isValid ? '' : rule.message;
            }
        } else {
            // Regular validation
            const rule = ValidationRules[fieldName];
            if (rule) {
                isValid = rule.regex.test(value);
                message = isValid ? '' : rule.message;
            } else if (['city', 'state'].includes(fieldName)) {
                isValid = value.length > 0;
                message = isValid ? '' : `${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)} is required`;
            }
        }

        // Update field state
        this.fieldStates[fieldName].valid = isValid;
        
        // Update UI
        this.updateFieldUI(field, errorElement, isValid, message);
        
        // Update submit button state
        this.updateSubmitButton();
        
        return isValid;
    }

    updateFieldUI(field, errorElement, isValid, message) {
        // Update field classes
        field.classList.remove('valid', 'invalid');
        if (this.fieldStates[field.name]?.touched) {
            field.classList.add(isValid ? 'valid' : 'invalid');
        }
        
        // Update aria-invalid
        field.setAttribute('aria-invalid', !isValid);
        
        // Update error message
        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    updatePasswordStrength(password) {
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let score = 0;
        let feedback = 'Weak';
        
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[@#$%^&+=!]/.test(password)) score++;
        
        // Remove all strength classes
        strengthBar.className = 'strength-bar';
        
        if (score < 3) {
            strengthBar.classList.add('weak');
            feedback = 'Weak';
        } else if (score < 5) {
            strengthBar.classList.add('medium');
            feedback = 'Medium';
        } else {
            strengthBar.classList.add('strong');
            feedback = 'Strong';
        }
        
        strengthText.textContent = `Password strength: ${feedback}`;
        
        // Update field state for strong requirement
        this.fieldStates.password.strong = score === 5;
    }

    async checkUsernameAvailability(username) {
        if (!username || !ValidationRules.username.regex.test(username)) {
            this.hideUsernameStatus();
            return;
        }
        
        const spinner = document.getElementById('username-spinner');
        const statusElement = document.getElementById('username-status');
        const suggestionsElement = document.getElementById('username-suggestions');
        
        spinner.classList.add('active');
        this.hideUsernameStatus();
        
        try {
            const result = await DirectoryService.checkUsernameAvailability(username);
            
            this.asyncStates.username.checked = true;
            this.asyncStates.username.available = result.available;
            
            if (result.available) {
                statusElement.textContent = '✓';
                statusElement.className = 'availability-status available';
                suggestionsElement.classList.remove('show');
            } else {
                statusElement.textContent = '✗';
                statusElement.className = 'availability-status taken';
                this.showUsernameSuggestions(result.suggestions);
            }
            
        } catch (error) {
            console.error('Username check failed:', error);
        } finally {
            spinner.classList.remove('active');
            this.updateSubmitButton();
        }
    }

    hideUsernameStatus() {
        const statusElement = document.getElementById('username-status');
        const suggestionsElement = document.getElementById('username-suggestions');
        statusElement.textContent = '';
        statusElement.className = 'availability-status';
        suggestionsElement.classList.remove('show');
        this.asyncStates.username.checked = false;
    }

    showUsernameSuggestions(suggestions) {
        const suggestionsElement = document.getElementById('username-suggestions');
        
        if (suggestions.length > 0) {
            suggestionsElement.innerHTML = `
                <strong>Suggestions:</strong><br>
                ${suggestions.map(s => `<span class="suggestion-item" onclick="selectUsername('${s}')">${s}</span>`).join('')}
            `;
            suggestionsElement.classList.add('show');
        }
    }

    async verifyEmailDomain(email) {
        if (!email || !ValidationRules.email.regex.test(email)) {
            this.hideEmailBadges();
            return;
        }
        
        const spinner = document.getElementById('email-spinner');
        const badgesContainer = document.getElementById('emailBadges');
        
        spinner.classList.add('active');
        badgesContainer.classList.add('show');
        
        // Reset badges to loading state
        this.updateEmailBadge('mxBadge', 'Checking...');
        this.updateEmailBadge('disposableBadge', 'Checking...');
        this.updateEmailBadge('academicBadge', 'Checking...');
        
        try {
            const result = await DirectoryService.verifyEmailDomain(email);
            
            this.asyncStates.email.checked = true;
            this.asyncStates.email.valid = result.mxOk && !result.disposable;
            
            this.updateEmailBadge('mxBadge', result.mxOk ? 'OK' : 'Fail', result.mxOk ? 'ok' : 'fail');
            this.updateEmailBadge('disposableBadge', result.disposable ? 'Yes' : 'No', result.disposable ? 'fail' : 'ok');
            this.updateEmailBadge('academicBadge', result.isAcademic ? 'Yes' : 'No', result.isAcademic ? 'yes' : 'no');
            
            // Show error if domain is invalid
            if (!result.mxOk || result.disposable) {
                const errorElement = document.getElementById('email-error');
                let message = '';
                if (!result.mxOk) message += 'Invalid domain (MX records fail). ';
                if (result.disposable) message += 'Disposable email addresses are not allowed. ';
                errorElement.textContent = message.trim();
                
                const emailField = document.getElementById('email');
                emailField.classList.add('invalid');
                emailField.setAttribute('aria-invalid', 'true');
            }
            
        } catch (error) {
            console.error('Email verification failed:', error);
            this.hideEmailBadges();
        } finally {
            spinner.classList.remove('active');
            this.updateSubmitButton();
        }
    }

    updateEmailBadge(badgeId, text, status = '') {
        const badge = document.getElementById(badgeId);
        const statusSpan = badge.querySelector('.badge-status');
        statusSpan.textContent = text;
        statusSpan.className = `badge-status ${status}`;
    }

    hideEmailBadges() {
        const badgesContainer = document.getElementById('emailBadges');
        badgesContainer.classList.remove('show');
        this.asyncStates.email.checked = false;
    }

    async lookupPincode(pincode) {
        if (!pincode || !ValidationRules.pincode.regex.test(pincode)) {
            this.clearAddressFields();
            return;
        }
        
        const spinner = document.getElementById('pincode-spinner');
        const cityField = document.getElementById('city');
        const stateField = document.getElementById('state');
        
        spinner.classList.add('active');
        
        try {
            const result = await DirectoryService.lookupPincode(pincode);
            
            this.asyncStates.pincode.checked = true;
            this.asyncStates.pincode.found = true;
            
            // Auto-fill city and state
            cityField.value = result.city;
            stateField.value = result.state;
            
            // Add auto-fill styling
            cityField.classList.add('auto-filled');
            stateField.classList.add('auto-filled');
            
            // Validate the auto-filled fields
            this.validateField('city');
            this.validateField('state');
            
        } catch (error) {
            const pincodeError = document.getElementById('pincode-error');
            pincodeError.textContent = 'Pincode not found. Please enter city and state manually.';
            this.asyncStates.pincode.found = false;
        } finally {
            spinner.classList.remove('active');
            this.updateSubmitButton();
        }
    }

    clearAddressFields() {
        const cityField = document.getElementById('city');
        const stateField = document.getElementById('state');
        
        cityField.classList.remove('auto-filled');
        stateField.classList.remove('auto-filled');
        this.asyncStates.pincode.checked = false;
    }

    updateSectionStatus() {
        Object.keys(this.sections).forEach(section => {
            const fields = this.sections[section];
            const allValid = fields.every(field => this.fieldStates[field]?.valid);
            const anyTouched = fields.some(field => this.fieldStates[field]?.touched);
            const allTouched = fields.every(field => this.fieldStates[field]?.touched);
            
            let status = 'invalid';
            if (allValid && allTouched) {
                status = 'complete';
            } else if (anyTouched && !allValid) {
                status = 'progress';
            }
            
            this.updateStatusBadge(section, status);
        });
    }

    updateStatusBadge(section, status) {
        const statusElement = document.getElementById(`${section}Status`);
        const badge = statusElement.querySelector('.status-badge');
        
        badge.className = `status-badge ${status}`;
        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        
        if (status === 'progress') {
            badge.textContent = 'In Progress';
        }
    }

    updateSubmitButton() {
        const allFieldsValid = Object.values(this.sections).flat().every(field => {
            const state = this.fieldStates[field];
            
            // Special checks
            if (field === 'password') {
                return state.valid && state.strong;
            }
            
            return state.valid;
        });
        
        // Check async validations
        const asyncValid = (
            (!this.asyncStates.username.checked || this.asyncStates.username.available) &&
            (!this.asyncStates.email.checked || this.asyncStates.email.valid)
        );
        
        this.submitBtn.disabled = !allFieldsValid || !asyncValid;
    }

    async handleSubmit(event) {
        event.preventDefault();
        
        // Re-validate all fields
        let allValid = true;
        Object.values(this.sections).flat().forEach(field => {
            this.fieldStates[field].touched = true;
            if (!this.validateField(field)) {
                allValid = false;
            }
        });
        
        if (!allValid) {
            this.showStatusMessage('Please fix all errors before submitting', 'error');
            return;
        }
        
        // Create candidate object
        const formData = new FormData(this.form);
        const candidate = new Candidate({
            candidateName: formData.get('candidateName'),
            email: formData.get('email'),
            username: formData.get('username'),
            phone: formData.get('phone'),
            pincode: formData.get('pincode'),
            city: formData.get('city'),
            state: formData.get('state'),
            graduationYear: formData.get('graduationYear'),
            resumeUrl: formData.get('resumeUrl')
        });
        
        await this.submitRegistration(candidate);
    }

    async submitRegistration(candidate) {
        this.setSubmitLoading(true);
        
        try {
            // Simulate API call
            await this.mockSubmitAPI(candidate);
            
            // Clear draft on successful submission
            DraftStore.clear();
            
            // Show success and preview
            const confirmationNumber = this.generateConfirmationNumber();
            this.showPreview(candidate, confirmationNumber);
            
        } catch (error) {
            this.showStatusMessage(
                `Registration failed: ${error.message}. ` +
                `<button class="retry-btn" onclick="jobFairForm.retrySubmission()">Retry</button>`,
                'error'
            );
        } finally {
            this.setSubmitLoading(false);
        }
    }

    async mockSubmitAPI(candidate) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                // Simulate random failure (20% chance)
                if (Math.random() < 0.2) {
                    reject(new Error('Network timeout. Please check your connection'));
                } else {
                    resolve({ success: true, id: candidate.id });
                }
            }, 2000 + Math.random() * 2000);
        });
    }

    generateConfirmationNumber() {
        return `JF2025-${Date.now().toString().slice(-6)}-${Math.random().toString(36).substr(2, 4).toUpperCase()}`;
    }

    setSubmitLoading(loading) {
        const submitBtn = document.getElementById('submitBtn');
        if (loading) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        } else {
            submitBtn.classList.remove('loading');
            this.updateSubmitButton();
        }
    }

    showStatusMessage(message, type) {
        const statusElement = document.getElementById('statusMessage');
        statusElement.innerHTML = message;
        statusElement.className = `status-message ${type}`;
        
        if (type === 'success') {
            setTimeout(() => {
                statusElement.style.display = 'none';
            }, 5000);
        }
    }

    showPreview(candidate, confirmationNumber) {
        const previewSection = document.getElementById('previewSection');
        const previewCard = document.getElementById('previewCard');
        const confirmationSection = document.getElementById('confirmationSection');
        
        previewCard.innerHTML = `
            <div class="preview-header">
                <div>
                    <h3 class="preview-name">${this.escapeHtml(candidate.candidateName)}</h3>
                    <div class="preview-username">@${this.escapeHtml(candidate.username)}</div>
                </div>
            </div>
            <div class="preview-details">
                <div class="preview-detail">
                    <strong>Email:</strong> ${this.escapeHtml(candidate.email)}
                </div>
                <div class="preview-detail">
                    <strong>Phone:</strong> ${this.escapeHtml(candidate.phone)}
                </div>
                <div class="preview-detail">
                    <strong>Location:</strong> ${this.escapeHtml(candidate.city)}, ${this.escapeHtml(candidate.state)}
                </div>
                <div class="preview-detail">
                    <strong>Graduation:</strong> ${this.escapeHtml(candidate.graduationYear)}
                </div>
                <div class="preview-detail">
                    <strong>Resume:</strong> <a href="${this.escapeHtml(candidate.resumeUrl)}" target="_blank">View Resume</a>
                </div>
            </div>
        `;
        
        confirmationSection.innerHTML = `
            <div class="confirmation-number">Confirmation #${confirmationNumber}</div>
            <div class="confirmation-message">
                Your registration has been successfully submitted! Please save this confirmation number for your records.
            </div>
        `;
        
        previewSection.style.display = 'block';
        previewSection.scrollIntoView({ behavior: 'smooth' });
        
        this.showStatusMessage('Registration submitted successfully!', 'success');
    }

    retrySubmission() {
        // Hide the error message and try again
        document.getElementById('statusMessage').style.display = 'none';
        this.form.dispatchEvent(new Event('submit'));
    }

    saveDraft() {
        const formData = new FormData(this.form);
        const draftData = {};
        
        Object.values(this.sections).flat().forEach(field => {
            draftData[field] = formData.get(field) || '';
        });
        
        DraftStore.save(draftData);
    }

    restoreDraft() {
        const draft = DraftStore.restore();
        if (!draft) return;
        
        Object.keys(draft).forEach(field => {
            if (field === 'timestamp') return;
            
            const fieldElement = document.getElementById(field);
            if (fieldElement && draft[field]) {
                fieldElement.value = draft[field];
                
                // Trigger validation but don't mark as touched yet
                this.validateField(field);
            }
        });
        
        this.updateSectionStatus();
        this.showStatusMessage('Draft restored from previous session', 'success');
    }

    clearDraft() {
        if (confirm('Are you sure you want to clear all form data?')) {
            DraftStore.clear();
            this.form.reset();
            
            // Reset all states
            Object.keys(this.fieldStates).forEach(field => {
                this.fieldStates[field] = { valid: false, touched: false };
            });
            
            // Clear UI states
            this.form.querySelectorAll('input').forEach(field => {
                field.classList.remove('valid', 'invalid', 'auto-filled');
                field.removeAttribute('aria-invalid');
            });
            
            // Clear error messages
            this.form.querySelectorAll('.error-message').forEach(el => {
                el.textContent = '';
            });
            
            // Reset async states
            this.hideUsernameStatus();
            this.hideEmailBadges();
            this.clearAddressFields();
            
            // Reset password strength
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            strengthBar.className = 'strength-bar';
            strengthText.textContent = 'Password strength';
            
            // Update sections and submit button
            this.updateSectionStatus();
            this.updateSubmitButton();
            
            // Hide preview section
            document.getElementById('previewSection').style.display = 'none';
            document.getElementById('statusMessage').style.display = 'none';
            
            this.showStatusMessage('Form cleared successfully', 'success');
        }
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Global functions for event handlers
function selectUsername(username) {
    document.getElementById('username').value = username;
    jobFairForm.validateField('username');
    jobFairForm.checkUsernameAvailability(username);
}

// Initialize the form when DOM is loaded
let jobFairForm;
document.addEventListener('DOMContentLoaded', () => {
    jobFairForm = new JobFairFormManager();
    
    // New registration button handler
    document.getElementById('newRegistrationBtn').addEventListener('click', () => {
        jobFairForm.clearDraft();
    });
});