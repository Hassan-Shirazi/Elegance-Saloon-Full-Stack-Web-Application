<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Saloon - Feedback</title>
      <link rel="icon" type="image/png" href="/images/logo.png">
</head>
<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="css/feedback.css">

<section id="feedback-hero">
    <div class="hero-content">
        <h1>We Value Your Feedback</h1>
        <h2>Help us serve you better.</h2>
        <a href="#feedback-form" class="btn">Share Your Thoughts</a>
    </div>
</section>

<!-- Feedback Form Section -->
<section id="feedback-form" class="section">
    <div class="container">
        <div class="section-title">
            <h2>Share Your Thoughts</h2>
            <div class="underline"></div>
        </div>
        <div class="feedback-form-container">
            <form class="feedback-form" id="feedbackForm">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Rating:</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" /><label for="star5"
                            title="5 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4"
                            title="4 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3"
                            title="3 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2"
                            title="2 stars"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1"
                            title="1 star"><i class="fas fa-star"></i></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="suggestions">Feedback / Suggestions:</label>
                    <textarea id="suggestions" name="suggestions" rows="6" required></textarea>
                </div>
                <button type="submit" class="btn">Submit Feedback</button>
            </form>
        </div>
    </div>
</section>

<!-- Why Feedback Matters Section -->
<section id="why-feedback" class="section">
    <div class="container">
        <div class="section-title">
            <h2>Why Your Feedback Matters</h2>
            <div class="underline"></div>
        </div>
        <div class="why-feedback-intro">
            <p>At Elegance Salon, your voice is invaluable. We are dedicated to providing an exceptional beauty
                experience, and your thoughts and suggestions are crucial for our continuous improvement. Help us
                tailor our services to perfection.</p>
        </div>
        <div class="why-feedback-grid">
            <div class="feedback-benefit-card">
                <i class="fas fa-lightbulb"></i>
                <h3>Innovate & Improve</h3>
                <p>Your suggestions fuel our creativity, helping us to introduce new services and refine existing
                    ones.</p>
            </div>
            <div class="feedback-benefit-card">
                <i class="fas fa-star-half-alt"></i>
                <h3>Elevate Your Experience</h3>
                <p>We use your insights to ensure every visit is comfortable, satisfying, and exceeds your
                    expectations.</p>
            </div>
            <div class="feedback-benefit-card">
                <i class="fas fa-hands-helping"></i>
                <h3>Build Our Community</h3>
                <p>By sharing your feedback, you become an integral part of the Elegance Salon family and our
                    journey to excellence.</p>
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

<script src="js/feedback.js">
    </script>
</body>
</html>