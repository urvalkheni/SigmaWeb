# WDF: ITUE203 - Programming Assignments

**Course:** Web Development Fundamentals: ITUE203  
**Student:** Kheni Urval  
**ID:** 24CE055  
**Total Assignments:** 13  

## 📚 Overview

This repository contains 13 progressive programming assignments covering fundamental web development concepts, from basic HTML/CSS to advanced PHP and MySQL database operations. Each assignment builds upon previous knowledge while introducing new programming concepts and best practices.

---

## 🎯 Assignment Definitions & Programming Concepts

### 1️⃣ **Assignment 1: Personal Portfolio (HTML5 + CSS3)**

**Definition:** A single-page portfolio website showcasing personal information, skills, projects, and contact details.

**Programming Concepts:**
- **Semantic HTML5:** Meaningful HTML elements (`<header>`, `<nav>`, `<main>`, `<section>`, `<footer>`)
- **CSS3 Layouts:** Flexbox and CSS Grid for responsive design
- **Responsive Design:** Mobile-first approach with media queries
- **Accessibility:** ARIA labels, proper heading hierarchy, keyboard navigation
- **Form Elements:** Contact form structure (no backend processing yet)

**Key Technologies:** HTML5, CSS3, Responsive Design
**Files:** `index.html`, `styles.css`, `assets/`

---

### 2️⃣ **Assignment 2: Color & Typography Playground (CSS)**

**Definition:** A comprehensive style guide demonstrating color theory, typography hierarchy, and design system principles.

**Programming Concepts:**
- **CSS Custom Properties (Variables):** Reusable design tokens
- **Color Theory:** Contrast ratios, accessibility compliance (WCAG)
- **Typography Scale:** Modular typography system (H1-H6 hierarchy)
- **Design Systems:** Consistent visual language and component styling
- **CSS Organization:** Structured stylesheets and naming conventions

**Key Technologies:** CSS3, Design Systems, Accessibility
**Files:** `styleguide.html`, `styleguide.css`

---

### 3️⃣ **Assignment 3: Interactive Quiz (JavaScript ES6)**

**Definition:** A dynamic 5-question multiple-choice quiz with scoring and result analysis.

**Programming Concepts:**
- **ES6+ Syntax:** Arrow functions, `const`/`let`, template literals
- **JavaScript Objects:** Question data structures and object manipulation
- **Event Handling:** Click events, navigation controls
- **DOM Manipulation:** Dynamic content updates without page reload
- **Application State:** Managing quiz progress and scoring logic
- **Control Flow:** Conditional statements and loop structures

**Key Technologies:** JavaScript ES6, DOM API, Event-driven Programming
**Files:** `quiz.html`, `quiz.js`, `quiz.css`

---

### 4️⃣ **Assignment 4: DOM To-Do App (DOM + Events)**

**Definition:** A fully functional task management application with persistent data storage.

**Programming Concepts:**
- **Dynamic DOM Creation:** Creating/removing elements programmatically
- **Event Delegation:** Efficient event handling for dynamic content
- **Local Storage API:** Client-side data persistence
- **CRUD Operations:** Create, Read, Update, Delete functionality
- **State Management:** Application state synchronization
- **Filtering Logic:** Data filtering and view management

**Key Technologies:** JavaScript DOM API, localStorage, Event Handling
**Files:** `todo.html`, `todo.js`, `todo.css`

---

### 5️⃣ **Assignment 5: Data Dashboard Cards (Arrays/Array Methods)**

**Definition:** An analytics dashboard that processes datasets and displays key performance indicators.

**Programming Concepts:**
- **Functional Programming:** Pure functions and immutable operations
- **Array Methods:** `map()`, `filter()`, `reduce()`, `sort()` for data processing
- **Data Transformation:** Converting raw data into meaningful insights
- **Statistical Calculations:** Totals, averages, percentiles, rankings
- **Data Visualization:** Dynamic card-based UI for metrics display
- **JSON Data Handling:** Working with structured data objects

**Key Technologies:** JavaScript Array Methods, Data Processing, Functional Programming
**Files:** `dashboard.html`, `dashboard.js`

---

