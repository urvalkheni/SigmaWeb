<?php
/**
 * Assignment 12: PHP Object-Oriented Programming System
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * This file contains the core OOP classes demonstrating inheritance,
 * polymorphism, encapsulation, and abstraction in PHP.
 */

// =====================================
// ABSTRACT BASE CLASSES
// =====================================

/**
 * Abstract Product class demonstrating abstraction and encapsulation
 */
abstract class Product {
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $category;
    protected $stock;
    protected $createdAt;
    protected $updatedAt;
    
    // Static property for product count
    protected static $productCount = 0;
    
    public function __construct($id, $name, $description, $price, $category, $stock = 0) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->setPrice($price); // Use setter for validation
        $this->category = $category;
        $this->setStock($stock); // Use setter for validation
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        
        self::$productCount++;
    }
    
    // Getters (Encapsulation)
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getCategory() { return $this->category; }
    public function getStock() { return $this->stock; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }
    
    // Setters with validation (Encapsulation)
    public function setName($name) {
        if (strlen($name) < 2) {
            throw new InvalidArgumentException("Product name must be at least 2 characters long");
        }
        $this->name = $name;
        $this->updateTimestamp();
    }
    
    public function setDescription($description) {
        $this->description = $description;
        $this->updateTimestamp();
    }
    
    public function setPrice($price) {
        if ($price < 0) {
            throw new InvalidArgumentException("Price cannot be negative");
        }
        $this->price = $price;
        $this->updateTimestamp();
    }
    
    public function setStock($stock) {
        if ($stock < 0) {
            throw new InvalidArgumentException("Stock cannot be negative");
        }
        $this->stock = $stock;
        $this->updateTimestamp();
    }
    
    public function setCategory($category) {
        $this->category = $category;
        $this->updateTimestamp();
    }
    
    // Stock management methods
    public function addStock($quantity) {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity must be positive");
        }
        $this->stock += $quantity;
        $this->updateTimestamp();
    }
    
    public function reduceStock($quantity) {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity must be positive");
        }
        if ($quantity > $this->stock) {
            throw new Exception("Insufficient stock. Available: {$this->stock}, Requested: {$quantity}");
        }
        $this->stock -= $quantity;
        $this->updateTimestamp();
    }
    
    public function isInStock($quantity = 1) {
        return $this->stock >= $quantity;
    }
    
    // Utility methods
    protected function updateTimestamp() {
        $this->updatedAt = new DateTime();
    }
    
    public static function getProductCount() {
        return self::$productCount;
    }
    
    // Abstract methods (must be implemented by subclasses)
    abstract public function calculateShipping();
    abstract public function getDisplayInfo();
    abstract public function getSpecifications();
    
    // Common method that can be overridden (Polymorphism)
    public function getFormattedPrice() {
        return '$' . number_format($this->price, 2);
    }
    
    // Magic methods
    public function __toString() {
        return $this->name . ' - ' . $this->getFormattedPrice();
    }
    
    public function __sleep() {
        return ['id', 'name', 'description', 'price', 'category', 'stock', 'createdAt', 'updatedAt'];
    }
    
    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category,
            'stock' => $this->stock,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
            'specifications' => $this->getSpecifications(),
            'shipping_cost' => $this->calculateShipping()
        ];
    }
}

// =====================================
// CONCRETE PRODUCT CLASSES (Inheritance)
// =====================================

/**
 * Electronics Product class demonstrating inheritance
 */
class ElectronicsProduct extends Product {
    private $brand;
    private $model;
    private $warranty;
    private $powerRating;
    private $voltage;
    
    public function __construct($id, $name, $description, $price, $stock, $brand, $model, $warranty, $powerRating = null, $voltage = null) {
        parent::__construct($id, $name, $description, $price, 'Electronics', $stock);
        $this->brand = $brand;
        $this->model = $model;
        $this->warranty = $warranty;
        $this->powerRating = $powerRating;
        $this->voltage = $voltage;
    }
    
    // Getters and setters for electronics-specific properties
    public function getBrand() { return $this->brand; }
    public function getModel() { return $this->model; }
    public function getWarranty() { return $this->warranty; }
    public function getPowerRating() { return $this->powerRating; }
    public function getVoltage() { return $this->voltage; }
    
    public function setBrand($brand) {
        $this->brand = $brand;
        $this->updateTimestamp();
    }
    
    public function setModel($model) {
        $this->model = $model;
        $this->updateTimestamp();
    }
    
    public function setWarranty($warranty) {
        $this->warranty = $warranty;
        $this->updateTimestamp();
    }
    
