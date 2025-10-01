<?php
session_start();

// Only destroy session if logout is confirmed
if (isset($_POST['confirm_logout'])) {
    // Destroy all session data
    $_SESSION = array();

    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session
    session_destroy();
    
    // Redirect to login page
    header("Location: /php/login.php?logout=success");
    exit();
}

// If user cancels, redirect back to admin panel
if (isset($_POST['cancel_logout'])) {
    header("Location: report.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Logout - Elegance Salon</title>
   <link rel="stylesheet" href="css/logout.css">
</head>
<body>
    <?php include "side.php"; ?>
    
    <main class="main-content">
        <div class="logout-container">
            <div class="logout-icon">
                <i>🚪</i>
            </div>
            
            <h1 class="logout-title">Confirm Logout</h1>
            
            <p class="logout-message">
                Are you sure you want to logout from your admin account?
            </p>

            <div class="user-info">
                <div class="info-item">
                    <span class="info-label">User Role:</span>
                    <span class="info-value">Administrator</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Current Time:</span>
                    <span class="info-value"><?php echo date('H:i:s'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    <span class="info-value"><?php echo date('Y-m-d'); ?></span>
                </div>
            </div>

            <form method="POST" action="">
                <div class="btn-group">
                    <button type="submit" name="cancel_logout" class="btn btn-cancel">
                        <i>←</i>
                        Cancel
                    </button>
                    <button type="submit" name="confirm_logout" class="btn btn-logout">
                        <i>🚪</i>
                        Logout
                    </button>
                </div>
            </form>

            <div class="security-note">
                <p><strong>Note:</strong> After logout, you will need to login again to access the admin panel.</p>
            </div>
        </div>
    </main>

    <script src = "js/logout.js">
  
    </script>
</body>
</html>