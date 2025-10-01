document.addEventListener('DOMContentLoaded', function () {
        // Smooth scrolling for all anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    // Small offset for smooth scroll to section start
                    const offset = 10; 
                    window.scrollTo({
                        top: targetElement.offsetTop - offset,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation to benefit cards on scroll
        const benefitCards = document.querySelectorAll('.feedback-benefit-card');
        const animateCardsOnScroll = function () {
            benefitCards.forEach(card => {
                const cardPosition = card.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;

                if (cardPosition < screenPosition) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        };

        benefitCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
        });

        window.addEventListener('scroll', animateCardsOnScroll);
        animateCardsOnScroll(); // Trigger on load to check visible elements


        // Feedback Form Submission Logic
        const feedbackForm = document.getElementById('feedbackForm');
        if (feedbackForm) {
            feedbackForm.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent actual form submission

                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const rating = document.querySelector('input[name="rating"]:checked');
                const suggestions = document.getElementById('suggestions').value;

                if (!name || !email || !rating || !suggestions) {
                    alert('Please fill in all fields and provide a rating.');
                    return;
                }

                alert('Thank you, ' + name + '! Your feedback has been submitted successfully.');

                // Clear the form
                feedbackForm.reset();
                // Optional: reset star rating display if needed (e.g., remove gold color)
                document.querySelectorAll('.star-rating input').forEach(input => input.checked = false);
            });
        }
    });