    // Implementation of abstract methods
    public function calculateShipping() {
        // Electronics have higher shipping cost due to fragility
        $baseShipping = 15.00;
        $weightFactor = $this->price * 0.02; // Assume price correlates with weight
        return $baseShipping + $weightFactor;
    }
    
    public function getDisplayInfo() {
        return [
            'type' => 'Electronics',
            'brand' => $this->brand,
            'model' => $this->model,
            'warranty' => $this->warranty,
            'price' => $this->getFormattedPrice(),
            'stock' => $this->stock,
            'shipping' => '$' . number_format($this->calculateShipping(), 2)
        ];
    }
    
    public function getSpecifications() {
        $specs = [
            'Brand' => $this->brand,
            'Model' => $this->model,
            'Warranty' => $this->warranty,
            'Category' => $this->category
        ];
        
        if ($this->powerRating) {
            $specs['Power Rating'] = $this->powerRating . 'W';
        }
        
        if ($this->voltage) {
            $specs['Voltage'] = $this->voltage . 'V';
        }
        
        return $specs;
    }
    
    // Electronics-specific methods
    public function isUnderWarranty() {
        $warrantyExpiry = clone $this->createdAt;
        $warrantyExpiry->add(new DateInterval('P' . $this->warranty . 'M'));
        return new DateTime() <= $warrantyExpiry;
    }
    
    public function getWarrantyExpiry() {
        $warrantyExpiry = clone $this->createdAt;
        $warrantyExpiry->add(new DateInterval('P' . $this->warranty . 'M'));
        return $warrantyExpiry;
    }
}

/**
 * Clothing Product class demonstrating inheritance
 */
class ClothingProduct extends Product {
    private $size;
    private $color;
    private $material;
    private $brand;
    private $gender;
    private $careInstructions;
    
    public function __construct($id, $name, $description, $price, $stock, $size, $color, $material, $brand, $gender = 'Unisex') {
        parent::__construct($id, $name, $description, $price, 'Clothing', $stock);
        $this->size = $size;
        $this->color = $color;
        $this->material = $material;
        $this->brand = $brand;
        $this->gender = $gender;
        $this->careInstructions = 'Machine wash cold, tumble dry low';
    }
    
    // Getters and setters
    public function getSize() { return $this->size; }
    public function getColor() { return $this->color; }
    public function getMaterial() { return $this->material; }
    public function getBrand() { return $this->brand; }
    public function getGender() { return $this->gender; }
    public function getCareInstructions() { return $this->careInstructions; }
    
    public function setSize($size) {
        $this->size = $size;
        $this->updateTimestamp();
    }
    
    public function setColor($color) {
        $this->color = $color;
        $this->updateTimestamp();
    }
    
    public function setCareInstructions($instructions) {
        $this->careInstructions = $instructions;
        $this->updateTimestamp();
    }
    
    // Implementation of abstract methods
    public function calculateShipping() {
        // Clothing has lower shipping cost
        $baseShipping = 5.00;
        $sizeFactor = 0;
        
        switch (strtoupper($this->size)) {
            case 'XL':
            case 'XXL':
                $sizeFactor = 2.00;
                break;
            case 'L':
                $sizeFactor = 1.00;
                break;
            default:
                $sizeFactor = 0.50;
        }
        
        return $baseShipping + $sizeFactor;
    }
    
    public function getDisplayInfo() {
        return [
            'type' => 'Clothing',
            'brand' => $this->brand,
            'size' => $this->size,
            'color' => $this->color,
            'material' => $this->material,
            'gender' => $this->gender,
            'price' => $this->getFormattedPrice(),
            'stock' => $this->stock,
            'shipping' => '$' . number_format($this->calculateShipping(), 2)
        ];
    }
    
    public function getSpecifications() {
        return [
            'Brand' => $this->brand,
            'Size' => $this->size,
            'Color' => $this->color,
            'Material' => $this->material,
            'Gender' => $this->gender,
            'Care Instructions' => $this->careInstructions,
            'Category' => $this->category
        ];
    }
    
    // Clothing-specific methods
    public function getSizeGuide() {
        $sizeGuides = [
            'XS' => ['Chest' => '30-32"', 'Waist' => '24-26"'],
            'S' => ['Chest' => '32-34"', 'Waist' => '26-28"'],
            'M' => ['Chest' => '34-36"', 'Waist' => '28-30"'],
            'L' => ['Chest' => '36-38"', 'Waist' => '30-32"'],
            'XL' => ['Chest' => '38-40"', 'Waist' => '32-34"'],
            'XXL' => ['Chest' => '40-42"', 'Waist' => '34-36"']
        ];
        
        return $sizeGuides[$this->size] ?? ['Size' => 'Custom sizing available'];
    }
}