### 6️⃣ **Assignment 6: String Utilities Library**

**Definition:** A collection of reusable string manipulation functions with comprehensive testing.

**Programming Concepts:**
- **Pure Functions:** Functions without side effects, predictable outputs
- **String Algorithms:** Text processing and manipulation techniques
- **Regular Expressions:** Pattern matching and text validation
- **Unit Testing Concepts:** Input/output validation and edge case handling
- **Library Design:** Modular, reusable code organization
- **API Design:** Consistent function interfaces and documentation

**Key Technologies:** JavaScript String Methods, RegEx, Functional Programming
**Files:** `string-utils.js`, `demo.html`

---

### 7️⃣ **Assignment 7: JSON Importer + Renderer**

**Definition:** An event management system that processes JSON data and renders organized content.

**Programming Concepts:**
- **JSON Parsing:** Working with structured data formats
- **Asynchronous JavaScript:** Fetch API and Promise handling
- **Data Grouping:** Organizing data by categories (months)
- **Date Manipulation:** Formatting and processing date objects
- **Error Handling:** Defensive programming and graceful failures
- **Template Rendering:** Dynamic HTML generation from data

**Key Technologies:** JSON, Fetch API, Date Objects, Async JavaScript
**Files:** `events.json`, `events.html`, `events.js`

---

### 8️⃣ **Assignment 8: Custom Iterable (Advanced JS Objects)**

**Definition:** Advanced JavaScript implementation of custom iterable objects using Symbol.iterator protocol.

**Programming Concepts:**
- **Iterator Protocol:** Implementing `Symbol.iterator` and `next()` methods
- **Generator Functions:** Using `yield` for lazy evaluation
- **for...of Loops:** Making objects compatible with iteration syntax
- **Spread Operator:** Object destructuring and array conversion
- **Object-Oriented Design:** Class-based inheritance and polymorphism
- **Memory Efficiency:** Lazy evaluation and iterative processing

**Key Technologies:** ES6 Iterators, Generators, Symbol.iterator, OOP
**Files:** `iterable.js`, `demo.html`

---

### 9️⃣ **Assignment 9: PHP Form Handling (Server-side Validation)**

**Definition:** A registration system with comprehensive server-side validation and security measures.

**Programming Concepts:**
- **Server-side Validation:** Input validation without client-side JavaScript
- **Form Processing:** POST data handling and sanitization
- **Sticky Forms:** Retaining user input after validation errors
- **Input Sanitization:** XSS prevention and data cleaning
- **HTTP Redirects:** Page flow control and user experience
- **Security Best Practices:** Preventing injection attacks and data validation

**Key Technologies:** PHP, HTML Forms, Server-side Processing, Security
**Files:** `index.php`, `submit.php`, `style.css`

---

### 🔟 **Assignment 10: PHP Sessions & Cookies (Login Mini-App)**

**Definition:** A simple authentication system demonstrating session management and persistent user preferences.

**Programming Concepts:**
- **Session Management:** Server-side user state tracking
- **Cookie Handling:** Client-side persistent data storage
- **Authentication Logic:** Login/logout workflow implementation
- **State Persistence:** "Remember me" functionality
- **Security Sessions:** Session hijacking prevention
- **User Experience:** Seamless authentication flow

**Key Technologies:** PHP Sessions, Cookies, Authentication, State Management
**Files:** `login.php`, `dashboard.php`, `logout.php`

---

### 1️⃣1️⃣ **Assignment 11: PHP File I/O (Guestbook)**

**Definition:** A guestbook application demonstrating file-based data persistence and concurrent access handling.

**Programming Concepts:**
- **File I/O Operations:** Reading from and writing to files
- **File Locking:** Preventing data corruption in concurrent access
- **CSV Data Format:** Structured data storage in plain text
- **Data Sanitization:** Input cleaning and validation
- **Append Operations:** Adding data without overwriting existing content
- **File System Security:** Safe file handling practices

**Key Technologies:** PHP File Functions, File Locking, CSV Processing
**Files:** `guestbook.php`, `save.php`, `list.php` + storage file

---

### 1️⃣2️⃣ **Assignment 12: PHP OOP Mini-Project**

**Definition:** Object-oriented programming demonstration with inheritance, encapsulation, and polymorphism.

**Programming Concepts:**
- **Encapsulation:** Private properties with getter/setter methods
- **Inheritance:** Parent-child class relationships
- **Polymorphism:** Method overriding and interface implementation
- **Abstract Classes:** Common base functionality definition
- **Constructor Methods:** Object initialization and validation
- **Method Overriding:** Specialized behavior in child classes

**Key Technologies:** PHP OOP, Classes, Inheritance, Encapsulation
**Files:** `Product.php`, `DigitalProduct.php`, `demo.php`

---

### 1️⃣3️⃣ **Assignment 13: MySQL CRUD with PHP (Database Operations)**

**Definition:** Complete database-driven application with Create, Read, Update, Delete operations.

**Programming Concepts:**
- **CRUD Operations:** Complete data lifecycle management
- **SQL Databases:** Relational database design and querying
- **Prepared Statements:** SQL injection prevention
- **Database Normalization:** Efficient table structure design
- **Pagination:** Large dataset management
- **Data Validation:** Server-side input validation
- **MVC Pattern:** Separation of data, logic, and presentation layers

**Key Technologies:** MySQL, PHP PDO, SQL, Database Design
**Files:** `schema.sql`, `config.php`, `list.php`, `create.php`, `edit.php`, `delete.php`

---

## 🛠️ **Progressive Learning Path**

### **Phase 1: Frontend Foundations (Assignments 1-4)**
- HTML5 semantic structure and accessibility
- CSS3 styling, layouts, and responsive design
- JavaScript fundamentals and DOM manipulation
- Client-side interactivity and local data storage

### **Phase 2: Advanced JavaScript (Assignments 5-8)**
- Functional programming with array methods
- Advanced string processing and algorithms
- Asynchronous programming and API handling
- Object-oriented programming and iterators

### **Phase 3: Server-side Development (Assignments 9-11)**
- PHP fundamentals and form processing
- Session management and user authentication
- File I/O operations and data persistence
- Security best practices and input validation

### **Phase 4: Database Integration (Assignments 12-13)**
- Object-oriented programming in PHP
- Database design and SQL operations
- Complete web application development
- Full-stack integration and deployment

---

## 📊 **Skills Assessment Matrix**

| Skill Category | Assignments | Key Concepts |
|----------------|-------------|--------------|
| **HTML/CSS** | 1, 2, 3, 4 | Semantic markup, responsive design, accessibility |
| **JavaScript** | 3, 4, 5, 6, 7, 8 | ES6+, DOM manipulation, async programming, OOP |
| **PHP Basics** | 9, 10, 11 | Form handling, sessions, file I/O |
| **PHP OOP** | 12 | Classes, inheritance, encapsulation |
| **Database** | 13 | MySQL, CRUD operations, prepared statements |
| **Security** | 9, 10, 11, 13 | Input validation, XSS prevention, SQL injection |

---

## 🎓 **Learning Outcomes**

Upon completion of all assignments, students will have demonstrated proficiency in:

✅ **Frontend Development:** HTML5, CSS3, responsive design  
✅ **JavaScript Programming:** ES6+, DOM API, asynchronous programming  
✅ **Server-side Development:** PHP fundamentals and advanced features  
✅ **Database Integration:** MySQL operations and data management  
✅ **Security Practices:** Input validation and attack prevention  
✅ **Full-stack Development:** Complete web application creation  

---

## 📁 **Repository Structure**

```
WDF-ITUE203-Assignments/
├── Assignment_01_Personal_Portfolio/
├── Assignment_02_Style_Guide/
├── Assignment_03_Interactive_Quiz/
├── Assignment_04_Todo_App/
├── Assignment_05_Dashboard_App/
├── Assignment_06_String_Utilities/
├── Assignment_07_JSON_Events/
├── Assignment_08_Custom_Iterables/
├── Assignment_09_PHP_Form_Handling/
├── Assignment_10_PHP_Sessions/
├── Assignment_11_PHP_Guestbook/
├── Assignment_12_PHP_OOP/
├── Assignment_13_MySQL_CRUD/
└── README.md (this file)
```

