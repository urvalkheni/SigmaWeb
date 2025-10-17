<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Guestbook - Kheni Urval (24CE055)</title>
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
            max-width: 1200px;
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

        .form-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
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
            transform: translateY(-1px);
        }

        .form-control.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
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

        .entry {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .entry:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .entry-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .entry-author {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .entry-date {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .entry-content {
            padding: 20px;
        }

        .entry-message {
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .entry-meta {
            display: flex;
            gap: 15px;
            font-size: 0.9rem;
            color: #6c757d;
            flex-wrap: wrap;
        }

        .entry-website {
            color: #667eea;
            text-decoration: none;
        }

        .entry-website:hover {
            text-decoration: underline;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .page-link {
            display: inline-block;
            padding: 10px 15px;
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .page-link:hover,
        .page-link.active {
            background: #667eea;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
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

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #667eea;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #e9ecef;
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

        .error-list {
            list-style: none;
            margin-top: 10px;
        }

        .error-list li {
            color: #dc3545;
            margin-bottom: 5px;
            position: relative;
            padding-left: 20px;
        }

        .error-list li::before {
            content: '⚠';
            position: absolute;
            left: 0;
            color: #dc3545;
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

            .entry-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        .admin-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📖 Digital Guestbook</h1>
            <p class="subtitle">Share your thoughts and memories</p>
            <div class="student-info">
                <strong>Assignment 11: PHP File I/O & CSV Operations</strong><br>
                Student: Kheni Urval (24CE055) | Course: WDF: ITUE203
            </div>
        </div>

        <div class="navigation">
            <ul class="nav-tabs">
                <li class="nav-tab active" onclick="showTab('guestbook')">📖 Guestbook</li>
                <li class="nav-tab" onclick="showTab('add-entry')">✍️ Sign Guestbook</li>
                <li class="nav-tab" onclick="showTab('admin')">⚙️ Admin Panel</li>
                <li class="nav-tab" onclick="showTab('stats')">📊 Statistics</li>
                <li class="nav-tab" onclick="showTab('about')">ℹ️ About</li>
            </ul>
        </div>

        <div class="content">
            <!-- Guestbook Tab -->
            <div id="guestbook" class="tab-content active">
                <div class="search-box">
                    <input type="text" class="search-input" id="searchInput" placeholder="Search entries by name, email, or message...">
                    <div class="filter-buttons">
                        <button class="filter-btn active" onclick="filterEntries('approved')">✅ Approved</button>
                        <button class="filter-btn" onclick="filterEntries('pending')">⏳ Pending</button>
                        <button class="filter-btn" onclick="filterEntries('all')">📋 All</button>
                    </div>
                </div>

                <div id="entriesContainer">
                    <div class="loading">
                        <div class="spinner"></div>
                        <p>Loading guestbook entries...</p>
                    </div>
                </div>

                <div id="paginationContainer"></div>
            </div>

            <!-- Add Entry Tab -->
            <div id="add-entry" class="tab-content">
                <div class="form-section">
                    <h2>📝 Sign Our Guestbook</h2>
                    <p>We'd love to hear from you! Share your thoughts, feedback, or just say hello.</p>
                    
                    <form id="entryForm" style="margin-top: 20px;">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" class="form-control" required 
                                   placeholder="Enter your full name" maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" required 
                                   placeholder="your.email@example.com" maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="website">Website (Optional)</label>
                            <input type="url" id="website" name="website" class="form-control" 
                                   placeholder="https://your-website.com" maxlength="200">
                        </div>

                        <div class="form-group">
                            <label for="message">Your Message *</label>
                            <textarea id="message" name="message" class="form-control" required 
                                      placeholder="Share your thoughts, feedback, or just say hello..." 
                                      maxlength="1000"></textarea>
                            <small class="form-text">Minimum 10 characters, maximum 1000 characters</small>
                        </div>

                        <button type="submit" class="btn btn-primary">📤 Submit Entry</button>
                        <button type="reset" class="btn btn-secondary">🔄 Reset Form</button>
                    </form>
                </div>

                <div class="alert alert-info">
                    <strong>Note:</strong> All entries are subject to moderation before being displayed publicly. 
                    We review submissions to ensure they meet our community guidelines.
                </div>
            </div>

            <!-- Admin Panel Tab -->
            <div id="admin" class="tab-content">
                <div class="form-section">
                    <h2>🔐 Admin Panel</h2>
                    <p>Manage guestbook entries and system settings</p>

                    <div style="margin-bottom: 20px;">
                        <input type="password" id="adminPassword" class="form-control" 
                               placeholder="Enter admin password" style="max-width: 300px; display: inline-block;">
                        <button onclick="authenticateAdmin()" class="btn btn-primary" style="margin-left: 10px;">
                            🔓 Login
                        </button>
                    </div>

                    <div id="adminControls" style="display: none;">
                        <div class="filter-buttons" style="margin-bottom: 20px;">
                            <button class="filter-btn active" onclick="loadAdminEntries('pending')">⏳ Pending Review</button>
                            <button class="filter-btn" onclick="loadAdminEntries('approved')">✅ Approved</button>
                            <button class="filter-btn" onclick="loadAdminEntries('rejected')">❌ Rejected</button>
                            <button class="filter-btn" onclick="loadAdminEntries('all')">📋 All Entries</button>
                        </div>

                        <div class="filter-buttons" style="margin-bottom: 20px;">
                            <button class="btn btn-success" onclick="createBackup()">💾 Create Backup</button>
                            <button class="btn btn-warning" onclick="cleanOldEntries()">🧹 Clean Old Entries</button>
                            <button class="btn btn-secondary" onclick="exportData('csv')">📊 Export CSV</button>
                            <button class="btn btn-secondary" onclick="exportData('json')">📄 Export JSON</button>
                        </div>

                        <div id="adminEntriesContainer">
                            <div class="loading">
                                <div class="spinner"></div>
                                <p>Loading admin entries...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Tab -->
            <div id="stats" class="tab-content">
                <h2>📊 Guestbook Statistics</h2>
                
                <div id="statsContainer">
                    <div class="loading">
                        <div class="spinner"></div>
                        <p>Loading statistics...</p>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <h3>📈 Features Demonstrated</h3>
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 15px;">
                        <ul style="list-style-type: none; line-height: 2;">
                            <li>✅ <strong>File I/O Operations:</strong> CSV reading, writing, and manipulation</li>
                            <li>✅ <strong>File Locking:</strong> Concurrent access protection with .lock files</li>
                            <li>✅ <strong>Data Validation:</strong> Input sanitization and validation</li>
                            <li>✅ <strong>Pagination System:</strong> Efficient large dataset handling</li>
                            <li>✅ <strong>Search & Filter:</strong> Dynamic content filtering</li>
                            <li>✅ <strong>Admin Moderation:</strong> Entry approval/rejection system</li>
                            <li>✅ <strong>Export Functionality:</strong> Multiple format exports (CSV, JSON, XML)</li>
                            <li>✅ <strong>Backup System:</strong> Automated data backup creation</li>
                            <li>✅ <strong>Activity Logging:</strong> Comprehensive audit trail</li>
                            <li>✅ <strong>Spam Detection:</strong> Basic spam filtering algorithms</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- About Tab -->
            <div id="about" class="tab-content">
                <h2>ℹ️ About This Assignment</h2>
                
                <div class="form-section">
                    <h3>📚 Assignment Overview</h3>
                    <p><strong>Assignment 11:</strong> PHP File I/O and CSV Operations</p>
                    <p><strong>Student:</strong> Kheni Urval (24CE055)</p>
                    <p><strong>Course:</strong> WDF: ITUE203</p>
                    <p><strong>Complexity Level:</strong> Medium</p>
                </div>

                <div class="form-section">
                    <h3>🎯 Learning Objectives</h3>
                    <ul style="line-height: 2;">
                        <li>Master PHP file I/O operations with proper error handling</li>
                        <li>Implement CSV data storage and manipulation</li>
                        <li>Practice file locking for concurrent access protection</li>
                        <li>Create robust data validation and sanitization systems</li>
                        <li>Develop pagination for efficient data display</li>
                        <li>Build admin interfaces for content moderation</li>
                        <li>Implement export functionality in multiple formats</li>
                        <li>Practice security measures and spam detection</li>
                    </ul>
                </div>

                <div class="form-section">
                    <h3>🛠️ Technical Implementation</h3>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; font-family: monospace;">
                        <strong>File Operations:</strong> fopen(), fclose(), fgetcsv(), fputcsv()<br>
                        <strong>File Locking:</strong> Custom lock file implementation<br>
                        <strong>Data Storage:</strong> CSV format with headers<br>
                        <strong>Validation:</strong> filter_var(), preg_match(), htmlspecialchars()<br>
                        <strong>Security:</strong> Input sanitization, XSS prevention<br>
                        <strong>Performance:</strong> Pagination, efficient file reading
                    </div>
                </div>

                <div class="form-section">
                    <h3>📁 File Structure</h3>
                    <ul style="font-family: monospace; line-height: 1.8;">
                        <li>📄 index.php - Main interface and navigation</li>
                        <li>📄 guestbook_manager.php - Core backend logic</li>
                        <li>📄 guestbook_actions.php - AJAX action handlers</li>
                        <li>📄 guestbook_data.csv - CSV data storage</li>
                        <li>📄 guestbook_config.json - Configuration settings</li>
                        <li>📄 guestbook_activity.log - Activity audit trail</li>
                        <li>📁 backups/ - Automated backup storage</li>
                        <li>📄 README.md - Documentation</li>
                    </ul>
                </div>

                <div class="form-section">
                    <h3>🔧 Admin Access</h3>
                    <p><strong>Password:</strong> <code>admin123</code></p>
                    <p>Admin features include entry moderation, backup creation, data export, and system maintenance.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentPage = 1;
        let currentFilter = 'approved';
        let currentSearch = '';
        let isAdmin = false;

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            loadEntries();
            loadStatistics();
            
            // Setup search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                currentSearch = this.value;
                currentPage = 1;
                loadEntries();
            });

            // Setup form submission
            document.getElementById('entryForm').addEventListener('submit', submitEntry);
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
            
            // Load specific content based on tab
            if (tabName === 'stats') {
                loadStatistics();
            } else if (tabName === 'admin' && isAdmin) {
                loadAdminEntries('pending');
            }
        }

        // Load guestbook entries
        async function loadEntries(page = 1) {
            const container = document.getElementById('entriesContainer');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Loading entries...</p></div>';

            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=get_entries&page=${page}&status=${currentFilter}&search=${encodeURIComponent(currentSearch)}`
                });

                const data = await response.json();
                
                if (data.success) {
                    displayEntries(data.data);
                    displayPagination(data.data.pages, page);
                } else {
                    container.innerHTML = `<div class="alert alert-error">${data.message}</div>`;
                }
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error loading entries. Please try again.</div>';
                console.error('Error:', error);
            }
        }

        // Display entries
        function displayEntries(data) {
            const container = document.getElementById('entriesContainer');
            
            if (data.entries.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i>📭</i>
                        <h3>No entries found</h3>
                        <p>Be the first to sign our guestbook!</p>
                    </div>
                `;
                return;
            }

            let html = '';
            data.entries.forEach(entry => {
                const statusBadge = `<span class="status-badge status-${entry.status}">${entry.status}</span>`;
                const websiteLink = entry.website ? 
                    `<a href="${entry.website}" target="_blank" class="entry-website">🌐 Website</a>` : '';
                
                html += `
                    <div class="entry">
                        <div class="entry-header">
                            <div class="entry-author">👤 ${entry.name} ${statusBadge}</div>
                            <div class="entry-date">📅 ${formatDate(entry.date)}</div>
                        </div>
                        <div class="entry-content">
                            <div class="entry-message">${entry.message}</div>
                            <div class="entry-meta">
                                <span>📧 ${entry.email}</span>
                                ${websiteLink}
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Display pagination
        function displayPagination(totalPages, currentPage) {
            const container = document.getElementById('paginationContainer');
            
            if (totalPages <= 1) {
                container.innerHTML = '';
                return;
            }

            let html = '<div class="pagination">';
            
            // Previous button
            if (currentPage > 1) {
                html += `<a href="#" class="page-link" onclick="changePage(${currentPage - 1})">← Previous</a>`;
            }
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    html += `<span class="page-link active">${i}</span>`;
                } else {
                    html += `<a href="#" class="page-link" onclick="changePage(${i})">${i}</a>`;
                }
            }
            
            // Next button
            if (currentPage < totalPages) {
                html += `<a href="#" class="page-link" onclick="changePage(${currentPage + 1})">Next →</a>`;
            }
            
            html += '</div>';
            container.innerHTML = html;
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            if (isAdmin && document.getElementById('adminControls').style.display !== 'none') {
                loadAdminEntries(currentFilter, page);
            } else {
                loadEntries(page);
            }
        }

        // Filter entries
        function filterEntries(status) {
            currentFilter = status;
            currentPage = 1;
            
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            loadEntries();
        }

        // Submit new entry
        async function submitEntry(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            formData.append('action', 'add_entry');
            
            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', data.message);
                    event.target.reset();
                    loadEntries(); // Refresh entries
                    loadStatistics(); // Refresh stats
                } else {
                    if (data.errors) {
                        let errorHtml = '<ul class="error-list">';
                        data.errors.forEach(error => {
                            errorHtml += `<li>${error}</li>`;
                        });
                        errorHtml += '</ul>';
                        showAlert('error', 'Please fix the following errors:' + errorHtml);
                    } else {
                        showAlert('error', data.message);
                    }
                }
            } catch (error) {
                showAlert('error', 'Error submitting entry. Please try again.');
                console.error('Error:', error);
            }
        }

        // Show alert message
        function showAlert(type, message) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = message;
            
            const container = document.getElementById('add-entry');
            container.insertBefore(alert, container.firstChild);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 5000);
        }

        // Load statistics
        async function loadStatistics() {
            const container = document.getElementById('statsContainer');
            
            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=get_statistics'
                });

                const data = await response.json();
                
                if (data.success) {
                    displayStatistics(data.data);
                } else {
                    container.innerHTML = `<div class="alert alert-error">${data.message}</div>`;
                }
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error loading statistics.</div>';
                console.error('Error:', error);
            }
        }

        // Display statistics
        function displayStatistics(stats) {
            const container = document.getElementById('statsContainer');
            
            container.innerHTML = `
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">${stats.total}</div>
                        <div class="stat-label">Total Entries</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.approved}</div>
                        <div class="stat-label">Approved</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.pending}</div>
                        <div class="stat-label">Pending Review</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.rejected}</div>
                        <div class="stat-label">Rejected</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.today}</div>
                        <div class="stat-label">Today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.this_week}</div>
                        <div class="stat-label">This Week</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.this_month}</div>
                        <div class="stat-label">This Month</div>
                    </div>
                </div>
            `;
        }

        // Admin authentication
        function authenticateAdmin() {
            const password = document.getElementById('adminPassword').value;
            
            if (password === 'admin123') {
                isAdmin = true;
                document.getElementById('adminControls').style.display = 'block';
                document.getElementById('adminPassword').style.display = 'none';
                event.target.style.display = 'none';
                showAlert('success', 'Admin access granted!');
                loadAdminEntries('pending');
            } else {
                showAlert('error', 'Invalid admin password!');
            }
        }

        // Load admin entries
        async function loadAdminEntries(status, page = 1) {
            if (!isAdmin) return;
            
            const container = document.getElementById('adminEntriesContainer');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Loading admin entries...</p></div>';

            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=get_entries&page=${page}&status=${status}&admin=true`
                });

                const data = await response.json();
                
                if (data.success) {
                    displayAdminEntries(data.data);
                } else {
                    container.innerHTML = `<div class="alert alert-error">${data.message}</div>`;
                }
            } catch (error) {
                container.innerHTML = '<div class="alert alert-error">Error loading entries.</div>';
                console.error('Error:', error);
            }
        }

        // Display admin entries
        function displayAdminEntries(data) {
            const container = document.getElementById('adminEntriesContainer');
            
            if (data.entries.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i>📭</i>
                        <h3>No entries found</h3>
                        <p>No entries match the current filter.</p>
                    </div>
                `;
                return;
            }

            let html = '';
            data.entries.forEach(entry => {
                const statusBadge = `<span class="status-badge status-${entry.status}">${entry.status}</span>`;
                
                html += `
                    <div class="entry">
                        <div class="entry-header">
                            <div class="entry-author">👤 ${entry.name} ${statusBadge}</div>
                            <div class="entry-date">📅 ${formatDate(entry.date)}</div>
                        </div>
                        <div class="entry-content">
                            <div class="entry-message">${entry.message}</div>
                            <div class="entry-meta">
                                <span>📧 ${entry.email}</span>
                                <span>🌐 IP: ${entry.ip_address}</span>
                                <span>🆔 ID: ${entry.id}</span>
                            </div>
                            <div class="admin-actions">
                                ${entry.status === 'pending' ? 
                                    `<button class="btn btn-success" onclick="moderateEntry('${entry.id}', 'approve')">✅ Approve</button>
                                     <button class="btn btn-danger" onclick="moderateEntry('${entry.id}', 'reject')">❌ Reject</button>` : 
                                    ''}
                                <button class="btn btn-danger" onclick="deleteEntry('${entry.id}')">🗑️ Delete</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Moderate entry
        async function moderateEntry(entryId, action) {
            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=moderate_entry&entry_id=${entryId}&moderate_action=${action}`
                });

                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', data.message);
                    loadAdminEntries(currentFilter);
                    loadStatistics();
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Error moderating entry.');
                console.error('Error:', error);
            }
        }

        // Delete entry
        async function deleteEntry(entryId) {
            if (!confirm('Are you sure you want to delete this entry?')) {
                return;
            }

            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=delete_entry&entry_id=${entryId}`
                });

                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', data.message);
                    loadAdminEntries(currentFilter);
                    loadStatistics();
                } else {
                    showAlert('error', data.message);
                }
            } catch (error) {
                showAlert('error', 'Error deleting entry.');
                console.error('Error:', error);
            }
        }

        // Create backup
        async function createBackup() {
            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=create_backup'
                });

                const data = await response.json();
                showAlert(data.success ? 'success' : 'error', data.message);
            } catch (error) {
                showAlert('error', 'Error creating backup.');
                console.error('Error:', error);
            }
        }

        // Clean old entries
        async function cleanOldEntries() {
            if (!confirm('This will permanently delete entries older than 1 year. Continue?')) {
                return;
            }

            try {
                const response = await fetch('guestbook_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=clean_old_entries'
                });

                const data = await response.json();
                showAlert(data.success ? 'success' : 'error', data.message);
                
                if (data.success) {
                    loadAdminEntries(currentFilter);
                    loadStatistics();
                }
            } catch (error) {
                showAlert('error', 'Error cleaning entries.');
                console.error('Error:', error);
            }
        }

        // Export data
        function exportData(format) {
            window.open(`guestbook_actions.php?action=export_data&format=${format}`, '_blank');
        }

        // Utility functions
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        }
    </script>
</body>
</html>
