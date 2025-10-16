// Assignment 6: String Utilities Library
// Student: Kheni Urval | ID: 24CE055 | Course: WDF: ITUE203

/**
 * String utility functions for common text processing tasks
 * All functions are pure (no side effects) and handle edge cases
 * Created by: Kheni Urval (Student ID: 24CE055)
 */

// 1. Convert string to title case
const toTitleCase = (str) => {
    if (typeof str !== 'string') return '';
    if (str.length === 0) return str;
    
    return str.toLowerCase()
        .split(' ')
        .map(word => {
            if (word.length === 0) return word;
            return word.charAt(0).toUpperCase() + word.slice(1);
        })
        .join(' ');
};

// 2. Trim extra spaces (multiple spaces become single space)
const trimExtraSpaces = (str) => {
    if (typeof str !== 'string') return '';
    
    return str.trim().replace(/\s+/g, ' ');
};

// 3. Count word frequency in text
const wordFrequency = (str) => {
    if (typeof str !== 'string') return {};
    if (str.length === 0) return {};
    
    const words = str.toLowerCase()
        .replace(/[^\w\s]/g, '') // Remove punctuation
        .split(/\s+/)
        .filter(word => word.length > 0);
    
    const frequency = {};
    
    words.forEach(word => {
        frequency[word] = (frequency[word] || 0) + 1;
    });
    
    return frequency;
};

// 4. Mask email address for privacy
const maskEmail = (email) => {
    if (typeof email !== 'string') return '';
    if (!email.includes('@')) return email;
    
    const [username, domain] = email.split('@');
    
    if (username.length <= 2) {
        return `${username}@${domain}`;
    }
    
    const maskedUsername = username.charAt(0) + 
        '*'.repeat(Math.max(0, username.length - 2)) + 
        username.charAt(username.length - 1);
    
    return `${maskedUsername}@${domain}`;
};

// 5. Additional utility: Capitalize first letter only
const capitalizeFirst = (str) => {
    if (typeof str !== 'string') return '';
    if (str.length === 0) return str;
    
    return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
};

// 6. Additional utility: Count characters excluding spaces
const countChars = (str) => {
    if (typeof str !== 'string') return 0;
    
    return str.replace(/\s/g, '').length;
};

// 7. Additional utility: Reverse words in string
const reverseWords = (str) => {
    if (typeof str !== 'string') return '';
    
    return str.split(' ').reverse().join(' ');
};

// 8. Additional utility: Extract initials from name
const getInitials = (name) => {
    if (typeof name !== 'string') return '';
    
    return name.trim()
        .split(' ')
        .filter(word => word.length > 0)
        .map(word => word.charAt(0).toUpperCase())
        .join('');
};

// 9. Additional utility: Truncate string with ellipsis
const truncate = (str, maxLength = 50) => {
    if (typeof str !== 'string') return '';
    if (str.length <= maxLength) return str;
    
    return str.slice(0, maxLength - 3) + '...';
};

// 10. Additional utility: Check if string is palindrome
const isPalindrome = (str) => {
    if (typeof str !== 'string') return false;
    
    const cleaned = str.toLowerCase().replace(/[^a-z0-9]/g, '');
    return cleaned === cleaned.split('').reverse().join('');
};

// Export functions for use in demo page
const StringUtils = {
    toTitleCase,
    trimExtraSpaces,
    wordFrequency,
    maskEmail,
    capitalizeFirst,
    countChars,
    reverseWords,
    getInitials,
    truncate,
    isPalindrome
};

// For Node.js environments (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = StringUtils;
}

// Console logging for development
console.log('String Utilities Library loaded successfully');
console.log('Created by: Kheni Urval (Student ID: 24CE055)');
console.log('Available functions:', Object.keys(StringUtils));
