<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - MySQL CRUD | Kheni Urval (24CE055)</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --border-radius: 8px;
            --box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: var(--box-shadow);
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        .student-badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            margin-left: 1rem;
        }

        .main-container {
            padding: 2rem 0;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-success {
            background: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-danger {
            background: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-warning {
            background: var(--warning-color);
            border-color: var(--warning-color);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            padding: 1rem 0.75rem;
            border-bottom: 2px solid #dee2e6;
        }

        .table td {
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active { background-color: #d4edda; color: #155724; }
        .status-inactive { background-color: #f8d7da; color: #721c24; }
        .status-graduated { background-color: #d1ecf1; color: #0c5460; }
        .status-suspended { background-color: #fff3cd; color: #856404; }

        .gpa-high { color: var(--success-color); font-weight: 600; }
        .gpa-medium { color: var(--warning-color); font-weight: 600; }
        .gpa-low { color: var(--danger-color); font-weight: 600; }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .alert {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .pagination .page-link {
            color: var(--secondary-color);
            border-color: #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .search-section {
            background: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        .stats-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            color: white;
            margin-bottom: 1rem;
        }

        .stats-card h3 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .stats-card p {
            margin: 0;
            font-size: 1rem;
            opacity: 0.9;
        }

        .stats-total { background: linear-gradient(135deg, #3498db, #2980b9); }
        .stats-active { background: linear-gradient(135deg, #27ae60, #229954); }
        .stats-graduated { background: linear-gradient(135deg, #8e44ad, #7d3c98); }
        .stats-inactive { background: linear-gradient(135deg, #e74c3c, #c0392b); }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-buttons .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .loading {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .loading i {
            font-size: 2rem;
            margin-bottom: 1rem;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .no-data i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 3rem;
        }

        .bulk-actions {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            display: none;
        }

        .bulk-actions.show {
            display: block;
        }

        .form-check-input:checked {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                margin-bottom: 0.25rem;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .search-section {
                padding: 1rem;
            }
            
            .stats-card h3 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                Student Management System
            </a>
            <span class="student-badge">
                <i class="fas fa-user-graduate me-1"></i>
                Kheni Urval (24CE055)
            </span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container main-container">
        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Statistics Cards -->
        <div class="row mb-4" id="statsContainer">
            <div class="col-md-3 col-sm-6">
                <div class="stats-card stats-total">
                    <h3 id="totalStudents">0</h3>
                    <p><i class="fas fa-users me-1"></i>Total Students</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card stats-active">
                    <h3 id="activeStudents">0</h3>
                    <p><i class="fas fa-user-check me-1"></i>Active Students</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card stats-graduated">
                    <h3 id="graduatedStudents">0</h3>
                    <p><i class="fas fa-user-graduate me-1"></i>Graduated</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card stats-inactive">
                    <h3 id="inactiveStudents">0</h3>
                    <p><i class="fas fa-user-times me-1"></i>Inactive</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-section">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="searchInput" class="form-label">
                        <i class="fas fa-search me-1"></i>Search Students
                    </label>
                    <input type="text" class="form-control" id="searchInput" 
                           placeholder="Search by name, email, or student ID...">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="statusFilter" class="form-label">
                        <i class="fas fa-filter me-1"></i>Filter by Status
                    </label>
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="courseFilter" class="form-label">
                        <i class="fas fa-book me-1"></i>Filter by Course
                    </label>
                    <select class="form-select" id="courseFilter">
                        <option value="">All Courses</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                        <i class="fas fa-times me-1"></i>Clear
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-table me-2"></i>Student Records</h4>
                <div>
                    <button type="button" class="btn btn-success me-2" onclick="showAddModal()">
                        <i class="fas fa-plus me-1"></i>Add Student
                    </button>
                    <button type="button" class="btn btn-info me-2" onclick="exportCSV()">
                        <i class="fas fa-download me-1"></i>Export CSV
                    </button>
                    <button type="button" class="btn btn-primary" onclick="loadStudents()">
                        <i class="fas fa-refresh me-1"></i>Refresh
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Bulk Actions -->
                <div id="bulkActions" class="bulk-actions">
                    <div class="d-flex justify-content-between align-items-center">
                        <span id="selectedCount">0 students selected</span>
                        <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                            <i class="fas fa-trash me-1"></i>Delete Selected
                        </button>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Semester</th>
                                <th>GPA</th>
                                <th>Status</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody">
                            <!-- Dynamic content will be loaded here -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3">
                    <div id="recordsInfo">
                        Showing 0 of 0 records
                    </div>
                    <nav aria-label="Students pagination">
                        <ul class="pagination mb-0" id="pagination">
                            <!-- Dynamic pagination will be loaded here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Student Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Add New Student
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="studentForm">
                        <input type="hidden" id="studentId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="student_id" class="form-label">Student ID *</label>
                                <input type="text" class="form-control" id="student_id" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="course" class="form-label">Course *</label>
                                <input type="text" class="form-control" id="course" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" id="semester">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gpa" class="form-label">GPA</label>
                                <input type="number" class="form-control" id="gpa" min="0" max="4" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="graduated">Graduated</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="saveStudent()">
                        <i class="fas fa-save me-1"></i>Save Student
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Student Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">
                        <i class="fas fa-eye me-2"></i>Student Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="studentDetails">
                    <!-- Student details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">
                <strong>Assignment 13: MySQL CRUD Operations</strong> | 
                Student: Kheni Urval (24CE055) | 
                Course: WDF: ITUE203 | 
                &copy; 2024
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables
        let currentPage = 1;
        let totalPages = 1;
        let selectedStudents = new Set();
        let studentModal;
        let viewModal;

        // Initialize application
        document.addEventListener('DOMContentLoaded', function() {
            studentModal = new bootstrap.Modal(document.getElementById('studentModal'));
            viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            
            loadStudents();
            loadStatistics();
            loadCourses();
            setupEventListeners();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Search input with debounce
            let searchTimeout;
            document.getElementById('searchInput').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    loadStudents();
                }, 500);
            });

            // Filter dropdowns
            document.getElementById('statusFilter').addEventListener('change', function() {
                currentPage = 1;
                loadStudents();
            });

            document.getElementById('courseFilter').addEventListener('change', function() {
                currentPage = 1;
                loadStudents();
            });

            // Select all checkbox
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('input[name="student_checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    if (this.checked) {
                        selectedStudents.add(parseInt(checkbox.value));
                    } else {
                        selectedStudents.delete(parseInt(checkbox.value));
                    }
                });
                updateBulkActions();
            });
        }

        // Load students with pagination
        async function loadStudents() {
            showLoading();
            
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const course = document.getElementById('courseFilter').value;
            
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=read&page=${currentPage}&search=${encodeURIComponent(search)}&status=${status}&course=${encodeURIComponent(course)}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    displayStudents(data.data);
                    updatePagination(data.pagination);
                    updateRecordsInfo(data.pagination);
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Failed to load students: ' + error.message);
            }
        }

        // Display students in table
        function displayStudents(students) {
            const tbody = document.getElementById('studentsTableBody');
            
            if (students.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="no-data">
                            <i class="fas fa-users"></i>
                            <h5>No students found</h5>
                            <p>Try adjusting your search criteria or add new students.</p>
                        </td>
                    </tr>
                `;
                return;
            }
            
            tbody.innerHTML = students.map(student => `
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input" name="student_checkbox" 
                               value="${student.id}" onchange="updateSelectedStudents(this)">
                    </td>
                    <td><strong>${student.student_id}</strong></td>
                    <td>${student.first_name} ${student.last_name}</td>
                    <td>${student.email}</td>
                    <td><small>${student.course}</small></td>
                    <td><span class="badge bg-secondary">${student.semester}</span></td>
                    <td>${formatGPA(student.gpa)}</td>
                    <td>${formatStatus(student.status)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-info btn-sm" onclick="viewStudent(${student.id})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="editStudent(${student.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteStudent(${student.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Format GPA display
        function formatGPA(gpa) {
            if (!gpa) return '<span class="text-muted">N/A</span>';
            
            const gpaValue = parseFloat(gpa);
            let className = 'gpa-medium';
            
            if (gpaValue >= 3.5) className = 'gpa-high';
            else if (gpaValue < 2.5) className = 'gpa-low';
            
            return `<span class="${className}">${gpaValue.toFixed(2)}</span>`;
        }

        // Format status display
        function formatStatus(status) {
            return `<span class="status-badge status-${status}">${status}</span>`;
        }

        // Update pagination
        function updatePagination(pagination) {
            totalPages = pagination.total_pages;
            const paginationEl = document.getElementById('pagination');
            
            let paginationHTML = '';
            
            // Previous button
            if (pagination.has_prev) {
                paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                `;
            }
            
            // Page numbers
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, currentPage + 2);
            
            if (startPage > 1) {
                paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(1)">1</a></li>`;
                if (startPage > 2) {
                    paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }
            
            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
            }
            
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
            }
            
            // Next button
            if (pagination.has_next) {
                paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                `;
            }
            
            paginationEl.innerHTML = paginationHTML;
        }

        // Update records info
        function updateRecordsInfo(pagination) {
            const start = ((currentPage - 1) * pagination.per_page) + 1;
            const end = Math.min(currentPage * pagination.per_page, pagination.total_records);
            
            document.getElementById('recordsInfo').textContent = 
                `Showing ${start}-${end} of ${pagination.total_records} records`;
        }

        // Change page
        function changePage(page) {
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                loadStudents();
            }
        }

        // Load statistics
        async function loadStatistics() {
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=statistics'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const stats = data.data;
                    document.getElementById('totalStudents').textContent = stats.total_students;
                    
                    // Update status counts
                    const statusCounts = {};
                    stats.by_status.forEach(item => {
                        statusCounts[item.status] = item.count;
                    });
                    
                    document.getElementById('activeStudents').textContent = statusCounts.active || 0;
                    document.getElementById('graduatedStudents').textContent = statusCounts.graduated || 0;
                    document.getElementById('inactiveStudents').textContent = statusCounts.inactive || 0;
                }
            } catch (error) {
                console.error('Failed to load statistics:', error);
            }
        }

        // Load courses for filter
        async function loadCourses() {
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=courses'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const courseFilter = document.getElementById('courseFilter');
                    courseFilter.innerHTML = '<option value="">All Courses</option>';
                    
                    data.data.forEach(course => {
                        courseFilter.innerHTML += `<option value="${course}">${course}</option>`;
                    });
                }
            } catch (error) {
                console.error('Failed to load courses:', error);
            }
        }

        // Show add student modal
        function showAddModal() {
            document.getElementById('studentModalLabel').innerHTML = '<i class="fas fa-user-plus me-2"></i>Add New Student';
            document.getElementById('studentForm').reset();
            document.getElementById('studentId').value = '';
            studentModal.show();
        }

        // Save student (create or update)
        async function saveStudent() {
            const form = document.getElementById('studentForm');
            const formData = new FormData(form);
            
            const studentData = {
                action: document.getElementById('studentId').value ? 'update' : 'create',
                id: document.getElementById('studentId').value,
                student_id: document.getElementById('student_id').value,
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                date_of_birth: document.getElementById('date_of_birth').value,
                course: document.getElementById('course').value,
                semester: document.getElementById('semester').value,
                gpa: document.getElementById('gpa').value,
                status: document.getElementById('status').value
            };
            
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: Object.keys(studentData).map(key => 
                        `${encodeURIComponent(key)}=${encodeURIComponent(studentData[key])}`
                    ).join('&')
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', data.message);
                    studentModal.hide();
                    loadStudents();
                    loadStatistics();
                    loadCourses();
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Failed to save student: ' + error.message);
            }
        }

        // View student details
        async function viewStudent(id) {
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=view&id=${id}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const student = data.data;
                    document.getElementById('studentDetails').innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Student ID:</strong> ${student.student_id}</p>
                                <p><strong>Name:</strong> ${student.first_name} ${student.last_name}</p>
                                <p><strong>Email:</strong> ${student.email}</p>
                                <p><strong>Phone:</strong> ${student.phone || 'N/A'}</p>
                                <p><strong>Date of Birth:</strong> ${student.date_of_birth || 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Course:</strong> ${student.course}</p>
                                <p><strong>Semester:</strong> ${student.semester}</p>
                                <p><strong>GPA:</strong> ${formatGPA(student.gpa)}</p>
                                <p><strong>Status:</strong> ${formatStatus(student.status)}</p>
                                <p><strong>Enrollment Date:</strong> ${new Date(student.enrollment_date).toLocaleDateString()}</p>
                            </div>
                        </div>
                    `;
                    viewModal.show();
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Failed to load student details: ' + error.message);
            }
        }

        // Edit student
        async function editStudent(id) {
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=view&id=${id}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const student = data.data;
                    
                    document.getElementById('studentModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Student';
                    document.getElementById('studentId').value = student.id;
                    document.getElementById('student_id').value = student.student_id;
                    document.getElementById('first_name').value = student.first_name;
                    document.getElementById('last_name').value = student.last_name;
                    document.getElementById('email').value = student.email;
                    document.getElementById('phone').value = student.phone || '';
                    document.getElementById('date_of_birth').value = student.date_of_birth || '';
                    document.getElementById('course').value = student.course;
                    document.getElementById('semester').value = student.semester;
                    document.getElementById('gpa').value = student.gpa || '';
                    document.getElementById('status').value = student.status;
                    
                    studentModal.show();
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Failed to load student data: ' + error.message);
            }
        }

        // Delete student
        async function deleteStudent(id) {
            if (!confirm('Are you sure you want to delete this student? This action cannot be undone.')) {
                return;
            }
            
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=delete&id=${id}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', data.message);
                    loadStudents();
                    loadStatistics();
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Failed to delete student: ' + error.message);
            }
        }

        // Update selected students for bulk operations
        function updateSelectedStudents(checkbox) {
            const studentId = parseInt(checkbox.value);
            
            if (checkbox.checked) {
                selectedStudents.add(studentId);
            } else {
                selectedStudents.delete(studentId);
            }
            
            updateBulkActions();
            
            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('input[name="student_checkbox"]');
            const checkedCheckboxes = document.querySelectorAll('input[name="student_checkbox"]:checked');
            document.getElementById('selectAll').checked = allCheckboxes.length === checkedCheckboxes.length;
        }

        // Update bulk actions UI
        function updateBulkActions() {
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (selectedStudents.size > 0) {
                bulkActions.classList.add('show');
                selectedCount.textContent = `${selectedStudents.size} student${selectedStudents.size > 1 ? 's' : ''} selected`;
            } else {
                bulkActions.classList.remove('show');
            }
        }

        // Bulk delete selected students
        async function bulkDelete() {
            if (selectedStudents.size === 0) {
                showAlert('warning', 'No students selected');
                return;
            }
            
            if (!confirm(`Are you sure you want to delete ${selectedStudents.size} selected student(s)? This action cannot be undone.`)) {
                return;
            }
            
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=bulk_delete&ids=${Array.from(selectedStudents).join(',')}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', data.message);
                    selectedStudents.clear();
                    document.getElementById('selectAll').checked = false;
                    updateBulkActions();
                    loadStudents();
                    loadStatistics();
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Failed to delete students: ' + error.message);
            }
        }

        // Export to CSV
        async function exportCSV() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const course = document.getElementById('courseFilter').value;
            
            try {
                const response = await fetch('operations.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=export&search=${encodeURIComponent(search)}&status=${status}&course=${encodeURIComponent(course)}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Create and download CSV file
                    const blob = new Blob([data.data], { type: 'text/csv' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `students_export_${new Date().toISOString().split('T')[0]}.csv`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                    
                    showAlert('success', `Exported ${data.count} student records to CSV`);
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Failed to export data: ' + error.message);
            }
        }

        // Clear all filters
        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('courseFilter').value = '';
            currentPage = 1;
            loadStudents();
        }

        // Show loading state
        function showLoading() {
            document.getElementById('studentsTableBody').innerHTML = `
                <tr>
                    <td colspan="9" class="loading">
                        <i class="fas fa-spinner"></i>
                        <p>Loading students...</p>
                    </td>
                </tr>
            `;
        }

        // Show alert messages
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            const alertId = 'alert_' + Date.now();
            
            const alertHTML = `
                <div id="${alertId}" class="alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            alertContainer.innerHTML = alertHTML;
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                const alert = document.getElementById(alertId);
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    </script>
</body>
</html>
