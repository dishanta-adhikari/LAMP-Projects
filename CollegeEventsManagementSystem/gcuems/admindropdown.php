<?php
require_once('connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You are logged Out ! Please log in Again");</script>';
    echo '<script>window.location.href = "./index.php";</script>';
    exit;
}


if (isset($_POST['name'])) {
    $_SESSION['name'] = $_POST['name'];
} else {
    echo "<script>Error Fetchnig Program Name</script>";
}

$program_name = $_SESSION['name'];
$query1 = "SELECT program_id FROM program WHERE name = '$program_name'";
$res1 = mysqli_query($con, $query1);

if ($res1) {
    $user = mysqli_fetch_assoc($res1);
    $program_id = $user['program_id'];
}

if (isset($_POST['delete_participant'])) {
    $participant_id = $_POST['participant_id'];

    // Query to delete participant based on participant ID
    $delete_query = "DELETE FROM participant WHERE participant_id = '$participant_id'";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result) {
        // Participant deleted successfully
        echo '<script>alert("Participant deleted successfully");</script>';
    } else {
        // Failed to delete participant
        echo '<script>alert("Failed to delete participant");</script>';
    }
}



$query = "SELECT * FROM participant WHERE program_id='$program_id'";
$res = mysqli_query($con, $query);



?>


<!-- html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/cropped-GCU-Logo-circle.png">
    <title>
        <?php echo $_SESSION['name']; ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        .card-header {
            display: flex;
            justify-content: space-between;
        }

        .card-header a {
            text-decoration: none;
            font-size: large;
            padding: 20px 0px 20px 0;
        }

        .card-header a:hover {
            color: #dd3737;
            transition: 0.5s ease;
        }

        .card-header a:hover {
            transform: scale(1.1);
        }

        #closeModal {
            font-size: 40px;
            cursor: pointer;
            transition: 0.5s ease;
        }

        #closeModal:hover {
            transform: scale(1.5);
        }

        .card-header h2 {
            text-align: start;
        }

        .card-footer {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        @media screen and (max-width: 1205px) {
            body {
                font-size: 0.7rem;
            }
        }

        @media screen and (max-width: 1023px) {
            body {
                font-size: 0.7rem;
            }
        }
    </style>

</head>

<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="column">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="display-6">
                            <?php echo $_SESSION['name']; ?>
                        </h2>
                        <span id="closeModal">&times;</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td class="bg-dark text-white"> ID </td>
                                    <td class="bg-dark text-white"> Name </td>
                                    <td class="bg-dark text-white"> Email </td>
                                    <td class="bg-dark text-white"> Phone </td>
                                    <td class="bg-dark text-white"> Branch </td>
                                    <td class="bg-dark text-white"> Semester </td>
                                    <td class="bg-dark text-white"> College </td>
                                    <td class="bg-dark text-white"> Program Name </td>
                                    <td class="bg-dark text-white"> Conducted By </td>
                                    <td class="bg-dark text-white"> Delete </td>
                                </tr>
                                <tr>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['participant_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['phone']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['branch']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['sem']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['college']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $user_id = $row['program_id']; // Assuming $row contains program_id
                                            $query = "SELECT name FROM program WHERE program_id = '$user_id'";
                                            $res2 = mysqli_query($con, $query);

                                            if ($res2) {
                                                $program = mysqli_fetch_assoc($res2);
                                                echo $program['name']; // Display the retrieved program name
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <?php

                                            $user_id = $row['user_id']; // Assuming $row contains user_id
                                            $query = "SELECT name FROM user WHERE user_id = '$user_id'";
                                            $res3 = mysqli_query($con, $query);

                                            if ($res) {
                                                $user = mysqli_fetch_assoc($res3);
                                                echo $user['name']; // Display the retrieved name
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <!-- Form to submit participant ID for deletion with confirmation -->
                                            <form action="" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this participant data?');">
                                                <input type="hidden" name="participant_id"
                                                    value="<?php echo $row['participant_id']; ?>">
                                                <button type="submit" name="delete_participant"
                                                    class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>

                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a onclick="printPage()" href="#" class="btn btn-secondary">Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const closeModal = document.getElementById('closeModal');
        closeModal.addEventListener('click', () => {
            window.location.href = './viewparticipants.php';

        });
    </script>
    <script src="./assets/JS/printpage.js"></script>
</body>

</html>