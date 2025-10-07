// Validation Rules Object
const ValidationRules = {
    fullName: {
        regex: /^[A-Za-z][A-Za-z.\s]{2,}$/,
        message: 'Name must start with a letter, contain only letters, spaces, and dots, minimum 3 characters'
    },
    email: {
        regex: /^[\w.%+-]+@[\w.-]+\.edu$/i,
        message: 'Email must be from an educational institution (.edu domain)'
    },
    phone: {
        regex: /^[6-9]\d{9}$/,
        message: 'Phone must be 10 digits starting with 6-9'
    },
    collegeId: {
        regex: /^CSPIT-IT-\d{4}-\d{3}$/,
        message: 'College ID must follow format: CSPIT-IT-YYYY-XXX'
    },
    password: {
        regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/,
        message: 'Password must be 8+ characters with uppercase, lowercase, digit, and special character'
    }
};

// Track information
const TrackInfo = {
    'Web': 'Web Development: Please bring your laptop with a modern browser installed.',
    'AI/ML': 'AI/ML: Ensure you have Python and Jupyter notebooks ready.',
    'CyberSec': 'Cyber Security: Bring laptop with virtualization support enabled.'
};

// Mock registered emails for uniqueness check
const registeredEmails = new Set([
    'john.doe@university.edu',
    'jane.smith@college.edu',
    'test@example.edu'
]);

// Mock valid college IDs
const validCollegeIds = new Set([
    'CSPIT-IT-2025-001',
    'CSPIT-IT-2025-002',
    'CSPIT-IT-2025-003',
    'CSPIT-IT-2024-001',
    'CSPIT-IT-2024-002'
]);

// Registrant Class
class Registrant {
    constructor(name, email, phone, collegeId, track, timestamp = new Date()) {
        this.name = name;
        this.email = email;
        this.phone = phone;
        this.collegeId = collegeId;
        this.track = track;
        this.timestamp = timestamp;
        this.id = this.generateId();
    }

    generateId() {
        return `REG-${Date.now()}-${Math.random().toString(36).substr(2, 5)}`;
    }

    validateField(fieldName, value) {
        const rule = ValidationRules[fieldName];
        if (!rule) return { valid: true, message: '' };

        const valid = rule.regex.test(value);
        return {
            valid,
            message: valid ? '' : rule.message
        };
    }

    toJSON() {
        return {
            id: this.id,
            name: this.name,
            email: this.email,
            phone: this.phone,
            collegeId: this.collegeId,
            track: this.track,
            timestamp: this.timestamp
        };
    }

    static fromJSON(json) {
        const registrant = new Registrant(
            json.name,
            json.email,
            json.phone,
            json.collegeId,
            json.track,
            new Date(json.timestamp)
        );
        registrant.id = json.id;
        return registrant;
    }
}

// Registry Store Class
class RegistryStore {
    constructor() {
        this.registrants = [];
        this.storageKey = 'techfest-registrants';
        this.loadFromStorage();
    }

    add(registrant) {
        // Check for duplicate email
        if (this.findByEmail(registrant.email)) {
            throw new Error('Email already registered');
        }
        
        this.registrants.push(registrant);
        this.saveToStorage();
        return registrant;
    }

    findByEmail(email) {
        return this.registrants.find(r => r.email.toLowerCase() === email.toLowerCase());
    }

    getAll() {
        return [...this.registrants];
    }

    saveToStorage() {
        try {
            const data = this.registrants.map(r => r.toJSON());
            localStorage.setItem(this.storageKey, JSON.stringify(data));
        } catch (error) {
            console.error('Failed to save to localStorage:', error);
        }
    }

    loadFromStorage() {
        try {
            const data = localStorage.getItem(this.storageKey);
            if (data) {
                const parsed = JSON.parse(data);
                this.registrants = parsed.map(item => Registrant.fromJSON(item));
            }
        } catch (error) {
            console.error('Failed to load from localStorage:', error);
            this.registrants = [];
        }
    }

    exportJSON() {
        return JSON.stringify(this.registrants.map(r => r.toJSON()), null, 2);
    }
}

// Form Manager Class
class FormManager {
    constructor() {
        this.form = document.getElementById('registrationForm');
        this.submitBtn = document.getElementById('submitBtn');
        this.resetBtn = document.getElementById('resetBtn');
        this.registryStore = new RegistryStore();
        this.fieldStates = {};
        
        this.initializeForm();
        this.bindEvents();
        this.renderRegistrants();
    }

    initializeForm() {
        // Initialize field states
        const fields = ['fullName', 'email', 'phone', 'collegeId', 'password', 'confirmPassword', 'track', 'terms'];
        fields.forEach(field => {
            this.fieldStates[field] = { valid: false, touched: false };
        });
    }

