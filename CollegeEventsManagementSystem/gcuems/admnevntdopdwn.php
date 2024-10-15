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

$user_name = $_SESSION['name'];
$query1 = "SELECT user_id FROM user WHERE name = '$user_name'";
$res1 = mysqli_query($con, $query1);

if ($res1) {
    $user = mysqli_fetch_assoc($res1);
    $user_id = $user['user_id'];
}

if (isset($_POST['delete_program_id'])) {
    $program_id = $_POST['delete_program_id'];

    // Prepare a DELETE query to remove the program
    $delete_query = "DELETE FROM program WHERE program_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $program_id);
        $delete_result = mysqli_stmt_execute($stmt);

        if ($delete_result) {
            echo '<script>alert("Program deleted successfully")</script>';
            // Redirect to the same page to update the program data displayed after deletion
            echo '<script>window.location.href = "./currentprograms.php";</script>';
            exit;
        } else {
            echo '<script>alert("Failed to delete the program")</script>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo '<script>alert("Failed to prepare delete statement")</script>';
    }
}


$query = "SELECT * FROM program where user_id = '$user_id'";
$res2 = mysqli_query($con, $query);


?>



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
                                    <td class="bg-dark text-white"> Program Name </td>
                                    <td class="bg-dark text-white"> Date </td>
                                    <td class="bg-dark text-white"> Time </td>
                                    <td class="bg-dark text-white"> Venue</td>
                                    <td class="bg-dark text-white"> Theme</td>
                                    <td class="bg-dark text-white"> Staff-Coordinator </td>
                                    <td class="bg-dark text-white"> Phone</td>
                                    <td class="bg-dark text-white"> Student-Coordinator</td>
                                    <td class="bg-dark text-white"> Phone</td>
                                    <td class="bg-dark text-white"> Conducted By</td>
                                    <td class="bg-dark text-white"> Delete</td>
                                </tr>
                                <tr>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($res2)) {
                                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['program_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['date']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['time']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['venue']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $user_id = $row['program_id'];
                                            $query = "SELECT image FROM program WHERE program_id = $user_id";
                                            $result = mysqli_query($con, $query);
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                $row0 = mysqli_fetch_assoc($result);
                                            }
                                            ?>
                                            <img class="admin-img" src="<?php echo $row0['image']; ?>" width="90px"
                                                alt="image"></a>
                                        </td>
                                        <td>
                                            <?php echo $row['staff_coordinator']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['phone1']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['student_coordinator']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['phone2']; ?>
                                        </td>
                                        <td>
                                            <?php $user_id = $row['user_id']; // Assuming $row contains user_id
                                                $query = "SELECT name FROM user WHERE user_id = '$user_id'";
                                                $res = mysqli_query($con, $query);

                                                if ($res) {
                                                    $user = mysqli_fetch_assoc($res);
                                                    echo $user['name']; // Display the retrieved name
                                                } ?>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['program_id']; ?>)">delete</a>
                                        </td>
                                        <form id="deleteForm" method="POST">
                                            <input type="hidden" name="delete_program_id" id="deleteProgramId">
                                        </form>
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
            window.location.href = './currentprograms.php';
        });



        function confirmDelete(programId) {
            if (confirm('Deleting this program will result in the permanent deletion of corresponding Participant Data. Are you certain you wish to proceed ?')) {
                // Set the program_id to the hidden input field and submit the form
                document.getElementById('deleteProgramId').value = programId;
                document.getElementById('deleteForm').submit();
            }
        }

    </script>
    <script src="./assets/JS/printpage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>