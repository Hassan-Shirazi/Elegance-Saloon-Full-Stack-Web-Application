<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <!-- Header Section -->
    <header id="header">
        <div class="container">
            <div class="logo">
                <img style = "border-radius:25px;" src="images/logo.png" alt="Elegance Salon Logo" class="logo-img">
                <h1>Elegance Salon</h1>
            </div>
            <nav>
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="#header" class="active">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li class="nav-button-item-mobile"><a href="/php/login.php" class="btn btn-nav login-btn">Login</a></li>
                </ul>
                <div class="nav-actions-desktop">
                    <a href="/php/login.php" class="btn btn-nav login-btn">Login</a>
                </div>
            </nav>
        </div>
    </header>

    <script src = "js/header.js">
    
    </script>
</body>
</html>