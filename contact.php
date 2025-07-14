<?php
$page_title = "Contact Us | M&P Barbershop";
$current_page = "contact";
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
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div id="success-popup" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center;z-index:9999;">
            <div style="background:#fff;padding:30px 40px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.2);text-align:center;">
                <h2 style="color:#27ae60;margin-bottom:10px;">Message Sent!</h2>
                <p>Thank you for contacting us. We have received your message and will get back to you soon.</p>
                <button onclick="document.getElementById('success-popup').style.display='none'" style="margin-top:15px;padding:8px 20px;background:#27ae60;color:#fff;border:none;border-radius:5px;cursor:pointer;">Close</button>
            </div>
        </div>
        <script>
            //auto-close after 3 seconds
            setTimeout(function(){
                var popup = document.getElementById('success-popup');
                if(popup) popup.style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Contact Hero Section -->
    <section class="page-hero barbers-hero" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('images/contactus.webp') center/cover no-repeat;">
        <div class="container">
            <div class="hero-content">
                <h1>Contact M&P Barbershop</h1>
                <p>Get in touch with us for appointments or inquiries</p>
            </div>
        </div>
    </section>

    <!-- Contact Main Section -->
    <section class="contact-main">
        <div class="container">
            <div class="contact-container">
                <div class="contact-info">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h3>Our Location</h3>
                            <p>Tingkat 1, atas dobi, Perkarangan Masjid Albusyra,<br>Kampung Merbok, 08400 Merbok, Kedah</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h3>Phone Number</h3>
                            <p><a href="tel:+60123456789">+60 12-345 6789</a></p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h3>Email Address</h3>
                            <p><a href="mailto:info@mpbarbershop.com">info@mpbarbershop.com</a></p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <h3>Opening Hours</h3>
                            <p>Monday - Friday: 9:00 AM - 7:00 PM<br>
                            Saturday: 9:00 AM - 5:00 PM<br>
                            Sunday: 10:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <h2>Send Us a Message</h2>
                    <form action="process_contact.php" method="POST">
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
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="appointment">Appointment Inquiry</option>
                                <option value="service">Service Question</option>
                                <option value="feedback">Feedback</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="contact-map">
        <div class="container">
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15879.73635224208!2d100.39079189300537!3d5.722634605780399!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304b270eed0fdd97%3A0xc74ea4252ac02d!2sBarbershop%20Al%20Busyra%20Merbok!5e0!3m2!1sen!2smy!4v1748017618242!5m2!1sen!2smy" referrerpolicy="no-referrer-when-downgrade" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>M&P Barbershop</h3>
                    <p>Providing premium barber services since 2012 at Masjid Albusyra Merbok. We're dedicated to giving you the best grooming experience.</p>
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
                    <p>Tingkat 1, atas dobi, Perkarangan Masjid Albusyra</p>
                    <p>Kampung Merbok, 08400 Merbok, Kedah</p>
                    <p>Phone: +60 12-345 6789</p>
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