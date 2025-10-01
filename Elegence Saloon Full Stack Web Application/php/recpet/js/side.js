  // Toggle sidebar on mobile
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        // Close sidebar when clicking on overlay
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Set active menu item
        const menuLinks = document.querySelectorAll('.menu-link');
        
        menuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                // Remove active class from all links
                menuLinks.forEach(item => item.classList.remove('active'));
                
                // Add active class to clicked link
                e.currentTarget.classList.add('active');
                
                // Close sidebar on mobile after selection
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });