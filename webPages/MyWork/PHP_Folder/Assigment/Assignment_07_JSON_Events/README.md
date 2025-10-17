# Assignment 07: JSON Events Renderer

**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  
**Assignment Type:** Medium-Level JavaScript Implementation  

## 📋 Assignment Overview

This assignment demonstrates advanced JSON data handling and dynamic DOM manipulation using JavaScript. The Events Renderer loads event data from a JSON file and provides an interactive interface for viewing, filtering, sorting, and searching events.

## 🎯 Learning Objectives

- Master JSON data loading and parsing with fetch API
- Implement dynamic DOM manipulation and event handling
- Create responsive and interactive user interfaces
- Develop advanced filtering and sorting mechanisms
- Practice modern JavaScript ES6+ features and patterns

## 🛠️ Implementation Details

### Core Features

1. **JSON Data Loading**
   - Asynchronous fetch API implementation
   - Error handling with fallback data
   - Dynamic data refresh capability

2. **Event Display System**
   - Card-based responsive layout
   - Category-based color coding
   - Date formatting and display
   - Modal detail view for events

3. **Interactive Controls**
   - Category filtering (All, Workshop, Lecture, Seminar, Tutorial, Presentation)
   - Multi-criteria sorting (Date, Title, Category, Attendees)
   - Real-time search functionality
   - Event count display

4. **Advanced Features**
   - Monthly grouping view
   - Event export functionality
   - Keyboard shortcuts support
   - Responsive design for all devices

### Technical Implementation

**Class Structure:**
```javascript
class EventsRenderer {
    constructor()           // Initialize renderer
    async loadEvents()      // Load JSON data
    setupEventListeners()   // Bind UI events
    renderEvents()          // Display events
    getFilteredEvents()     // Apply filters
    getSortedEvents()       // Apply sorting
    displayEvents()         // Render to DOM
    groupEventsByMonth()    // Monthly grouping
    showEventDetails()      // Modal display
    exportEvents()          // Data export
}
```

**Key JavaScript Features:**
- Async/await for API calls
- Arrow functions and modern syntax
- Array methods (filter, map, sort, reduce)
- Destructuring and spread operator
- Template literals for HTML generation
- Event delegation and handling

## 📁 File Structure

```
Assignment_07_JSON_Events/
├── index.html              # Main application page
├── events-renderer.js      # Core JavaScript implementation
├── events.json            # Sample events data
└── README.md              # This documentation
```

## 🚀 Features Demonstrated

### 1. JSON Data Management
- **File:** `events.json`
- Contains 12 sample events with complete metadata
- Structured data with categories, dates, locations, and organizers

### 2. Core Renderer Class
- **File:** `events-renderer.js`
- Modern ES6 class implementation
- Comprehensive error handling
- Modular method organization

### 3. Interactive UI
- **File:** `index.html`
- Responsive CSS Grid and Flexbox layout
- Modern design with glass-morphism effects
- Comprehensive accessibility features

## 💡 Code Highlights

### Advanced JSON Loading
```javascript
async loadEvents() {
    try {
        const response = await fetch('events.json');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.events = await response.json();
        console.log(`Loaded ${this.events.length} events successfully`);
    } catch (error) {
        console.error('Error loading events:', error);
        this.events = this.getSampleEvents(); // Fallback data
    }
}
```

### Dynamic Event Card Generation
```javascript
createEventCard(event) {
    const eventDate = new Date(event.date);
    const formattedDate = this.formatDate(eventDate);
    const dayOfWeek = eventDate.toLocaleDateString('en-US', { weekday: 'long' });
    
    return `
        <div class="event-card ${event.category}" data-event-id="${event.id}">
            <div class="event-date">
                <span class="day">${eventDate.getDate()}</span>
                <span class="month">${eventDate.toLocaleDateString('en-US', { month: 'short' })}</span>
                <span class="weekday">${dayOfWeek}</span>
            </div>
            <div class="event-content">
                <!-- Event details... -->
            </div>
        </div>
    `;
}
```

