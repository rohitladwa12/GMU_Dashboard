<!-- SIDEBAR CODE START -->
<style>
    /*
     * Enhanced professional look for sidebar, keeping the same theme and layout.
     * Subtle improvements: more modern shadow, smoother transitions, better spacing, and font polish.
     */
    .sidebar {
        position: fixed;
        top: 60px;
        left: 0;
        height: 100vh;
        width: 230px;
        background: #5B1F1F;
        padding: 28px 20px 28px 20px;
        transition: all 0.3s cubic-bezier(.4,0,.2,1);
        z-index: 1000;
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: 0 10px 36px 0 rgba(44, 19, 19, 0.25), 0 2px 8px rgba(0,0,0,0.10);
        border-top-right-radius: 18px;
        border-bottom-right-radius: 18px;
    }

    .sidebar.collapsed {
        width: 90px;
        padding: 28px 8px;
        border-radius: 0 18px 18px 0;
    }

    .sidebar .profile {
        text-align: center;
        margin-bottom: 34px;
        color: #ecc35c;
        padding: 20px 10px 14px 10px;
        background: rgba(236,195,92,0.09);
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(236,195,92,0.10);
    }

    .sidebar .profile img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        margin-bottom: 10px;
        border: 2.5px solid #ecc35c;
        box-shadow: 0 2px 8px rgba(236,195,92,0.18);
    }

    .sidebar.collapsed .profile img {
        width: 40px;
        height: 40px;
        margin-bottom: 0;
    }

    .sidebar .profile h3 {
        margin: 10px 0 2px;
        color: #ecc35c;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-family: 'Segoe UI', 'Arial', sans-serif;
    }

    .sidebar .profile p {
        color: #ecc35c;
        font-size: 13px;
        margin: 0;
        font-weight: 400;
        opacity: 0.85;
    }

    .sidebar.collapsed .profile h3,
    .sidebar.collapsed .profile p {
        display: none;
    }

    .sidebar nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 15px;
    }

    .sidebar nav ul li {
        margin-bottom: 20px;
    }

    .sidebar .dropbtn {
        display: flex;
        align-items: center;
        padding: 13px 18px;
        text-decoration: none;
        background: linear-gradient(90deg, #ecc35c 0%, #f7f3b7 60%, #ecc35c 100%);
        color: #5B1F1F;
        border-radius: 8px;
        transition: box-shadow 0.2s, background 0.2s, color 0.2s, transform 0.2s;
        font-size: 15px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(236,195,92,0.10);
        letter-spacing: 0.2px;
        position: relative;
    }

    .sidebar .dropbtn:hover, .sidebar .dropbtn:focus {
        background: linear-gradient(90deg, #f7f3b7 0%, #ecc35c 100%);
        color: #3d1818;
        box-shadow: 0 6px 20px rgba(236,195,92,0.16);
        outline: none;
        transform: translateY(-2px) scale(1.03);
    }

    .sidebar .dropbtn i {
        margin-right: 14px;
        width: 28px;
        text-align: center;
        font-size: 1.5em;
        transition: color 0.2s;
        color: #5B1F1F;
    }

    .sidebar.collapsed .dropbtn {
        padding: 16px 8px;
        justify-content: center;
    }

    .sidebar.collapsed .dropbtn i {
        margin-right: 0;
        font-size: 1.6em;
    }

    .sidebar .menu-text {
        flex: 1;
        transition: opacity 0.3s;
        font-size: 15px;
        font-family: 'Segoe UI', 'Arial', sans-serif;
    }

    .sidebar.collapsed .menu-text {
        display: none;
    }

    .sidebar .arrow {
        margin-left: 10px;
        transition: transform 0.3s cubic-bezier(.4,0,.2,1);
        font-size: 1.1em;
        opacity: 0.7;
    }

    .sidebar.collapsed .arrow {
        display: none;
    }

    .dropdown-content {
        display: none;
        background: linear-gradient(90deg, #ecc35c 0%, #f7f3b7 60%, #ecc35c 100%);
        margin-left: 20px;
        margin-top: 8px;
        border-radius: 8px;
        overflow: hidden;
        padding: 8px 6px;
        margin-bottom: 24px;
        box-shadow: 0 2px 14px rgba(236,195,92,0.13);
        min-width: 170px;
    }

    .dropdown-content a {
        padding: 11px 18px;
        text-decoration: none;
        display: block;
        color: #5B1F1F;
        transition: background 0.18s, color 0.18s, transform 0.18s;
        border-radius: 6px;
        margin: 5px 0;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Segoe UI', 'Arial', sans-serif;
        letter-spacing: 0.1px;
    }

    .dropdown-content a:first-child {
        margin-top: 0;
    }

    .dropdown-content a:last-child {
        margin-bottom: 0;
    }

    .dropdown-content a:hover, .dropdown-content a:focus {
        background: rgba(91, 31, 31, 0.13);
        color: #3d1818;
        transform: translateX(7px) scale(1.04);
        outline: none;
    }

    .sidebar.collapsed .dropdown-content {
        position: absolute;
        left: 85px;
        margin-left: 5px;
        margin-top: -40px;
        min-width: 200px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.13);
    }

    /* Hide scrollbar but keep functionality */
    .sidebar::-webkit-scrollbar {
        width: 0px;
    }
    .sidebar {
        scrollbar-width: none;
    }
</style>

<div class="sidebar" id="sidebar">
    <nav>
        <ul>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="menu-text">Dashboard</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="index.php">Dashboard 1</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Events">
                    <i class="fas fa-user-graduate"></i>
                    <span class="menu-text">Admissions</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="ad_enquiry.php">Admission Enquiry</a>
                    <a href="seat_matrix.php">Seat Matrix</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Professors">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="menu-text">Teachers</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="#">All Professors</a>
                    <a href="#">Add Professor</a>
                    <a href="#">Edit Professor</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Students">
                    <i class="fas fa-users"></i>
                    <span class="menu-text">Students</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="#">Finalised Students</a>
                    <a href="#">Add Student</a>
                    <a href="#">Edit Student</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Courses">
                    <i class="fas fa-book"></i>
                    <span class="menu-text">Courses</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="#">All Courses</a>
                    <a href="#">Add Course</a>
                    <a href="#">Edit Course</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Library">
                    <i class="fas fa-book-reader"></i>
                    <span class="menu-text">Library</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="#">Library Assets</a>
                    <a href="#">Add Library Assets</a>
                    <a href="#">Add Assets</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Department">
                    <i class="fas fa-building"></i>
                    <span class="menu-text">Departments</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="#">All Department</a>
                    <a href="#">Add Department</a>
                    <a href="#">Edit Department</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" data-label="Staff">
                    <i class="fas fa-user-tie"></i>
                    <span class="menu-text">Staff</span>
                    <span class="arrow">&#9654;</span>
                </a>
                <div class="dropdown-content">
                    <a href="#">All Staff</a>
                    <a href="#">Add Staff</a>
                    <a href="#">Edit Staff</a>
                </div>
            </li>
        </ul>
    </nav>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-btn');
    const dropdowns = document.querySelectorAll('.dropdown');
    
    // Toggle sidebar collapse
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            // If sidebar is expanded and about to collapse, close all dropdowns first
            if (!sidebar.classList.contains('collapsed')) {
                // Close all dropdowns with animation
                dropdowns.forEach(dropdown => {
                    const dropdownContent = dropdown.querySelector('.dropdown-content');
                    const arrow = dropdown.querySelector('.arrow');
                    
                    // Add transition for smooth closing
                    dropdownContent.style.transition = 'opacity 0.2s ease-out';
                    dropdownContent.style.opacity = '0';
                    
                    // After fade out, hide the dropdown
                    setTimeout(() => {
                        dropdownContent.style.display = 'none';
                        dropdownContent.style.opacity = '1';
                        dropdownContent.style.transition = '';
                        if (arrow) arrow.style.transform = 'rotate(0deg)';
                    }, 200);
                });
            }

            // Toggle sidebar collapse after dropdown animation
            setTimeout(() => {
                sidebar.classList.toggle('collapsed');
                document.querySelector('.content').style.marginLeft = 
                    sidebar.classList.contains('collapsed') ? '90px' : '250px';
            }, sidebar.classList.contains('collapsed') ? 0 : 200);
        });
    }

    // Handle dropdown menus and sidebar expansion
    dropdowns.forEach(dropdown => {
        const dropbtn = dropdown.querySelector('.dropbtn');
        const dropdownContent = dropdown.querySelector('.dropdown-content');

        // Handle click on menu items
        dropbtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            // If sidebar is collapsed, expand it first
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                document.querySelector('.content').style.marginLeft = '250px';
                
                // Small delay to allow sidebar expansion before showing dropdown
                setTimeout(() => {
                    showDropdown(dropdown);
                }, 300);
            } else {
                // If sidebar is already expanded, toggle the clicked dropdown
                toggleDropdown(dropdown);
            }
        });

        // Handle click on dropdown items
        dropdownContent.querySelectorAll('a').forEach(item => {
            item.addEventListener('click', (e) => {
                // If sidebar is collapsed, prevent immediate navigation
                if (sidebar.classList.contains('collapsed')) {
                    e.preventDefault();
                    sidebar.classList.remove('collapsed');
                    document.querySelector('.content').style.marginLeft = '250px';
                    
                    // Navigate after sidebar expansion
                    setTimeout(() => {
                        window.location.href = item.href;
                    }, 300);
                }
            });
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
        dropdowns.forEach(dropdown => {
            hideDropdown(dropdown);
        });
    });

    // Prevent dropdown close when clicking inside dropdown content
    document.querySelectorAll('.dropdown-content').forEach(content => {
        content.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });

    // Helper functions for dropdown management
    function showDropdown(dropdown) {
        // Hide all other dropdowns first
        dropdowns.forEach(d => {
            if (d !== dropdown) {
                hideDropdown(d);
            }
        });

        const dropdownContent = dropdown.querySelector('.dropdown-content');
        const arrow = dropdown.querySelector('.arrow');
        
        // Add fade-in animation
        dropdownContent.style.transition = 'opacity 0.2s ease-in';
        dropdownContent.style.opacity = '0';
        dropdownContent.style.display = 'block';
        
        // Trigger reflow to ensure transition works
        dropdownContent.offsetHeight;
        
        dropdownContent.style.opacity = '1';
        if (arrow) arrow.style.transform = 'rotate(90deg)';
        
        // Remove transition after animation
        setTimeout(() => {
            dropdownContent.style.transition = '';
        }, 200);
    }

    function hideDropdown(dropdown) {
        const dropdownContent = dropdown.querySelector('.dropdown-content');
        const arrow = dropdown.querySelector('.arrow');
        
        // Add fade-out animation
        dropdownContent.style.transition = 'opacity 0.2s ease-out';
        dropdownContent.style.opacity = '0';
        
        // Hide after fade out
        setTimeout(() => {
            dropdownContent.style.display = 'none';
            dropdownContent.style.opacity = '1';
            dropdownContent.style.transition = '';
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }, 200);
    }

    function toggleDropdown(dropdown) {
        const dropdownContent = dropdown.querySelector('.dropdown-content');
        const isVisible = dropdownContent.style.display === 'block';
        
        if (isVisible) {
            hideDropdown(dropdown);
        } else {
            showDropdown(dropdown);
        }
    }

    // Handle touch events for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    document.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    document.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchEndX - touchStartX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0 && sidebar.classList.contains('collapsed')) {
                // Swipe right to expand
                sidebar.classList.remove('collapsed');
                document.querySelector('.content').style.marginLeft = '250px';
            } else if (diff < 0 && !sidebar.classList.contains('collapsed')) {
                // Close all dropdowns first
                dropdowns.forEach(dropdown => hideDropdown(dropdown));
                
                // Then collapse sidebar after a small delay
                setTimeout(() => {
                    sidebar.classList.add('collapsed');
                    document.querySelector('.content').style.marginLeft = '90px';
                }, 200);
            }
        }
    }
});
</script>