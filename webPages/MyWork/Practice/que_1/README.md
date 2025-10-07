# Student Registration Form

## Overview
A simple HTML, CSS, and JavaScript project for a Student Registration Form with real-time validation.

## Features
- **Form Fields**: Name, Email, Password, Confirm Password, Phone
- **Real-time Validation**: Checks input as you type and on blur
- **Error Messages**: Shows validation messages below each field
- **Responsive Design**: Works on desktop and mobile devices

## Validation Rules

### Name
- Must be at least 2 characters long
- Cannot be empty

### Email
- Must be a valid email format (contains @ and domain)
- Uses regex pattern: `/^[^\s@]+@[^\s@]+\.[^\s@]+$/`

### Password
- Must be at least 6 characters long
- Cannot be empty

### Confirm Password
- Must match the password field
- Cannot be empty

### Phone
- Must be exactly 10 digits
- Only numbers allowed
- Uses regex pattern: `/^[0-9]{10}$/`

## How to Use
1. Open `index.html` in any web browser
2. Fill out the form fields
3. Watch for real-time validation messages
4. Click "Register" to submit (shows success alert if all fields are valid)

## Technologies Used
- **HTML**: Form structure and semantic elements
- **CSS**: Styling with flexbox and responsive design
- **JavaScript**: Form validation and DOM manipulation

## File Structure
```
que_1/
├── index.html (Complete project with HTML, CSS, and JS)
└── README.md (This file)
```

## Key Learning Points
- Form validation using JavaScript
- Event listeners (`blur`, `submit`)
- DOM manipulation with `getElementById`
- Regular expressions for input validation
- Preventing form submission with `preventDefault()`

## Browser Compatibility
Works in all modern browsers including:
- Chrome
- Firefox
- Safari
- Edge

## Mobile Responsive
- Responsive design with CSS media queries
- Optimized for screens 768px and below
- Touch-friendly button sizes