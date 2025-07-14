<?php
$page_title = "Our Barbers | M&P Barbershop";
$current_page = "barbers";
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

    <!-- Barbers Hero Section -->
    <section class="page-hero barbers-hero" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('images/ourbarber.jpg') center/cover no-repeat;">
        <div class="container">
            <div class="hero-content">
                <h1>Meet Our Barbers</h1>
                <p>Our skilled professionals are ready to give you the perfect cut and style</p>
            </div>
        </div>
    </section>

    <!-- Main Barbers Section -->
    <section class="barbers-main">
        <div class="container">
            <div class="section-title">
                <h2>Our Expert Team</h2>
                <p>With over 35 years of combined experience, our barbers deliver exceptional service every time</p>
            </div>
            
            <div class="barbers-grid">
                <!-- Barber 1 -->
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="images/adib-barber.jpg" alt="Adib Hafiz">
                    </div>
                    <div class="barber-info">
                        <h3>Adib Hafiz</h3>
                        <p class="position">Master Barber & Co-owner</p>
                        <p class="experience">15 years experience</p>
                        <p class="specialty">Specializes in: Classic cuts, fades, and traditional styles</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                        <a href="booking.php?barber=mark" class="btn">Book with Adib</a>
                    </div>
                </div>

                <!-- Barber 2 -->
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="images/nuqman-barber.jpg" alt="Nuqman Hazim">
                    </div>
                    <div class="barber-info">
                        <h3>Nuqman Hazim</h3>
                        <p class="position">Beard Specialist & Co-owner</p>
                        <p class="experience">12 years experience</p>
                        <p class="specialty">Specializes in: Beard grooming, straight razor shaves</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                        <a href="booking.php?barber=peter" class="btn">Book with Nuqman</a>
                    </div>
                </div>

                <!-- Barber 3 -->
                <div class="barber-card">
                    <div class="barber-img">
                        <img src="images/hanif-barber.jpg" alt="Hanif Ridzuan">
                    </div>
                    <div class="barber-info">
                        <h3>Hanif Ridzuan</h3>
                        <p class="position">Styling Expert</p>
                        <p class="experience">8 years experience</p>
                        <p class="specialty">Specializes in: Modern styles, hair coloring and hair styling</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                        <a href="booking.php?barber=alex" class="btn">Book with Hanif</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Barber Skills Section -->
    <section class="skills-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Skills & Expertise</h2>
                <p>What makes our barbers stand out from the rest</p>
            </div>
            
            <div class="skills-grid">
                <div class="skill-card">
                    <div class="skill-icon">
                        <i class="fas fa-cut"></i>
                    </div>
                    <h3>Precision Cutting</h3>
                    <p>Every haircut is executed with meticulous attention to detail and perfect technique.</p>
                </div>
                
                <div class="skill-card">
                    <div class="skill-icon">
                        <i class="fas fa-air-freshener"></i>
                    </div>
                    <h3>Traditional Techniques</h3>
                    <p>We maintain time-honored barbering methods combined with modern approaches.</p>
                </div>
                
                <div class="skill-card">
                    <div class="skill-icon">
                        <i class="fas fa-hand-sparkles"></i>
                    </div>
                    <h3>Sanitation Standards</h3>
                    <p>Highest cleanliness protocols with sterilized tools for every client.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="barber-testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Client Experiences</h2>
                <p>Hear what our clients say about our barbers</p>
            </div>
            <div class="testimonials-carousel">
                <div class="carousel-track">
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Adib is a true master of his craft. My fade is always perfect and he remembers exactly how I like it every time!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Ikram Azri</h4>
                                <span>Regular Client</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Nuqman gave my beard a complete transformation. I get compliments all the time now!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Ahmad Dialo</h4>
                                <span>Beard Client</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                        <p>"Hanif styled my hair for my wedding and it was perfect. All my friends now go to him too!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Zakwan Zarif</h4>
                                <span>Special Event Client</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"The barbershop is always clean and the staff are super friendly. I always book with Adib for my monthly cut."</p>
                        <div class="client-info">
                            <div>
                                <h4>Sarah Lim</h4>
                                <span>Mother of Customer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Nuqman is the only one I trust with my beard. He always gives great advice and tips for maintenance."</p>
                        <div class="client-info">
                            <div>
                                <h4>Syafiq Rahman</h4>
                                <span>Returning Customer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Hanif's coloring skills are amazing. My new look is exactly what I wanted!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Emily Tan</h4>
                                <span>Hair Coloring Client</span>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat testimonials for seamless loop -->
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Adib is a true master of his craft. My fade is always perfect and he remembers exactly how I like it every time!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Ikram Azri</h4>
                                <span>Regular Client</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
            .testimonials-carousel {
                overflow: hidden;
                width: 100%;
                margin: 40px 0;
                background: transparent;
            }
            .carousel-track {
                display: flex;
                width: max-content;
                gap: 32px;
                animation: scrollTestimonials 25s linear infinite;
                will-change: transform;
            }
            .testimonial-card {
                min-width: 340px;
                max-width: 340px;
                background: white;
                border-radius: 14px;
                box-shadow: 0 2px 12px rgba(212,175,55,0.10);
                padding: 28px 24px;
                margin: 0 8px;
                font-size: 1.08em;
                color: #222;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            @keyframes scrollTestimonials {
                0% { transform: translate3d(0, 0, 0); }
                100% { transform: translate3d(-50%, 0, 0); }
            }
            .testimonials-carousel:hover .carousel-track {
                animation-play-state: paused;
            }
            @media (max-width: 600px) {
                .testimonial-card {
                    min-width: 220px;
                    max-width: 240px;
                    padding: 18px 10px;
                    font-size: 0.98em;
                }
            }
            </style>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Experience the Difference?</h2>
            <p>Book your appointment with one of our expert barbers today</p>
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
                <p>&copy; <?php echo date('Y'); ?> M&P Barbershop. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>