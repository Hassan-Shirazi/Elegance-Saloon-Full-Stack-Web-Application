<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon</title>
    <link rel="icon" type="image/png" href="/images/logo.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&display=swap"
        rel="stylesheet">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
     <style>
           /* Base Styles */
        :root {
            --primary-color: #e0e0e0;
            /* Light Gray for accents */
            --secondary-color: #707070;
            /* Medium Gray/Silver for highlights */
            --tertiary-color: #f8f8f8;
            /* Off-White background */
            --accent-color: #eaeaea;
            /* Another light gray for section backgrounds */
            --text-color: #444;
            /* Darker gray for main text */
            --light-text: #ffffff;
            /* White text */
            --dark-text: #1a1a1a;
            /* Very dark gray/black for main headings/footer bg */
            --hover-color: #b0b0b0;
            /* Subtle silver/gray for hover effects */
            --transition: all 0.3s ease;
        }

* {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
        color: var(--text-color);
        background-color: var(--tertiary-color);
    }

    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: gray;
        border-radius: 25px;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .section {
        padding: 80px 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: var(--dark-text);
        margin-bottom: 15px;
    }

    .underline {
        height: 3px;
        width: 70px;
        background-color: var(--secondary-color);
        margin: 0 auto;
    }

    .btn {
        display: inline-block;
        background-color: var(--secondary-color);
        /* Changed to secondary color */
        color: var(--light-text);
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }

    .btn:hover {
        background-color: var(--dark-text);
        /* Changed to dark text */
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* Hero Section (Carousel) */
    #hero {
        position: relative;
        height: 100vh;
        overflow: hidden;
        /* Ensure images don't overflow */
        background-color: var(--dark-text);
        /* Fallback background */
    }

    .carousel-container {
        position: absolute;
        inset: 0;
        /* Cover the entire hero section */
        /* No direct styling for carousel-container, slides handle visibility */
    }

    .carousel-slide {
        position: absolute;
        inset: 0;
        /* Cover the entire hero section */
        opacity: 0;
        /* Hidden by default */
        transition: opacity 1.5s ease-in-out;
        /* Smooth fade transition */
        z-index: 1;
        /* Below text overlay */
        display: flex;
        /* For overlay positioning */
    }

    .carousel-slide.active {
        opacity: 1;
        /* Active slide is visible */
    }

    .carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Cover the area, maintain aspect ratio */
        object-position: center;
    }

    .carousel-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7));
        /* Dark gradient for text readability */
        z-index: 2;
        /* Above image, below text */
    }

    .hero-text-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: var(--light-text);
        z-index: 10;
        /* Above all carousel elements */
        width: 90%;
        /* Max width for text on smaller screens */
        max-width: 800px;
        /* Max width for text on larger screens */
    }

    .hero-text-overlay h1 {
        font-family: 'Playfair Display', serif;
        font-size: 4.5rem;
        /* Larger font for impact */
        margin-bottom: 20px;
        animation: fadeInDown 1s ease;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        /* Text shadow for better readability */
    }

    .hero-text-overlay h2 {
        font-size: 1.8rem;
        font-weight: 300;
        margin-bottom: 40px;
        animation: fadeInUp 1s ease;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
    }

    /* Carousel Navigation Arrows */
    .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 15;
        cursor: pointer;
        color: var(--light-text);
        background-color: rgba(0, 0, 0, 0.3);
        padding: 15px;
        border-radius: 50%;
        font-size: 1.5rem;
        transition: background-color 0.3s ease, transform 0.3s ease;
        user-select: none;
        /* Prevent text selection */
        border: none;
        /* Remove default button border */
        outline: none;
        /* Remove outline on focus */
    }

    .carousel-arrow:hover {
        background-color: rgba(0, 0, 0, 0.6);
        transform: translateY(-50%) scale(1.1);
        /* Subtle zoom on hover */
    }

    .carousel-arrow.left {
        left: 20px;
    }

    .carousel-arrow.right {
        right: 20px;
    }

    /* Carousel Dot Indicators */
    .carousel-dots {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 15;
        display: flex;
        gap: 10px;
    }

    .dot {
        width: 12px;
        height: 12px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.7);
        /* Subtle border */
    }

    .dot:hover {
        background-color: rgba(255, 255, 255, 0.8);
        transform: scale(1.1);
    }

    .dot.active {
        background-color: var(--light-text);
        border-color: var(--light-text);
        transform: scale(1.2);
    }

    /* About Section */
    #about {
        background-color: var(--tertiary-color);
        /* Explicitly set to default */
    }

    .about-content {
        display: flex;
        align-items: center;
        gap: 50px;
    }

    .about-text {
        flex: 1;
    }

    .about-text p {
        margin-bottom: 30px;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .about-image {
        flex: 1;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Services Section */
    #services {
        background-color: var(--accent-color);
        /* Changed to accent color */
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .service-card {
        background-color: var(--light-text);
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        transition: var(--transition);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        opacity: 0;
        /* For scroll animation */
        transform: translateY(20px);
        /* For scroll animation */
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .service-icon {
        width: 70px;
        height: 70px;
        background-color: var(--primary-color);
        /* Changed to primary color */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .service-icon i {
        font-size: 1.8rem;
        color: var(--dark-text);
    }

    .service-card h3 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 15px;
        color: var(--dark-text);
    }

    /* NEW: Why Choose Us Section Styles */
    #why-choose-us {
        background-color: var(--tertiary-color);
        /* Match body background for alternation */
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background-color: var(--light-text);
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        opacity: 0;
        /* For scroll animation */
        transform: translateY(20px);
        /* For scroll animation */
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .feature-icon i {
        font-size: 1.8rem;
        color: var(--dark-text);
    }

    .feature-card h3 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 15px;
        color: var(--dark-text);
    }

    .feature-card p {
        font-size: 0.95rem;
        color: var(--text-color);
        line-height: 1.7;
    }


    /* Gallery Section */
    #gallery {
        background-color: var(--accent-color);
        /* Changed for alternation */
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .gallery-item {
        overflow: hidden;
        border-radius: 10px;
        height: 250px;
        position: relative;
        /* Needed for absolute positioning of overlay */
        cursor: pointer;
        /* Indicates interactivity */
        outline: none;
        /* Remove default focus outline if undesired, manage with :focus below */
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    /* NEW: Gallery Caption Overlay Styles */
    .gallery-caption-overlay {
        position: absolute;
        inset: 0;
        /* Shorthand for top:0; right:0; bottom:0; left:0; */
        background-color: rgba(0, 0, 0, 0.7);
        /* Semi-opaque dark background */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        opacity: 0;
        /* Hidden by default */
        transform: translateY(10px);
        /* Slightly below its final position */
        transition: opacity 0.3s ease, transform 0.3s ease;
        /* Smooth animation */
        pointer-events: none;
        /* Allow events to pass through when hidden */
    }

    .gallery-item:hover .gallery-caption-overlay,
    .gallery-item:focus-within .gallery-caption-overlay {
        opacity: 1;
        /* Fully visible on hover/focus */
        transform: translateY(0);
        /* Slide up to final position */
        pointer-events: auto;
        /* Enable pointer events when visible */
    }

    .gallery-item:focus {
        outline: 2px solid var(--secondary-color);
        /* Accessible focus indicator */
        outline-offset: -2px;
        /* Keep outline inside the border */
        border-radius: 10px;
        /* Match item border-radius */
    }

    .gallery-caption-overlay p {
        color: var(--light-text);
        /* White text */
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        margin: 0;
        /* Remove default paragraph margin */
        max-width: 90%;
        /* Prevent text from touching edges */
    }

    /* Testimonials Section */
    #testimonials {
        background-color: var(--tertiary-color);
        /* Match body background */
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .testimonial-card {
        background-color: var(--light-text);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        position: relative;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        opacity: 0;
        /* For scroll animation */
        transform: translateY(20px);
        /* For scroll animation */
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .testimonial-card .quote-icon {
        font-size: 2rem;
        color: var(--secondary-color);
        margin-bottom: 25px;
        opacity: 0.7;
    }

    .testimonial-card .testimonial-text {
        font-size: 1rem;
        line-height: 1.8;
        color: var(--text-color);
        margin-bottom: 30px;
        flex-grow: 1;
        /* Allow text to take available space */
    }

    .testimonial-card .client-info {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
    }

    .testimonial-card .client-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
        border: 3px solid var(--primary-color);
    }

    .testimonial-card .client-name {
        font-weight: 600;
        color: var(--dark-text);
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
    }


    /* Footer Section */
    #footer {
        background-color: var(--dark-text);
        /* Black/very dark gray */
        color: var(--light-text);
        /* White text */
        padding: 60px 0 20px 0;
        /* Adjust padding as needed */
        text-align: left;
        /* Default text alignment for columns */
    }

    #footer .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
        /* Space between columns and copyright */
    }

    #footer .footer-col h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        margin-bottom: 25px;
        color: var(--light-text);
        position: relative;
        padding-bottom: 10px;
    }

    #footer .footer-col h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: var(--secondary-color);
        /* Medium gray underline */
    }

    #footer .footer-col p {
        font-size: 0.95rem;
        line-height: 1.7;
        opacity: 0.8;
    }

    #footer .footer-col ul {
        list-style: none;
    }

    #footer .footer-col ul li {
        margin-bottom: 12px;
        font-size: 0.95rem;
        color: var(--light-text);
        /* Default color for list items */
        transition: var(--transition);
    }

    #footer .footer-col ul li:hover {
        color: var(--hover-color);
        /* Hover for list items */
        padding-left: 5px;
        /* Subtle slide effect */
    }

    #footer .footer-col ul li a {
        text-decoration: none;
        color: var(--light-text);
        transition: var(--transition);
        display: inline-block;
        /* For padding-left effect */
    }

    #footer .footer-col ul li a:hover {
        color: var(--hover-color);
        transform: translateX(5px);
        /* Slide effect for links */
    }

    #footer .social-icons {
        display: flex;
        justify-content: flex-start;
        /* Align to the left in column */
        gap: 15px;
        margin-top: 20px;
    }

    #footer .social-icon {
        width: 45px;
        /* Slightly larger icons */
        height: 45px;
        background-color: var(--light-text);
        /* White background */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--dark-text);
        /* Black/dark gray icon color */
        font-size: 1.1rem;
        transition: all 0.3s ease;
        /* Ensure smooth transition */
    }

    #footer .social-icon:hover {
        background-color: var(--secondary-color);
        /* Medium gray on hover */
        color: var(--light-text);
        /* White icon on hover */
        transform: scale(1.1);
        /* Zoom-in effect */
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        /* Subtle shadow on hover */
    }

    #footer .copyright-container {
        border-top: 1px solid white;
        /* Subtle separator */
        padding-top: 20px;
        margin-top: 20px;
        /* Space from content above */
        text-align: center;
        font-size: 0.85rem;
        opacity: 0.7;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Styles */
    @media screen and (max-width: 992px) {
        .about-content {
            flex-direction: column;
        }

        .hero-text-overlay h1 {
            font-size: 3.5rem;
            /* Adjusted for smaller screens */
        }

        .hero-text-overlay h2 {
            font-size: 1.5rem;
            /* Adjusted for smaller screens */
        }

        .carousel-arrow {
            padding: 12px;
            font-size: 1.2rem;
        }

        .carousel-arrow.left {
            left: 10px;
        }

        .carousel-arrow.right {
            right: 10px;
        }

        .carousel-dots {
            bottom: 20px;
        }

        .dot {
            width: 10px;
            height: 10px;
        }
    }

    @media screen and (max-width: 768px) {
        .hero-text-overlay h1 {
            font-size: 2.8rem;
            /* Further adjustment for smaller tablets/large phones */
        }

        .hero-text-overlay h2 {
            font-size: 1.2rem;
        }

        .section {
            padding: 60px 0;
        }

        .section-title h2 {
            font-size: 2rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        /* NEW: Responsive Styles for Gallery Caption */
        .gallery-caption-overlay p {
            font-size: 0.9rem;
            /* Slightly smaller font on tablets */
            padding: 15px;
        }

        /* Footer Responsive */
        #footer .footer-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            /* Allow 2 columns on tablet */
            text-align: center;
            /* Center content when stacked */
        }

        #footer .footer-col h3::after {
            left: 50%;
            /* Center underline */
            transform: translateX(-50%);
        }

        #footer .social-icons {
            justify-content: center;
            /* Center social icons */
        }

        /* New sections responsive */
        .testimonials-grid,
        .features-grid {
            grid-template-columns: 1fr;
        }
    }

    @media screen and (max-width: 576px) {
        .hero-text-overlay h1 {
            font-size: 2.2rem;
            /* Mobile phone heading */
        }

        .hero-text-overlay h2 {
            font-size: 1.0rem;
            /* Adjusted for smaller screens */
        }

        .btn {
            padding: 10px 25px;
            font-size: 0.8rem;
        }

        .section-title h2 {
            font-size: 1.8rem;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
        }

        /* NEW: Responsive Styles for Gallery Caption */
        .gallery-caption-overlay p {
            font-size: 0.85rem;
            /* Even smaller on mobile phones */
            padding: 10px;
        }

        /* Footer Responsive */
        #footer .footer-grid {
            grid-template-columns: 1fr;
        }

        /* Testimonials Responsive */
        .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .carousel-arrow {
            padding: 10px;
            font-size: 1rem;
        }

        .carousel-arrow.left {
            left: 5px;
        }

        .carousel-arrow.right {
            right: 5px;
        }

        .carousel-dots {
            bottom: 10px;
            gap: 5px;
        }

        .dot {
            width: 8px;
            height: 8px;
        }
    }
     </style>

