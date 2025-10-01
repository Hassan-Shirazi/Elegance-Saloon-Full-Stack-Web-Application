 document.addEventListener('DOMContentLoaded', function () {
            // Mobile Menu Toggle
            const menuToggle = document.querySelector('.menu-toggle');
            const navMenu = document.querySelector('.nav-menu');

            if (menuToggle) {
                menuToggle.addEventListener('click', function () {
                    navMenu.classList.toggle('active');
                    menuToggle.querySelector('i').classList.toggle('fa-bars');
                    menuToggle.querySelector('i').classList.toggle('fa-times');
                });
            }

            // Close mobile menu when clicking on a nav item (excluding buttons)
            const navLinks = document.querySelectorAll('.nav-menu a:not(.btn-nav)');
            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    // Only close if the menu is active and it's a mobile view
                    if (navMenu.classList.contains('active') && window.innerWidth <= 768) {
                        navMenu.classList.remove('active');
                        menuToggle.querySelector('i').classList.add('fa-bars');
                        menuToggle.querySelector('i').classList.remove('fa-times');
                    }
                });
            });

            // Smooth scrolling for all anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        const headerHeight = document.querySelector('header').offsetHeight; // Dynamically get header height
                        // For the hero section (or header itself), scroll to the very top, otherwise add offset
                        const offset = (targetId === '#hero' || targetId === '#header') ? 0 : headerHeight + 10;

                        window.scrollTo({
                            top: targetElement.offsetTop - offset,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Active menu item based on scroll position
            const sections = document.querySelectorAll('section:not(#footer)'); // Exclude footer from active section logic
            const navItems = document.querySelectorAll('.nav-menu a:not(.btn-nav)'); // Exclude buttons from active state

            window.addEventListener('scroll', function () {
                let current = '';
                const headerOffset = document.querySelector('header').offsetHeight + 50; // Offset from header

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionBottom = sectionTop + section.clientHeight;
                    if (pageYOffset + headerOffset >= sectionTop && pageYOffset + headerOffset < sectionBottom) {
                        current = section.getAttribute('id');
                    }
                });

                navItems.forEach(item => {
                    item.classList.remove('active');
                    // Ensure href starts with # and matches current section ID (e.g., #about matches 'about')
                    // Special handling for the #header (Home) link.
                    const hrefId = item.getAttribute('href').substring(1);
                    if (hrefId === current || (hrefId === 'header' && current === 'hero')) { // Consider 'hero' as 'home' for navigation
                        item.classList.add('active');
                    }
                });

                // Special case for Home: if at the very top, activate Home
                if (window.scrollY < headerOffset / 2) { // A threshold near the top
                    navItems.forEach(item => item.classList.remove('active'));
                    const homeLink = document.querySelector('.nav-menu a[href="#header"]');
                    if (homeLink) homeLink.classList.add('active');
                }
            });

            // Header scroll effect
            const header = document.querySelector('header');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    // MODIFIED: Smaller padding when scrolled
                    header.style.padding = '5px 0';
                    header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                } else {
                    // MODIFIED: Smaller initial padding
                    header.style.padding = '10px 0';
                    header.style.boxShadow = 'none';
                }
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