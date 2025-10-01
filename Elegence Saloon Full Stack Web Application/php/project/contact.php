<?php

// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "elegence"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");


// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    // Basic validation
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Insert into database
        $sql = "INSERT INTO contact_form (name, email, subject, message, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        if ($stmt->execute()) {
            $success_message = "Thank you for your message! We'll get back to you soon.";
        } else {
            $error_message = "Sorry, there was an error sending your message. Please try again.";
        }
        
        $stmt->close();
    } else {
        $error_message = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon - Contact Us</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
    
<?php include "header.php"; ?>

    <!-- Contact Hero Section -->
    <section id="contact-hero">
        <div class="hero-background">
            <!-- Placeholder image: replace with your own or a suitable stock image -->
            <img style="margin-top: 1px;" src="images/team4.950Z.png"
                alt="Stylist working on hair" class="hero-image">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-text-overlay">
            <h1 style="-webkit-text-stroke: 0.8px gray">We'd Love to Hear from You</h1>
        </div>
    </section>

    <!-- Display Messages -->
    <?php if (isset($success_message)): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; text-align: center; margin: 20px auto; max-width: 600px; border-radius: 5px;">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; text-align: center; margin: 20px auto; max-width: 600px; border-radius: 5px;">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <!-- Contact Information Section -->
    <section id="contact-info" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Get in Touch</h2>
                <div class="underline"></div>
            </div>
            <div class="contact-info-grid">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Email Us</h3>
                    <p><a href="mailto:info@elegancesalon.com">info@elegancesalon.com</a></p>
                </div>
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                    <h3>Call Us</h3>
                    <p><a href="tel:+11234567890">+1 (123) 456-7890</a></p>
                </div>
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3>Our Address</h3>
                    <p>123 Beauty Blvd, Suite 100,<br>Cityville, ST 12345</p>
                </div>
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-clock"></i></div>
                    <h3>Working Hours</h3>
                    <p>Mon-Fri: 9 AM - 7 PM<br>Sat: 10 AM - 5 PM<br>Sun: Closed</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contact-form" class="section" style="background-color: var(--accent-color);">
        <div class="container">
            <div class="section-title">
                <h2>Send Us a Message</h2>
                <div class="underline"></div>
            </div>
            <form class="contact-form-grid" method="POST" action="">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input required type="text" id="name" name="name" required placeholder="Your Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required type="email" id="email" name="email" required placeholder="Your Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                <div class="form-group full-width">
                    <label for="subject">Subject</label>
                    <input required type="text" id="subject" name="subject" required placeholder="Subject of your message" value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                </div>
                <div class="form-group full-width">
                    <label for="message">Message</label>
                    <textarea required id="message" name="message" rows="6" required placeholder="Your message..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>
                <div class="form-group full-width">
                    <button type="submit" class="btn">Send Message</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Map Section -->
    <section id="location-map" class="section" style="background-color: var(--accent-color);">
        <div class="container">
            <div class="section-title">
                <h2>Find Our Location</h2>
                <div class="underline"></div>
            </div>
            <div class="map-container">
                <!-- Replace with your actual salon location -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.2081594956327!2d144.96090621531713!3d-37.81735127975109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4df4473e6b%3A0x6a1f0a5f1e5e0a6d!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1678912345678!5m2!1sen!2sau"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" aria-label="Location of Elegance Salon on Google Maps"></iframe>
            </div>
        </div>
    </section>

</body>
</html>