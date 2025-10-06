<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleLogoutDropdown() {
        const dropdown = document.getElementById('logoutDropdown');
        dropdown.classList.toggle('active');
    }

    function handleLogout() {
        // Close dropdown
        document.getElementById('logoutDropdown').classList.remove('active');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'logout.php'; // Redirect to server-side logout
            }
        });
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