    bindEvents() {
        // Form submission
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
        
        // Reset button
        this.resetBtn.addEventListener('click', this.handleReset.bind(this));
        
        // Field validation events
        this.bindFieldEvents('fullName');
        this.bindFieldEvents('email');
        this.bindFieldEvents('phone');
        this.bindFieldEvents('collegeId');
        this.bindFieldEvents('password');
        this.bindFieldEvents('confirmPassword');
        this.bindFieldEvents('track');
        this.bindFieldEvents('terms');
        
        // Track selection
        document.getElementById('track').addEventListener('change', this.handleTrackChange.bind(this));
        
        // Export button
        document.getElementById('exportBtn').addEventListener('click', this.exportRegistrants.bind(this));
    }

    bindFieldEvents(fieldName) {
        const field = document.getElementById(fieldName);
        if (!field) return;

        field.addEventListener('input', () => this.validateField(fieldName));
        field.addEventListener('blur', () => {
            this.fieldStates[fieldName].touched = true;
            this.validateField(fieldName);
            
            // Async validations on blur
            if (fieldName === 'email') {
                this.validateEmailUniqueness(field.value);
            } else if (fieldName === 'collegeId') {
                this.validateCollegeId(field.value);
            }
        });
    }

    validateField(fieldName) {
        const field = document.getElementById(fieldName);
        const errorElement = document.getElementById(`${fieldName}-error`);
        const value = field.value.trim();

        let isValid = false;
        let message = '';

        // Special handling for different field types
        switch (fieldName) {
            case 'confirmPassword':
                const password = document.getElementById('password').value;
                isValid = value === password && value.length > 0;
                message = isValid ? '' : 'Passwords do not match';
                break;
                
            case 'terms':
                isValid = field.checked;
                message = isValid ? '' : 'You must agree to the terms and conditions';
                break;
                
            case 'track':
                isValid = value !== '';
                message = isValid ? '' : 'Please select a track';
                break;
                
            case 'password':
                this.updatePasswordStrength(value);
                // Fall through to default validation
                
            default:
                if (ValidationRules[fieldName]) {
                    const result = new Registrant().validateField(fieldName, value);
                    isValid = result.valid;
                    message = result.message;
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
        errorElement.textContent = message;
    }

    updatePasswordStrength(password) {
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let score = 0;
        let feedback = 'Very Weak';
        
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[@#$%^&+=!]/.test(password)) score++;
        
        // Remove all strength classes
        strengthBar.className = 'strength-bar';
        
        switch (score) {
            case 0:
            case 1:
                strengthBar.classList.add('weak');
                feedback = 'Weak';
                break;
            case 2:
            case 3:
                strengthBar.classList.add('fair');
                feedback = 'Fair';
                break;
            case 4:
                strengthBar.classList.add('good');
                feedback = 'Good';
                break;
            case 5:
                strengthBar.classList.add('strong');
                feedback = 'Strong';
                break;
        }
        
        strengthText.textContent = `Password strength: ${feedback}`;
        
        // Update password field state for strong requirement
        if (this.fieldStates.password) {
            this.fieldStates.password.strong = score === 5;
        }
    }

    async validateEmailUniqueness(email) {
        if (!email || !ValidationRules.email.regex.test(email)) return;
        
        const spinner = document.getElementById('email-spinner');
        const errorElement = document.getElementById('email-error');
        
        spinner.classList.add('active');
        
        try {
            // Simulate API call
            await this.mockEmailCheck(email);
            
            // Check against localStorage registrants
            const existingRegistrant = this.registryStore.findByEmail(email);
            if (existingRegistrant) {
                throw new Error('Email already registered in our system');
            }
            
            // Email is unique
            this.fieldStates.email.unique = true;
            
        } catch (error) {
            this.fieldStates.email.unique = false;
            this.fieldStates.email.valid = false;
            errorElement.textContent = error.message;
            
            const emailField = document.getElementById('email');
            emailField.classList.remove('valid');
            emailField.classList.add('invalid');
            emailField.setAttribute('aria-invalid', 'true');
        } finally {
            spinner.classList.remove('active');
            this.updateSubmitButton();
        }
    }

    async mockEmailCheck(email) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                if (registeredEmails.has(email.toLowerCase())) {
                    reject(new Error('Email already registered'));
                } else {
                    resolve();
                }
            }, 1000 + Math.random() * 1000); // 1-2 second delay
        });
    }

    async validateCollegeId(collegeId) {
        if (!collegeId || !ValidationRules.collegeId.regex.test(collegeId)) {
            this.updateCollegeIdStatus('');
            return;
        }
        
        const statusElement = document.getElementById('collegeId-status');
        statusElement.textContent = '⏳';
        statusElement.className = 'verification-status';
        
        try {
            await this.mockCollegeIdCheck(collegeId);
            this.updateCollegeIdStatus('verified');
            this.fieldStates.collegeId.verified = true;
        } catch (error) {
            this.updateCollegeIdStatus('not-found');
            this.fieldStates.collegeId.verified = false;
        }
        
        this.updateSubmitButton();
    }

    async mockCollegeIdCheck(collegeId) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                if (validCollegeIds.has(collegeId)) {
                    resolve();
                } else {
                    reject(new Error('College ID not found'));
                }
            }, 800 + Math.random() * 800);
        });
    }

    updateCollegeIdStatus(status) {
        const statusElement = document.getElementById('collegeId-status');
        statusElement.className = 'verification-status';
        
        switch (status) {
            case 'verified':
                statusElement.textContent = '✓';
                statusElement.classList.add('verified');
                break;
            case 'not-found':
                statusElement.textContent = '✗';
                statusElement.classList.add('not-found');
                break;
            default:
                statusElement.textContent = '';
        }
    }

    handleTrackChange(event) {
        const track = event.target.value;
        const noteElement = document.getElementById('track-note');
        
        if (track && TrackInfo[track]) {
            noteElement.textContent = TrackInfo[track];
            noteElement.classList.add('show');
        } else {
            noteElement.classList.remove('show');
        }
        
        this.validateField('track');
    }

    updateSubmitButton() {
        const allFieldsValid = Object.keys(this.fieldStates).every(field => {
            const state = this.fieldStates[field];
            
            // Special checks
            if (field === 'password') {
                return state.valid && state.strong;
            }
            if (field === 'email') {
                return state.valid && state.unique !== false;
            }
            if (field === 'collegeId') {
                return state.valid && state.verified !== false;
            }
            
            return state.valid;
        });
        
        this.submitBtn.disabled = !allFieldsValid;
    }

    async handleSubmit(event) {
        event.preventDefault();
        
        // Re-validate all fields
        let allValid = true;
        Object.keys(this.fieldStates).forEach(field => {
            this.fieldStates[field].touched = true;
            if (!this.validateField(field)) {
                allValid = false;
            }
        });
        
        if (!allValid) {
            this.showToast('Please fix all errors before submitting', 'error');
            return;
        }
        
        // Create registrant object
        const formData = new FormData(this.form);
        const registrant = new Registrant(
            formData.get('fullName'),
            formData.get('email'),
            formData.get('phone'),
            formData.get('collegeId'),
            formData.get('track')
        );
        
        try {
            this.registryStore.add(registrant);
            this.showToast('Registration successful!');
            this.renderRegistrants();
            this.handleReset();
        } catch (error) {
            this.showToast(error.message, 'error');
        }
    }

    handleReset() {
        // Reset form
        this.form.reset();
        
        // Reset field states
        Object.keys(this.fieldStates).forEach(field => {
            this.fieldStates[field] = { valid: false, touched: false };
        });
        
        // Clear UI states
        this.form.querySelectorAll('input, select').forEach(field => {
            field.classList.remove('valid', 'invalid');
            field.removeAttribute('aria-invalid');
        });
        
        // Clear error messages
        this.form.querySelectorAll('.error-message').forEach(el => {
            el.textContent = '';
        });
        
        // Clear password strength
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        strengthBar.className = 'strength-bar';
        strengthText.textContent = 'Password strength';
        
        // Clear track note
        document.getElementById('track-note').classList.remove('show');
        
        // Clear college ID status
        this.updateCollegeIdStatus('');
        
        // Update submit button
        this.updateSubmitButton();
    }

    showToast(message, type = 'success') {
        const toast = document.getElementById('successToast');
        const messageEl = toast.querySelector('.toast-message');
        const iconEl = toast.querySelector('.toast-icon');
        
        messageEl.textContent = message;
        iconEl.textContent = type === 'success' ? '✓' : '✗';
        
        toast.className = `toast ${type}`;
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    renderRegistrants() {
        const container = document.getElementById('registrantsList');
        const registrants = this.registryStore.getAll();
        
        if (registrants.length === 0) {
            container.innerHTML = '<p style="text-align: center; color: #666; font-style: italic;">No registrations yet.</p>';
            return;
        }
        
        container.innerHTML = registrants.map(registrant => `
            <div class="registrant-card">
                <div class="registrant-header">
                    <h3 class="registrant-name">${this.escapeHtml(registrant.name)}</h3>
                    <span class="registrant-track">${this.escapeHtml(registrant.track)}</span>
                </div>
                <div class="registrant-details">
                    <div class="registrant-detail">
                        <strong>Email:</strong> ${this.escapeHtml(registrant.email)}
                    </div>
                    <div class="registrant-detail">
                        <strong>Phone:</strong> ${this.escapeHtml(registrant.phone)}
                    </div>
                    <div class="registrant-detail">
                        <strong>College ID:</strong> ${this.escapeHtml(registrant.collegeId)}
                    </div>
                    <div class="registrant-detail">
                        <strong>Registered:</strong> ${new Date(registrant.timestamp).toLocaleDateString()}
                    </div>
                </div>
            </div>
        `).join('');
    }

    exportRegistrants() {
        const data = this.registryStore.exportJSON();
        const blob = new Blob([data], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        
        const a = document.createElement('a');
        a.href = url;
        a.download = `techfest-registrants-${new Date().toISOString().split('T')[0]}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        this.showToast('Registrants exported successfully!');
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize the form when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new FormManager();
});

// Add some additional registered emails for testing
registeredEmails.add('existing@university.edu');
registeredEmails.add('taken@college.edu');