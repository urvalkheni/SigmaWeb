<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OOP E-Commerce Demo - Kheni Urval (24CE055)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .student-info {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }

        .navigation {
            background: #f8f9fa;
            padding: 20px 30px;
            border-bottom: 1px solid #e9ecef;
        }

        .nav-tabs {
            display: flex;
            list-style: none;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-tab {
            background: white;
            border: 2px solid #667eea;
            border-radius: 25px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #667eea;
        }

        .nav-tab:hover,
        .nav-tab.active {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .content {
            padding: 40px 30px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .demo-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .demo-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .output-area {
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
            max-height: 400px;
            overflow-y: auto;
            white-space: pre-wrap;
            margin-top: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .product-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 15px;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .product-category {
            font-size: 0.9rem;
            color: #6c757d;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 12px;
            display: inline-block;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            margin: 10px 0;
        }

        .product-description {
            color: #6c757d;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .product-specs {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .spec-item:last-child {
            border-bottom: none;
        }

        .cart-items {
            margin-top: 20px;
        }

        .cart-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            border: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-total {
            font-size: 1.2rem;
            font-weight: 700;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 10px;
            margin-top: 10px;
        }

        .order-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #667eea;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .order-id {
            font-weight: 700;
            color: #667eea;
        }

        .order-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #e7f3ff; color: #0056b3; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.1);
            transform: skewY(-5deg);
            transform-origin: top left;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-info {
            background: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .code-example {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            overflow-x: auto;
        }

        .code-example h4 {
            margin-bottom: 15px;
            color: #667eea;
        }

        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            white-space: pre;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .header {
                padding: 20px 15px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .content {
                padding: 20px 15px;
            }

            .navigation {
                padding: 15px;
            }

            .nav-tabs {
                justify-content: center;
            }

            .nav-tab {
                padding: 8px 15px;
                font-size: 14px;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .demo-controls {
                flex-direction: column;
            }

            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }

            .cart-item {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .order-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }

        .loading {
            text-align: center;
            padding: 40px;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #e9ecef;
            border-left-color: #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .highlight {
            background: #fff3cd;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .success-highlight {
            background: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .error-highlight {
            background: #f8d7da;
            color: #721c24;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛍️ PHP OOP E-Commerce System</h1>
            <p class="subtitle">Demonstrating Object-Oriented Programming Principles</p>
            <div class="student-info">
                <strong>Assignment 12: PHP Object-Oriented Programming</strong><br>
                Student: Kheni Urval (24CE055) | Course: WDF: ITUE203
            </div>
        </div>

        <div class="navigation">
            <ul class="nav-tabs">
                <li class="nav-tab active" onclick="showTab('products')">🛍️ Products</li>
                <li class="nav-tab" onclick="showTab('cart')">🛒 Shopping Cart</li>
                <li class="nav-tab" onclick="showTab('orders')">📦 Orders</li>
                <li class="nav-tab" onclick="showTab('users')">👥 Users</li>
                <li class="nav-tab" onclick="showTab('demo')">⚡ Live Demo</li>
                <li class="nav-tab" onclick="showTab('concepts')">📚 OOP Concepts</li>
                <li class="nav-tab" onclick="showTab('about')">ℹ️ About</li>
            </ul>
        </div>

        <div class="content">
            <!-- Products Tab -->
            <div id="products" class="tab-content active">
                <div class="demo-section">
                    <h2>🛍️ Product Catalog</h2>
                    <p>Explore our product catalog demonstrating inheritance, polymorphism, and encapsulation.</p>
                    
                    <div class="demo-controls">
                        <button class="btn btn-primary" onclick="loadProducts()">🔄 Load Products</button>
                        <button class="btn btn-success" onclick="addSampleProducts()">➕ Add Sample Products</button>
                        <button class="btn btn-info" onclick="showProductDetails()">📋 Show Details</button>
                        <button class="btn btn-warning" onclick="testPolymorphism()">🔄 Test Polymorphism</button>
                    </div>

                    <div id="productCatalog">
                        <div class="loading">
                            <div class="spinner"></div>
                            <p>Loading product catalog...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shopping Cart Tab -->
            <div id="cart" class="tab-content">
                <div class="demo-section">
                    <h2>🛒 Shopping Cart Management</h2>
                    <p>Demonstrate cart operations, composition, and aggregation patterns.</p>
                    
                    <div class="demo-controls">
                        <button class="btn btn-primary" onclick="createUserCart()">👤 Create User & Cart</button>
                        <button class="btn btn-success" onclick="addToCart()">➕ Add Items to Cart</button>
                        <button class="btn btn-info" onclick="viewCart()">👁️ View Cart</button>
                        <button class="btn btn-warning" onclick="updateCart()">✏️ Update Cart</button>
                        <button class="btn btn-danger" onclick="clearCart()">🗑️ Clear Cart</button>
                    </div>

                    <div id="cartContainer">
                        <div class="alert alert-info">
                            <strong>Create a user and cart to start shopping!</strong><br>
                            Click "Create User & Cart" to begin the shopping experience.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Tab -->
            <div id="orders" class="tab-content">
                <div class="demo-section">
                    <h2>📦 Order Management System</h2>
                    <p>Complex object relationships, state management, and business logic.</p>
                    
                    <div class="demo-controls">
                        <button class="btn btn-primary" onclick="createOrder()">📝 Create Order</button>
                        <button class="btn btn-success" onclick="processPayment()">💳 Process Payment</button>
                        <button class="btn btn-info" onclick="updateOrderStatus()">📊 Update Status</button>
                        <button class="btn btn-warning" onclick="shipOrder()">🚚 Ship Order</button>
                        <button class="btn btn-secondary" onclick="viewAllOrders()">📋 View All Orders</button>
                    </div>

                    <div id="orderContainer">
                        <div class="alert alert-info">
                            <strong>Create an order to see order management in action!</strong><br>
                            Make sure you have items in your cart first.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Tab -->
            <div id="users" class="tab-content">
                <div class="demo-section">
                    <h2>👥 User Management</h2>
                    <p>User authentication, validation, and encapsulation demonstration.</p>
                    
                    <div class="demo-controls">
                        <button class="btn btn-primary" onclick="createUsers()">👤 Create Sample Users</button>
                        <button class="btn btn-success" onclick="authenticateUser()">🔐 Test Authentication</button>
                        <button class="btn btn-info" onclick="validateUserData()">✅ Test Validation</button>
                        <button class="btn btn-warning" onclick="updateUserProfile()">✏️ Update Profile</button>
                        <button class="btn btn-secondary" onclick="showUserStats()">📊 User Statistics</button>
                    </div>

                    <div id="userContainer">
                        <div class="loading">
                            <div class="spinner"></div>
                            <p>Loading user management system...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Live Demo Tab -->
            <div id="demo" class="tab-content">
                <div class="demo-section">
                    <h2>⚡ Interactive Live Demo</h2>
                    <p>Real-time demonstration of all OOP concepts working together.</p>
                    
                    <div class="demo-controls">
                        <button class="btn btn-primary" onclick="runCompleteDemo()">🚀 Run Complete Demo</button>
                        <button class="btn btn-success" onclick="testInheritance()">🧬 Test Inheritance</button>
                        <button class="btn btn-info" onclick="testEncapsulation()">🔒 Test Encapsulation</button>
                        <button class="btn btn-warning" onclick="testAbstraction()">🏗️ Test Abstraction</button>
                        <button class="btn btn-danger" onclick="clearDemo()">🗑️ Clear Output</button>
                    </div>

                    <div class="output-area" id="demoOutput">
Welcome to the PHP OOP E-Commerce Demo!
=====================================

This interactive demo showcases all four pillars of Object-Oriented Programming:

🧬 INHERITANCE: Product classes (Electronics, Clothing, Books) inherit from base Product class
🔒 ENCAPSULATION: Private properties with getters/setters and validation
🔄 POLYMORPHISM: Different product types implement abstract methods differently  
🏗️ ABSTRACTION: Abstract Product class and interfaces define contracts

Click any button above to see OOP concepts in action!

Student: Kheni Urval (24CE055)
Course: WDF: ITUE203
Assignment: PHP Object-Oriented Programming
                    </div>
                </div>
            </div>

            <!-- OOP Concepts Tab -->
            <div id="concepts" class="tab-content">
                <div class="demo-section">
                    <h2>📚 OOP Concepts Demonstrated</h2>
                    
                    <div class="code-example">
                        <h4>🧬 Inheritance</h4>
                        <div class="code-block">abstract class Product {
    protected $id, $name, $price, $category;
    
    abstract public function calculateShipping();
    abstract public function getDisplayInfo();
}

class ElectronicsProduct extends Product {
    private $brand, $model, $warranty;
    
    public function calculateShipping() {
        return 15.00 + ($this->price * 0.02);
    }
}

class ClothingProduct extends Product {
    private $size, $color, $material;
    
    public function calculateShipping() {
        return 5.00 + $this->getSizeFactor();
    }
}</div>
                    </div>

                    <div class="code-example">
                        <h4>🔒 Encapsulation</h4>
                        <div class="code-block">class Product {
    private $price;  // Private property
    
    public function setPrice($price) {
        if ($price < 0) {
            throw new InvalidArgumentException("Price cannot be negative");
        }
        $this->price = $price;
    }
    
    public function getPrice() {
        return $this->price;
    }
}</div>
                    </div>

                    <div class="code-example">
                        <h4>🔄 Polymorphism</h4>
                        <div class="code-block">interface PaymentProcessorInterface {
    public function processPayment($amount, $details);
}

class CreditCardPayment implements PaymentProcessorInterface {
    public function processPayment($amount, $details) {
        // Credit card specific processing
        return $this->chargeCreditCard($amount, $details);
    }
}

class PayPalPayment implements PaymentProcessorInterface {
    public function processPayment($amount, $details) {
        // PayPal specific processing
        return $this->chargePayPal($amount, $details);
    }
}</div>
                    </div>

                    <div class="code-example">
                        <h4>🏗️ Abstraction</h4>
                        <div class="code-block">abstract class Product {
    // Abstract methods must be implemented by subclasses
    abstract public function calculateShipping();
    abstract public function getSpecifications();
    
    // Concrete method available to all subclasses
    public function getFormattedPrice() {
        return '$' . number_format($this->price, 2);
    }
}</div>
                    </div>

                    <div class="code-example">
                        <h4>🏭 Design Patterns</h4>
                        <div class="code-block">// Factory Pattern
class ProductFactory {
    public static function createProduct($type, $data) {
        switch ($type) {
            case 'electronics':
                return new ElectronicsProduct($data);
            case 'clothing':
                return new ClothingProduct($data);
            default:
                throw new InvalidArgumentException("Unknown type");
        }
    }
}

// Singleton Pattern
class StoreManager {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}</div>
                    </div>
                </div>
            </div>

            <!-- About Tab -->
            <div id="about" class="tab-content">
                <div class="demo-section">
                    <h2>ℹ️ About This Assignment</h2>
                    
                    <h3>📚 Assignment Overview</h3>
                    <p><strong>Assignment 12:</strong> PHP Object-Oriented Programming System</p>
                    <p><strong>Student:</strong> Kheni Urval (24CE055)</p>
                    <p><strong>Course:</strong> WDF: ITUE203</p>
                    <p><strong>Complexity Level:</strong> Medium</p>
                </div>

                <div class="demo-section">
                    <h3>🎯 Learning Objectives</h3>
                    <ul style="line-height: 2; margin-left: 20px;">
                        <li><strong>Inheritance:</strong> Create class hierarchies with parent-child relationships</li>
                        <li><strong>Encapsulation:</strong> Implement data hiding with private/protected properties</li>
                        <li><strong>Polymorphism:</strong> Use interfaces and method overriding for flexible code</li>
                        <li><strong>Abstraction:</strong> Define abstract classes and methods for code contracts</li>
                        <li><strong>Design Patterns:</strong> Implement Factory, Singleton, and other patterns</li>
                        <li><strong>Complex Relationships:</strong> Composition, aggregation, and associations</li>
                        <li><strong>Error Handling:</strong> Custom exceptions and validation</li>
                        <li><strong>Real-world Application:</strong> E-commerce system with practical features</li>
                    </ul>
                </div>

                <div class="demo-section">
                    <h3>🛠️ Technical Implementation</h3>
                    <div class="statistics-grid">
                        <div class="stat-card">
                            <div class="stat-number">15+</div>
                            <div class="stat-label">Classes</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">3</div>
                            <div class="stat-label">Interfaces</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">4</div>
                            <div class="stat-label">OOP Pillars</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">5+</div>
                            <div class="stat-label">Design Patterns</div>
                        </div>
                    </div>
                </div>

                <div class="demo-section">
                    <h3>📁 File Structure</h3>
                    <ul style="font-family: monospace; line-height: 1.8; margin-left: 20px;">
                        <li>📄 index.php - Main interface and demonstrations</li>
                        <li>📄 oop_classes.php - All OOP class definitions</li>
                        <li>📄 demo_handler.php - AJAX handlers and demo logic</li>
                        <li>📄 README.md - Comprehensive documentation</li>
                    </ul>
                </div>

                <div class="demo-section">
                    <h3>✨ Key Features</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 15px;">
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #28a745;">
                            <h4 style="color: #28a745; margin-bottom: 10px;">🧬 Inheritance</h4>
                            <p>Product hierarchy with Electronics, Clothing, and Book classes inheriting from abstract Product base class.</p>
                        </div>
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #007bff;">
                            <h4 style="color: #007bff; margin-bottom: 10px;">🔒 Encapsulation</h4>
                            <p>Private properties with getter/setter methods, data validation, and access control.</p>
                        </div>
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #ffc107;">
                            <h4 style="color: #e68900; margin-bottom: 10px;">🔄 Polymorphism</h4>
                            <p>Interface implementations for payment processing and method overriding across product types.</p>
                        </div>
                        <div style="background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #6f42c1;">
                            <h4 style="color: #6f42c1; margin-bottom: 10px;">🏗️ Abstraction</h4>
                            <p>Abstract classes defining contracts and hiding implementation complexity from users.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentDemo = null;
        let demoData = {
            products: [],
            users: [],
            carts: {},
            orders: []
        };

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-load products on page load
            setTimeout(() => {
                addSampleProducts();
            }, 1000);
        });

        // Tab navigation
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all nav tabs
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        // Product management functions
        async function loadProducts() {
            const container = document.getElementById('productCatalog');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Loading products...</p></div>';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=load_products'
                });
                
                const data = await response.json();
                displayProducts(data.products || []);
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error loading products: ' + error.message + '</div>';
            }
        }

        async function addSampleProducts() {
            const container = document.getElementById('productCatalog');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Creating sample products...</p></div>';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=add_sample_products'
                });
                
                const data = await response.json();
                if (data.success) {
                    displayProducts(data.products);
                } else {
                    container.innerHTML = '<div class="alert alert-error">' + data.message + '</div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error creating products: ' + error.message + '</div>';
            }
        }

        function displayProducts(products) {
            const container = document.getElementById('productCatalog');
            
            if (!products || products.length === 0) {
                container.innerHTML = '<div class="alert alert-info">No products available. Click "Add Sample Products" to create some!</div>';
                return;
            }
            
            let html = '<div class="product-grid">';
            
            products.forEach(product => {
                html += `
                    <div class="product-card">
                        <div class="product-header">
                            <div>
                                <div class="product-name">${product.name}</div>
                                <span class="product-category">${product.category}</span>
                            </div>
                        </div>
                        <div class="product-price">$${product.price}</div>
                        <div class="product-description">${product.description}</div>
                        
                        <div class="product-specs">
                            <h5>Specifications:</h5>
                            ${Object.entries(product.specifications || {}).map(([key, value]) => 
                                `<div class="spec-item"><span>${key}:</span><span>${value}</span></div>`
                            ).join('')}
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                            <div>
                                <small>Stock: ${product.stock}</small><br>
                                <small>Shipping: $${product.shipping_cost}</small>
                            </div>
                            <button class="btn btn-primary" onclick="addProductToCart('${product.id}')">
                                🛒 Add to Cart
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            container.innerHTML = html;
        }

        // Cart management functions
        async function createUserCart() {
            const container = document.getElementById('cartContainer');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Creating user and cart...</p></div>';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=create_user_cart'
                });
                
                const data = await response.json();
                if (data.success) {
                    container.innerHTML = `
                        <div class="alert alert-success">
                            <strong>User and cart created successfully!</strong><br>
                            User: ${data.user.fullName} (${data.user.username})<br>
                            Cart ID: ${data.cart.user.id}
                        </div>
                        <div class="cart-items" id="cartItems">
                            <div class="alert alert-info">Cart is empty. Add some products!</div>
                        </div>
                    `;
                } else {
                    container.innerHTML = '<div class="alert alert-error">' + data.message + '</div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error creating user/cart: ' + error.message + '</div>';
            }
        }

        async function addToCart() {
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=add_to_cart'
                });
                
                const data = await response.json();
                if (data.success) {
                    displayCart(data.cart);
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Error adding to cart: ' + error.message);
            }
        }

        async function viewCart() {
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=view_cart'
                });
                
                const data = await response.json();
                if (data.success) {
                    displayCart(data.cart);
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Error viewing cart: ' + error.message);
            }
        }

        function displayCart(cart) {
            const container = document.getElementById('cartContainer');
            
            if (!cart || !cart.items || cart.items.length === 0) {
                container.innerHTML = '<div class="alert alert-info">Cart is empty. Add some products!</div>';
                return;
            }
            
            let html = '<h3>🛒 Shopping Cart</h3>';
            html += '<div class="cart-items">';
            
            cart.items.forEach(item => {
                html += `
                    <div class="cart-item">
                        <div>
                            <strong>${item.product.name}</strong><br>
                            <small>${item.product.category} - $${item.product.price} each</small>
                        </div>
                        <div>
                            Qty: ${item.quantity}<br>
                            Subtotal: $${item.subtotal}
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            html += `
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>$${cart.subtotal}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>$${cart.shipping_cost}</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax:</span>
                        <span>$${cart.tax}</span>
                    </div>
                    <div class="summary-total">
                        <div class="summary-row">
                            <span>Total:</span>
                            <span>$${cart.total}</span>
                        </div>
                    </div>
                </div>
            `;
            
            container.innerHTML = html;
        }

        // Demo functions
        async function runCompleteDemo() {
            const output = document.getElementById('demoOutput');
            output.innerHTML = 'Running Complete PHP OOP Demo...\n' +
                              '================================\n\n';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=complete_demo'
                });
                
                const data = await response.json();
                if (data.success) {
                    output.innerHTML += data.output;
                } else {
                    output.innerHTML += 'Error: ' + data.message;
                }
            } catch (error) {
                output.innerHTML += 'Error running demo: ' + error.message;
            }
        }

        async function testInheritance() {
            const output = document.getElementById('demoOutput');
            output.innerHTML = 'Testing Inheritance...\n' +
                              '====================\n\n';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=test_inheritance'
                });
                
                const data = await response.json();
                output.innerHTML += data.output || 'Inheritance test completed';
            } catch (error) {
                output.innerHTML += 'Error: ' + error.message;
            }
        }

        async function testEncapsulation() {
            const output = document.getElementById('demoOutput');
            output.innerHTML = 'Testing Encapsulation...\n' +
                              '======================\n\n';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=test_encapsulation'
                });
                
                const data = await response.json();
                output.innerHTML += data.output || 'Encapsulation test completed';
            } catch (error) {
                output.innerHTML += 'Error: ' + error.message;
            }
        }

        function clearDemo() {
            document.getElementById('demoOutput').innerHTML = 'Demo output cleared.\n\nReady for new demonstrations!';
        }

        // Utility functions
        function showAlert(type, message) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = message;
            
            // Insert at the top of the current tab
            const activeTab = document.querySelector('.tab-content.active');
            activeTab.insertBefore(alert, activeTab.firstChild);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 5000);
        }

        // Additional product and cart functions
        async function addProductToCart(productId) {
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=add_product_to_cart&product_id=${productId}`
                });
                
                const data = await response.json();
                if (data.success) {
                    showAlert('success', 'Product added to cart!');
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Error adding product to cart');
            }
        }

        // Order management functions
        async function createOrder() {
            const container = document.getElementById('orderContainer');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Creating order...</p></div>';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=create_order'
                });
                
                const data = await response.json();
                if (data.success) {
                    displayOrder(data.order);
                } else {
                    container.innerHTML = '<div class="alert alert-error">' + data.message + '</div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error creating order: ' + error.message + '</div>';
            }
        }

        function displayOrder(order) {
            const container = document.getElementById('orderContainer');
            
            const html = `
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">Order: ${order.id}</div>
                        <div class="order-status status-${order.status}">${order.status}</div>
                    </div>
                    <div>
                        <strong>Customer:</strong> ${order.user.fullName}<br>
                        <strong>Items:</strong> ${order.item_count} items (${order.total_quantity} total)<br>
                        <strong>Total:</strong> $${order.total}<br>
                        <strong>Date:</strong> ${order.order_date}
                    </div>
                </div>
            `;
            
            container.innerHTML = html;
        }

        // User management functions
        async function createUsers() {
            const container = document.getElementById('userContainer');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Creating sample users...</p></div>';
            
            try {
                const response = await fetch('demo_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=create_users'
                });
                
                const data = await response.json();
                if (data.success) {
                    displayUsers(data.users);
                } else {
                    container.innerHTML = '<div class="alert alert-error">' + data.message + '</div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error creating users: ' + error.message + '</div>';
            }
        }

        function displayUsers(users) {
            const container = document.getElementById('userContainer');
            
            let html = '<div class="statistics-grid">';
            
            users.forEach(user => {
                html += `
                    <div class="stat-card">
                        <div style="position: relative; z-index: 1;">
                            <div style="font-size: 1.2rem; font-weight: bold; margin-bottom: 10px;">
                                ${user.fullName}
                            </div>
                            <div style="font-size: 0.9rem; opacity: 0.9;">
                                @${user.username}<br>
                                ${user.email}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            container.innerHTML = html;
        }
    </script>
</body>
</html>
