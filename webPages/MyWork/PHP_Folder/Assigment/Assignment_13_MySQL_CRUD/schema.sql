-- Assignment 13: MySQL CRUD Operations - Database Schema
-- Student: Kheni Urval (24CE055)
-- Course: WDF: ITUE203

-- HOW TO RUN:
-- 1. Open phpMyAdmin or MySQL command line
-- 2. Drop the old database: DROP DATABASE IF EXISTS student_management;
-- 3. Run this entire file to create fresh database with correct structure

-- Create database
CREATE DATABASE IF NOT EXISTS student_management;
USE student_management;

-- Create students table
CREATE TABLE IF NOT EXISTS students (
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

-- Insert sample data
INSERT INTO students (student_id, name, email, course, semester, gpa, status) VALUES
('24CE055', 'Kheni Urval', 'kheni.urval@example.com', 'Computer Engineering', '5', 3.85, 'Active'),
('24IT012', 'Disu Makadiya', 'disu.makadiya@example.com', 'Information Technology', '5', 3.92, 'Active'),
('24EC034', 'Krish Patel', 'krish.patel@example.com', 'Electronics Engineering', '6', 3.67, 'Active'),
('24ME067', 'Heet Mehta', 'heet.mehta@example.com', 'Mechanical Engineering', '4', 3.45, 'Inactive'),
('24CV089', 'Pushti Kansara', 'pushti.kansara@example.com', 'Civil Engineering', '8', 3.78, 'Graduated');

-- Create index for better performance
CREATE INDEX idx_students_student_id ON students(student_id);
CREATE INDEX idx_students_email ON students(email);
CREATE INDEX idx_students_course ON students(course);
CREATE INDEX idx_students_status ON students(status);