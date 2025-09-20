    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleLogoutDropdown() {
            const dropdown = document.getElementById('logoutDropdown');
            dropdown.classList.toggle('active');
        }

        function handleLogout() {
            // Add logout logic here (e.g., redirect or API call)
            alert('Logged out!'); // Placeholder action
            document.getElementById('logoutDropdown').classList.remove('active');
        }

        // Close dropdown if clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('logoutDropdown');
            const icon = document.querySelector('.logout-icon');
            if (!icon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
</body>

</html>
