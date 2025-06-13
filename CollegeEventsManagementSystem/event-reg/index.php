<?php
require('connection.php'); //connect to the databse
session_start();



if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if (empty($email) || empty($pass)) {
        echo '<script>alert("Please fill in both email and password fields")</script>';
    } else {
        $query = "SELECT * FROM user WHERE email='$email'";
        $res = mysqli_query($con, $query);

        if ($row = mysqli_fetch_assoc($res)) {
            $db_pass = $row['pass'];

            if (md5($pass) === $db_pass) {
                $_SESSION['user_id'] = $row['user_id']; // Set the user ID in the session variable

                if ($row["user_type"] === "admin") {   //user type admin or club
                    header("location: ./admindash");
                    exit;
                } else {
                    header("location: ./clubdash");
                    exit;
                }
            } else {
                echo '<script>alert("Incorrect password")</script>';
            }
        } else {
            echo '<script>alert("Invalid email")</script>';
        }
    }
}



$query = "SELECT * FROM program ORDER BY program_id DESC";
$res2 = mysqli_query($con, $query);


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/cropped-GCU-Logo-circle.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/CSS/navbar.css">
    <link rel="stylesheet" href="./assets/CSS/carousel.css">
    <link rel="stylesheet" href="./assets/CSS/login.css">
    <link rel="stylesheet" href="./assets/CSS/aboutpop.css">
    <link rel="stylesheet" href="./assets/CSS/contactmodal.css">
    <link rel="stylesheet" href="./assets/CSS/footer.css">
    <!-- <link rel="stylesheet" href="./CSS/signup.css"> -->
    <title>𝔼ᐯ𝔼ᑎ𝕋 ᒍᑌᑎᑕ𝕋𝕀𝕆ᑎ</title>

    <script>
        if (window.performance && window.performance.navigation.type === 2) {
            function detectBackButton() {
                window.location.href = './logout';
            }
            window.onload = detectBackButton;
        }
    </script>

    <style>
        html,
        body {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            background-color: white;
        }

        .column {
            margin-bottom: 50px;
        }

        nav {
            padding: 10px;
        }

        .text {
            padding: 2.5em;
            background-color: #000;
        }

        nav li:first-child {
            background-color: #fffbe9;
        }


        .iconic {
            margin-left: -10%;
            background-color: #333;
            border-bottom-left-radius: 40%;
            border-top-left-radius: 40%;
        }


        nav a:hover {
            /* border-radius: 5px; */
            border-top-right-radius: 50px;
            border-bottom-left-radius: 50px;
            background-color: #333;
            color: orange;
        }

        nav {
            background-color: #fffbe9;
        }

        .loginbackground {
            z-index: 99;
        }

        .aboutbackground {
            z-index: 99;
        }

        .card-footer {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .card-footer-title {
            padding: 20px;
            border-radius: 7px;
            transition: 0.5s ease;
        }

        .card-footer-title:hover {
            background-color: black;
            color: white;
        }

        .carousel-item {
            transition: 0.5s ease;
        }

        .ems {
            background-color: #333;
            padding: 2vh;
            margin-left: -10%;
            border-top-right-radius: 50px;
            /* border-bottom-right-radius: 200px; */
            border-bottom-left-radius: 50px;
            color: #fffbe9;
            text-align: center;
        }

        .card-footer .btn {
            border-radius: 1vh;
            border: 1px solid #333;
        }

        .card-footer .btn:hover {
            background-color: #222;
            color: white;
        }

        .event_img {
            width: 100%;
            height: auto;
            display: cover;
            border-radius: 9px;
        }

        .card {
            display: inline-grid;
            margin: 5%;
            border-radius: 9px;
            box-shadow: 2px 0px 10px 0px #333;
            transition: 0.1s ease;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .card .btn {
            box-shadow: none;
        }

        .admin-img {
            border-radius: 3%;
        }

        .row>* {
            padding: 0;
            margin: 0;
            display: flex;
        }

        .details {
            padding: 6px;
            margin: 0;
            color: darkblue;
            border-radius: 50px;
            background-color: none;
            border: none;
            transition: 0.5s ease;
        }

        .details:hover {
            transform: scale(1.1);
        }


        .details_form {
            margin: 0 0 0 0;
        }

        .register_form {
            margin: 0 0 0 0;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        @media only screen and (min-width:768px) and (max-width:1023px) {
            .card-body {
                width: 10rem;
            }
        }


        @media(max-width:1023px) {
            .hideOnMobile {
                display: none;
            }
        }

        @media(max-width:1022px) {
            .sidebar {
                width: 100%;
            }

            .menu-button {
                display: block;
            }
        }

        @media(max-width:1275px) {
            .mx-auto {
                width: 35%;
            }

            .team .team_member {
                width: 28rem;
                height: 21rem;
                margin-left: -30%;
            }

            .team .team_member2 {
                /* width: 22rem; */
                height: 21rem;
                margin-left: -8%;
            }
        }

        .text-animation h1 {
            overflow: hidden;
            border-right: 0.15em solid orange;
            white-space: nowrap;
            margin: 0;
            margin-top: 4rem;
            margin-bottom: -2rem;
            letter-spacing: 0.15em;
            animation: typing 3s steps(10000, end);
        }


        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        @media(max-width:426px) {
            .text-animation h1 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation Bar  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul>
            <li class="text bg-light"> <span style="color:orange" class="display-4 ems">𝔼ᐯ𝔼ᑎ𝕋 ᒍᑌᑎᑕ𝕋𝕀𝕆ᑎ</span>
            </li>
            <li class="hideOnMobile"><a href="./index">Home</a></li>
            <li class="hideOnMobile"><a href="#sectionId">Events</a>
            </li>
            <!-- <li class="hideOnMobile" id="aboutButton"><a href="#">About</a></li> -->
            <li class="hideOnMobile" id="openModal"><a href="#">Contact</a></li>

            <li class="hideOnMobile" id="loginButton"><a class="active-link" href="#">Login</a></li>
            <!-- <li class="hideOnMobile" id="signupButton"><a href="#">Sign Up</a></li> -->
            <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg"
                        height="24" viewBox="0 -960 960 960" width="24">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                    </svg></a></li>
        </ul>
        <ul class="sidebar">
            <li onclick=hideSidebar()><a id="X" href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24"
                        viewBox="0 -960 960 960" width="24">
                        <path
                            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                    </svg></a></li>
            <li><a href="./index">Home</a></li>
            <li onclick=hideSidebar()><a href="#sectionId">Events</a></li>
            <!-- <li><a href="./Tests/about.html">About</a></li> -->
            <li><a href="./Tests/contact.html">Contact</a></li>
            <li><a href="./login">Login</a></li>
            <!-- <li><a href="./signup.html">Sign Up</a></li> -->
        </ul>
    </nav>




    <!-- Carousel -->
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="5000">
                <img src="./assets/images/DSC_7401_1-scaled.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/DSC_8915-1536x864.jpg" class="d-block w-100" alt="...">
            </div>

            <div class="carousel-item">
                <img src="./assets/images/DSC_7433_1-1536x864.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./assets/images/DSC_8798-scaled.jpg" class="d-block w-100" alt="...">
            </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <!-- Animated text -->
    <div class="text-animation text-center">
        <h1>Welcome to 𝔼ᐯ𝔼ᑎ𝕋 ᒍᑌᑎᑕ𝕋𝕀𝕆ᑎ</h1>
    </div>



    <!-- Login Form -->
    <div class="container.fluid">
        <div class="loginbackground">
            <form class="mx-auto" id="loginModal" method="POST">
                <span class="closelogin" id="closeModal">&times;</span>
                <h4 class="text-center">Login</h4>
                <div class="mb-3 mt-4">
                    <label for="exampleInputusername1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-2">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" required>
                    <input type="checkbox" class="checkbox" onclick="myFunction1()">Show Password
                    <!-- <div id="emailHelp" id="form-text mt-3"><a href="#">Forgot Password?</a></div> -->
                </div>
                <button type="submit" value="Login" name="login" class="btn btn-primary mt-4">login</button>
                <!-- <p>if not registered ! <a href="./signup.html">Sign Up</a></p> -->
                <p>go to <a href="./index">Home</a></p>
            </form>
        </div>
    </div>
    <!--pop login script -->
    <script src="./assets/JS/login.js"></script>



    <!-- The Programs listed on index page -->
    <section id="sectionId">
        <div class="container mt-5 inside-section" style="background-color:#fffbe9">
            <div class="row bg-light">
                <?php
                $count = 0; // Initialize count to track cards in a row
                while ($row = mysqli_fetch_assoc($res2)) {
                ?>
                    <div class="col-md-3 mt-3 column bg-light">
                        <div class="card mt-5 bg-light" style="width: 100%; height:auto;">
                            <!-- Card image -->
                            <?php
                            $user_id = $row['program_id'];
                            $query = "SELECT image FROM program WHERE program_id = $user_id";
                            $result = mysqli_query($con, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row0 = mysqli_fetch_assoc($result);
                            }
                            ?>
                            <img class="admin-img" src="<?php echo $row0['image']; ?>" width="100%" alt="image"></a>

                            <div class="card-body text-center">
                                <h2 class="text-center" style="font-weight:bold">
                                    <?php echo $row['name']; ?>
                                </h2>
                                <p>

                                    <!-- <?php echo $row['program_id']; ?> <br> -->
                                    <?php echo $row['date']; ?> &nbsp;
                                    <?php echo $row['time']; ?> <br>
                                    Venue :
                                    <?php echo $row['venue']; ?> <br>
                                    <!-- <?php echo $row['staff_coordinator']; ?><br>
                                        <?php echo $row['student_coordinator']; ?><br> -->

                                    <!-- <?php
                                            $user_id = $row['user_id']; // $row contains user_id
                                            $query = "SELECT name FROM user WHERE user_id = '$user_id'";
                                            $res = mysqli_query($con, $query);

                                            if ($res) {
                                                $user = mysqli_fetch_assoc($res);
                                                echo $user['name']; // Display the retrieved name
                                            }
                                            ?> -->
                                </p>
                                <div class="button-container">
                                    <form action="./details" method="POST" class="details_form text-center">
                                        <input type="hidden" name="program_id" value="<?php echo $row['program_id']; ?>">
                                        <button type="submit" value="Submit" name="details"
                                            class="btn details">Details</button>
                                    </form>
                                    <form action="./register" method="POST" class="register_form text-center">
                                        <input type="hidden" name="program_id" value="<?php echo $row['program_id']; ?>">
                                        <button type="submit" value="Submit" name="register"
                                            class="btn btn-primary program_register">Register</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $count++;
                    if ($count % 4 == 0) {
                        // If four cards are reached, close the row and start a new one
                        echo '</div><div class="row">';
                    }
                }
                ?>
            </div>
        </div>
    </section>




    <!--On pressed 'About' at the navigation bar team sliders are poped -->
    <div class="aboutbackground">
        <div class="wrapper" id="aboutModal">
            <span class="closeabout" id="closeabout">&times;</span>
            <!-- <h1>Our Team</h1> -->
            <div class="team">
                <div class="team_member team_member1">
                    <div class="team_img">
                        <img src="assets/images/dishanta1-removebg-preview.jpg" alt="Team_image">
                    </div>
                    <h3>Dishanta Adhikari</h3>
                    <p class="role">developer | Roll no. 20 BCA 5th sem</p>
                    <p>𝐂𝐀@𝐀𝐒𝐓𝐔 | 𝐖𝐞𝐛 𝐃𝐞𝐯𝐞𝐥𝐨𝐩𝐞𝐫 𝐄𝐧𝐭𝐡𝐮𝐬𝐢𝐚𝐬𝐭 |
                        Guwahati, Assam, India
                        Assam Science and Technology University ASTU
                        Bachelor of Computer Applications - BCA, Computer Programming | Roll no. 20 BCA 5th sem</p>
                    <a class="social-link" href="https://www.facebook.com/adhikari.dishanta"><i
                            class="fa-brands fa-facebook"></i></a>
                    <a class="social-link" href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a class="social-link" href="https://www.linkedin.com/in/dishanta-adhikari-607691229"><i
                            class="fa-brands fa-linkedin"></i></a>
                </div>
                <div class="team_member team_member2">
                    <div class="team_img">
                        <img src="assets/images/shujan-removebg-preview.jpg" alt="Team_image">
                    </div>
                    <h3>Shujan Kr Ray</h3>
                    <p class="role">developer and Tester | Roll no. 49 BCA 5th sem</p>
                    <p>MERN Stack Developer | React.js, MongoDB, Express, Node.js | Full Stack Developer | Java DSA |
                        Aspiring software engineer | Roll no. 49 BCA 5th sem</p>
                    <a class="social-link" href="https://www.facebook.com/shujan.kumarray.9"><i
                            class="fa-brands fa-facebook"></i></a>
                    <a class="social-link" href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a class="social-link" href="https://www.linkedin.com/in/shujankumarray"><i
                            class="fa-brands fa-linkedin"></i></a>
                </div>
                <!-- <div class="team_member">
                <div class="team_img">
                    <img src="https://i.imgur.com/2Necikc.png" alt="Team_image">
                </div>
                <h3>Alex Wood</h3>
                <p class="role">Support Lead</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est quaerat tempora, voluptatum quas facere
                    dolorum aut cumque nihil nulla harum nemo distinctio quam blanditiis dignissimos.</p>
            </div> -->
            </div>
        </div>
    </div>
    <!-- script 'About' -->
    <script src="assets/JS/popabout.js"></script>



    <!-- Contact us from -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Contact Us</h2>
            <form id="contactForm" action="./contactform" method="post">
                <label for="name">Name:</label>
                <input type="text" id="Cname" name="Cname" required>

                <label for="email">Email:</label>
                <input type="email" id="Cemail" name="Cemail" required>

                <label for="message">Message:</label>
                <textarea id="Cmessage" name="Cmessage" required></textarea>

                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </div>
    <!-- Contact us script -->
    <script src="assets/JS/contact.js"></script>



    <!-- index page footer  -->
    <footer>
        <div class="footercontainer mt-5">
            <!-- <div class="footernav">
                <ul>
                    <li><a href="./index">Home</a></li>
                    <li><a href="#">News</a></li>
                    <li id="aboutButton"><a href="#">About</a></li>
                    <li><a href="./contact.html">Contact</a></li>
                </ul>
            </div> -->

            <div>
                <p style="color:white;text-align:center;">
                    Contact Us : <br>
                    info@gcuniversity.ac.in <br>
                    7099034050 <br>
                    24x7 Women Helpline Number : <br>
                    7099004706
                </p>
            </div>

            <div class="socialicons">
                <a href="https://www.facebook.com/gcuniversityassam"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.instagram.com/gcu_assam"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://twitter.com/GCUniversityA"><i class="fa-brands fa-twitter"></i></a>
            </div>

        </div>
        <div class="footerbottom">
            <p>Copyright &copy;2023 Designed by <span class="designer"><br>
                    Dishanta Adhikari</span></p>
        </div>
    </footer>





    <!-- script bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>


</body>

</html>