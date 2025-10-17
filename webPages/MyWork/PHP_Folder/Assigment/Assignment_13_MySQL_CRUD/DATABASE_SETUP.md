# Assignment 13 - Database Setup Guide

**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203

## 🗄️ Database Files

### 1. **reset_database.sql** ⭐ (USE THIS ONE)
Complete database reset with sample data. This will:
- Drop the old database completely
- Create fresh database structure
- Insert 10 sample students
- Add all necessary indexes

### 2. **schema.sql**
Original schema file (backup/reference)

---

## 📋 Step-by-Step Instructions

### **Option 1: Using phpMyAdmin (Recommended)**

1. **Open phpMyAdmin**
   - URL: http://localhost/phpmyadmin
   - Login with your credentials (usually `root` with no password)

2. **Execute Reset Script**
   - Click on **"SQL"** tab at the top
   - Open `reset_database.sql` file
   - Copy **ALL** the content (Ctrl+A, Ctrl+C)
   - Paste into the SQL query box
   - Click **"Go"** button

3. **Verify Database**
   - Look for "student_management" in the left sidebar
   - Click on it to see the "students" table
   - Click on "students" to see 10 sample records

4. **Refresh Your Application**
   - Go to: http://localhost:8000/Assignment_13_MySQL_CRUD/
   - You should see:
     - ✅ Statistics cards showing counts
     - ✅ 10 student records in the table
     - ✅ No console errors

### **Option 2: Using MySQL Command Line**

```bash
# Navigate to Assignment 13 folder
cd "d:\Sigma Web Devlopment\webPages\MyWork\PHP_Folder\Assigment\Assignment_13_MySQL_CRUD"

# Execute the reset script
mysql -u root -p < reset_database.sql

# Press Enter (no password if default)
```

---

## 🎯 What's Included in Sample Data

After running `reset_database.sql`, you'll have 10 students:

| Student ID | Name | Course | Semester | GPA | Status |
|------------|------|--------|----------|-----|--------|
| 24CE055 | Kheni Urval | Computer Engineering | 5 | 3.85 | Active |
| 24IT012 | Disu Makadiya | Information Technology | 5 | 3.92 | Active |
| 24EC034 | Krish Patel | Electronics Engineering | 6 | 3.67 | Active |
| 24ME067 | Heet Mehta | Mechanical Engineering | 4 | 3.45 | Inactive |
| 24CV089 | Pushti Kansara | Civil Engineering | 8 | 3.78 | Graduated |
| 24CS101 | Raj Shah | Computer Science | 3 | 3.55 | Active |
| 24IT098 | Priya Patel | Information Technology | 7 | 3.88 | Active |
| 24EC045 | Amit Kumar | Electronics Engineering | 2 | 3.22 | Active |
| 24ME078 | Sneha Desai | Mechanical Engineering | 6 | 3.71 | Active |
| 24CV023 | Vikram Singh | Civil Engineering | 8 | 3.95 | Graduated |

---

## ✅ Expected Results

After running the reset script, your dashboard should show:

📊 **Statistics:**
- **Total Students:** 10
- **Active Students:** 7
- **Graduated:** 2
- **Inactive:** 1

🎓 **Courses Available:**
- Computer Engineering
- Computer Science
- Information Technology
- Electronics Engineering
- Mechanical Engineering
- Civil Engineering

---

## 🔧 Troubleshooting

### Problem: "Database connection failed"
**Solution:** Check `operations.php` line 9-12 for correct credentials:
```php
$host = 'localhost';
$username = 'root';
$password = '';  // Change if you have a password
$database = 'student_management';
```

### Problem: "Table doesn't exist"
**Solution:** Re-run `reset_database.sql` completely

### Problem: "Duplicate entry error"
**Solution:** The database wasn't properly dropped. Run this first:
```sql
DROP DATABASE IF EXISTS student_management;
```

---

## 📝 Notes

- **All data will be deleted** when you run `reset_database.sql`
- This is normal and expected for testing
- You can run it multiple times to reset to fresh state
- Sample data helps test all CRUD operations

---

## 🚀 Quick Test Checklist

After database reset:
- [ ] Dashboard loads without errors
- [ ] Statistics show correct counts (10, 7, 2, 1)
- [ ] Student table shows 10 records
- [ ] Search functionality works
- [ ] Filter by status works
- [ ] Filter by course works
- [ ] Can add new student
- [ ] Can edit existing student
- [ ] Can delete student
- [ ] Export CSV works

---

**Last Updated:** October 17, 2025  
**Status:** Ready to Use ✅
