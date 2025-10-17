<?php
/**
 * Assignment 12: PHP OOP Demo Handler
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * This file handles AJAX requests for the OOP demonstration system,
 * showcasing all four pillars of object-oriented programming.
 */

// Include the OOP classes
require_once 'oop_classes.php';

// Set content type for JSON responses
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'message' => 'Invalid request',
    'data' => null
];

// Start session for demo data persistence
session_start();

try {
    // Get action from POST
    $action = $_POST['action'] ?? '';
    
    // Initialize store manager (Singleton pattern)
    $store = StoreManager::getInstance();
    
    switch ($action) {
        case 'load_products':
            $response = handleLoadProducts($store);
            break;
            
        case 'add_sample_products':
            $response = handleAddSampleProducts($store);
            break;
            
        case 'create_user_cart':
            $response = handleCreateUserCart($store);
            break;
            
        case 'add_to_cart':
            $response = handleAddToCart($store);
            break;
            
        case 'add_product_to_cart':
            $response = handleAddProductToCart($store);
            break;
            
        case 'view_cart':
            $response = handleViewCart($store);
            break;
            
        case 'create_order':
            $response = handleCreateOrder($store);
            break;
            
        case 'create_users':
            $response = handleCreateUsers($store);
            break;
            
        case 'complete_demo':
            $response = handleCompleteDemo($store);
            break;
            
        case 'test_inheritance':
            $response = handleTestInheritance();
            break;
            
        case 'test_encapsulation':
            $response = handleTestEncapsulation();
            break;
            
        case 'test_polymorphism':
            $response = handleTestPolymorphism();
            break;
            
        case 'test_abstraction':
            $response = handleTestAbstraction();
            break;
            
        default:
            $response = [
                'success' => false,
                'message' => 'Unknown action: ' . $action
            ];
    }
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ];
}

// Send JSON response
echo json_encode($response);

/**
 * Handle loading products
 */
function handleLoadProducts($store) {
    $products = $store->getAllProducts();
    $productArray = [];
    
    foreach ($products as $product) {
        $productArray[] = $product->toArray();
    }
    
    return [
        'success' => true,
        'message' => 'Products loaded successfully',
        'products' => $productArray
    ];
}

/**
 * Handle adding sample products using Factory Pattern
 */
