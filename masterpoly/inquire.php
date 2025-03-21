<?php
include 'conf.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $messageContent = $_POST['message']; // Avoid conflict with `$message`

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($messageContent)) {
        $message = "All fields are required.";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO inquire (Name, Email, Subject, Messege) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $subject, $messageContent);

            if ($stmt->execute()) {
                $message = "Inquiry submitted successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="contactus3.css">

</head>
<body>
    <div class="wrapper">
        <header>
        <div class="container">
            <div class="logo">
                <img src="images/logo.png" alt="Logo" class="logo-img">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="Home.html">Home</a></li>
                    <!--<li><a href="phome.html">Products</a></li>-->
                    <li><a href="aboutus.html">About Us</a></li>
                    <li><a href="inquire.php">FAQs</a></li>
                </ul>
                <div class="buttons">
                    <a href="slogin.html" class="btn">Staff</a>
                    <a href="cuslogin.html" class="btn">Client</a>
                    <a href="suplogin.html" class="btn">Supplier</a>
                </div>
            </nav>
        </div>
        </header>

        <section class="contact-us">
            <div class="container">
                <div class="contact-info">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Address</h3>
                        <p>No 125, Mahaweli Industrial Park, New Town, Embilipitiya, Sri Lanka</p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <h3>Email</h3>
                        <p><a href="mailto:contact@greentech.lk">NMFruits@greentech.lk</a></p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone-alt"></i>
                        <h3>Call Us</h3>
                        <p><a href="tel:+94764846394">+94 76 484 6394</a></p>
                        <p><a href="tel:+94716415300">+94 71 641 5300</a></p>
                    </div>
                </div>

                <div class="inquire-form">
                    <h2>Inquire Now</h2>

                    <!-- Display message -->
                    <?php if (!empty($message)): ?>
                        <div class="message">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <form name="ContactUs" action="" method="POST">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" placeholder="Enter subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Enter your message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="inquire-btn">Inquire Now</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="map-section">
            <div class="map-container">
                <h2>Find Us on the Map</h2>
                <div class="map">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d179318.26590540685!2d80.00764101209717!3d6.719560188663651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae24ff6e4e17ec3%3A0x16afb4d992fc46f2!2sPiliyandala%20Town%20Square!5e0!3m2!1sen!2slk!4v1731941187374!5m2!1sen!2slk" 
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </section>

        <footer class="footer">
        <div class="footer-container">
            <div class="footer-box">
                <img src="images/logo.png" alt="Company Logo" class="company-logo">
                <p>Delivering high-quality product worldwide.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-box">
                <h3>Our Company</h3>
                <ul>
                    <li><a href="#">Who We Are</a></li>
                    <li><a href="#">About Company</a></li>
                    <li><a href="#">Services We Provide</a></li>
                    <li><a href="#">What We Have Done</a></li>
                </ul>
            </div>
            <div class="footer-box">
                <h3>Our Services</h3>
                <ul>
                    <li><a href="#">Architecture</a></li>
                    <li><a href="#">Exterior Design</a></li>
                    <li><a href="#">Landscape Design</a></li>
                    <li><a href="#">Site Planning</a></li>
                </ul>
            </div>
            <div class="footer-box">
                <h3>Contact Details</h3>
                <ul>
                    <li>
                        No.122, Stratford Avenue, Kirulapone,Colombo 06,
                        Sri Lanka.</li>
                    <li>(+94) 777 306 412</li>
                    <li> (+94) 773 876 054</li>
                    <li><a href="masterpoly@gmail.com">masterpoly@gmail.com</a></li>
                </ul>
            </div>
        </div>
    </footer>
    </div>
</body>
</html>
