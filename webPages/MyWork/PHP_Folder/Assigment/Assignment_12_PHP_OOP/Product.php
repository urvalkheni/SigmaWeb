<?php
/**
 * Assignment 12: PHP OOP - Product Class
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * Product class demonstrating encapsulation with getters/setters
 */

class Product {
    private $name;
    private $price;
    private $description;
    private $shippingCost;
    
    public function __construct($name, $price, $description, $shippingCost = 5.00) {
        $this->setName($name);
        $this->setPrice($price);
        $this->setDescription($description);
        $this->setShippingCost($shippingCost);
    }
    
    // Getters (Encapsulation)
    public function getName() {
        return $this->name;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getShippingCost() {
        return $this->shippingCost;
    }
    
    // Setters (Encapsulation with validation)
    public function setName($name) {
        if (empty($name)) {
            throw new InvalidArgumentException("Product name cannot be empty");
        }
        $this->name = $name;
    }
    
    public function setPrice($price) {
        if ($price < 0) {
            throw new InvalidArgumentException("Price cannot be negative");
        }
        $this->price = (float)$price;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function setShippingCost($cost) {
        if ($cost < 0) {
            throw new InvalidArgumentException("Shipping cost cannot be negative");
        }
        $this->shippingCost = (float)$cost;
    }
    
    // Method to calculate final price with tax and discount
    public function getFinalPrice($taxRate = 0.0, $discountPercent = 0.0) {
        $subtotal = $this->price + $this->shippingCost;
        $discount = $subtotal * ($discountPercent / 100);
        $afterDiscount = $subtotal - $discount;
        $tax = $afterDiscount * ($taxRate / 100);
        
        return $afterDiscount + $tax;
    }
    
    // Display product information
    public function displayInfo() {
        return "Product: {$this->name}\n" .
               "Description: {$this->description}\n" .
               "Price: $" . number_format($this->price, 2) . "\n" .
               "Shipping: $" . number_format($this->shippingCost, 2) . "\n";
    }
}
?>