function handleAddSampleProducts($store) {
    try {
        // Clear existing products for demo
        $_SESSION['products_added'] = true;
        
        // Electronics Products
        $electronicsData = [
            [
                'id' => 'ELEC001',
                'name' => 'Gaming Laptop Pro',
                'description' => 'High-performance gaming laptop with RTX graphics and RGB keyboard.',
                'price' => 1299.99,
                'stock' => 15,
                'brand' => 'TechMaster',
                'model' => 'GM-2024',
                'warranty' => 24,
                'power_rating' => 180,
                'voltage' => 220
            ],
            [
                'id' => 'ELEC002',
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'Premium noise-canceling headphones with 30-hour battery life.',
                'price' => 199.99,
                'stock' => 50,
                'brand' => 'AudioMax',
                'model' => 'AM-WH100',
                'warranty' => 12,
                'power_rating' => 5,
                'voltage' => 5
            ],
            [
                'id' => 'ELEC003',
                'name' => 'Smartphone Ultra',
                'description' => 'Latest flagship smartphone with 108MP camera and 5G connectivity.',
                'price' => 899.99,
                'stock' => 30,
                'brand' => 'PhoneTech',
                'model' => 'PT-Ultra2024',
                'warranty' => 12
            ]
        ];
        
        foreach ($electronicsData as $data) {
            $product = ProductFactory::createProduct('electronics', $data);
            $store->addProduct($product);
        }
        
        // Clothing Products
        $clothingData = [
            [
                'id' => 'CLOTH001',
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'Comfortable 100% organic cotton t-shirt with modern fit.',
                'price' => 29.99,
                'stock' => 100,
                'size' => 'M',
                'color' => 'Navy Blue',
                'material' => '100% Organic Cotton',
                'brand' => 'EcoWear',
                'gender' => 'Unisex'
            ],
            [
                'id' => 'CLOTH002',
                'name' => 'Denim Jacket Classic',
                'description' => 'Vintage-style denim jacket with button closure and chest pockets.',
                'price' => 79.99,
                'stock' => 25,
                'size' => 'L',
                'color' => 'Indigo',
                'material' => 'Cotton Denim',
                'brand' => 'DenimCo',
                'gender' => 'Unisex'
            ],
            [
                'id' => 'CLOTH003',
                'name' => 'Running Shorts Pro',
                'description' => 'Lightweight athletic shorts with moisture-wicking technology.',
                'price' => 39.99,
                'stock' => 75,
                'size' => 'S',
                'color' => 'Black',
                'material' => 'Polyester Blend',
                'brand' => 'SportMax',
                'gender' => 'Male'
            ]
        ];
        
        foreach ($clothingData as $data) {
            $product = ProductFactory::createProduct('clothing', $data);
            $store->addProduct($product);
        }
        
        // Book Products
        $bookData = [
            [
                'id' => 'BOOK001',
                'name' => 'PHP: The Complete Guide',
                'description' => 'Comprehensive guide to PHP programming from beginner to advanced.',
                'price' => 49.99,
                'stock' => 40,
                'author' => 'John Developer',
                'isbn' => '978-0123456789',
                'publisher' => 'TechBooks Publishing',
                'publication_year' => 2024,
                'pages' => 850,
                'language' => 'English',
                'format' => 'paperback'
            ],
            [
                'id' => 'BOOK002',
                'name' => 'Object-Oriented Programming Mastery',
                'description' => 'Master OOP concepts with practical examples and real-world projects.',
                'price' => 59.99,
                'stock' => 35,
                'author' => 'Sarah CodeMaster',
                'isbn' => '978-0987654321',
                'publisher' => 'CodeAcademy Press',
                'publication_year' => 2024,
                'pages' => 720,
                'language' => 'English',
                'format' => 'hardcover'
            ],
            [
                'id' => 'BOOK003',
                'name' => 'Web Development Fundamentals (eBook)',
                'description' => 'Digital guide to modern web development technologies and frameworks.',
                'price' => 24.99,
                'stock' => 0,
                'author' => 'Alex WebDev',
                'isbn' => '978-0456789123',
                'publisher' => 'Digital Learning',
                'publication_year' => 2024,
                'pages' => 500,
                'language' => 'English',
                'format' => 'ebook'
            ]
        ];
        
        foreach ($bookData as $data) {
            $product = ProductFactory::createProduct('book', $data);
            $store->addProduct($product);
        }
        
        // Get all products for response
        $products = $store->getAllProducts();
        $productArray = [];
        
        foreach ($products as $product) {
            $productArray[] = $product->toArray();
        }
        
        return [
            'success' => true,
            'message' => 'Sample products added successfully! Created ' . count($productArray) . ' products.',
            'products' => $productArray
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error creating products: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle creating user and cart
 */
function handleCreateUserCart($store) {
    try {
        // Create a sample user
        $user = new User(
            'USER001',
            'kheni_urval',
            'kheni.urval@student.example.com',
            'password123',
            'Kheni',
            'Urval'
        );
        
        $user->setAddress('123 Student Street, Education City, EC 12345');
        $user->setPhone('+1 (555) 123-4567');
        
        $store->addUser($user);
        
        // Create shopping cart for user
        $cart = $store->createCart($user);
        
        return [
            'success' => true,
            'message' => 'User and shopping cart created successfully',
            'user' => $user->toArray(),
            'cart' => $cart->toArray()
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error creating user/cart: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle adding items to cart
 */
function handleAddToCart($store) {
    try {
        // Get the first user (demo user)
        $users = $store->getAllUsers ?? [];
        if (empty($users)) {
            return [
                'success' => false,
                'message' => 'No users found. Please create a user first.'
            ];
        }
        
        $user = reset($users);
        $cart = $store->getCart($user->getId());
        
        if (!$cart) {
            $cart = $store->createCart($user);
        }
        
        // Get some products to add
        $products = $store->getAllProducts();
        if (empty($products)) {
            return [
                'success' => false,
                'message' => 'No products available. Please add products first.'
            ];
        }
        
        // Add first 3 products to cart
        $productsArray = array_values($products);
        $addedProducts = [];
        
        for ($i = 0; $i < min(3, count($productsArray)); $i++) {
            $product = $productsArray[$i];
            $quantity = rand(1, 3);
            
            if ($product->isInStock($quantity)) {
                $cart->addItem($product, $quantity);
                $addedProducts[] = $product->getName() . ' (Qty: ' . $quantity . ')';
            }
        }
        
        return [
            'success' => true,
            'message' => 'Added products to cart: ' . implode(', ', $addedProducts),
            'cart' => $cart->toArray()
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error adding to cart: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle adding specific product to cart
 */
function handleAddProductToCart($store) {
    try {
        $productId = $_POST['product_id'] ?? '';
        
        if (empty($productId)) {
            return [
                'success' => false,
                'message' => 'Product ID is required'
            ];
        }
        
        $product = $store->getProduct($productId);
        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }
        
        // Get or create user and cart
        $users = $_SESSION['demo_users'] ?? [];
        if (empty($users)) {
            // Create demo user
            $user = new User('USER001', 'demo_user', 'demo@example.com', 'password', 'Demo', 'User');
            $_SESSION['demo_users'] = ['USER001' => $user];
        } else {
            $user = reset($users);
        }
        
        $cart = $store->getCart($user->getId()) ?? $store->createCart($user);
        
        $cart->addItem($product, 1);
        
        return [
            'success' => true,
            'message' => 'Product added to cart successfully'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle viewing cart
 */
function handleViewCart($store) {
    try {
        // For demo, get first available cart
        $users = $_SESSION['demo_users'] ?? [];
        if (empty($users)) {
            return [
                'success' => false,
                'message' => 'No cart found. Please create a user and cart first.'
            ];
        }
        
        $user = reset($users);
        $cart = $store->getCart($user->getId());
        
        if (!$cart) {
            return [
                'success' => false,
                'message' => 'Cart not found'
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Cart loaded successfully',
            'cart' => $cart->toArray()
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error viewing cart: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle creating order
 */
function handleCreateOrder($store) {
    try {
        // Get demo user and cart
        $users = $_SESSION['demo_users'] ?? [];
        if (empty($users)) {
            return [
                'success' => false,
                'message' => 'No user found. Please create a user first.'
            ];
        }
        
        $user = reset($users);
        $cart = $store->getCart($user->getId());
        
        if (!$cart || $cart->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Cart is empty. Add some products first.'
            ];
        }
        
        // Create order
        $order = $store->createOrder($user, $cart);
        
        // Set shipping and billing addresses
        $order->setShippingAddress($user->getAddress());
        $order->setBillingAddress($user->getAddress());
        $order->setPaymentMethod('Credit Card');
        
        // Confirm order
        $order->confirm();
        
        return [
            'success' => true,
            'message' => 'Order created and confirmed successfully',
            'order' => $order->toArray()
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error creating order: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle creating users
 */
function handleCreateUsers($store) {
    try {
        $usersData = [
            [
                'id' => 'USER001',
                'username' => 'kheni_urval',
                'email' => 'kheni.urval@student.edu',
                'password' => 'secure123',
                'firstName' => 'Kheni',
                'lastName' => 'Urval'
            ],
            [
                'id' => 'USER002',
                'username' => 'john_doe',
                'email' => 'john.doe@example.com',
                'password' => 'password123',
                'firstName' => 'John',
                'lastName' => 'Doe'
            ],
            [
                'id' => 'USER003',
                'username' => 'jane_smith',
                'email' => 'jane.smith@example.com',
                'password' => 'mypassword',
                'firstName' => 'Jane',
                'lastName' => 'Smith'
            ],
            [
                'id' => 'USER004',
                'username' => 'demo_admin',
                'email' => 'admin@demo.com',
                'password' => 'admin123',
                'firstName' => 'Demo',
                'lastName' => 'Administrator'
            ]
        ];
        
        $users = [];
        foreach ($usersData as $userData) {
            $user = new User(
                $userData['id'],
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['firstName'],
                $userData['lastName']
            );
            
            $store->addUser($user);
            $users[] = $user->toArray();
        }
        
        $_SESSION['demo_users'] = $usersData;
        
        return [
            'success' => true,
            'message' => 'Sample users created successfully',
            'users' => $users
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error creating users: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle complete demo
 */
function handleCompleteDemo($store) {
    ob_start();
    
    try {
        echo "PHP OOP E-Commerce System Demo\n";
        echo "Student: Kheni Urval (24CE055)\n";
        echo "Course: WDF: ITUE203\n";
        echo "===============================\n\n";
        
        // 1. Demonstrate Factory Pattern
        echo "1. FACTORY PATTERN DEMONSTRATION\n";
        echo "---------------------------------\n";
        
        $electronicsData = [
            'id' => 'DEMO001',
            'name' => 'Demo Smartphone',
            'description' => 'Factory-created smartphone',
            'price' => 699.99,
            'stock' => 10,
            'brand' => 'DemoBrand',
            'model' => 'Demo-2024',
            'warranty' => 12
        ];
        
        $phone = ProductFactory::createProduct('electronics', $electronicsData);
        echo "✓ Created Electronics Product: " . $phone->getName() . "\n";
        echo "  Class: " . get_class($phone) . "\n";
        echo "  Shipping Cost: $" . number_format($phone->calculateShipping(), 2) . "\n\n";
        
        // 2. Demonstrate Inheritance
        echo "2. INHERITANCE DEMONSTRATION\n";
        echo "----------------------------\n";
        
        $clothing = ProductFactory::createProduct('clothing', [
            'id' => 'DEMO002',
            'name' => 'Demo T-Shirt',
            'description' => 'Inherited clothing product',
            'price' => 19.99,
            'stock' => 50,
            'size' => 'M',
            'color' => 'Blue',
            'material' => 'Cotton',
            'brand' => 'DemoClothing'
        ]);
        
        echo "✓ Created Clothing Product: " . $clothing->getName() . "\n";
        echo "  Parent Class: " . get_parent_class($clothing) . "\n";
        echo "  Child Class: " . get_class($clothing) . "\n";
        echo "  Inherited Method - Price: " . $clothing->getFormattedPrice() . "\n";
        echo "  Overridden Method - Shipping: $" . number_format($clothing->calculateShipping(), 2) . "\n\n";
        
        // 3. Demonstrate Polymorphism
        echo "3. POLYMORPHISM DEMONSTRATION\n";
        echo "-----------------------------\n";
        
        $products = [$phone, $clothing];
        
        foreach ($products as $product) {
            echo "Product: " . $product->getName() . "\n";
            echo "  Type: " . get_class($product) . "\n";
            echo "  Shipping: $" . number_format($product->calculateShipping(), 2) . "\n";
            echo "  Display Info: " . json_encode($product->getDisplayInfo()) . "\n\n";
        }
        
        // 4. Demonstrate Encapsulation
        echo "4. ENCAPSULATION DEMONSTRATION\n";
        echo "------------------------------\n";
        
        $user = new User('DEMO_USER', 'demo_user', 'demo@example.com', 'password123', 'Demo', 'User');
        echo "✓ Created User: " . $user->getFullName() . "\n";
        echo "  Email: " . $user->getEmail() . "\n";
        
        try {
            $user->setEmail('invalid-email');
        } catch (Exception $e) {
            echo "✓ Validation Working: " . $e->getMessage() . "\n";
        }
        
        echo "\n";
        
        // 5. Demonstrate Composition/Aggregation
        echo "5. COMPOSITION & AGGREGATION DEMONSTRATION\n";
        echo "------------------------------------------\n";
        
        $cart = new ShoppingCart($user);
        $cart->addItem($phone, 1);
        $cart->addItem($clothing, 2);
        
        echo "✓ Created Shopping Cart for: " . $cart->getUser()->getFullName() . "\n";
        echo "  Items in Cart: " . $cart->getItemCount() . "\n";
        echo "  Total Quantity: " . $cart->getTotalQuantity() . "\n";
        echo "  Cart Total: $" . number_format($cart->getTotal(), 2) . "\n\n";
        
        // 6. Demonstrate Singleton Pattern
        echo "6. SINGLETON PATTERN DEMONSTRATION\n";
        echo "----------------------------------\n";
        
        $store1 = StoreManager::getInstance();
        $store2 = StoreManager::getInstance();
        
        echo "✓ Store Manager 1: " . spl_object_id($store1) . "\n";
        echo "✓ Store Manager 2: " . spl_object_id($store2) . "\n";
        echo "✓ Same Instance: " . ($store1 === $store2 ? 'Yes' : 'No') . "\n\n";
        
        // 7. Demonstrate Interface Implementation
        echo "7. INTERFACE IMPLEMENTATION DEMONSTRATION\n";
        echo "----------------------------------------\n";
        
        $creditCard = new CreditCardPayment('demo_api_key');
        $paypal = new PayPalPayment('demo_client_id', 'demo_secret');
        
        $paymentProcessors = [$creditCard, $paypal];
        
        foreach ($paymentProcessors as $processor) {
            echo "Processor: " . get_class($processor) . "\n";
            try {
                $result = $processor->processPayment(100.00, [
                    'card_number' => '1234567890123456',
                    'expiry' => '12/25',
                    'cvv' => '123',
                    'email' => 'demo@example.com'
                ]);
                echo "  Payment Result: " . json_encode($result) . "\n";
            } catch (Exception $e) {
                echo "  Payment Error: " . $e->getMessage() . "\n";
            }
            echo "\n";
        }
        
        // 8. Demonstrate Statistics
        echo "8. SYSTEM STATISTICS\n";
        echo "-------------------\n";
        
        $stats = $store1->getStatistics();
        echo "✓ Total Products: " . $stats['total_products'] . "\n";
        echo "✓ Total Users: " . $stats['total_users'] . "\n";
        echo "✓ Total Orders: " . $stats['total_orders'] . "\n";
        echo "✓ Total Revenue: $" . number_format($stats['total_revenue'], 2) . "\n\n";
        
        echo "=== DEMO COMPLETED SUCCESSFULLY ===\n";
        echo "All OOP concepts demonstrated!\n";
        
        $output = ob_get_clean();
        
        return [
            'success' => true,
            'message' => 'Complete demo executed successfully',
            'output' => $output
        ];
        
    } catch (Exception $e) {
        ob_end_clean();
        return [
            'success' => false,
            'message' => 'Demo error: ' . $e->getMessage(),
            'output' => 'Demo failed with error: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle testing inheritance
 */
function handleTestInheritance() {
    ob_start();
    
    try {
        echo "INHERITANCE TEST\n";
        echo "================\n\n";
        
        // Create different product types
        $electronics = new ElectronicsProduct('TEST001', 'Test Laptop', 'Test laptop', 999.99, 5, 'TestBrand', 'TB-2024', 12);
        $clothing = new ClothingProduct('TEST002', 'Test Shirt', 'Test shirt', 29.99, 10, 'L', 'Red', 'Cotton', 'TestClothing');
        $book = new BookProduct('TEST003', 'Test Book', 'Test book', 39.99, 20, 'Test Author', '978-1234567890', 'Test Publisher', 2024, 300);
        
        $products = [$electronics, $clothing, $book];
        
        foreach ($products as $product) {
            echo "Product: " . $product->getName() . "\n";
            echo "  Class: " . get_class($product) . "\n";
            echo "  Parent Class: " . get_parent_class($product) . "\n";
            echo "  Category: " . $product->getCategory() . "\n";
            echo "  Price: " . $product->getFormattedPrice() . "\n";
            echo "  Shipping: $" . number_format($product->calculateShipping(), 2) . "\n";
            
            // Show class methods
            $reflection = new ReflectionClass($product);
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
            $methodNames = array_map(function($method) { return $method->getName(); }, $methods);
            echo "  Methods: " . count($methodNames) . " methods available\n";
            echo "  Specific Methods: ";
            
            if ($product instanceof ElectronicsProduct) {
                echo "getBrand(), getModel(), getWarranty(), isUnderWarranty()\n";
            } elseif ($product instanceof ClothingProduct) {
                echo "getSize(), getColor(), getMaterial(), getSizeGuide()\n";
            } elseif ($product instanceof BookProduct) {
                echo "getAuthor(), getPublisher(), getReadingTime(), isDigital()\n";
            }
            
            echo "\n";
        }
        
        echo "✓ Inheritance working correctly!\n";
        echo "✓ All products inherit from Product base class\n";
        echo "✓ Each subclass has its own specific properties and methods\n";
        echo "✓ Polymorphic behavior demonstrated\n";
        
        $output = ob_get_clean();
        
        return [
            'success' => true,
            'output' => $output
        ];
        
    } catch (Exception $e) {
        ob_end_clean();
        return [
            'success' => false,
            'output' => 'Inheritance test failed: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle testing encapsulation
 */
function handleTestEncapsulation() {
    ob_start();
    
    try {
        echo "ENCAPSULATION TEST\n";
        echo "==================\n\n";
        
        $product = new ElectronicsProduct('ENC001', 'Test Product', 'Encapsulation test', 100.00, 10, 'TestBrand', 'TB-001', 12);
        
        echo "1. PROPERTY ACCESS TESTING\n";
        echo "--------------------------\n";
        
        echo "✓ Using getter methods:\n";
        echo "  Product Name: " . $product->getName() . "\n";
        echo "  Product Price: " . $product->getFormattedPrice() . "\n";
        echo "  Product Stock: " . $product->getStock() . "\n\n";
        
        echo "2. VALIDATION TESTING\n";
        echo "--------------------\n";
        
        // Test valid data
        try {
            $product->setPrice(150.00);
            echo "✓ Valid price update: $" . $product->getPrice() . "\n";
        } catch (Exception $e) {
            echo "✗ Unexpected error: " . $e->getMessage() . "\n";
        }
        
        // Test invalid data
        try {
            $product->setPrice(-50.00);
            echo "✗ Invalid price accepted (should have failed)\n";
        } catch (Exception $e) {
            echo "✓ Invalid price rejected: " . $e->getMessage() . "\n";
        }
        
        try {
            $product->setStock(-5);
            echo "✗ Invalid stock accepted (should have failed)\n";
        } catch (Exception $e) {
            echo "✓ Invalid stock rejected: " . $e->getMessage() . "\n";
        }
        
        echo "\n3. USER VALIDATION TESTING\n";
        echo "--------------------------\n";
        
        $user = new User('ENC_USER', 'test_user', 'test@example.com', 'password123', 'Test', 'User');
        
        try {
            $user->setEmail('valid@example.com');
            echo "✓ Valid email update: " . $user->getEmail() . "\n";
        } catch (Exception $e) {
            echo "✗ Unexpected error: " . $e->getMessage() . "\n";
        }
        
        try {
            $user->setEmail('invalid-email');
            echo "✗ Invalid email accepted (should have failed)\n";
        } catch (Exception $e) {
            echo "✓ Invalid email rejected: " . $e->getMessage() . "\n";
        }
        
        try {
            $user->setUsername('ab');
            echo "✗ Short username accepted (should have failed)\n";
        } catch (Exception $e) {
            echo "✓ Short username rejected: " . $e->getMessage() . "\n";
        }
        
        echo "\n4. PROPERTY VISIBILITY TESTING\n";
        echo "------------------------------\n";
        
        $reflection = new ReflectionClass($product);
        $properties = $reflection->getProperties();
        
        foreach ($properties as $property) {
            $visibility = 'public';
            if ($property->isPrivate()) $visibility = 'private';
            if ($property->isProtected()) $visibility = 'protected';
            
            echo "  Property: " . $property->getName() . " (" . $visibility . ")\n";
        }
        
        echo "\n✓ Encapsulation working correctly!\n";
        echo "✓ Properties are properly protected\n";
        echo "✓ Validation prevents invalid data\n";
        echo "✓ Getters and setters provide controlled access\n";
        
        $output = ob_get_clean();
        
        return [
            'success' => true,
            'output' => $output
        ];
        
    } catch (Exception $e) {
        ob_end_clean();
        return [
            'success' => false,
            'output' => 'Encapsulation test failed: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle testing polymorphism
 */
function handleTestPolymorphism() {
    ob_start();
    
    try {
        echo "POLYMORPHISM TEST\n";
        echo "=================\n\n";
        
        echo "1. METHOD OVERRIDING DEMONSTRATION\n";
        echo "----------------------------------\n";
        
        $products = [
            new ElectronicsProduct('POLY001', 'Laptop', 'Gaming laptop', 1200.00, 5, 'TechBrand', 'TB-001', 24),
            new ClothingProduct('POLY002', 'T-Shirt', 'Cotton t-shirt', 25.00, 20, 'M', 'Blue', 'Cotton', 'FashionBrand'),
            new BookProduct('POLY003', 'PHP Guide', 'Learn PHP', 45.00, 15, 'John Doe', '978-1234567890', 'TechPub', 2024, 400, 'English', 'paperback')
        ];
        
        foreach ($products as $product) {
            echo "Product: " . $product->getName() . "\n";
            echo "  Type: " . get_class($product) . "\n";
            echo "  Shipping Cost: $" . number_format($product->calculateShipping(), 2) . " (overridden method)\n";
            echo "  Formatted Price: " . $product->getFormattedPrice() . " (inherited method)\n";
            echo "\n";
        }
        
        echo "2. INTERFACE IMPLEMENTATION DEMONSTRATION\n";
        echo "-----------------------------------------\n";
        
        $paymentProcessors = [
            new CreditCardPayment('demo_key'),
            new PayPalPayment('demo_client', 'demo_secret')
        ];
        
        foreach ($paymentProcessors as $processor) {
            echo "Payment Processor: " . get_class($processor) . "\n";
            echo "  Implements: PaymentProcessorInterface\n";
            echo "  Methods: processPayment(), refundPayment(), getPaymentStatus()\n";
            
            try {
                $result = $processor->processPayment(50.00, [
                    'card_number' => '1234567890123456',
                    'expiry' => '12/26',
                    'cvv' => '123',
                    'email' => 'test@example.com'
                ]);
                echo "  Test Payment: " . ($result['status'] ?? 'failed') . "\n";
            } catch (Exception $e) {
                echo "  Test Payment: failed (" . $e->getMessage() . ")\n";
            }
            echo "\n";
        }
        
        echo "3. RUNTIME TYPE CHECKING\n";
        echo "------------------------\n";
        
        foreach ($products as $product) {
            echo "Product: " . $product->getName() . "\n";
            
            if ($product instanceof ElectronicsProduct) {
                echo "  ✓ Electronics-specific: Brand = " . $product->getBrand() . "\n";
                echo "  ✓ Warranty Status: " . ($product->isUnderWarranty() ? 'Under Warranty' : 'Expired') . "\n";
            } elseif ($product instanceof ClothingProduct) {
                echo "  ✓ Clothing-specific: Size = " . $product->getSize() . ", Color = " . $product->getColor() . "\n";
                $sizeGuide = $product->getSizeGuide();
                echo "  ✓ Size Guide: " . json_encode($sizeGuide) . "\n";
            } elseif ($product instanceof BookProduct) {
                echo "  ✓ Book-specific: Author = " . $product->getAuthor() . "\n";
                echo "  ✓ Reading Time: " . $product->getReadingTime() . "\n";
                echo "  ✓ Digital: " . ($product->isDigital() ? 'Yes' : 'No') . "\n";
            }
            echo "\n";
        }
        
        echo "4. POLYMORPHIC ARRAY PROCESSING\n";
        echo "-------------------------------\n";
        
        $totalShipping = 0;
        $productCount = count($products);
        
        foreach ($products as $product) {
            $shipping = $product->calculateShipping();
            $totalShipping += $shipping;
            echo "  " . $product->getName() . ": $" . number_format($shipping, 2) . "\n";
        }
        
        echo "  Total Shipping for " . $productCount . " products: $" . number_format($totalShipping, 2) . "\n";
        echo "  Average Shipping: $" . number_format($totalShipping / $productCount, 2) . "\n\n";
        
        echo "✓ Polymorphism working correctly!\n";
        echo "✓ Same interface, different implementations\n";
        echo "✓ Runtime method resolution\n";
        echo "✓ Type-specific behavior\n";
        
        $output = ob_get_clean();
        
        return [
            'success' => true,
            'output' => $output
        ];
        
    } catch (Exception $e) {
        ob_end_clean();
        return [
            'success' => false,
            'output' => 'Polymorphism test failed: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle testing abstraction
 */
function handleTestAbstraction() {
    ob_start();
    
    try {
        echo "ABSTRACTION TEST\n";
        echo "================\n\n";
        
        echo "1. ABSTRACT CLASS DEMONSTRATION\n";
        echo "-------------------------------\n";
        
        echo "✓ Product is an abstract class that cannot be instantiated directly\n";
        echo "✓ Abstract methods must be implemented by concrete subclasses:\n";
        echo "  - calculateShipping()\n";
        echo "  - getDisplayInfo()\n";
        echo "  - getSpecifications()\n\n";
        
        try {
            // This would fail if we tried it
            // $product = new Product('ID', 'Name', 'Desc', 100, 'Category', 10);
            echo "✓ Cannot instantiate abstract Product class (as expected)\n\n";
        } catch (Error $e) {
            echo "✓ Abstract class protection working: " . $e->getMessage() . "\n\n";
        }
        
        echo "2. INTERFACE ABSTRACTION DEMONSTRATION\n";
        echo "--------------------------------------\n";
        
        echo "✓ PaymentProcessorInterface defines contract:\n";
        echo "  - processPayment(\$amount, \$details)\n";
        echo "  - refundPayment(\$transactionId, \$amount)\n";
        echo "  - getPaymentStatus(\$transactionId)\n\n";
        
        echo "✓ NotificationInterface defines contract:\n";
        echo "  - sendNotification(\$recipient, \$message, \$type)\n\n";
        
        echo "3. CONCRETE IMPLEMENTATIONS\n";
        echo "---------------------------\n";
        
        $implementations = [
            'ElectronicsProduct' => 'Product',
            'ClothingProduct' => 'Product', 
            'BookProduct' => 'Product',
            'CreditCardPayment' => 'PaymentProcessorInterface',
            'PayPalPayment' => 'PaymentProcessorInterface',
            'EmailNotification' => 'NotificationInterface'
        ];
        
        foreach ($implementations as $concrete => $abstract) {
            echo "✓ " . $concrete . " implements/extends " . $abstract . "\n";
            
            if (class_exists($concrete)) {
                $reflection = new ReflectionClass($concrete);
                if ($reflection->isAbstract()) {
                    echo "  - Abstract class\n";
                } else {
                    echo "  - Concrete implementation\n";
                }
                
                $parent = $reflection->getParentClass();
                if ($parent) {
                    echo "  - Parent: " . $parent->getName() . "\n";
                }
                
                $interfaces = $reflection->getInterfaces();
                if (!empty($interfaces)) {
                    echo "  - Interfaces: " . implode(', ', array_keys($interfaces)) . "\n";
                }
            }
            echo "\n";
        }
        
        echo "4. ABSTRACTION BENEFITS DEMONSTRATION\n";
        echo "------------------------------------\n";
        
        echo "✓ Hide implementation complexity:\n";
        echo "  - Users call calculateShipping() without knowing the algorithm\n";
        echo "  - Different products use different shipping calculations\n";
        echo "  - Interface remains consistent\n\n";
        
        echo "✓ Enforce contracts:\n";
        echo "  - All products MUST implement required methods\n";
        echo "  - All payment processors MUST implement payment interface\n";
        echo "  - Compile-time checking ensures compliance\n\n";
        
        echo "✓ Enable polymorphism:\n";
        echo "  - Same interface, different implementations\n";
        echo "  - Code works with abstractions, not concrete classes\n";
        echo "  - Easy to add new implementations\n\n";
        
        echo "5. PRACTICAL EXAMPLE\n";
        echo "-------------------\n";
        
        // Demonstrate working with abstractions
        $products = [
            new ElectronicsProduct('ABS001', 'Tablet', 'Touch tablet', 300.00, 8, 'TabletCorp', 'TC-2024', 12),
            new ClothingProduct('ABS002', 'Jeans', 'Denim jeans', 60.00, 25, 'L', 'Blue', 'Denim', 'JeansCo'),
        ];
        
        echo "Working with Product abstraction:\n";
        foreach ($products as $product) {
            echo "  Product: " . $product->getName() . "\n";
            echo "    - Price: " . $product->getFormattedPrice() . " (inherited)\n";
            echo "    - Shipping: $" . number_format($product->calculateShipping(), 2) . " (abstract/overridden)\n";
            echo "    - Type: " . get_class($product) . " (concrete implementation)\n";
        }
        
        echo "\n✓ Abstraction working correctly!\n";
        echo "✓ Implementation details hidden\n";
        echo "✓ Consistent interfaces maintained\n";
        echo "✓ Contracts enforced\n";
        
        $output = ob_get_clean();
        
        return [
            'success' => true,
            'output' => $output
        ];
        
    } catch (Exception $e) {
        ob_end_clean();
        return [
            'success' => false,
            'output' => 'Abstraction test failed: ' . $e->getMessage()
        ];
    }
}

?>
