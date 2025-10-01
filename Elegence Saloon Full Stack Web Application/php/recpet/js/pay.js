 // Modal functions
        function openModal() {
            document.getElementById('paymentModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Record New Payment';
            document.getElementById('formAction').value = 'add';
            document.getElementById('paymentForm').reset();
            document.getElementById('paymentId').value = '';
            
            // Set today's date as default
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('payment_date').value = today;
        }

        function closeModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        function editPayment(id) {
            // In a real application, you would fetch the payment data via AJAX
            // For simplicity, we'll redirect to a pre-filled form
            window.location.href = 'payment_system.php?edit=' + id;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Set today's date as default for new payments
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('payment_date').value = today;
            
            // Check if we're editing a payment (from URL parameter)
            const urlParams = new URLSearchParams(window.location.search);
            const editId = urlParams.get('edit');
            
            if (editId) {
                // In a real application, you would fetch the payment data via AJAX
                // For this example, we'll show a message
                alert('Edit functionality would load payment ID: ' + editId + '. In a full implementation, this would pre-fill the form with payment data.');
                // Remove the parameter from URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });