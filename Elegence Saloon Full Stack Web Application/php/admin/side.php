<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/side.css">
</head>
<body>
    <!-- Hamburger Toggle Button -->
    <button class="toggle-btn" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon">
                   <img src="images/logo.png" alt="" width = "50px" style = "border-radius:25px;">
                </div>
                <div class="logo-text">AdminPanel</div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-group">
                <div class="menu-title">Main</div>
                <ul class="menu-items">
                <li class="menu-item">
                        <a href="report.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-chart-bar"></i></span>
                            <span class="menu-text">Reports & Analytics</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="appo.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-calendar-check"></i></span>
                            <span class="menu-text">Appointments</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="inv.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-boxes"></i></span>
                            <span class="menu-text">Inventory</span>
                        </a>
                    </li>
                        <li class="menu-item">
                        <a href="contactM.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-boxes"></i></span>
                            <span class="menu-text">Customer Messages</span>
                        </a>
                    </li>
                 
                    <li class="menu-item">
                        <a href="payment.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-credit-card"></i></span>
                            <span class="menu-text">Payments</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="menu-group">
                <div class="menu-title">Management</div>
                <ul class="menu-items">
                    <li class="menu-item">
                        <a href="stylist.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-user-plus"></i></span>
                            <span class="menu-text">Add Stylist</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="rec.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-user-plus"></i></span>
                            <span class="menu-text">Add Receptionist</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="menu-group">
                <div class="menu-title">Account</div>
                <ul class="menu-items">
                    <li class="menu-item">
                        <a href="setting.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-cog"></i></span>
                            <span class="menu-text">Settings</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="logout.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span class="menu-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="user-info">
                <!-- <div class="user-avatar">JD</div> -->
                <div class="user-details">
                    
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </nav>

    <script src = "js/side.js">
      
    </script>
</body>
</html>