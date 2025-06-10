<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: #5B1F1F;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        z-index: 1001;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .navbar-left {
        display: flex;
        align-items: center;
    }

    .toggle-btn {
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .toggle-btn span {
        font-size: 24px;
        background: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .toggle-btn:hover {
        background: rgba(236, 195, 92, 0.1);
    }

    .navbar-center {
        flex: 1;
        text-align: center;
    }

    .university-name {
        font-size: 37px;
        font-weight: 600;
        background: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        font-family: 'Times New Roman', Times, serif;
    }

    .navbar-right {
        display: flex;
        align-items: center;
    }

    .profile-container {
        position: relative;
    }

    .profile-icon {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 5px;
        transition: all 0.3s ease;
        background: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #5B1F1F;
        font-weight: 500;
    }

    .profile-icon img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 200px;
        background: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: none;
        z-index: 1000;
        margin-top: 5px;
        overflow: hidden;
    }

    .profile-dropdown ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .profile-dropdown ul li {
        padding: 12px 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        color: #5B1F1F;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .profile-dropdown ul li i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .navbar {
            padding: 0 10px;
        }

        .university-name {
            font-size: 18px;
        }

        .profile-icon span:not(:first-child) {
            display: none;
        }

        .profile-icon img {
            margin-right: 0;
        }
    }
</style>

<header class="navbar">
    <div class="navbar-left">
        <div class="toggle-btn" id="toggle-btn">
            <span>&#9776;</span> <!-- Hamburger menu icon -->
        </div>
    </div>
    <div class="navbar-center">
        <span class="university-name">GM UNIVERSITY</span>
    </div>
    <div class="navbar-right">
        <div class="profile-container">
            <span class="profile-icon" id="profileIcon">
                <img src="Icons/admin.png" alt="Profile Picture">
                Admin
            </span>
            <div class="profile-dropdown" id="profileDropdown">
                <ul>
                    <li><i class="fas fa-user"></i> Profile</li>
                    <li><i class="fas fa-cog"></i> Settings</li>
                    <li><i class="fas fa-question-circle"></i> Help</li>
                    <li><i class="fas fa-lock"></i> Lock</li>
                    <li><i class="fas fa-sign-out-alt"></i> Log Out</li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileIcon = document.getElementById('profileIcon');
    const profileDropdown = document.getElementById('profileDropdown');

    // Toggle profile dropdown on click with animation
    profileIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        
        if (profileDropdown.style.display === 'block') {
            // Add fade-out animation
            profileDropdown.style.transition = 'opacity 0.2s ease-out';
            profileDropdown.style.opacity = '0';
            
            // Hide after fade out
            setTimeout(() => {
                profileDropdown.style.display = 'none';
                profileDropdown.style.opacity = '1';
                profileDropdown.style.transition = '';
            }, 200);
        } else {
            // Add fade-in animation
            profileDropdown.style.transition = 'opacity 0.2s ease-in';
            profileDropdown.style.opacity = '0';
            profileDropdown.style.display = 'block';
            
            // Trigger reflow to ensure transition works
            profileDropdown.offsetHeight;
            
            profileDropdown.style.opacity = '1';
            
            // Remove transition after animation
            setTimeout(() => {
                profileDropdown.style.transition = '';
            }, 200);
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        if (profileDropdown.style.display === 'block') {
            // Add fade-out animation
            profileDropdown.style.transition = 'opacity 0.2s ease-out';
            profileDropdown.style.opacity = '0';
            
            // Hide after fade out
            setTimeout(() => {
                profileDropdown.style.display = 'none';
                profileDropdown.style.opacity = '1';
                profileDropdown.style.transition = '';
            }, 200);
        }
    });

    // Prevent dropdown from closing when clicking inside it
    profileDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Handle dropdown items click
    const dropdownItems = profileDropdown.querySelectorAll('li');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            // Handle each menu item click
            const action = this.textContent.trim();
            switch(action) {
                case 'Profile':
                    // Handle profile action
                    break;
                case 'Settings':
                    // Handle settings action
                    break;
                case 'Help':
                    // Handle help action
                    break;
                case 'Lock':
                    // Handle lock action
                    break;
                case 'Log Out':
                    // Handle logout action
                    break;
            }
            
            // Add fade-out animation before closing
            profileDropdown.style.transition = 'opacity 0.2s ease-out';
            profileDropdown.style.opacity = '0';
            
            // Hide after fade out
            setTimeout(() => {
                profileDropdown.style.display = 'none';
                profileDropdown.style.opacity = '1';
                profileDropdown.style.transition = '';
            }, 200);
        });
    });
});
</script>