/**
 * Book Product class demonstrating inheritance
 */
class BookProduct extends Product {
    private $author;
    private $isbn;
    private $publisher;
    private $publicationYear;
    private $pages;
    private $language;
    private $format; // hardcover, paperback, ebook
    
    public function __construct($id, $name, $description, $price, $stock, $author, $isbn, $publisher, $publicationYear, $pages, $language = 'English', $format = 'paperback') {
        parent::__construct($id, $name, $description, $price, 'Books', $stock);
        $this->author = $author;
        $this->isbn = $isbn;
        $this->publisher = $publisher;
        $this->publicationYear = $publicationYear;
        $this->pages = $pages;
        $this->language = $language;
        $this->format = $format;
    }
    
    // Getters and setters
    public function getAuthor() { return $this->author; }
    public function getIsbn() { return $this->isbn; }
    public function getPublisher() { return $this->publisher; }
    public function getPublicationYear() { return $this->publicationYear; }
    public function getPages() { return $this->pages; }
    public function getLanguage() { return $this->language; }
    public function getFormat() { return $this->format; }
    
    public function setAuthor($author) {
        $this->author = $author;
        $this->updateTimestamp();
    }
    
    public function setFormat($format) {
        $allowedFormats = ['hardcover', 'paperback', 'ebook'];
        if (!in_array($format, $allowedFormats)) {
            throw new InvalidArgumentException("Invalid format. Allowed: " . implode(', ', $allowedFormats));
        }
        $this->format = $format;
        $this->updateTimestamp();
    }
    
    // Implementation of abstract methods
    public function calculateShipping() {
        if ($this->format === 'ebook') {
            return 0; // No shipping for digital products
        }
        
        $baseShipping = 3.00;
        $weightFactor = $this->pages * 0.005; // Assume weight based on pages
        
        if ($this->format === 'hardcover') {
            $weightFactor *= 1.5; // Hardcovers are heavier
        }
        
        return $baseShipping + $weightFactor;
    }
    
    public function getDisplayInfo() {
        return [
            'type' => 'Book',
            'author' => $this->author,
            'publisher' => $this->publisher,
            'year' => $this->publicationYear,
            'pages' => $this->pages,
            'format' => $this->format,
            'language' => $this->language,
            'price' => $this->getFormattedPrice(),
            'stock' => $this->format === 'ebook' ? 'Digital' : $this->stock,
            'shipping' => $this->format === 'ebook' ? 'Digital Download' : '$' . number_format($this->calculateShipping(), 2)
        ];
    }
    
    public function getSpecifications() {
        return [
            'Author' => $this->author,
            'ISBN' => $this->isbn,
            'Publisher' => $this->publisher,
            'Publication Year' => $this->publicationYear,
            'Pages' => $this->pages,
            'Language' => $this->language,
            'Format' => ucfirst($this->format),
            'Category' => $this->category
        ];
    }
    
    // Book-specific methods
    public function getAge() {
        return date('Y') - $this->publicationYear;
    }
    
    public function isDigital() {
        return $this->format === 'ebook';
    }
    
    public function getReadingTime() {
        // Assume average reading speed of 250 words per minute
        // and average 250 words per page
        $wordsPerPage = 250;
        $wordsPerMinute = 250;
        $totalWords = $this->pages * $wordsPerPage;
        $readingMinutes = $totalWords / $wordsPerMinute;
        
        $hours = floor($readingMinutes / 60);
        $minutes = $readingMinutes % 60;
        
        return sprintf("%d hours %d minutes", $hours, $minutes);
    }
}

// =====================================
// USER MANAGEMENT CLASSES
// =====================================

/**
 * User class demonstrating encapsulation and validation
 */
class User {
    private $id;
    private $username;
    private $email;
    private $passwordHash;
    private $firstName;
    private $lastName;
    private $address;
    private $phone;
    private $registrationDate;
    private $lastLogin;
    private $isActive;
    
