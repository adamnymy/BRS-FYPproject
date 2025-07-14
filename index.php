<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M&P Barbershop - Premium Grooming Services</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg hero-bg-1"></div>
        <div class="hero-bg hero-bg-2"></div>
        <div class="container">
            <div class="hero-content">
                <h1>Premium Barber Services at M&P</h1>
                <p>Experience the perfect blend of traditional barbering and modern styling at M&P Barbershop</p>
                <a href="booking.php" class="btn">Book Now</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <div class="section-title">
                <h2>Our Services</h2>
                <p>M&P Barbershop offers a wide range of grooming services to keep you looking sharp and fresh</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="images/classicHaircut-services.webp" alt="Haircut Service">
                    </div>
                    <div class="service-content">
                        <h3>Classic Haircut</h3>
                        <p>Professional haircut with styling using premium products for that perfect look.</p>
                        <div class="price">RM13</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="images/beardtrim-services.jpg" alt="Beard Trim">
                    </div>
                    <div class="service-content">
                        <h3>Beard Trim & Shape</h3>
                        <p>Precision beard trimming and shaping to maintain your perfect facial hair style.</p>
                        <div class="price">RM20</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="images/hottowel-services.webp" alt="Hot Towel Shave">
                    </div>
                    <div class="service-content">
                        <h3>Hot Towel Shave</h3>
                        <p>Traditional straight razor shave with hot towels and premium shaving products.</p>
                        <div class="price">RM24</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Barbers Section -->
    <section class="barbers">
        <div class="container">
            <div class="section-title">
                <h2>Meet Our Barbers</h2>
                <p>Our skilled professionals at M&P Barbershop are ready to give you the perfect cut and style</p>
            </div>
            <div class="barbers-grid">
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="images/adib-barber.jpg" alt="Barber Adib">
                    </div>
                    <div class="barber-info">
                        <h3>Adib Hafiz</h3>
                        <p>Master Barber</p>
                        <p>15 years experience</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="images/nuqman-barber.jpg" alt="Barber Nuqman">
                    </div>
                    <div class="barber-info">
                        <h3>Nuqman Hazim</h3>
                        <p>Beard Specialist</p>
                        <p>12 years experience</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="images/hanif-barber.jpg" alt="Barber Hanif">
                    </div>
                    <div class="barber-info">
                        <h3>Hanif Ridzuan</h3>
                        <p>Styling Expert</p>
                        <p>8 years experience</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section class="booking">
        <div class="container">
            <div class="section-title">
                <h2>Book Your Appointment</h2>
                <p>Reserve your spot at M&P Barbershop and we'll take care of the rest</p>
            </div>
            <div class="booking-container">
                <div class="booking-img">
                    <img src="images/animate-interior.gif" alt="M&P Barbershop Interior">
                </div>
                <div class="booking-form">
                    <form action="process_booking.php" method="POST">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="service">Service</label>
                            <select id="service" name="service" required>
                                <option value="">Select a service</option>
                                <?php
                                require_once 'config/db.php';
                                // Fetch services from database for the booking form
                                $stmt = $pdo->query("SELECT id, service_name, price FROM services WHERE status = 'active'");
                                $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($services as $service): ?>
                                    <option value="<?php echo htmlspecialchars($service['id']); ?>">
                                        <?php echo htmlspecialchars($service['service_name']); ?> - RM<?php echo htmlspecialchars($service['price']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="barber">Preferred Barber</label>
                            <select id="barber" name="barber">
                                <option value="">No preference</option>
                                <option value="mark">Adib Hafiz</option>
                                <option value="peter">Nuqman Hazim</option>
                                <option value="alex">Hanif Ridzuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <select id="time" name="time" required>
                                <option value="">Select time</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="17:00">5:00 PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Special Requests</label>
                            <textarea id="notes" name="notes"></textarea>
                        </div>
                        <button type="submit" class="btn">Confirm Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>M&P Barbershop</h3>
                    <p>Providing premium barber services since 2012. We're dedicated to giving you the best grooming experience in town.</p>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <a href="index.php">Home</a>
                    <a href="services.php">Services</a>
                    <a href="barbers.php">Our Barbers</a>
                    <a href="booking.php">Book Online</a>
                </div>
                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <p>Tingkat 1, atas dobi, Perkarangan Masjid Albusyra,</p>
                    <p>Kampung Merbok, 08400 Merbok, Kedah</p>
                    <p>Phone: (60) 123-4567</p>
                    <p>Email: info@mpbarbershop.com</p>
                </div>
                <div class="footer-col">
                    <h3>Opening Hours</h3>
                    <p>Monday - Friday: 9am - 7pm</p>
                    <p>Saturday: 9am - 5pm</p>
                    <p>Sunday: 10am - 4pm</p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <script>document.write(new Date().getFullYear())</script> M&P Barbershop. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = [
        "images/barber-interior.webp",
        "images/barber-services.jpg",
        "images/classicHaircut-services.webp",
        "images/contactus.webp",
        "images/bgbarang.webp",
        "images/barberpole.webp",
        "images/guntingkatdinding.jpg",
        "images/interior-7.jpg"
    ];

    let current = 0;
    const bg1 = document.querySelector('.hero-bg-1');
    const bg2 = document.querySelector('.hero-bg-2');
    let showingBg1 = true;

    // Initialize
    bg1.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('${images[0]}')`;
    bg1.classList.add('active');

    function crossfadeHeroBg() {
        current = (current + 1) % images.length;
        if (showingBg1) {
            bg2.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('${images[current]}')`;
            bg2.classList.add('active');
            bg1.classList.remove('active');
        } else {
            bg1.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('${images[current]}')`;
            bg1.classList.add('active');
            bg2.classList.remove('active');
        }
        showingBg1 = !showingBg1;
    }

    setInterval(crossfadeHeroBg, 2500);
});
</script>
</body>
</html>