<?php
/**
 * Assignment 12: PHP OOP - DigitalProduct Class
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * DigitalProduct class demonstrating inheritance and method override
 */

require_once 'Product.php';

class DigitalProduct extends Product {
    private $fileSize;
    private $downloadLink;
    
    public function __construct($name, $price, $description, $fileSize = 0, $downloadLink = '') {
        // Call parent constructor with no shipping cost for digital products
        parent::__construct($name, $price, $description, 0.00);
        $this->setFileSize($fileSize);
        $this->setDownloadLink($downloadLink);
    }
    
    // Additional getters for digital product properties
    public function getFileSize() {
        return $this->fileSize;
    }
    
    public function getDownloadLink() {
        return $this->downloadLink;
    }
    
    // Additional setters
    public function setFileSize($size) {
        if ($size < 0) {
            throw new InvalidArgumentException("File size cannot be negative");
        }
        $this->fileSize = (float)$size;
    }
    
    public function setDownloadLink($link) {
        $this->downloadLink = $link;
    }
    
    // Override getFinalPrice method (no shipping for digital products)
    public function getFinalPrice($taxRate = 0.0, $discountPercent = 0.0) {
        // Digital products have no shipping cost
        $subtotal = $this->getPrice(); // Only the product price
        $discount = $subtotal * ($discountPercent / 100);
        $afterDiscount = $subtotal - $discount;
        $tax = $afterDiscount * ($taxRate / 100);
        
        return $afterDiscount + $tax;
    }
    
    // Override displayInfo method to include digital-specific information
    public function displayInfo() {
        $info = parent::displayInfo();
        $info .= "Type: Digital Product\n" .
                "File Size: " . number_format($this->fileSize, 2) . " MB\n" .
                "Download Link: " . ($this->downloadLink ?: 'Will be provided after purchase') . "\n" .
                "Shipping: FREE (Digital Delivery)\n";
        
        return $info;
    }
    
    // Digital-specific method
    public function generateDownloadLink() {
        if (empty($this->downloadLink)) {
            $this->downloadLink = "https://downloads.example.com/" . 
                                 strtolower(str_replace(' ', '-', $this->getName())) . 
                                 '-' . uniqid();
        }
        return $this->downloadLink;
    }
}
?>