</head>

<body>
<?php include "header.php"; ?>

    <!-- Hero Section (Carousel) -->
    <section id="hero">
        <div class="carousel-container">
            <!-- Carousel Slide 1 -->
            <div class="carousel-slide active">
                <img src="images/back1.png" alt="Luxurious Hair Styling Session">
                <div class="carousel-overlay"></div>
            </div>
            <!-- Carousel Slide 2 -->
            <div class="carousel-slide">
                <img src="images/back2.png" alt="Elegant Manicure and Nail Treatment">
                <div class="carousel-overlay"></div>
            </div>
            <!-- Carousel Slide 3 -->
            <div class="carousel-slide">
                <img src="images/back3.png" alt="Relaxing Facial Treatment">
                <div class="carousel-overlay"></div>
            </div>
        </div>

        <!-- Text Overlay (stays fixed on top of carousel) -->
        <div class="hero-text-overlay">
            <h1 style="-webkit-text-stroke: 0.8px gray">Elegance Salon</h1>
            <h2>Where Beauty Meets Perfection</h2>

        </div>

        <!-- Carousel Navigation Arrows -->
        <button class="carousel-arrow left" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
        <button class="carousel-arrow right" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>

        <!-- Carousel Dot Indicators -->
        <div class="carousel-dots">
            <span class="dot active" aria-label="Go to slide 1"></span>
            <span class="dot" aria-label="Go to slide 2"></span>
            <span class="dot" aria-label="Go to slide 3"></span>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="section-title">
                <h2>About Us</h2>
                <div class="underline"></div>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p>Elegance Salon is a popular beauty establishment that offers a variety of services including hair
                        styling, manicures, pedicures, and facials. Our commitment is to enhance operational efficiency,
                        improve customer experience, and streamline business processes to bring you the best in beauty.
                    </p>
                    <a href="#services" class="btn">Explore Services</a> <!-- Changed to Services section -->
                </div>
                <div class="about-image">
                    <img src="images/8.png" alt="Elegance Salon Interior">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <a style="text-decoration: none;" href="contact.html">
        <section id="services" class="section">
            <div class="container">
                <div class="section-title">
                    <h2>Our Services</h2>
                    <div class="underline"></div>
                </div>
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-cut"></i>
                        </div>
                        <h3>Hair Styling</h3>
                        <p style="color: black;">Professional hair styling services including cuts, coloring, and
                            treatments for all hair types.
                        </p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-hand-sparkles"></i>
                        </div>
                        <h3>Manicures</h3>
                        <p style="color: black;">Luxurious manicure services with premium products and the latest nail
                            art techniques.</p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h3>Pedicures</h3>
                        <p style="color: black;">Relaxing pedicure treatments that will leave your feet feeling
                            refreshed and looking beautiful.
                        </p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-magic"></i>
                        </div>
                        <h3>Facials</h3>
                        <p style="color: black;">Rejuvenating facial treatments customized to your skin type and
                            concerns.</p>
                    </div>
                </div>
            </div>
        </section>
    </a>

    <!-- Gallery Section -->
        <section id="gallery" class="section">
            <div class="container">
                <div class="section-title">
                    <h2>Our Gallery</h2>
                    <div class="underline"></div>
                </div>
    <a href="contact.html">

                <div class="gallery-grid">
                    <!-- Gallery Item 1 -->
                    <div class="gallery-item" tabindex="0">
                        <img src="images/1.535Z.png" alt="Stylish Hair Cut and Color">
                        <div class="gallery-caption-overlay" aria-hidden="true"></div>
                    </div>
                    <!-- Gallery Item 2 -->
                    <div class="gallery-item" tabindex="0">
                        <img src="images/2.118Z.png" alt="Elegant Manicure and Nail Art">
                        <div class="gallery-caption-overlay" aria-hidden="true"></div>
                    </div>
                    <!-- Gallery Item 3 -->
                    <div class="gallery-item" tabindex="0">
                        <img src="images/3.942Z.png" alt="Relaxing Pedicure Treatment">
                        <div class="gallery-caption-overlay" aria-hidden="true"></div>
                    </div>
                    <!-- Gallery Item 4 -->
                    <div class="gallery-item" tabindex="0">
                        <img src="images/5.031Z.png" alt="Rejuvenating Facial Session">
                        <div class="gallery-caption-overlay" aria-hidden="true"></div>
                    </div>
                    <!-- Gallery Item 5 -->
                    <div class="gallery-item" tabindex="0">
                        <img src="images/6.141Z.png" alt="Luxurious Salon Ambiance">
                        <div class="gallery-caption-overlay" aria-hidden="true"></div>
                    </div>
                    <!-- Gallery Item 6 -->
                    <div class="gallery-item" tabindex="0">
                        <img src="images/4.png" alt="Professional Makeup Application">
                        <div class="gallery-caption-overlay" aria-hidden="true"></div>
                    </div>
                </div>
    </a>

            </div>
        </section>
    <section id="why-choose-us" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Elegance Salon?</h2>
                <div class="underline"></div>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Experienced Stylists</h3>
                    <p>Our team comprises highly skilled and passionate professionals dedicated to perfection.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3>Premium Products</h3>
                    <p>We use only top-tier, quality-tested products for superior results and client well-being.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chair"></i>
                    </div>
                    <h3>Relaxing Environment</h3>
                    <p>Step into a serene and luxurious atmosphere designed for your ultimate comfort and relaxation.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Client Satisfaction</h3>
                    <p>Your happiness is our priority; we strive to exceed expectations with every visit.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-brush"></i>
                    </div>
                    <h3>Customized Treatments</h3>
                    <p>Services tailored specifically to your individual needs, style, and beauty goals.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Easy Booking</h3>
                    <p>Convenient online scheduling allows you to book your preferred services with ease.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials Section -->
    <section id="testimonials" class="section">
        <div class="container">
            <div class="section-title">
                <h2>What Our Clients Say</h2>
                <div class="underline"></div>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <i class="fas fa-quote-left quote-icon"></i>
                    <p class="testimonial-text">"Elegance Salon truly lives up to its name! My hair has never looked
                        better, and the staff are incredibly professional and friendly. Highly recommend their styling
                        services."</p>
                    <div class="client-info">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTccyupHsvVu-P1awfnOdcP_H8U8pKpuwHKRg&s"
                            alt="Client 1" class="client-avatar">
                        <p class="client-name">Sarah J.</p>
                    </div>
                </div>
                <div class="testimonial-card">
                    <i class="fas fa-quote-left quote-icon"></i>
                    <p class="testimonial-text">"I always look forward to my appointments here. The pedicures are so
                        relaxing, and my nails always look perfect. It's a real treat and a wonderful escape."</p>
                    <div class="client-info">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3q_Gz1_LsJLKgS9djCvRPiaKAq_-_zZV3GA&s"
                            alt="Client 2" class="client-avatar">
                        <p class="client-name">Emily K.</p>
                    </div>
                </div>
                <div class="testimonial-card">
                    <i class="fas fa-quote-left quote-icon"></i>
                    <p class="testimonial-text">"The facials are divine! My skin feels so refreshed and rejuvenated
                        after every session. The estheticians are knowledgeable and gentle. Best salon experience!"</p>
                    <div class="client-info">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQRnRWikSG3yp8H8UfoDMuacMZ3GII5XlrGQ&s"
                            alt="Client 3" class="client-avatar">
                        <p class="client-name">Jessica L.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer id="footer">
        <div class="container footer-grid">
            <div class="footer-col about-col">
                <h3>About Us</h3>
                <p>Elegance Salon is a popular beauty establishment dedicated to providing exceptional hair styling,
                    manicures, pedicures, and facial treatments. We strive for perfection and customer satisfaction.</p>
            </div>
            <div class="footer-col links-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#why-choose-us">Why Us</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#testimonials">Testimonials</a></li> <!-- Added testimonials link -->
                </ul>
            </div>
            <div class="footer-col services-col">
                <h3>Our Services</h3>
                <ul>
                    <li>Hair Styling</li>
                    <li>Manicures</li>
                    <li>Pedicures</li>
                    <li>Facials</li>
                </ul>
            </div>
            <div class="footer-col social-col">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="container copyright-container">
            <p class="copyright">© 2025 Elegance Salon. All Rights Reserved.</p>
        </div>
    </footer>

