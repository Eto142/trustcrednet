
        </div>
        <!-- Admin Content End -->
    </main>
    <!-- Main End -->

    <!-- JavaScript -->
    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Admin Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle
            const sidebar = document.getElementById('adminSidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.innerWidth <= 992) {
                        document.body.classList.toggle('sidebar-open');
                    } else {
                        sidebar.classList.toggle('collapsed');
                    }
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    document.body.classList.remove('sidebar-open');
                });
            }

            // Close sidebar on nav link click (mobile)
            document.querySelectorAll('.admin-sidebar .nav-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        document.body.classList.remove('sidebar-open');
                    }
                });
            });

            // Close sidebar on window resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    document.body.classList.remove('sidebar-open');
                }
            });

            // Profile Dropdown Toggle
            const profileToggle = document.getElementById('profileDropdownToggle');
            const profileDropdown = document.getElementById('profileDropdown');

            if (profileToggle && profileDropdown) {
                profileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!profileToggle.contains(e.target)) {
                        profileDropdown.classList.remove('show');
                    }
                });
            }

            // Auto-dismiss alerts after 5 seconds
            document.querySelectorAll('.admin-alert').forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(function() { alert.remove(); }, 300);
                }, 5000);
            });

            // Responsive table data labels
            document.querySelectorAll('.admin-table').forEach(function(table) {
                const headers = Array.from(table.querySelectorAll('th')).map(function(th) { return th.textContent.trim(); });
                table.querySelectorAll('tbody tr').forEach(function(row) {
                    row.querySelectorAll('td').forEach(function(cell, index) {
                        if (headers[index]) {
                            cell.setAttribute('data-label', headers[index]);
                        }
                    });
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>