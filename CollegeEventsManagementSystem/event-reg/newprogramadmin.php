<?php
require_once('connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You are logged Out ! Please log in Again");</script>';
    echo '<script>window.location.href = "./index";</script>';
    exit;
}


if (isset($_POST['submit'])) {
    // Gather form data
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $time = date("h:i A", strtotime($_POST['time']));
    $venue = $_POST['venue'];
    $staff_coordinator = $_POST['staff_coordinator'];
    $phone1 = $_POST['phone1'];
    $student_coordinator = $_POST['student_coordinator'];
    $phone2 = $_POST['phone2'];
    $club_id = $_SESSION['user_id']; // Using user ID from session

    $formatted_date = date('j F Y', strtotime($date)); // Format the date

    // File upload handling
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_destination = "./assets/images/EventImages/" . $file_name;
    move_uploaded_file($file_tmp, $file_destination);


    // Prepare and bind parameters for duplicate check
    $check_duplicate = $con->prepare("SELECT * FROM program WHERE name=? AND time=? AND venue=?");
    $check_duplicate->bind_param("sss", $name, $time, $venue);
    $check_duplicate->execute();
    $check_duplicate->store_result();

    if ($check_duplicate->num_rows > 0) {
        echo "<script>alert('Name, Venue, and Time are already booked')</script>";
    } else {
        // Insert new program using prepared statement
        $insert_query = "INSERT INTO program (name, date, time, venue, image, staff_coordinator,phone1, student_coordinator,phone2, user_id) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_statement = $con->prepare($insert_query);
        $insert_statement->bind_param("sssssssssi", $name, $date, $time, $venue, $file_destination, $staff_coordinator, $phone1, $student_coordinator, $phone1, $club_id);

        if ($insert_statement->execute()) {
            echo "<script>alert('New Program Added Successfully')</script>";
        } else {
            echo "<script>alert('Failed to add new program')</script>";
        }
        $insert_statement->close();
    }
    $check_duplicate->close();

}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./assets/images/cropped-GCU-Logo-circle.png">
    <title>New Program</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


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
            margin-top: 20px;
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

        .text-center {
            background-color: #111;
            color: white;
            padding: 30px;
        }

        .form-control {
            box-shadow: 1px 1px 5px #222;
            border-radius: 20px;
        }

        h4 {
            font-size: 2rem;
            font-weight: 700;
            animation: fadeIn 0.5s ease-in-out;
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

    <div class="container.fluid">
        <div class="loginbackground">
            <h4 class="text-center">Add New Programs</h4>
            <form class="mx-auto addnew" id="loginModal" method="POST" enctype="multipart/form-data">
                <span class="closelogin text-white" id="closeModal">&times;</span>
                <div class="mb-3 mt-3">
                    <label for="exampleInputname1" class="form-label">Program Name</label>
                    <input type="name" name="name" class="form-control" id="exampleInputname1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputname1" class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputname1" class="form-label">Time (HH:MM AM/PM)</label>
                    <input type="text" name="time" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputphone1" class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-control" id="exampleInputphone1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Select Image File</label>
                    <input type="file" name="image" class="form-control" id="formFile">
                </div>
                <!-- staff_co-ordinator -->
                <div class="mb-3">
                    <label for="exampleInputphone1" class="form-label">Staff Co-ordinator</label>
                    <input type="text" name="staff_coordinator" class="form-control" id="exampleInputphone1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputphone1" class="form-label">Phone Staff Co-ordinator</label>
                    <input type="tel" name="phone1" class="form-control" id="exampleInputphone1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputphone1" class="form-label">Student Co-ordinator</label>
                    <input type="text" name="student_coordinator" class="form-control" id="exampleInputphone1"
                        aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputphone1" class="form-label">Phone Student Co-ordinator</label>
                    <input type="tel" name="phone2" class="form-control" id="exampleInputphone1"
                        aria-describedby="emailHelp" required>
                </div>
                <!-- <div class="input-group mb-3 mt-4">
                    <label class="input-group-text" for="inputGroupSelect01">Program Type</label>
                    <select class="form-select" name="type" id="inputGroupSelect01">
                        <option selected>Select...</option>
                        <option value="1">Solo</option>
                        <option value="2">Group</option>
                         <option value="3">Three</option>
                    </select>
                </div> -->
                <div class="add-button">
                    <button type="submit" value="submit" name="submit" class="btn btn-primary mt-4">ADD</button>
                </div>
                <p>go to <a href="./admindash">Dashboard</a></p>
            </form>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>


    <script>
        const closeModal = document.getElementById('closeModal');
        closeModal.addEventListener('click', () => {
            window.location.href = "./admindash";
        });
    </script>
</body>

</html>