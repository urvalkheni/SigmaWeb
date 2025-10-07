# Student Portal Home Page

## Overview
A responsive Student Portal Home Page using HTML and CSS with clean design and mobile-friendly layout.

## Features
- **Header**: Title and welcome message
- **Navigation Bar**: 5 navigation links (Home, Courses, Grades, Library, Support)
- **Main Content**: Welcome section with 3 feature cards
- **Cards**: Events, Profile, and Contact with icons and descriptions
- **Footer**: Copyright and college information
- **Responsive Design**: Mobile-first approach with flexbox

## Layout Structure

### Header Section
- College portal title
- Welcoming subtitle
- Dark blue background (`#2c3e50`)

### Navigation
- Horizontal navigation bar
- Hover effects on menu items
- Converts to vertical on mobile

### Cards Section
- **Events Card**: Red theme, displays college events
- **Profile Card**: Blue theme, manages student information  
- **Contact Card**: Green theme, communication and support

### Footer
- Simple footer with copyright information
- Consistent styling with header

## CSS Features Used

### Flexbox Layout
- Navigation bar: `display: flex; justify-content: center`
- Cards container: `display: flex; gap: 2rem; flex-wrap: wrap`
- Responsive wrapping for smaller screens

### Responsive Design
- **Desktop**: 3 cards in a row
- **Tablet** (768px and below): Stacked cards
- **Mobile** (480px and below): Single column layout

### Interactive Elements
- Card hover effects with `transform: translateY(-5px)`
- Button hover animations
- Navigation link hover states

## Color Scheme
- **Primary**: #2c3e50 (Dark blue)
- **Secondary**: #34495e (Medium blue)
- **Events**: #e74c3c (Red)
- **Profile**: #3498db (Blue)
- **Contact**: #27ae60 (Green)

## How to Use
1. Open `index.html` in any web browser
2. Resize browser window to see responsive behavior
3. Hover over navigation items and cards to see effects
4. Click buttons (currently show as styled buttons, no functionality)

## Technologies Used
- **HTML5**: Semantic structure with header, nav, main, footer
- **CSS3**: Flexbox, transitions, media queries
- **No JavaScript**: Pure CSS solution

## File Structure
```
que_2/
├── index.html (Complete project with HTML and CSS)
└── README.md (This file)
```

## Media Queries
```css
@media (max-width: 768px) {
    /* Tablet styles */
}

@media (max-width: 480px) {
    /* Mobile styles */
}
```

## Key Learning Points
- CSS Flexbox for layout
- Responsive web design principles
- CSS hover effects and transitions
- Media queries for mobile compatibility
- Semantic HTML structure
- CSS Grid alternative (cards container)

## Browser Compatibility
- All modern browsers
- IE11+ (with flexbox support)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Future Enhancements
- Add JavaScript functionality to buttons
- Implement actual navigation routing
- Add more interactive elements
- Include user authentication features