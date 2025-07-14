<?php
$page_title = "About Us | M&P Barbershop";
$current_page = "about";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- About Hero Section -->
    <section class="page-hero" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/barberpole.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="hero-content">
                <h1 class="fadeInDown">About M&P Barbershop</h1>
                <p>Traditional barbering with modern style in the heart of Merbok</p>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="our-story">
        <div class="container">
            <div class="story-container">
                <div class="story-content">
                    <div class="section-title">
                        <h2 class="section-animate">Our Story</h2>
                        <p>How M&P Barbershop came to be</p>
                    </div>
                    <p>Founded in 2012 by Adib Hafiz and Nuqman Hazim, M&P Barbershop began as a small two-chair shop with a vision to bring back traditional barbering values with a contemporary twist.</p>
                    <p>What started as a humble neighborhood barbershop near Masjid Busyra Merbok has grown into one of the most respected grooming destinations in the area, known for our exceptional service and welcoming atmosphere.</p>
                    <p>Today, we continue to uphold the founders' commitment to quality craftsmanship, using both time-honored techniques and modern styling approaches to give our clients the perfect look.</p>
                </div>
                <div class="story-image">
                    <img src="images/ourbarber.jpg" alt="M&P Barbershop Interior">
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="location">
        <div class="container">
            <div class="section-title">
                <h2 class="section-animate">Our Location</h2>
                <p>Visit us at Masjid Busyra Merbok</p>
            </div>
            <div class="location-container">
                <div class="location-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15879.73635224208!2d100.39079189300537!3d5.722634605780399!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304b270eed0fdd97%3A0xc74ea4252ac02d!2sBarbershop%20Al%20Busyra%20Merbok!5e0!3m2!1sen!2smy!4v1748017618242!5m2!1sen!2smy" width="720" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="location-info">
                    <h3>M&P Barbershop</h3>
                    <address>
                        Tingkat 1, atas dobi, Perkarangan Masjid Albusyra,<br>
                        Jalan Merbok, 08400 Merbok<br>
                        Kedah, Malaysia
                    </address>
                    <div class="contact-info">
                        <p><i class="fas fa-phone"></i> <a href="tel:+60123456789">+60 12-345 6789</a></p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:info@mpbarbershop.com">info@mpbarbershop.com</a></p>
                    </div>
                    <div class="hours-info">
                        <h4>Opening Hours:</h4>
                        <ul>
                            <li>Monday - Friday: 3.00 PM - 10:00 PM</li>
                            <li>Saturday: 9:00 AM - 5:00 PM</li>
                            <li>Sunday: 10:00 AM - 4:00 PM</li>
                        </ul>
                    </div>
                    <a href="https://maps.app.goo.gl/1AYxr1qX6MY95GVo8" class="btn" target="_blank">Get Directions</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values">
        <div class="container">
            <div class="section-title">
                <h2 class="section-animate">Our Values</h2>
                <p>What makes M&P Barbershop different</p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-cut"></i>
                    </div>
                    <h3>Craftsmanship</h3>
                    <p>We take pride in our work, ensuring every haircut and shave meets our high standards of quality.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Community</h3>
                    <p>We're proud to be part of the Merbok community and serve our neighbors with care.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3>Hospitality</h3>
                    <p>Every client is treated like family from the moment they walk through our doors.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery">
        <div class="container">
            <div class="section-title">
                <h2 class="section-animate">Our Barbershop</h2>
                <p>Take a look inside M&P Barbershop</p>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="images/gambarluar.jpg" alt="Barbershop interior">
                </div>
                <div class="gallery-item">
                    <img src="images/interior1.png" alt="Barber at work">
                </div>
                <div class="gallery-item">
                    <img src="images/customer-tengah-potongrambut.jpg" alt="Client getting haircut">
                </div>
                <div class="gallery-item">
                    <img src="images/rambutcustomer.png" alt="Barber tools">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2 class="section-animate">Experience the M&P Difference</h2>
            <p>Book your appointment today and discover why we're Merbok's favorite barbershop</p>
            <div class="cta-buttons">
                <a href="booking.php" class="btn">Book Online</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>M&P Barbershop</h3>
                    <p>Providing premium barber services since 2012 at Masjid Busra Merbok. We're dedicated to giving you the best grooming experience.</p>
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
                <p>&copy; <?php echo date('Y'); ?> M&P Barbershop. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>