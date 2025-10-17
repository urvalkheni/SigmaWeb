# Assignment 12: PHP Object-Oriented Programming (OOP)

**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  
**Assignment:** Complete PHP OOP E-Commerce System  

## Overview

This assignment demonstrates a comprehensive implementation of Object-Oriented Programming (OOP) concepts in PHP through a fully functional e-commerce system. The project showcases all four pillars of OOP: **Inheritance**, **Encapsulation**, **Polymorphism**, and **Abstraction**.

## Features Implemented

### 🏗️ Core OOP Concepts

1. **Inheritance**
   - Abstract `Product` base class
   - Concrete product classes: `ElectronicsProduct`, `ClothingProduct`, `BookProduct`
   - Proper method inheritance and overriding

2. **Encapsulation**
   - Private/protected properties with controlled access
   - Getter and setter methods with validation
   - Data integrity through proper access modifiers

3. **Polymorphism**
   - Method overriding for product-specific behavior
   - Interface implementations for payment processing
   - Runtime type checking and method resolution

4. **Abstraction**
   - Abstract `Product` class with abstract methods
   - Interfaces for payment processing and notifications
   - Hidden implementation complexity

### 🛠️ Design Patterns

1. **Factory Pattern**
   - `ProductFactory` for creating different product types
   - Centralized object creation logic

2. **Singleton Pattern**
   - `StoreManager` ensures single instance
   - Global access point for store operations

### 🛒 E-Commerce Features

1. **Product Management**
   - Multiple product categories
   - Stock management
   - Price calculations with validation

2. **User Management**
   - User registration and authentication
   - Profile management with validation
   - Secure data handling

3. **Shopping Cart System**
   - Add/remove items
   - Quantity management
   - Total calculations with tax and shipping

4. **Order Processing**
   - Order creation and management
   - Status tracking
   - Payment integration

5. **Payment System**
   - Multiple payment methods (Credit Card, PayPal)
   - Secure payment processing
   - Transaction status tracking

## File Structure

```
Assignment_12_PHP_OOP/
├── README.md                   # This documentation file
├── index.php                   # Interactive demonstration interface
├── oop_classes.php            # Core OOP class implementations
└── demo_handler.php           # AJAX handler for demonstrations
```

## Core Classes

### Abstract Classes

- **`Product`** - Base class for all products with abstract methods
- **`PaymentProcessorInterface`** - Interface for payment processors
- **`NotificationInterface`** - Interface for notification services

### Concrete Classes

- **`ElectronicsProduct`** - Extends Product for electronic items
- **`ClothingProduct`** - Extends Product for clothing items
- **`BookProduct`** - Extends Product for books
- **`User`** - User management with authentication
- **`ShoppingCart`** - Shopping cart functionality
- **`CartItem`** - Individual cart item management
- **`Order`** - Order processing and tracking
- **`CreditCardPayment`** - Credit card payment implementation
- **`PayPalPayment`** - PayPal payment implementation
- **`EmailNotification`** - Email notification service
- **`ProductFactory`** - Factory for creating products
- **`StoreManager`** - Singleton store management

## How to Run

1. **Setup Web Server**
   ```bash
   # Using PHP built-in server
   php -S localhost:8000
   ```

2. **Access Application**
   - Open browser to `http://localhost:8000`
   - Navigate to the assignment folder
   - Open `index.php`

3. **Interactive Demo**
   - Use the tabbed interface to explore features
   - Run live demonstrations of OOP concepts
   - Test product management, cart operations, and order processing

## Usage Examples

### Creating Products with Factory Pattern
```php
// Electronics Product
$laptop = ProductFactory::createProduct('electronics', [
    'id' => 'ELEC001',
    'name' => 'Gaming Laptop',
    'price' => 1299.99,
    'brand' => 'TechMaster',
    'warranty' => 24
]);

// Clothing Product
$shirt = ProductFactory::createProduct('clothing', [
    'id' => 'CLOTH001',
    'name' => 'Cotton T-Shirt',
    'price' => 29.99,
    'size' => 'M',
    'color' => 'Blue'
]);
```

### User Management with Encapsulation
```php
$user = new User('USER001', 'kheni_urval', 'kheni@example.com', 'password123', 'Kheni', 'Urval');
$user->setAddress('123 Student Street, Education City');
$user->setPhone('+1 (555) 123-4567');

// Validation ensures data integrity
try {
    $user->setEmail('invalid-email');  // Throws exception
} catch (Exception $e) {
    echo "Validation error: " . $e->getMessage();
}
```

