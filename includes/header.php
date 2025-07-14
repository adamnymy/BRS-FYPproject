<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="main-header">
    <div class="container header-container">
        <div class="logo">
            <a href="index.php">M&P <span>Barbershop</span></a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">Services</a></li>
                <li><a href="barbers.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'barbers.php' ? 'active' : ''; ?>">Our Barbers</a></li>
                <li><a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a></li>
                <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                <li<?php if (basename($_SERVER['PHP_SELF']) == 'booking.php') echo ' class="active"'; ?>><a href="booking.php" class="book-btn">Book Now</a></li>
            </ul>
        </nav>
        <div class="profile-section">
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="admin/dashboard.php" class="admin-btn">
                        <i class="fas fa-crown"></i>
                        <span>Admin</span>
                    </a>
                <?php else: ?>
                    <a href="customer_dashboard/c_dashboard.php" class="profile-icon">
                        <i class="fas fa-user"></i>
                        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="login.php" class="login-btn">
                        <i class="fas fa-user"></i>
                        <span>Login</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<style>
.main-header {
    background-color: #1a1a1a;
    padding: 10px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.logo a {
    color: #d4af37;
    text-decoration: none;
    font-size: 24px;
    font-weight: bold;
}

.logo span {
    color: #ffffff;
}

nav ul {
    display: flex;
    align-items: center;
    gap: 30px;
    list-style: none;
    margin: 0;
    padding: 0;
}

nav ul li a {
    color: #ffffff;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #d4af37;
}

.book-btn {
    padding: 8px 20px;
    background: #d4af37;
    color: #1a1a1a !important;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.book-btn:hover {
    background: #c4a032;
    transform: translateY(-1px);
}

.profile-section {
    margin-left: 20px;
}

.profile-icon {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 15px;
    border-radius: 25px;
    background: #d4af37;
    color: #1a1a1a;
    transition: all 0.3s ease;
}

.profile-icon:hover {
    background: #c4a032;
}

.profile-icon i {
    color: #1a1a1a;
}

.login-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    border-radius: 25px;
    background: #d4af37;
    color: #1a1a1a;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.login-btn:hover {
    background: #c4a032;
    transform: translateY(-1px);
}

.login-btn i {
    color: #1a1a1a;
}

.admin-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    border-radius: 25px;
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(255,107,107,0.3);
}

.admin-btn:hover {
    background: linear-gradient(135deg, #ee5a24, #d63031);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255,107,107,0.4);
}

.admin-btn i {
    color: #fff;
    font-size: 1.1em;
}

.admin-login-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 25px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(102,126,234,0.3);
    font-size: 0.9em;
}

.admin-login-btn:hover {
    background: linear-gradient(135deg, #764ba2, #667eea);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102,126,234,0.4);
}

.admin-login-btn i {
    color: #fff;
    font-size: 1em;
}

.dropdown {
    position: relative;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: auto;  /* Changed from right: 0 */
    left: 0;      /* Keep this */
    top: 100%;
    background-color: #1a1a1a;
    min-width: 200px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    border-radius: 8px;
    padding: 10px 0;
    margin-top: 10px;
    z-index: 1001;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-menu a {
    color: #ffffff;
    padding: 12px 20px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.dropdown-menu a:hover {
    background-color: #2a2a2a;
    color: #d4af37;
}

.dropdown-menu i {
    color: #d4af37;
}

nav ul li a.active {
    border-bottom: 3px solid #d4af37;
    color: #d4af37 !important;
    font-weight: bold;
    transition: border-bottom 0.2s, color 0.2s;
}

li.active .book-btn {
    color: #181818 !important;
    font-weight: 700 !important;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (dropdown && dropdownMenu) {
        // Toggle dropdown on click
        dropdown.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
});
</script>