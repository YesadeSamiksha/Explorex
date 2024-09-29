<?php
    // Configuration
    $db_host = "localhost";
    $db_username = "root"; // Your MySQL username (default: root for XAMPP)
    $db_password = ""; // Your MySQL password (default: empty for XAMPP)
    $db_name = "test"; // Database name (ensure it is correctly named in your setup)

    // Connect to the database
    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the form is submitted for signup or login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['signup'])) {
            // Signup Logic
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Check if email already exists
            $check_email_query = "SELECT * FROM registration WHERE email='$email'";
            $check_email_result = mysqli_query($conn, $check_email_query);
            
            if (mysqli_num_rows($check_email_result) > 0) {
                echo "Email already exists. Please try logging in.";
            } else {
                // Insert the new user into the registration table
                $signup_query = "INSERT INTO registration (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
                
                if (mysqli_query($conn, $signup_query)) {
                    echo "Signup successful! Please log in.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        } elseif (isset($_POST['login'])) {
            // Login Logic
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            
            // Fetch the user record from the registration table
            $login_query = "SELECT * FROM registration WHERE email='$email'";
            $login_result = mysqli_query($conn, $login_query);
            
            if (mysqli_num_rows($login_result) > 0) {
                $user = mysqli_fetch_assoc($login_result);
                
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    echo "Welcome, " . $user['name'];
                } else {
                    echo "Invalid password. Please try again.";
                }
            } else {
                echo "No account found with that email. Please sign up.";
            }
        }
    }

    // Close database connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorex</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css"> <!-- Link to your custom CSS file -->
</head>
<body>
    <header class="header">
        <a href="#" class="logo">Explorex</a>
        <p class="slogan">Wherever You Roam, We Guide</p>
        <nav class="navbar">
            <a href="#home" class="active">Home</a>
            <a href="#services">Services</a>
            <a href="#search">Search</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>
    
    <section class="home" id="home">
        <div class="form-container">
            <!-- Login Form -->
            <form id="login-form" class="form" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <h2>Login</h2>
                <input type="email" class="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button> <!-- Login button with name="login" -->
                <p>New user? <a href="#" id="show-signup">Sign Up</a></p>
            </form>

            <!-- Signup Form -->
            <form id="signup-form" class="form hidden" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <h2>Sign Up</h2>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="signup">Sign Up</button> <!-- Signup button with name="signup" -->
                <p>Already have an account? <a href="#" id="show-login">Login</a></p>
            </form>
        </div>

        <script>
            // JavaScript to toggle between signup and login forms
            document.getElementById('show-signup').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('login-form').classList.add('hidden');
                document.getElementById('signup-form').classList.remove('hidden');
            });

            document.getElementById('show-login').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('signup-form').classList.add('hidden');
                document.getElementById('login-form').classList.remove('hidden');
            });
        </script>
    </section>

    <section id="services" class="services">
        <h2 class="heading">Our&nbsp;<span> Services</span></h2>
        <div class="services-container">
            <div class="services-box">
                <h3>Route</h3>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
                <a href="index.html" class="btn">Read More</a>
            </div>
            <div class="services-box">
                <h3>Search</h3>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
                <a href="map.html" class="btn">Read More</a>
            </div>
            <div class="services-box">
                <h3>Favourites</h3>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>
        <div class="info">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <a href="#" class="btnn">Read More</a>
        </div>
    </section>

    <section class="contact" id="contact">
        <h2 class="heading">Feedback</h2>
        <form action="#">
            <div class="contact-form">
                <input type="text" placeholder="Name">
                <input type="email" placeholder="Email">
            </div>
            <div class="contact-form">
                <input type="number" placeholder="Mobile Number">
            </div>
            <textarea cols="30" rows="10" placeholder="Your Message"></textarea>
            <input type="submit" value="Send Message" class="btn">
        </form>
    </section>

    <footer class="footer">
        <div class="social-media">
            <a href="#"><i class='bx bxl-instagram'></i></a>
            <a href="#"><i class='bx bxl-youtube'></i></a>
            <a href="#"><i class='bx bxl-github'></i></a>
            <a href="#"><i class='bx bxl-facebook'></i></a>
        </div>
        <div class="footer-text">
            <p>Copyright &copy; 2024 by Samiksha | All Rights Reserved.</p>
        </div>
        <div class="footer-iconTop">
            <a href="#home"><i class="bx bx-up-arrow-alt"></i></a>
        </div>
    </footer>
</body>
</html>