### Shopping Cart Operations
```php
$cart = new ShoppingCart($user);
$cart->addItem($laptop, 1);
$cart->addItem($shirt, 2);

echo "Items: " . $cart->getItemCount();
echo "Total: $" . number_format($cart->getTotal(), 2);
```

### Polymorphic Payment Processing
```php
$paymentProcessors = [
    new CreditCardPayment('api_key'),
    new PayPalPayment('client_id', 'secret')
];

foreach ($paymentProcessors as $processor) {
    $result = $processor->processPayment(100.00, $paymentDetails);
    echo "Payment via " . get_class($processor) . ": " . $result['status'];
}
```

## OOP Concepts Demonstrated

### 1. Inheritance
- **Product Hierarchy:** Electronics, Clothing, and Book products inherit from abstract Product class
- **Method Inheritance:** Common methods inherited and specialized methods overridden
- **Property Inheritance:** Base properties shared across all product types

### 2. Encapsulation
- **Data Protection:** Private/protected properties prevent direct access
- **Controlled Access:** Public getters/setters with validation
- **Data Integrity:** Input validation and business rules enforcement

### 3. Polymorphism
- **Method Overriding:** Each product type implements calculateShipping() differently
- **Interface Implementation:** Multiple payment processors implement same interface
- **Runtime Resolution:** Same method calls produce different behavior based on object type

### 4. Abstraction
- **Abstract Classes:** Product class defines contract for subclasses
- **Interfaces:** Payment and notification interfaces define required methods
- **Implementation Hiding:** Complex logic hidden behind simple interfaces

## Design Patterns Used

### Factory Pattern
- **Purpose:** Centralized object creation
- **Implementation:** ProductFactory creates appropriate product objects
- **Benefits:** Loose coupling, easy extensibility

### Singleton Pattern
- **Purpose:** Ensure single instance of StoreManager
- **Implementation:** Private constructor, static getInstance() method
- **Benefits:** Global access, resource management

## Testing Features

The application includes comprehensive testing capabilities:

1. **Unit Tests** - Test individual class functionality
2. **Integration Tests** - Test component interactions
3. **OOP Concept Tests** - Demonstrate each OOP pillar
4. **Live Demonstrations** - Interactive testing interface

## Key Learning Outcomes

1. **Class Design** - Proper class hierarchy and relationships
2. **Interface Design** - Clean contracts and implementations
3. **Data Validation** - Robust input validation and error handling
4. **Design Patterns** - Practical application of common patterns
5. **Code Organization** - Modular, maintainable code structure
6. **PHP Best Practices** - Modern PHP development techniques

## Security Features

1. **Input Validation** - All user inputs validated
2. **Data Sanitization** - Proper data cleaning
3. **Password Security** - Secure password handling
4. **Error Handling** - Comprehensive exception handling
5. **Access Control** - Proper encapsulation and access modifiers

## Extensibility

The system is designed for easy extension:

1. **New Product Types** - Add new classes extending Product
2. **Payment Methods** - Implement PaymentProcessorInterface
3. **Notification Types** - Implement NotificationInterface
4. **Business Logic** - Extend existing classes or add new ones

## Browser Compatibility

- **Modern Browsers:** Chrome, Firefox, Safari, Edge
- **JavaScript Required:** For interactive demonstrations
- **PHP Version:** 7.4+ recommended

## Assignment Requirements Met

✅ **Object-Oriented Design** - Complete class hierarchy with proper relationships  
✅ **Inheritance** - Abstract base class with concrete implementations  
✅ **Encapsulation** - Private/protected properties with controlled access  
✅ **Polymorphism** - Method overriding and interface implementations  
✅ **Abstraction** - Abstract classes and interfaces  
✅ **Design Patterns** - Factory and Singleton patterns implemented  
✅ **Error Handling** - Comprehensive exception handling  
✅ **Documentation** - Complete code documentation and comments  
✅ **Interactive Demo** - User-friendly demonstration interface  
✅ **Real-world Application** - Practical e-commerce system  

## Technical Specifications

- **PHP Version:** 7.4+
- **Server Requirements:** Web server with PHP support
- **Database:** File-based storage (no database required)
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Architecture:** Model-View-Controller inspired design

## Future Enhancements

1. **Database Integration** - MySQL/PostgreSQL support
2. **Authentication System** - Session-based login
3. **Admin Panel** - Product and user management
4. **API Integration** - RESTful API endpoints
5. **Advanced Security** - CSRF protection, SQL injection prevention

---

**© 2024 Kheni Urval (24CE055) - WDF: ITUE203 Assignment**

*This assignment demonstrates comprehensive understanding of Object-Oriented Programming concepts in PHP through a practical e-commerce application.*
