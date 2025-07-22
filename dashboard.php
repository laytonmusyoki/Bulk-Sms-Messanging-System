<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #334155;
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            display: flex;
            justify-content: between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 700;
        }

        .navbar-brand::before {
            content: "📱";
            margin-right: 10px;
            font-size: 28px;
        }

        .navbar-user {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            margin-right: 15px;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            margin-right: 15px;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .hamburger {
            display: flex;
            flex-direction: column;
            width: 20px;
            height: 14px;
            justify-content: space-between;
        }

        .hamburger span {
            display: block;
            height: 2px;
            width: 100%;
            background: white;
            border-radius: 1px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            height: calc(100vh - 70px);
            width: 280px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            z-index: 999;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 30px 20px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .sidebar-header h3 {
            color: #1e293b;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            color: #64748b;
            font-size: 14px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: block;
            padding: 15px 25px;
            color: #475569;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-item:hover {
            background: #f1f5f9;
            color: #3b82f6;
            border-left-color: #3b82f6;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #2563eb;
            border-left-color: #2563eb;
            font-weight: 600;
        }

        .menu-item .icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .menu-section {
            padding: 10px 25px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.3s ease;
        }

        .content-header {
            margin-bottom: 30px;
        }

        .content-header h1 {
            font-size: 32px;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .content-header p {
            color: #64748b;
            font-size: 16px;
        }

        /* Dashboard Cards */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }

        .card-icon.send {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .card-icon.history {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .card-icon.contacts {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .card-icon.analytics {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .card-description {
            color: #64748b;
            font-size: 14px;
        }

        .card-action {
            margin-top: 20px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
        }

        /* Content Sections */
        .content-section {
            display: none;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .content-section.active {
            display: block;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 600;
            font-size: 16px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 16px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .info-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border: 2px solid #f59e0b;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            position: relative;
        }

        .info-box::before {
            content: "💡";
            position: absolute;
            top: -10px;
            left: 20px;
            background: #f59e0b;
            color: white;
            padding: 8px;
            border-radius: 50%;
            font-size: 16px;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-sent {
            background: #dcfce7;
            color: #166534;
        }

        .status-failed {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }

            .menu-toggle {
                display: none;
            }

            .navbar-user .user-info span {
                display: none;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .main-content.sidebar-collapsed {
                margin-left: 0;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width: 769px) {
            .mobile-toggle {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .sidebar.collapsed {
                width: 80px;
            }

            .sidebar.collapsed .sidebar-header,
            .sidebar.collapsed .menu-section,
            .sidebar.collapsed .menu-item span:not(.icon) {
                display: none;
            }

            .sidebar.collapsed .menu-item {
                justify-content: center;
                padding: 15px 10px;
            }

            .sidebar.collapsed .menu-item .icon {
                margin-right: 0;
            }

            .main-content.sidebar-collapsed {
                margin-left: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
            SMS Dashboard
        </div>
        <div class="navbar-user">
            <div class="user-info">
                <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></div>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>SMS Management</h3>
            <p>Bulk messaging system</p>
        </div>
        
        <div class="sidebar-menu">
            <a href="#" class="menu-item active" onclick="showSection('dashboard')">
                <span class="icon">🏠</span>
                Dashboard
            </a>
            <a href="#" class="menu-item" onclick="showSection('send-sms')">
                <span class="icon">📤</span>
                Send SMS
            </a>
            <a href="#" class="menu-item" onclick="showSection('message-history')">
                <span class="icon">📋</span>
                Message History
            </a>
            <!-- <a href="#" class="menu-item" onclick="showSection('contacts')">
                <span class="icon">👥</span>
                Contacts
            </a> -->
            
            
            <div class="menu-section">Analytics</div>
            <a href="#" class="menu-item" onclick="showSection('reports')">
                <span class="icon">📊</span>
                Reports
            </a>
            
            
            <div class="menu-section">Settings</div>
            <a href="#" class="menu-item" onclick="showSection('api-settings')">
                <span class="icon">⚙️</span>
                API Settings
            </a>
            <a href="#" class="menu-item" onclick="showSection('profile')">
                <span class="icon">👤</span>
                Profile
            </a>
            <a href="logout.php" class="menu-item">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Dashboard Section -->
        <section id="dashboard" class="content-section active">
            <div class="content-header">
                <h1>Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>! Here's your SMS activity overview.</p>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-icon send">📤</div>
                        <div>
                            <div class="card-title">Send SMS</div>
                            <div class="card-description">Send bulk messages to multiple recipients</div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#" class="btn btn-primary" onclick="showSection('send-sms')">Send Messages</a>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-icon history">📋</div>
                        <div>
                            <div class="card-title">Message History</div>
                            <div class="card-description">View all sent messages and delivery status</div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#" class="btn btn-primary" onclick="showSection('message-history')">View History</a>
                    </div>
                </div>

                <!-- <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-icon contacts">👥</div>
                        <div>
                            <div class="card-title">Manage Contacts</div>
                            <div class="card-description">Organize your contact lists and groups</div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#" class="btn btn-primary" onclick="showSection('contacts')">Manage Contacts</a>
                    </div>
                </div> -->

                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-icon analytics">📊</div>
                        <div>
                            <div class="card-title">Analytics</div>
                            <div class="card-description">View detailed reports and statistics</div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#" class="btn btn-primary" onclick="showSection('reports')">View Reports</a>
                    </div>
                </div>
            </div>
        </section>

            <!-- Send SMS Section -->
            <?php include 'send.php'; ?>


        <!-- Message History Section -->
        <?php include 'history.php'; ?>

        <!-- Other sections can be added here -->
        <section id="contacts" class="content-section">
            <div class="content-header">
                <h1>Contact Management</h1>
                <p>Organize your contacts and create groups for easier messaging.</p>
            </div>
            <p>Contact management features coming soon...</p>
        </section>

        
        <section id="reports" class="content-section">
            <?php include 'reports.php'; ?>
        </section>

        

        <section id="api-settings" class="content-section">
            <?php include 'api.php'; ?>
        </section>

        <section id="profile" class="content-section">
            <?php include 'profile.php'; ?>
        </section>
    </main>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.classList.remove('active'));
            
            // Remove active class from all menu items
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            
            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Add active class to clicked menu item
            event.target.classList.add('active');
            
            // Close sidebar on mobile after selection
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('open');
            }
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>