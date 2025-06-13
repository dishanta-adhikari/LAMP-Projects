<?php
require_once('connection.php');
session_start();


if (isset($_POST['program_id'])) {
    $_SESSION['program_id'] = $_POST['program_id'];
}


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $branch = $_POST['branch'];
    $sem = $_POST['sem'];
    $college = $_POST['college'];

    $program_id = $_SESSION['program_id'];

    // Check for existing email or program_id in the participant table
    $duplicate = mysqli_query($con, "SELECT * FROM participant WHERE phone='$phone' AND program_id='$program_id'");
    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script>alert('Already registered')</script>";
        echo '<script>window.location.href = "./index";</script>';
    } else {

        $query = "SELECT user_id FROM program WHERE program_id = '$program_id'";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);
        $user_id = $row['user_id'];

        // Insert the participant data into the participant table
        $query = "INSERT INTO participant (name, email, phone, branch, sem, college, program_id, user_id) VALUES ('$name', '$email', '$phone', '$branch', '$sem', '$college', '$program_id', '$user_id')";
        $res2 = mysqli_query($con, $query);

        if ($res2) {
            echo "<script>alert('Registration Successfull.')</script>";
            echo '<script>window.location.href = "./index";</script>';
        } else {
            echo "<script>alert('Error registering participant.')</script>";
            echo '<script>window.location.href = "./index";</script>';
        }
    }


} else {
    echo "<script>Error</script>";
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./assets/images/cropped-GCU-Logo-circle.png">
    <title>Register for a Program</title>
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

        form {
            width: 40%;
            background-color: #FFFFFF;
            /* border: 10px solid rgb(245, 222, 179); */
            padding: 0px 50px;
            border-radius: 50px;
            /* margin-top: 200px; */
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
            animation: fadeIn 0.5s ease-in-out;
            background-color: #222;
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

        .checkbox {
            margin: 20px 5px 20px 0;
        }

        .text-center {
            padding: 20vh;
            color: white;
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

            h4 {
                font-size: 0.7rem;
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
        }

        @media (max-width:1025px) {
            .btn-primary {
                margin: 0 0 0 11vh;
            }
        }

        @media (max-width:1500px) {
            .btn-primary {
                margin: 0 0 0 11vh;
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


    <!-- Login Form -->
    <div class="container.fluid">
        <div class="loginbackground">
            <h4 class="text-center">
                <?php $query = "SELECT name FROM program WHERE program_id = '$_SESSION[program_id]'";
                $res0 = mysqli_query($con, $query);
                $row0 = mysqli_fetch_assoc($res0);
                echo $row0['name']; ?><br><br>Give Your Details Below
            </h4>
            <form class="mx-auto" id="loginModal" method="POST">
                <span class="closelogin" id="closeModal">&times;</span>

                <div class="mb-3 mt-5">
                    <label for="exampleInputname1" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3 ">
                    <label for="exampleInputuseremail1" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3 ">
                    <label for="exampleInputusername1" class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3 ">
                    <label for="exampleInputusername1" class="form-label">Branch</label>
                    <input type="text" name="branch" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3 ">
                    <label for="exampleInputusername1" class="form-label">Semester</label>
                    <input type="text" name="sem" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3 ">
                    <label for="exampleInputusercollege1" class="form-label">College</label>
                    <input type="text" name="college" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>

                <button type="submit" value="Submit" name="submit"
                    onclick="return confirm('This Process Cannot be Reversed. Are you sure you want to continue this Registration ?');"
                    class="btn btn-primary mt-4">submit</button>
                <!-- <p>if not registered ! <a href="./signup.html">Sign Up</a></p> -->
                <p>go to <a href="./index">Home</a></p>
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
            window.window.location.href = "./index";

        });
    </script>
</body>

</html>