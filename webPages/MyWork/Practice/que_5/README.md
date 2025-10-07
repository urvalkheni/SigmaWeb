# Password Strength Checker

## Overview
A real-time password strength checker that evaluates password security and provides visual feedback using HTML, CSS, and JavaScript.

## Features
- **Real-time Analysis**: Checks password strength as you type
- **Visual Strength Bar**: Color-coded progress bar
- **Requirement Checklist**: Shows which criteria are met
- **Three Strength Levels**: Weak, Medium, Strong
- **Color Coding**: Red (weak), Orange (medium), Green (strong)
- **Progress Tracking**: Shows requirements met (X/5)

## Password Requirements

### 1. Length (8+ characters)
- Minimum 8 characters required
- Longer passwords get higher scores

### 2. Lowercase Letters (a-z)
- Must contain at least one lowercase letter
- Uses regex: `/[a-z]/`

### 3. Uppercase Letters (A-Z)  
- Must contain at least one uppercase letter
- Uses regex: `/[A-Z]/`

### 4. Numbers (0-9)
- Must contain at least one digit
- Uses regex: `/[0-9]/`

### 5. Special Characters
- Must contain special characters: `!@#$%^&*()_+-=[]{}|;':"\\,.<>?/`
- Uses regex: `/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/`

## Strength Levels

### Weak (Score: 0-2)
- **Color**: Red (#e74c3c)
- **Bar Width**: 33%
- **Requirements**: 0-2 criteria met
- **Security**: Not recommended

### Medium (Score: 3-4)
- **Color**: Orange (#f39c12)  
- **Bar Width**: 66%
- **Requirements**: 3-4 criteria met
- **Security**: Fair protection

### Strong (Score: 5)
- **Color**: Green (#27ae60)
- **Bar Width**: 100%
- **Requirements**: All 5 criteria met
- **Security**: Excellent protection

## Visual Components

### Strength Bar
```css
.strength-bar::after {
    width: [percentage]%;
    background-color: [strength-color];
    transition: width 0.3s ease, background-color 0.3s ease;
}
```

### Requirement Indicators
- **✓ Green Circle**: Requirement met
- **✗ Red Circle**: Requirement not met
- **Real-time Updates**: Changes as you type

### Progress Display
- Shows "Password Strength: [Level] (X/5 requirements met)"
- Updates dynamically with each keystroke

## JavaScript Functionality

### Main Validation Function
```javascript
function checkPasswordStrength() {
    // Get password input
    // Check each requirement with regex
    // Calculate score (0-5)
    // Update visual indicators
    // Set strength level and colors
}
```

### Regex Patterns Used
```javascript
/[a-z]/          // Lowercase
/[A-Z]/          // Uppercase  
/[0-9]/          // Numbers
/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/ // Special chars
```

### Dynamic Updates
- **Event**: `oninput` on password field
- **Real-time**: Updates with every character typed
- **Immediate Feedback**: No delay in strength calculation

## CSS Features

### Animated Progress Bar
- **Smooth Transitions**: 0.3s ease animation
- **Width Changes**: Grows from 0% to 100%
- **Color Transitions**: Smooth color changes

### Requirement List Styling
- **Circular Indicators**: CSS circles with checkmarks
- **Color Coding**: Green for met, red for unmet
- **Clean Layout**: Well-spaced requirement list

### Responsive Design
- **Mobile Friendly**: Works on all screen sizes
- **Touch Compatible**: Large input fields
- **Readable Text**: Appropriate font sizes

## How to Use
1. Open `index.html` in any web browser
2. Click in the password field
3. Start typing a password
4. Watch the strength bar and requirements update in real-time
5. Aim for "Strong" rating (all 5 requirements met)

## Example Passwords

### Weak Examples
- `123` (too short, no letters)
- `password` (no uppercase, numbers, special chars)
- `PASSWORD` (no lowercase, numbers, special chars)

### Medium Examples  
- `Password1` (missing special character)
- `password123!` (missing uppercase)
- `PASSWORD123!` (missing lowercase)

### Strong Examples
- `MyPassword123!` (meets all 5 requirements)
- `SecurePass@2025` (meets all 5 requirements)
- `StrongPwd#456` (meets all 5 requirements)

## Technologies Used
- **HTML**: Input field and requirement structure
- **CSS**: Progress bar animations and styling
- **JavaScript**: Real-time validation and regex patterns

## File Structure
```
que_5/
├── index.html (Complete project with HTML, CSS, and JS)
└── README.md (This file)
```

## Security Best Practices
- **Real-time Feedback**: Helps users create strong passwords
- **Clear Requirements**: Shows exactly what's needed
- **Visual Indicators**: Easy to understand progress
- **Educational**: Teaches password security principles

## Browser Compatibility
- All modern browsers
- IE11+ (with CSS3 support)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Key Learning Points
- **Regular Expressions**: Pattern matching for validation
- **Event Handling**: `oninput` event for real-time updates
- **DOM Manipulation**: Dynamic class and content updates
- **CSS Animations**: Smooth transitions and progress bars
- **Security Awareness**: Password best practices

## Alternative Simple Version
The code includes a commented simpler version:
```javascript
// Basic length-based checking
// Good for beginner understanding
// Uses simple if-else conditions
```

## Customization Options
- **Add Requirements**: Include more security criteria
- **Change Colors**: Modify strength level colors
- **Adjust Scoring**: Change requirement weights
- **Add Feedback**: Include specific improvement suggestions