document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('appointmentForm');
            const successMessage = document.getElementById('successMessage');
            const cancelBtn = document.getElementById('cancelBtn');
            const timeSlotsContainer = document.getElementById('timeSlots');
            
            // Generate time slots (9:00 AM to 5:00 PM)
            function generateTimeSlots() {
                const timeSlots = [];
                for (let hour = 9; hour <= 17; hour++) {
                    for (let minute = 0; minute < 60; minute += 30) {
                        if (hour === 17 && minute === 30) break; // Stop at 5:00 PM
                        
                        const period = hour >= 12 ? 'PM' : 'AM';
                        const displayHour = hour > 12 ? hour - 12 : hour;
                        const displayMinute = minute === 0 ? '00' : minute;
                        
                        timeSlots.push(`${displayHour}:${displayMinute} ${period}`);
                    }
                }
                
                return timeSlots;
            }
            
            // Render time slots
            function renderTimeSlots() {
                const timeSlots = generateTimeSlots();
                timeSlotsContainer.innerHTML = '';
                
                timeSlots.forEach(slot => {
                    const slotElement = document.createElement('div');
                    slotElement.className = 'time-slot';
                    slotElement.textContent = slot;
                    slotElement.addEventListener('click', function() {
                        // Remove selected class from all slots
                        document.querySelectorAll('.time-slot').forEach(s => {
                            s.classList.remove('selected');
                        });
                        // Add selected class to clicked slot
                        this.classList.add('selected');
                        updateSummary();
                    });
                    
                    // Randomly disable some slots for demo purposes
                    if (Math.random() > 0.7) {
                        slotElement.classList.add('disabled');
                        slotElement.addEventListener('click', null);
                    }
                    
                    timeSlotsContainer.appendChild(slotElement);
                });
            }
            
            // Update appointment summary
            function updateSummary() {
                document.getElementById('summaryClient').textContent = 
                    document.getElementById('clientName').value || '-';
                
                const serviceSelect = document.getElementById('service');
                document.getElementById('summaryService').textContent = 
                    serviceSelect.options[serviceSelect.selectedIndex].text || '-';
                
                const stylistSelect = document.getElementById('stylist');
                document.getElementById('summaryStylist').textContent = 
                    stylistSelect.options[stylistSelect.selectedIndex].text || '-';
                
                const date = document.getElementById('date').value;
                const timeSlot = document.querySelector('.time-slot.selected');
                const time = timeSlot ? timeSlot.textContent : '-';
                
                if (date && time !== '-') {
                    const dateObj = new Date(date);
                    const formattedDate = dateObj.toLocaleDateString('en-US', { 
                        weekday: 'short', 
                        year: 'numeric', 
                        month: 'short', 
                        day: 'numeric' 
                    });
                    document.getElementById('summaryDateTime').textContent = `${formattedDate} at ${time}`;
                } else {
                    document.getElementById('summaryDateTime').textContent = '-';
                }
            }
            
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').min = today;
            
            // Set default date to tomorrow
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById('date').value = tomorrow.toISOString().split('T')[0];
            
            // Initialize time slots
            renderTimeSlots();
            
            // Add event listeners for real-time summary updates
            document.getElementById('clientName').addEventListener('input', updateSummary);
            document.getElementById('service').addEventListener('change', updateSummary);
            document.getElementById('stylist').addEventListener('change', updateSummary);
            document.getElementById('date').addEventListener('change', updateSummary);
            
            // Cancel button action
            cancelBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                    form.reset();
                    renderTimeSlots();
                    updateSummary();
                }
            });
            
            // Form validation and submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Reset previous errors
                resetErrors();
                
                // Get form values
                const clientName = document.getElementById('clientName').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const email = document.getElementById('email').value.trim();
                const service = document.getElementById('service').value;
                const stylist = document.getElementById('stylist').value;
                const date = document.getElementById('date').value;
                const timeSlot = document.querySelector('.time-slot.selected');
                
                let isValid = true;
                
                // Validate client name
                if (clientName === '' || clientName.length < 2) {
                    showError('clientName', 'nameError');
                    isValid = false;
                }
                
                // Validate phone
                const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                const cleanPhone = phone.replace(/\D/g, '');
                if (!phoneRegex.test(cleanPhone)) {
                    showError('phone', 'phoneError');
                    isValid = false;
                }
                
                // Validate email if provided
                if (email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        showError('email', 'emailError');
                        isValid = false;
                    }
                }
                
                // Validate service
                if (!service) {
                    showError('service', 'serviceError');
                    isValid = false;
                }
                
                // Validate stylist
                if (!stylist) {
                    showError('stylist', 'stylistError');
                    isValid = false;
                }
                
                // Validate date
                if (!date) {
                    showError('date', 'dateError');
                    isValid = false;
                }
                
                // Validate time slot
                if (!timeSlot || timeSlot.classList.contains('disabled')) {
                    document.getElementById('timeError').style.display = 'block';
                    isValid = false;
                }
                
                // If form is valid, show success message
                if (isValid) {
                    successMessage.style.display = 'block';
                    
                    // Scroll to top to show success message
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    
                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 5000);
                }
            });
            
            // Helper function to show error
            function showError(inputId, errorId) {
                const inputElement = document.getElementById(inputId);
                if (inputElement) {
                    inputElement.classList.add('error');
                }
                document.getElementById(errorId).style.display = 'block';
            }
            
            // Helper function to reset errors
            function resetErrors() {
                const errorInputs = document.querySelectorAll('.error');
                const errorMessages = document.querySelectorAll('.error-message');
                
                errorInputs.forEach(input => {
                    input.classList.remove('error');
                });
                
                errorMessages.forEach(message => {
                    message.style.display = 'none';
                });
                
                successMessage.style.display = 'none';
            }
            
            // Initial summary update
            updateSummary();
        });