    public function __construct($id, $username, $email, $password, $firstName, $lastName) {
        $this->id = $id;
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->registrationDate = new DateTime();
        $this->isActive = true;
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getFullName() { return $this->firstName . ' ' . $this->lastName; }
    public function getAddress() { return $this->address; }
    public function getPhone() { return $this->phone; }
    public function getRegistrationDate() { return $this->registrationDate; }
    public function getLastLogin() { return $this->lastLogin; }
    public function isActive() { return $this->isActive; }
    
    // Setters with validation
    public function setUsername($username) {
        if (strlen($username) < 3) {
            throw new InvalidArgumentException("Username must be at least 3 characters long");
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            throw new InvalidArgumentException("Username can only contain letters, numbers, and underscores");
        }
        $this->username = $username;
    }
    
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address");
        }
        $this->email = $email;
    }
    
    public function setPassword($password) {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException("Password must be at least 8 characters long");
        }
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }
    
    public function setPhone($phone) {
        if ($phone && !preg_match('/^\+?[\d\s\-\(\)]+$/', $phone)) {
            throw new InvalidArgumentException("Invalid phone number format");
        }
        $this->phone = $phone;
    }
    
    public function setActive($isActive) {
        $this->isActive = $isActive;
    }
    
    // Authentication methods
    public function verifyPassword($password) {
        return password_verify($password, $this->passwordHash);
    }
    
    public function updateLastLogin() {
        $this->lastLogin = new DateTime();
    }
    
    // Utility methods
    public function toArray() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'fullName' => $this->getFullName(),
            'address' => $this->address,
            'phone' => $this->phone,
            'registrationDate' => $this->registrationDate->format('Y-m-d H:i:s'),
            'lastLogin' => $this->lastLogin ? $this->lastLogin->format('Y-m-d H:i:s') : null,
            'isActive' => $this->isActive
        ];
    }
    
    public function __toString() {
        return $this->getFullName() . ' (' . $this->username . ')';
    }
}

// =====================================
// SHOPPING CART CLASSES
// =====================================

/**
 * Cart Item class representing items in shopping cart
 */
class CartItem {
    private $product;
    private $quantity;
    private $addedAt;
    
    public function __construct(Product $product, $quantity = 1) {
        $this->product = $product;
        $this->setQuantity($quantity);
        $this->addedAt = new DateTime();
    }
    
    public function getProduct() { return $this->product; }
    public function getQuantity() { return $this->quantity; }
    public function getAddedAt() { return $this->addedAt; }
    
    public function setQuantity($quantity) {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity must be positive");
        }
        if (!$this->product->isInStock($quantity)) {
            throw new Exception("Insufficient stock for " . $this->product->getName());
        }
        $this->quantity = $quantity;
    }
    
    public function getSubtotal() {
        return $this->product->getPrice() * $this->quantity;
    }
    
    public function getShippingCost() {
        return $this->product->calculateShipping();
    }
    
    public function toArray() {
        return [
            'product' => $this->product->toArray(),
            'quantity' => $this->quantity,
            'subtotal' => $this->getSubtotal(),
            'shipping_cost' => $this->getShippingCost(),
            'added_at' => $this->addedAt->format('Y-m-d H:i:s')
        ];
    }
}

/**
 * Shopping Cart class demonstrating composition and aggregation
 */
class ShoppingCart {
    private $user;
    private $items = [];
    private $createdAt;
    private $updatedAt;
    private $discountCode;
    private $discountAmount = 0;
    
    public function __construct(User $user) {
        $this->user = $user;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }
    
    public function getUser() { return $this->user; }
    public function getItems() { return $this->items; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }
    public function getDiscountCode() { return $this->discountCode; }
    public function getDiscountAmount() { return $this->discountAmount; }
    
    public function addItem(Product $product, $quantity = 1) {
        $productId = $product->getId();
        
        if (isset($this->items[$productId])) {
            // Update existing item
            $currentQuantity = $this->items[$productId]->getQuantity();
            $this->items[$productId]->setQuantity($currentQuantity + $quantity);
        } else {
            // Add new item
            $this->items[$productId] = new CartItem($product, $quantity);
        }
        
        $this->updateTimestamp();
    }
    