<script>
     document.addEventListener('DOMContentLoaded', function () {
            // Smooth scrolling for all anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        const offset = 20; // Small offset for better visibility

                        window.scrollTo({
                            top: targetElement.offsetTop - offset,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add animation to service cards, feature cards, and testimonial cards on scroll
            const cardsToAnimate = document.querySelectorAll('.service-card, .feature-card, .testimonial-card');
            const animateOnScroll = function () {
                cardsToAnimate.forEach(card => {
                    const cardPosition = card.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;

                    if (cardPosition < screenPosition) {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }
                });
            };

            // Set initial state for cards
            cardsToAnimate.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
            });

            // Run animation on scroll
            window.addEventListener('scroll', animateOnScroll);
            // Run once on page load
            animateOnScroll();

            // NEW: Gallery Caption Logic
            const galleryItems = document.querySelectorAll('.gallery-item');

            galleryItems.forEach(item => {
                const img = item.querySelector('img');
                const overlay = item.querySelector('.gallery-caption-overlay');

                if (img && overlay) {
                    const altText = img.alt;
                    if (altText) {
                        const captionParagraph = document.createElement('p');
                        captionParagraph.textContent = altText;
                        overlay.appendChild(captionParagraph);
                    }

                    // Set initial aria-hidden state for screen readers
                    overlay.setAttribute('aria-hidden', 'true');

                    // Event listeners for mouse hover
                    item.addEventListener('mouseenter', () => {
                        overlay.setAttribute('aria-hidden', 'false');
                    });
                    item.addEventListener('mouseleave', () => {
                        overlay.setAttribute('aria-hidden', 'true');
                    });

                    // Event listeners for keyboard focus (using focusin/focusout for bubbling)
                    item.addEventListener('focusin', () => {
                        overlay.setAttribute('aria-hidden', 'false');
                    });
                    item.addEventListener('focusout', (event) => {
                        // Check if the focus has moved outside the current gallery item
                        // 'relatedTarget' is the element that receives focus
                        if (!item.contains(event.relatedTarget)) {
                            overlay.setAttribute('aria-hidden', 'true');
                        }
                    });
                }
            });

            // CAROUSEL JAVASCRIPT
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.dot');
            const leftArrow = document.querySelector('.carousel-arrow.left');
            const rightArrow = document.querySelector('.carousel-arrow.right');
            const autoSlideInterval = 5000; // 5 seconds
            let currentSlide = 0;
            let slideInterval;

            function showSlide(index) {
                // Hide all slides and deactivate all dots
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                // Show the current slide and activate the current dot
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                currentSlide = index;
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }

            function startAutoSlide() {
                stopAutoSlide(); // Clear any existing interval
                slideInterval = setInterval(nextSlide, autoSlideInterval);
            }

            function stopAutoSlide() {
                clearInterval(slideInterval);
            }

            // Event listeners for arrows
            if (leftArrow) {
                leftArrow.addEventListener('click', () => {
                    stopAutoSlide();
                    prevSlide();
                    startAutoSlide(); // Restart auto-slide after manual interaction
                });
            }
            if (rightArrow) {
                rightArrow.addEventListener('click', () => {
                    stopAutoSlide();
                    nextSlide();
                    startAutoSlide(); // Restart auto-slide after manual interaction
                });
            }

            // Event listeners for dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    stopAutoSlide();
                    showSlide(index);
                    startAutoSlide(); // Restart auto-slide
                });
            });

            // Initialize carousel
            if (slides.length > 0) {
                showSlide(0); // Display the first slide
                startAutoSlide(); // Start auto-sliding
            }
        });
</script>
</body>

</html>