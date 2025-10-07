# FAQ Section with Expand/Collapse

## Overview
An interactive FAQ section where each question expands or collapses when clicked, built with HTML, CSS, and JavaScript.

## Features
- **5 FAQ Items**: College-related questions and answers
- **Click to Expand**: Questions expand to show answers
- **Accordion Effect**: Only one FAQ open at a time
- **Smooth Animations**: CSS transitions for smooth expand/collapse
- **Visual Indicators**: Plus/minus icons show current state
- **Color Variety**: Different colored questions for visual appeal

## FAQ Topics Covered
1. **Admission Requirements**: Undergraduate program requirements
2. **Scholarships**: Application process and eligibility
3. **Course Registration**: Online registration procedure
4. **Hostel Facilities**: Accommodation and mess facilities
5. **Library Resources**: Access and borrowing policies

## Interactive Features

### Click Functionality
- Click any question to expand/collapse
- Uses `onclick="toggleFAQ(this)"` event
- Implements accordion behavior (closes others when opening new)

### Visual Feedback
- **Plus (+)** icon when collapsed
- **Minus (−)** icon when expanded
- Icon rotation animation with CSS transitions
- Color change on hover

### Animations
- **Expand**: `max-height` increases with transition
- **Collapse**: `max-height` decreases smoothly
- **Duration**: 0.3 seconds for smooth user experience

## CSS Features

### Layout
- Clean card-based design
- Rounded corners (`border-radius: 8px`)
- Box shadows for depth
- Responsive grid layout

### Color Scheme
- **Question 1**: Blue (`#3498db`)
- **Question 2**: Red (`#e74c3c`)
- **Question 3**: Green (`#27ae60`)
- **Question 4**: Orange (`#f39c12`)
- **Question 5**: Purple (`#9b59b6`)

### Transitions
```css
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out, padding 0.3s ease-out;
}
```

## JavaScript Functionality

### Main Function
```javascript
function toggleFAQ(element) {
    // Toggle current FAQ
    // Close other open FAQs (accordion effect)
    // Update visual indicators
}
```

### Event Handling
- **Method 1**: `onclick` attributes in HTML
- **Method 2**: Event delegation (commented alternative)
- **DOM Manipulation**: `classList.toggle()` and `nextElementSibling`

## How to Use
1. Open `index.html` in any web browser
2. Click on any question to expand it
3. Click again to collapse
4. Notice that clicking a new question closes the previous one

## Technologies Used
- **HTML**: Semantic structure with proper ARIA labels
- **CSS**: Flexbox, transitions, hover effects
- **JavaScript**: DOM manipulation, event handling

## File Structure
```
que_3/
├── index.html (Complete project with HTML, CSS, and JS)
└── README.md (This file)
```

## Accessibility Features
- Proper heading hierarchy
- Keyboard navigation support
- Color contrast compliance
- Semantic HTML structure

## Browser Compatibility
- All modern browsers
- IE11+ (with CSS transitions support)
- Mobile touch devices

## Responsive Design
- **Desktop**: Full-width FAQ items
- **Mobile** (768px and below): Adjusted padding and font sizes
- **Touch-Friendly**: Large click areas for mobile users

## Key Learning Points
- JavaScript event handling
- CSS transitions and animations
- DOM traversal (`nextElementSibling`)
- `classList.toggle()` method
- Accordion UI pattern implementation
- CSS pseudo-elements (`::after`)

## Alternative Implementation
The code includes a commented alternative using event delegation:
```javascript
// More advanced approach using addEventListener
// Better for dynamically added content
// Single event listener for all FAQ items
```

## Customization Options
- Add more FAQ items by copying the HTML structure
- Change colors by modifying CSS custom properties
- Adjust animation speed by changing transition duration
- Modify accordion behavior to allow multiple open items