---

**© 2025 WDF: ITUE203 Programming Assignments | Student: Kheni Urval (24CE055)**

*This document serves as a comprehensive guide to all programming assignments, their underlying concepts, and the progressive learning path for web development fundamentals.*
- **Technologies:** CSS3, Custom Properties, Typography
- **Features:** CSS Variables, Color palettes, Font systems, Type scale
- **Files:** `styleguide.html`, `styleguide.css`

### ✅ Assignment 3: Interactive Quiz Application
**Path:** `Assignment_03_Interactive_Quiz/`
- **Technologies:** JavaScript ES6+, DOM Manipulation, Events
- **Features:** 5-question MCQ, Score tracking, Review mode, No page reload
- **Files:** `quiz.html`, `quiz.js`, `quiz.css`

### ✅ Assignment 4: Dynamic Todo Application
**Path:** `Assignment_04_Todo_App/`
- **Technologies:** JavaScript ES6+, LocalStorage, DOM Events
- **Features:** Add/edit/delete tasks, Filter options, Persistent storage
- **Files:** `todo.html`, `todo.js`, `todo.css`

### ✅ Assignment 5: Data Dashboard Cards
**Path:** `Assignment_05_Dashboard_App/`
- **Technologies:** JavaScript ES6+, Array Methods, Data Visualization
- **Features:** Sales analytics, KPI calculations using map/filter/reduce
- **Files:** `dashboard.html`, `dashboard.js`

### 📁 Assignment 6: String Utilities Library
**Path:** `Assignment_06_String_Utilities/`
- **Technologies:** JavaScript ES6+, Pure Functions, Testing
- **Status:** Directory created, implementation pending

### 📁 Assignment 7: JSON Events Renderer
**Path:** `Assignment_07_JSON_Events/`
- **Technologies:** JavaScript ES6+, JSON, Fetch API, Date Formatting
- **Status:** Directory created, implementation pending

### 📁 Assignment 8: Custom Iterable Objects
**Path:** `Assignment_08_Custom_Iterable/`
- **Technologies:** JavaScript ES6+, Symbols, Iterators, Advanced Objects
- **Status:** Directory created, implementation pending

### ✅ Assignment 9: PHP Form Handling
**Path:** `Assignment_09_PHP_Form_Handling/`
- **Technologies:** PHP, Server-side Validation, Sessions
- **Features:** Registration form, Sticky values, Error handling
- **Files:** `index.php`, `style.css`

### 📁 Assignment 10: PHP Sessions & Cookies
**Path:** `Assignment_10_PHP_Sessions_Cookies/`
- **Technologies:** PHP, Sessions, Cookies, Authentication
- **Status:** Directory created, implementation pending

### 📁 Assignment 11: PHP File I/O Guestbook
**Path:** `Assignment_11_PHP_Guestbook/`
- **Technologies:** PHP, File I/O, Data Sanitization, File Locking
- **Status:** Directory created, implementation pending

### 📁 Assignment 12: PHP OOP Mini-Project
**Path:** `Assignment_12_PHP_OOP/`
- **Technologies:** PHP OOP, Classes, Inheritance, Encapsulation
- **Status:** Directory created, implementation pending

### 📁 Assignment 13: MySQL CRUD with PHP
**Path:** `Assignment_13_MySQL_CRUD/`
- **Technologies:** PHP, MySQL, PDO, CRUD Operations
- **Status:** Directory created, implementation pending

## How to Run the Assignments

### Prerequisites
- **Web Server:** Apache/Nginx with PHP support
- **PHP Version:** 7.4 or higher
- **MySQL:** 5.7 or higher (for Assignment 13)
- **Modern Browser:** Chrome, Firefox, Safari, Edge

### Frontend Assignments (1-8)
1. Navigate to the assignment folder
2. Open the main HTML file in a web browser
3. For local development, use a local server (Live Server, XAMPP, etc.)

### PHP Assignments (9-13)
1. Place assignment folders in your web server's document root
2. Start Apache and MySQL services
3. Navigate to `http://localhost/Assignment_XX_Name/`
4. Follow individual assignment setup instructions

