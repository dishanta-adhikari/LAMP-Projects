<?php
require_once('connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You are logged Out ! Please log in Again");</script>';
    echo '<script>window.location.href = "./index";</script>';
    exit;
}

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if (empty($email) || empty($pass)) {
        echo '<script>alert("please fill the blanks")</script>';
    } else {
        $query = "select * from user where email='$email' && user_name='$user_name'";
        $res = mysqli_query($con, $query);
        if ($row = mysqli_fetch_assoc($res)) {
            $db_password = $row['password'];
            if ($pass == $db_password) {
                $db_email = $row['email'];
                $db_user_name = $row['user_name'];
                if ($email == $db_email && $user_name == $db_user_name) {
                    $query = "DELETE FROM user WHERE email = '$email' && username='$user_name'";
                    $res = mysqli_query($con, $query);
                    echo '<script>alert("Account Deleted")</script>';
                    echo '<script>window.location.href = "./index";</script>';
                } else {
                    echo '<script>alert("Enter Proper Credential")</script>';
                }
            } else {
                echo '<script>alert("Enter a Proper Password")</script>';
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./images/cropped-GCU-Logo-circle.png">
    <title>Delete Your Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS -->
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body,
        html {
            background: #FFFFFF;
            background-size: cover;
            object-fit: cover;
        }

        .mx-auto {
            width: 40%;
            background-color: #FFFFFF;
            /* border: 10px solid rgb(245, 222, 179); */
            padding: 0px 50px;
            border-radius: 50px;
            margin-top: 90px;
        }


        .btn-primary {
            width: 50%;
            border: none;
            border-radius: 50px;
            background-color: #dd3737;
            box-shadow: 3px 3px 9px #222;
            transition: 0.5s ease;
            margin: 0 0 0 16vh;
        }

        .text-center {
            background-color: #111;
            color: white;
            padding: 20px;
            width: 100%;
        }


        .btn-primary:hover {
            transform: scale(1.05);
        }

        .form-control {
            box-shadow: 1px 1px 5px #222;
            border-radius: 20px;
        }

        h4 {
            font-size: 2rem;
            font-weight: 700;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .closelogin {
            position: absolute;
            top: 1px;
            right: 20px;
            font-size: 40px;
            cursor: pointer;
            transition: 0.4s ease;
        }

        .closelogin:hover {
            transform: scale(1.5);
        }

        p {
            padding: 0;
            margin-top: 1vh;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #dd3737;
        }

        a:hover {
            color: #1778f2;
        }

        .text-center {
            padding: 20vh;
        }

        .checkbox {
            margin: 20px 5px 20px 0;
        }

        .closelogin {
            color: white;
        }

        @media (max-width:1440px) {
            form {
                width: 30%;
                height: auto;
                margin-top: 200px;

            }
        }

        @media (max-width:1024px) {
            form {
                width: 40%;
                height: auto;
                margin-top: 200px;

            }
        }

        @media (max-width:912px) {
            form {
                width: 50%;
                height: auto;

            }
        }

        @media (max-width:820px) {
            form {
                width: 50%;
                height: auto;

            }
        }

        @media (max-width:768px) {
            form {
                width: 50%;
                height: auto;
                margin-top: 200px;

            }
        }

        @media (max-width:600px) {
            form {
                width: 60%;
                height: auto;
                box-shadow: none;

            }
        }

        @media (max-width:480px) {
            form {
                width: 100%;
                height: auto;
                box-shadow: none;
                margin-top: 100px;
                background-color: #ffffff;
                border: #ffffff;
            }

            body,
            html {
                background: #ffffff;
            }

            .addnew {
                width: 25rem;
            }

            h4 {
                font-size: 0.6rem;
            }

            .add-button {
                display: block;
                margin-left: -4rem;
            }
        }
    </style>

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>



    <!-- Add New Admin -->
    <div class="container.fluid">
        <div class="loginbackground">
            <h4 class="text-center">Delete Your Account Parmanently </h4>
            <form class="mx-auto addnew" id="loginModal" method="POST">
                <span class="closelogin" id="closeModal">&times;</span>


                <div class="mb-3 mt-5">
                    <label for="exampleInputname1" class="form-label">Confirm Your Idendity</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                        placeholder="(username)" aria-describedby="emailHelp" required>
                </div>

                <div class="mb-3 ">
                    <label for="exampleInputname1" class="form-label">Confirm Your Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>

                <div class="mb-3 mt-4">
                    <label for="exampleInputPassword1" class="form-label">Enter Password</label>
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword3" required>
                    <input type="checkbox" class="checkbox" onclick="myFunction3()">Show Password
                    <!-- <div id="emailHelp" id="form-text mt-3"><a href="#">Forgot Password?</a></div> -->
                </div>
                <div class="add-button">
                    <button type="submit" value="submit" name="submit" class="btn btn-primary mt-4">DELETE</button>
                </div>
                <!-- <p>if not registered ! <a href="./signup.html">Sign Up</a></p> -->
                <p>go to <a href="./admindash">Dashboard</a></p>
            </form>
        </div>
    </div>
    <script>
        function myFunction3() {
            var x = document.getElementById("exampleInputPassword3");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        const closeModal = document.getElementById('closeModal');
        closeModal.addEventListener('click', () => {
            window.location.href = "./admindash";

        });

        function detectBackButton() {
            if (window.performance && window.performance.navigation.type === 2) {
                window.location.href = "./admindash";
            }
        }
        // Call the function on page load
        window.onload = detectBackButton;
    </script>
</body>

</html>