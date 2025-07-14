<?php
$page_title = "Our Services | M&P Barbershop";
$current_page = "services";
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

    <!-- Services Hero Section -->
    <section class="page-hero animate-hero" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/barber-services.jpg');">
        <div class="container">
            <div class="hero-content">
                <h1>Our Services</h1>
                <p>Premium grooming services tailored to your needs</p>
            </div>
        </div>
    </section>

    <!-- Main Services Section -->
    <section class="services-main">
        <div class="container">
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="images/classicHaircut-services.webp" alt="Haircut Service">
                    </div>
                    <div class="service-content">
                        <h3>Classic Haircut</h3>
                        <p>Our signature haircut includes shampoo, precision cutting, styling, and finishing touches with premium products.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Personalized consultation</li>
                            <li><i class="fas fa-check"></i> Precision cutting techniques</li>
                            <li><i class="fas fa-check"></i> Hot towel treatment</li>
                            <li><i class="fas fa-check"></i> Professional styling</li>
                        </ul>
                        <div class="price">RM13</div>
                        <a href="booking.php" class="btn">Book Now</a>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-img">
                        <img src="images/beardtrim-services.jpg" alt="Beard Trim">
                    </div>
                    <div class="service-content">
                        <h3>Beard Trim & Shape</h3>
                        <p>Expert beard grooming including trimming, shaping, and conditioning for a perfectly maintained look.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Detailed beard analysis</li>
                            <li><i class="fas fa-check"></i> Precision trimming</li>
                            <li><i class="fas fa-check"></i> Hot towel treatment</li>
                            <li><i class="fas fa-check"></i> Beard oil application</li>
                        </ul>
                        <div class="price">RM20</div>
                        <a href="booking.php" class="btn">Book Now</a>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-img">
                        <img src="images/hottowel-services.webp" alt="Hot Towel Shave">
                    </div>
                    <div class="service-content">
                        <h3>Hot Towel Shave</h3>
                        <p>Traditional straight razor shave with multiple hot towels, pre-shave oil, and post-shave balm.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Hot towel preparation</li>
                            <li><i class="fas fa-check"></i> Premium shaving cream</li>
                            <li><i class="fas fa-check"></i> Straight razor shave</li>
                            <li><i class="fas fa-check"></i> Cooling aftershave</li>
                        </ul>
                        <div class="price">RM24</div>
                        <a href="booking.php" class="btn">Book Now</a>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-img">
                        <img src="images/Kids-Haircuts.webp" alt="Kids Haircut">
                    </div>
                    <div class="service-content">
                        <h3>Kids Haircut</h3>
                        <p>Specialized haircuts for children in a friendly, comfortable environment with patient barbers.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Child-friendly approach</li>
                            <li><i class="fas fa-check"></i> Fun styling options</li>
                            <li><i class="fas fa-check"></i> Gentle techniques</li>
                            <li><i class="fas fa-check"></i> Lollipop treat</li>
                        </ul>
                        <div class="price">RM8</div>
                        <a href="booking.php" class="btn">Book Now</a>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-img">
                        <img src="images/hairColoring-services.png" alt="Hair Coloring">
                    </div>
                    <div class="service-content">
                        <h3>Hair Coloring</h3>
                        <p>Professional hair coloring services including full color, highlights, and gray coverage.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Color consultation</li>
                            <li><i class="fas fa-check"></i> Premium color products</li>
                            <li><i class="fas fa-check"></i> Conditioning treatment</li>
                            <li><i class="fas fa-check"></i> Style finish</li>
                        </ul>
                        <div class="price">Starting at RM30</div>
                        <a href="booking.php" class="btn">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Our Clients Say</h2>
                <p>Hear from our satisfied customers</p>
            </div>
            <div class="testimonials-carousel">
                <div class="carousel-track">
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"The best haircut I've ever had! Adib listened to exactly what I wanted and delivered beyond my expectations."</p>
                        <div class="client-info">
                            <div>
                                <h4>Hafizh Hazim</h4>
                                <span>Regular Client</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Nuqman beard trimming skills are unmatched. I won't let anyone else touch my beard now!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Bob Skidibob</h4>
                                <span>Beard Specialist Client</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                        <p>"The hot towel shave is an experience everyone should try at least once. I'm hooked!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Kimi Bimi</h4>
                                <span>New Customer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"I brought my son for a kids haircut and he loved the experience. The staff were so patient and friendly!"</p>
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
                        <p>"The hair coloring service was amazing. My new look is exactly what I wanted!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Amira Zain</h4>
                                <span>Hair Coloring Client</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Super clean shop, friendly barbers, and great prices. I recommend M&P to all my friends!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Jason Lee</h4>
                                <span>First Time Visitor</span>
                            </div>
                        </div>
                    </div>
                    <!-- 3 More Testimonials -->
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Absolutely love the monthly maintenance package. It keeps me looking sharp all month long!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Rashid Omar</h4>
                                <span>Package Subscriber</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"The barbers here are true professionals. I always leave feeling refreshed and confident."</p>
                        <div class="client-info">
                            <div>
                                <h4>Emily Tan</h4>
                                <span>Returning Customer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Booking online was so easy and convenient. Highly recommend M&P Barbershop!"</p>
                        <div class="client-info">
                            <div>
                                <h4>Syafiq Rahman</h4>
                                <span>Online Booking Client</span>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat testimonials for seamless loop -->
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
            <h2>Ready for Your Next Grooming Experience?</h2>
            <p>Book your appointment online or visit our barbershop today</p>
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