## Assignment Features by Category

### **Frontend Development (Assignments 1-8)**
- ✅ **Responsive Design:** All assignments work on mobile and desktop
- ✅ **Modern JavaScript:** ES6+ features (const/let, arrow functions, destructuring)
- ✅ **DOM Manipulation:** Dynamic content creation and modification
- ✅ **Event Handling:** User interactions and form processing
- ✅ **Local Storage:** Client-side data persistence
- ✅ **Accessibility:** ARIA labels, semantic HTML, keyboard navigation

### **Backend Development (Assignments 9-13)**
- ✅ **Server-side Validation:** Input sanitization and security
- 🔄 **Session Management:** User authentication and state
- 🔄 **File Operations:** Reading, writing, and data persistence
- 🔄 **Object-Oriented Programming:** Classes, inheritance, encapsulation
- 🔄 **Database Integration:** CRUD operations with MySQL

## Student Information Display

Every assignment prominently displays:
- **Student Name:** Kheni Urval
- **Student ID:** 24CE055
- **Course Code:** WDF: ITUE203

This information appears in:
- Page headers and navigation
- About sections and contact forms
- Comments in source code
- Console logs and debugging output

## Technical Specifications

### **Code Quality Standards**
- ✅ **Clean Code:** Readable, well-commented, and organized
- ✅ **Medium Complexity:** Appropriate for academic coursework
- ✅ **Best Practices:** Following web development standards
- ✅ **Error Handling:** Proper validation and user feedback

### **Browser Compatibility**
- ✅ **Modern Browsers:** Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- ✅ **Responsive Design:** Mobile-first approach
- ✅ **Progressive Enhancement:** Works without JavaScript where applicable

### **Security Considerations**
- ✅ **Input Validation:** Server-side validation for all PHP forms
- ✅ **XSS Prevention:** HTML escaping and sanitization
- ✅ **SQL Injection Prevention:** Prepared statements (Assignment 13)

## Development Environment

### **Recommended Setup**
- **Code Editor:** VS Code with PHP and JavaScript extensions
- **Local Server:** XAMPP, WAMP, or MAMP
- **Browser DevTools:** For debugging and testing
- **Version Control:** Git for code management

### **Testing Process**
1. **Unit Testing:** Individual function testing
2. **Integration Testing:** Component interaction testing
3. **User Acceptance Testing:** Real-world usage scenarios
4. **Cross-browser Testing:** Multiple browser compatibility

## Assignment Progress Tracking

| Assignment | Status | Completion Date | Key Features |
|------------|--------|----------------|--------------|
| 1. Portfolio | ✅ Complete | 2025-01-15 | Responsive design, contact form |
| 2. Style Guide | ✅ Complete | 2025-01-15 | CSS variables, typography system |
| 3. Quiz App | ✅ Complete | 2025-01-15 | Interactive quiz, score tracking |
| 4. Todo App | ✅ Complete | 2025-01-15 | CRUD operations, local storage |
| 5. Dashboard | ✅ Complete | 2025-01-15 | Data visualization, array methods |
| 6. String Utils | 🔄 Pending | - | Pure functions, testing |
| 7. JSON Events | 🔄 Pending | - | JSON parsing, date formatting |
| 8. Custom Iterable | 🔄 Pending | - | Iterators, symbols |
| 9. PHP Forms | ✅ Complete | 2025-01-15 | Server validation, sticky forms |
| 10. PHP Sessions | 🔄 Pending | - | Authentication, cookies |
| 11. PHP Guestbook | 🔄 Pending | - | File I/O, data persistence |
| 12. PHP OOP | 🔄 Pending | - | Classes, inheritance |
| 13. MySQL CRUD | 🔄 Pending | - | Database operations |

## Contact Information

**Student:** Kheni Urval  
**Student ID:** 24CE055  
**Course:** WDF: ITUE203  
**Institution:** ITU Engineering College  

For questions or clarifications about any assignment, please refer to the individual README files in each assignment folder.

---

*All assignments are created as part of the WDF: ITUE203 course curriculum and demonstrate proficiency in modern web development technologies and best practices.*