### Advanced Filtering and Sorting
```javascript
getFilteredEvents() {
    if (this.currentFilter === 'all') {
        return this.events;
    }
    return this.events.filter(event => event.category === this.currentFilter);
}

getSortedEvents(events) {
    const sortedEvents = [...events];
    
    switch (this.currentSort) {
        case 'date':
            return sortedEvents.sort((a, b) => new Date(a.date) - new Date(b.date));
        case 'title':
            return sortedEvents.sort((a, b) => a.title.localeCompare(b.title));
        case 'category':
            return sortedEvents.sort((a, b) => a.category.localeCompare(b.category));
        case 'attendees':
            return sortedEvents.sort((a, b) => b.attendees - a.attendees);
        default:
            return sortedEvents;
    }
}
```

### Monthly Grouping System
```javascript
groupEventsByMonth(events) {
    return events.reduce((groups, event) => {
        const date = new Date(event.date);
        const monthKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        
        if (!groups[monthKey]) {
            groups[monthKey] = [];
        }
        groups[monthKey].push(event);
        
        return groups;
    }, {});
}
```

## 🎨 Design Features

### Modern UI Elements
- **Glass-morphism Effects:** Backdrop blur and transparency
- **Gradient Backgrounds:** Dynamic color schemes
- **Responsive Cards:** Flexible grid layout
- **Category Color Coding:** Visual event type identification
- **Smooth Animations:** Hover effects and transitions

### Accessibility Features
- **Keyboard Navigation:** Full keyboard support
- **Screen Reader Friendly:** Semantic HTML structure
- **High Contrast:** Readable color combinations
- **Mobile Responsive:** Touch-friendly interface

## 🔧 Technical Specifications

### Browser Compatibility
- Modern browsers with ES6+ support
- Fetch API compatibility
- CSS Grid and Flexbox support

### Performance Optimizations
- Efficient DOM manipulation
- Event delegation patterns
- Minimal re-renders
- Optimized CSS animations

### Error Handling
- Network failure graceful degradation
- JSON parsing error recovery
- User-friendly error messages
- Fallback data provision

## 📊 Sample Data Structure

```json
{
    "id": 1,
    "title": "Web Development Workshop",
    "description": "Learn modern web development techniques",
    "date": "2025-01-15",
    "time": "09:00",
    "location": "Computer Lab A",
    "category": "workshop",
    "organizer": "Kheni Urval (24CE055)",
    "attendees": 25
}
```

## 🚀 Usage Instructions

1. **Open Application:** Load `index.html` in a web browser
2. **View Events:** Browse all events in card format
3. **Filter Events:** Use category buttons to filter by event type
4. **Sort Events:** Choose sorting criteria from dropdown
5. **Search Events:** Type in search box for real-time filtering
6. **View Details:** Click any event card for detailed information
7. **Export Data:** Use export button to download JSON data
8. **Monthly View:** Scroll down to see events grouped by month

## 🎓 Educational Value

This assignment demonstrates:
- **Advanced JavaScript Concepts:** Classes, async/await, modern syntax
- **JSON Data Handling:** Loading, parsing, and manipulation
- **DOM Manipulation:** Dynamic content generation and updates
- **Event Handling:** User interaction and response systems
- **Responsive Design:** Mobile-first approach and accessibility
- **Error Handling:** Robust application development practices

## 🏆 Assignment Completion

**Status:** ✅ Complete  
**Grade Level:** Medium-Level Implementation  
**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  

**Key Achievements:**
- ✅ Complete JSON data loading and parsing
- ✅ Interactive filtering and sorting system
- ✅ Responsive design with modern UI
- ✅ Advanced JavaScript class implementation
- ✅ Comprehensive error handling
- ✅ Export functionality and keyboard shortcuts
- ✅ Monthly grouping and detail modal views