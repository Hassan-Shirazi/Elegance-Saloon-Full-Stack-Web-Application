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

            // Close mobile menu when clicking on a nav item
            const navLinks = document.querySelectorAll('.nav-menu a');
            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (navMenu.classList.contains('active') && window.innerWidth <= 768) {
                        navMenu.classList.remove('active');
                        menuToggle.querySelector('i').classList.add('fa-bars');
                        menuToggle.querySelector('i').classList.remove('fa-times');
                    }
                });
            });

            // Smooth scrolling for local anchor links (e.g., #contact-hero)
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        const headerHeight = document.querySelector('header').offsetHeight;
                        const offset = headerHeight + 10; // Extra padding below header

                        window.scrollTo({
                            top: targetElement.offsetTop - offset,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Header scroll effect
            const header = document.querySelector('header');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    header.style.padding = '5px 0';
                    header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                } else {
                    header.style.padding = '10px 0';
                    header.style.boxShadow = 'none';
                }
            });

          
        });