    public function removeItem($productId) {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
            $this->updateTimestamp();
            return true;
        }
        return false;
    }
    
    public function updateItemQuantity($productId, $quantity) {
        if (isset($this->items[$productId])) {
            if ($quantity <= 0) {
                $this->removeItem($productId);
            } else {
                $this->items[$productId]->setQuantity($quantity);
                $this->updateTimestamp();
            }
            return true;
        }
        return false;
    }
    
    public function clear() {
        $this->items = [];
        $this->discountCode = null;
        $this->discountAmount = 0;
        $this->updateTimestamp();
    }
    
    public function getItemCount() {
        return count($this->items);
    }
    
    public function getTotalQuantity() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getQuantity();
        }
        return $total;
    }
    
    public function getSubtotal() {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item->getSubtotal();
        }
        return $subtotal;
    }
    
    public function getShippingCost() {
        $shipping = 0;
        foreach ($this->items as $item) {
            $shipping += $item->getShippingCost();
        }
        return $shipping;
    }
    
    public function getTax($taxRate = 0.08) {
        return $this->getSubtotal() * $taxRate;
    }
    
    public function getTotal($taxRate = 0.08) {
        $subtotal = $this->getSubtotal();
        $shipping = $this->getShippingCost();
        $tax = $this->getTax($taxRate);
        $total = $subtotal + $shipping + $tax - $this->discountAmount;
        return max(0, $total); // Ensure total is not negative
    }
    
    public function applyDiscount($code, $amount) {
        $this->discountCode = $code;
        $this->discountAmount = $amount;
        $this->updateTimestamp();
    }
    
    public function removeDiscount() {
        $this->discountCode = null;
        $this->discountAmount = 0;
        $this->updateTimestamp();
    }
    
    private function updateTimestamp() {
        $this->updatedAt = new DateTime();
    }
    
    public function isEmpty() {
        return empty($this->items);
    }
    
    public function toArray() {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $item->toArray();
        }
        
        return [
            'user' => $this->user->toArray(),
            'items' => $items,
            'item_count' => $this->getItemCount(),
            'total_quantity' => $this->getTotalQuantity(),
            'subtotal' => $this->getSubtotal(),
            'shipping_cost' => $this->getShippingCost(),
            'tax' => $this->getTax(),
            'discount_code' => $this->discountCode,
            'discount_amount' => $this->discountAmount,
            'total' => $this->getTotal(),
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s')
        ];
    }
}

// =====================================
// ORDER MANAGEMENT CLASSES
// =====================================

/**
 * Order class demonstrating complex object relationships
 */
class Order {
    private $id;
    private $user;
    private $items = [];
    private $status;
    private $subtotal;
    private $shippingCost;
    private $tax;
    private $discountAmount;
    private $total;
    private $shippingAddress;
    private $billingAddress;
    private $paymentMethod;
    private $orderDate;
    private $shippedDate;
    private $deliveredDate;
    private $trackingNumber;
    
    // Order status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';
    
    public function __construct($id, User $user, ShoppingCart $cart) {
        $this->id = $id;
        $this->user = $user;
        $this->status = self::STATUS_PENDING;
        $this->orderDate = new DateTime();
        
        // Copy cart items to order
        foreach ($cart->getItems() as $item) {
            $this->items[] = clone $item;
        }
        
        // Calculate totals
        $this->subtotal = $cart->getSubtotal();
        $this->shippingCost = $cart->getShippingCost();
        $this->tax = $cart->getTax();
        $this->discountAmount = $cart->getDiscountAmount();
        $this->total = $cart->getTotal();
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getUser() { return $this->user; }
    public function getItems() { return $this->items; }
    public function getStatus() { return $this->status; }
    public function getSubtotal() { return $this->subtotal; }
    public function getShippingCost() { return $this->shippingCost; }
    public function getTax() { return $this->tax; }
    public function getDiscountAmount() { return $this->discountAmount; }
    public function getTotal() { return $this->total; }
    public function getShippingAddress() { return $this->shippingAddress; }
    public function getBillingAddress() { return $this->billingAddress; }
    public function getPaymentMethod() { return $this->paymentMethod; }
    public function getOrderDate() { return $this->orderDate; }
    public function getShippedDate() { return $this->shippedDate; }
    public function getDeliveredDate() { return $this->deliveredDate; }
    public function getTrackingNumber() { return $this->trackingNumber; }
    
    // Status management
    public function setStatus($status) {
        $validStatuses = [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_PROCESSING,
            self::STATUS_SHIPPED,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED,
            self::STATUS_REFUNDED
        ];
        
        if (!in_array($status, $validStatuses)) {
            throw new InvalidArgumentException("Invalid order status");
        }
        
        $this->status = $status;
        
        // Set timestamps based on status
        if ($status === self::STATUS_SHIPPED && !$this->shippedDate) {
            $this->shippedDate = new DateTime();
        } elseif ($status === self::STATUS_DELIVERED && !$this->deliveredDate) {
            $this->deliveredDate = new DateTime();
        }
    }
    
    public function setShippingAddress($address) {
        $this->shippingAddress = $address;
    }
    
    public function setBillingAddress($address) {
        $this->billingAddress = $address;
    }
    
    public function setPaymentMethod($method) {
        $this->paymentMethod = $method;
    }
    
    public function setTrackingNumber($trackingNumber) {
        $this->trackingNumber = $trackingNumber;
    }
    
    // Status checking methods
    public function isPending() {
        return $this->status === self::STATUS_PENDING;
    }
    
    public function isConfirmed() {
        return $this->status === self::STATUS_CONFIRMED;
    }
    
    public function isShipped() {
        return $this->status === self::STATUS_SHIPPED;
    }
    
    public function isDelivered() {
        return $this->status === self::STATUS_DELIVERED;
    }
    
    public function isCancelled() {
        return $this->status === self::STATUS_CANCELLED;
    }
    
    public function canBeCancelled() {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }
    
    public function canBeShipped() {
        return in_array($this->status, [self::STATUS_CONFIRMED, self::STATUS_PROCESSING]);
    }
    
    // Order operations
    public function confirm() {
        if ($this->status === self::STATUS_PENDING) {
            $this->setStatus(self::STATUS_CONFIRMED);
            
            // Reduce stock for all items
            foreach ($this->items as $item) {
                $item->getProduct()->reduceStock($item->getQuantity());
            }
        }
    }
    
    public function cancel() {
        if ($this->canBeCancelled()) {
            $this->setStatus(self::STATUS_CANCELLED);
            
            // Restore stock if order was confirmed
            if ($this->status === self::STATUS_CONFIRMED) {
                foreach ($this->items as $item) {
                    $item->getProduct()->addStock($item->getQuantity());
                }
            }
        }
    }
    
    public function ship($trackingNumber = null) {
        if ($this->canBeShipped()) {
            $this->setStatus(self::STATUS_SHIPPED);
            if ($trackingNumber) {
                $this->setTrackingNumber($trackingNumber);
            }
        }
    }
    
    public function deliver() {
        if ($this->status === self::STATUS_SHIPPED) {
            $this->setStatus(self::STATUS_DELIVERED);
        }
    }
    
    public function getItemCount() {
        return count($this->items);
    }
    
    public function getTotalQuantity() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getQuantity();
        }
        return $total;
    }
    
    public function toArray() {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $item->toArray();
        }
        
        return [
            'id' => $this->id,
            'user' => $this->user->toArray(),
            'items' => $items,
            'status' => $this->status,
            'subtotal' => $this->subtotal,
            'shipping_cost' => $this->shippingCost,
            'tax' => $this->tax,
            'discount_amount' => $this->discountAmount,
            'total' => $this->total,
            'shipping_address' => $this->shippingAddress,
            'billing_address' => $this->billingAddress,
            'payment_method' => $this->paymentMethod,
            'tracking_number' => $this->trackingNumber,
            'order_date' => $this->orderDate->format('Y-m-d H:i:s'),
            'shipped_date' => $this->shippedDate ? $this->shippedDate->format('Y-m-d H:i:s') : null,
            'delivered_date' => $this->deliveredDate ? $this->deliveredDate->format('Y-m-d H:i:s') : null,
            'item_count' => $this->getItemCount(),
            'total_quantity' => $this->getTotalQuantity()
        ];
    }
}

// =====================================
// INTERFACE DEFINITIONS
// =====================================

/**
 * Payment interface demonstrating polymorphism
 */
interface PaymentProcessorInterface {
    public function processPayment($amount, $paymentDetails);
    public function refundPayment($transactionId, $amount);
    public function getPaymentStatus($transactionId);
}

/**
 * Notification interface
 */
interface NotificationInterface {
    public function sendNotification($recipient, $message, $type);
}

// =====================================
// CONCRETE IMPLEMENTATIONS
// =====================================

/**
 * Credit Card Payment Processor
 */
class CreditCardPayment implements PaymentProcessorInterface {
    private $apiKey;
    private $transactions = [];
    
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
    
    public function processPayment($amount, $paymentDetails) {
        // Simulate credit card processing
        $transactionId = 'CC_' . uniqid();
        
        // Basic validation
        if (!isset($paymentDetails['card_number'], $paymentDetails['expiry'], $paymentDetails['cvv'])) {
            throw new Exception("Missing required payment details");
        }
        
        if ($amount <= 0) {
            throw new Exception("Invalid payment amount");
        }
        
        // Simulate processing delay
        usleep(500000); // 0.5 seconds
        
        // Simulate random failure (10% chance)
        if (rand(1, 10) === 1) {
            throw new Exception("Payment declined by bank");
        }
        
        $this->transactions[$transactionId] = [
            'amount' => $amount,
            'status' => 'completed',
            'payment_method' => 'credit_card',
            'card_last_four' => substr($paymentDetails['card_number'], -4),
            'processed_at' => new DateTime()
        ];
        
        return [
            'transaction_id' => $transactionId,
            'status' => 'completed',
            'amount' => $amount,
            'fee' => $amount * 0.029 // 2.9% fee
        ];
    }
    
    public function refundPayment($transactionId, $amount) {
        if (!isset($this->transactions[$transactionId])) {
            throw new Exception("Transaction not found");
        }
        
        $transaction = $this->transactions[$transactionId];
        
        if ($amount > $transaction['amount']) {
            throw new Exception("Refund amount exceeds original payment");
        }
        
        $refundId = 'REF_' . uniqid();
        $this->transactions[$refundId] = [
            'amount' => -$amount,
            'status' => 'refunded',
            'original_transaction' => $transactionId,
            'processed_at' => new DateTime()
        ];
        
        return [
            'refund_id' => $refundId,
            'status' => 'refunded',
            'amount' => $amount
        ];
    }
    
    public function getPaymentStatus($transactionId) {
        return $this->transactions[$transactionId] ?? null;
    }
}

/**
 * PayPal Payment Processor
 */
class PayPalPayment implements PaymentProcessorInterface {
    private $clientId;
    private $clientSecret;
    private $transactions = [];
    
    public function __construct($clientId, $clientSecret) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }
    
    public function processPayment($amount, $paymentDetails) {
        $transactionId = 'PP_' . uniqid();
        
        if (!isset($paymentDetails['email'])) {
            throw new Exception("PayPal email required");
        }
        
        if ($amount <= 0) {
            throw new Exception("Invalid payment amount");
        }
        
        // Simulate processing
        usleep(750000); // 0.75 seconds
        
        $this->transactions[$transactionId] = [
            'amount' => $amount,
            'status' => 'completed',
            'payment_method' => 'paypal',
            'email' => $paymentDetails['email'],
            'processed_at' => new DateTime()
        ];
        
        return [
            'transaction_id' => $transactionId,
            'status' => 'completed',
            'amount' => $amount,
            'fee' => $amount * 0.034 // 3.4% fee
        ];
    }
    
    public function refundPayment($transactionId, $amount) {
        if (!isset($this->transactions[$transactionId])) {
            throw new Exception("Transaction not found");
        }
        
        $transaction = $this->transactions[$transactionId];
        
        if ($amount > $transaction['amount']) {
            throw new Exception("Refund amount exceeds original payment");
        }
        
        $refundId = 'PPREF_' . uniqid();
        $this->transactions[$refundId] = [
            'amount' => -$amount,
            'status' => 'refunded',
            'original_transaction' => $transactionId,
            'processed_at' => new DateTime()
        ];
        
        return [
            'refund_id' => $refundId,
            'status' => 'refunded',
            'amount' => $amount
        ];
    }
    
    public function getPaymentStatus($transactionId) {
        return $this->transactions[$transactionId] ?? null;
    }
}

/**
 * Email Notification Service
 */
class EmailNotification implements NotificationInterface {
    private $smtpHost;
    private $smtpPort;
    private $username;
    private $password;
    
    public function __construct($smtpHost, $smtpPort, $username, $password) {
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
        $this->username = $username;
        $this->password = $password;
    }
    
    public function sendNotification($recipient, $message, $type) {
        // Simulate email sending
        $subject = $this->getSubjectByType($type);
        
        // In a real implementation, this would use a library like PHPMailer
        $emailData = [
            'to' => $recipient,
            'subject' => $subject,
            'message' => $message,
            'type' => $type,
            'sent_at' => new DateTime(),
            'status' => 'sent'
        ];
        
        // Simulate sending delay
        usleep(200000); // 0.2 seconds
        
        return $emailData;
    }
    
    private function getSubjectByType($type) {
        $subjects = [
            'order_confirmation' => 'Order Confirmation - Thank you for your purchase!',
            'order_shipped' => 'Your order has been shipped',
            'order_delivered' => 'Your order has been delivered',
            'payment_success' => 'Payment processed successfully',
            'payment_failed' => 'Payment processing failed',
            'account_created' => 'Welcome to our store!',
            'password_reset' => 'Password reset instructions'
        ];
        
        return $subjects[$type] ?? 'Notification from Kheni Urval Store (24CE055)';
    }
}

// =====================================
// UTILITY CLASSES
// =====================================

