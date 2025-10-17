-- Assignment 13: MySQL CRUD Operations - Database Reset
-- Student: Kheni Urval (24CE055)
-- Course: WDF: ITUE203

-- ============================================
-- INSTRUCTIONS:
-- ============================================
-- 1. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Click on "SQL" tab at the top
-- 3. Copy and paste this ENTIRE file
-- 4. Click "Go" button to execute
-- 5. Refresh your Assignment 13 application
-- ============================================

-- Step 1: Drop the old database completely
DROP DATABASE IF EXISTS student_management;

-- Step 2: Create fresh database
CREATE DATABASE student_management;
USE student_management;

-- Step 3: Create students table with all required fields
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    semester VARCHAR(20),
    gpa DECIMAL(3,2),
    status ENUM('Active', 'Inactive', 'Graduated') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Step 4: Insert sample student data
INSERT INTO students (student_id, name, email, course, semester, gpa, status) VALUES
('24CE055', 'Kheni Urval', 'kheni.urval@example.com', 'Computer Engineering', '5', 3.85, 'Active'),
('24IT012', 'Disu Makadiya', 'disu.makadiya@example.com', 'Information Technology', '5', 3.92, 'Active'),
('24EC034', 'Krish Patel', 'krish.patel@example.com', 'Electronics Engineering', '6', 3.67, 'Active'),
('24ME067', 'Heet Mehta', 'heet.mehta@example.com', 'Mechanical Engineering', '4', 3.45, 'Inactive'),
('24CV089', 'Pushti Kansara', 'pushti.kansara@example.com', 'Civil Engineering', '8', 3.78, 'Graduated'),
('24CS101', 'Raj Shah', 'raj.shah@example.com', 'Computer Science', '3', 3.55, 'Active'),
('24IT098', 'Priya Patel', 'priya.patel@example.com', 'Information Technology', '7', 3.88, 'Active'),
('24EC045', 'Amit Kumar', 'amit.kumar@example.com', 'Electronics Engineering', '2', 3.22, 'Active'),
('24ME078', 'Sneha Desai', 'sneha.desai@example.com', 'Mechanical Engineering', '6', 3.71, 'Active'),
('24CV023', 'Vikram Singh', 'vikram.singh@example.com', 'Civil Engineering', '8', 3.95, 'Graduated');

-- Step 5: Create indexes for better performance
CREATE INDEX idx_students_student_id ON students(student_id);
CREATE INDEX idx_students_email ON students(email);
CREATE INDEX idx_students_course ON students(course);
CREATE INDEX idx_students_status ON students(status);

-- ============================================
-- DATABASE RESET COMPLETED!
-- ============================================
-- Your database now has:
-- - 10 sample students
-- - Proper table structure with all fields
-- - Indexes for fast queries
-- - Mixed statuses (Active, Inactive, Graduated)
-- ============================================