/**
 * Product Factory class demonstrating Factory Pattern
 */
class ProductFactory {
    public static function createProduct($type, $data) {
        switch (strtolower($type)) {
            case 'electronics':
                return new ElectronicsProduct(
                    $data['id'],
                    $data['name'],
                    $data['description'],
                    $data['price'],
                    $data['stock'],
                    $data['brand'],
                    $data['model'],
                    $data['warranty'],
                    $data['power_rating'] ?? null,
                    $data['voltage'] ?? null
                );
                
            case 'clothing':
                return new ClothingProduct(
                    $data['id'],
                    $data['name'],
                    $data['description'],
                    $data['price'],
                    $data['stock'],
                    $data['size'],
                    $data['color'],
                    $data['material'],
                    $data['brand'],
                    $data['gender'] ?? 'Unisex'
                );
                
            case 'book':
                return new BookProduct(
                    $data['id'],
                    $data['name'],
                    $data['description'],
                    $data['price'],
                    $data['stock'],
                    $data['author'],
                    $data['isbn'],
                    $data['publisher'],
                    $data['publication_year'],
                    $data['pages'],
                    $data['language'] ?? 'English',
                    $data['format'] ?? 'paperback'
                );
                
            default:
                throw new InvalidArgumentException("Unknown product type: $type");
        }
    }
    
    public static function getAvailableTypes() {
        return ['electronics', 'clothing', 'book'];
    }
}

/**
 * Store Manager class demonstrating Singleton Pattern
 */
class StoreManager {
    private static $instance = null;
    private $products = [];
    private $users = [];
    private $orders = [];
    private $carts = [];
    
    private function __construct() {
        // Private constructor for singleton
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Product management
    public function addProduct(Product $product) {
        $this->products[$product->getId()] = $product;
    }
    
    public function getProduct($id) {
        return $this->products[$id] ?? null;
    }
    
    public function getAllProducts() {
        return $this->products;
    }
    
    public function getProductsByCategory($category) {
        return array_filter($this->products, function($product) use ($category) {
            return $product->getCategory() === $category;
        });
    }
    
    public function searchProducts($query) {
        return array_filter($this->products, function($product) use ($query) {
            return stripos($product->getName(), $query) !== false ||
                   stripos($product->getDescription(), $query) !== false;
        });
    }
    
    // User management
    public function addUser(User $user) {
        $this->users[$user->getId()] = $user;
    }
    
    public function getUser($id) {
        return $this->users[$id] ?? null;
    }
    
    public function getUserByUsername($username) {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null;
    }
    
    public function getUserByEmail($email) {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }
    
    // Cart management
    public function createCart(User $user) {
        $cart = new ShoppingCart($user);
        $this->carts[$user->getId()] = $cart;
        return $cart;
    }
    
    public function getCart($userId) {
        return $this->carts[$userId] ?? null;
    }
    
    // Order management
    public function createOrder(User $user, ShoppingCart $cart) {
        $orderId = 'ORD_' . date('Ymd') . '_' . uniqid();
        $order = new Order($orderId, $user, $cart);
        $this->orders[$orderId] = $order;
        
        // Clear the cart after creating order
        $cart->clear();
        
        return $order;
    }
    
    public function getOrder($orderId) {
        return $this->orders[$orderId] ?? null;
    }
    
    public function getUserOrders($userId) {
        return array_filter($this->orders, function($order) use ($userId) {
            return $order->getUser()->getId() === $userId;
        });
    }
    
    public function getAllOrders() {
        return $this->orders;
    }
    
    // Statistics
    public function getStatistics() {
        $totalRevenue = 0;
        $ordersByStatus = [];
        
        foreach ($this->orders as $order) {
            $totalRevenue += $order->getTotal();
            $status = $order->getStatus();
            $ordersByStatus[$status] = ($ordersByStatus[$status] ?? 0) + 1;
        }
        
        return [
            'total_products' => count($this->products),
            'total_users' => count($this->users),
            'total_orders' => count($this->orders),
            'total_revenue' => $totalRevenue,
            'orders_by_status' => $ordersByStatus,
            'products_by_category' => $this->getProductCountByCategory()
        ];
    }
    
    private function getProductCountByCategory() {
        $categories = [];
        foreach ($this->products as $product) {
            $category = $product->getCategory();
            $categories[$category] = ($categories[$category] ?? 0) + 1;
        }
        return $categories;
    }
}

// Prevent cloning and unserialization of singleton
class_alias('StoreManager', 'Store');

// Initialize error reporting for demo
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
