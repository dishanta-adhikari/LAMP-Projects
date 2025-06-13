<?php
require_once('connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You are logged Out ! Please log in Again");</script>';
    echo '<script>window.location.href = "./index";</script>';
    exit;
}

if (isset($_POST['delete']) && isset($_POST['club_id'])) {
    $club_id = $_POST['club_id'];

    // Retrieve the email associated with the club
    $email_query = "SELECT email FROM club WHERE club_id = ?";
    $stmt_email = mysqli_prepare($con, $email_query);

    if ($stmt_email) {
        mysqli_stmt_bind_param($stmt_email, "i", $club_id);
        mysqli_stmt_execute($stmt_email);
        $result = mysqli_stmt_get_result($stmt_email);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];

        // Delete data from both 'club' and 'user' tables where the email IDs match
        $delete_query = "DELETE club, user FROM club INNER JOIN user ON club.email = user.email WHERE club.email = ?";
        $stmt_delete = mysqli_prepare($con, $delete_query);

        if ($stmt_delete) {
            mysqli_stmt_bind_param($stmt_delete, "s", $email);
            $delete_result = mysqli_stmt_execute($stmt_delete);

            if ($delete_result) {
                echo '<script>alert("Club data deleted successfully")</script>';
                echo '<script>window.location.href = "./viewclub";</script>';
                exit;
            } else {
                echo '<script>alert("Failed to delete club ")</script>';
            }

            mysqli_stmt_close($stmt_delete);
        } else {
            echo '<script>alert("Failed to prepare delete statement")</script>';
        }

        mysqli_stmt_close($stmt_email);
    } else {
        echo '<script>alert("Failed to fetch email")</script>';
    }
}

$query = "SELECT * FROM club";
$res = mysqli_query($con, $query);
?>



<!-- html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/cropped-GCU-Logo-circle.png">
    <title>View Clubs</title>
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

        @media only screen and (max-width: 770px) {
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
                        <h2 class="display-6">Present Clubs Data</h2>
                        <span id="closeModal">&times;</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td class="bg-dark text-white"> Club ID </td>
                                    <td class="bg-dark text-white"> Club Name </td>
                                    <td class="bg-dark text-white"> Email </td>
                                    <td class="bg-dark text-white"> Phone </td>
                                    <td class="bg-dark text-white"> Delete </td>
                                </tr>
                                <tr>

                                    <?php
                                    // Fetch all the clubs from the database and display them
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['club_id']; ?>
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
                                            <!-- Delete button -->
                                            <form class="del" method="post" action="">
                                                <input type="hidden" name="club_id" id="clubId"
                                                    value="<?php echo $row['club_id']; ?>">
                                                <input type="hidden" name="name" id="clubName"
                                                    value="<?php echo $row['name']; ?>">
                                                <button type="submit" name="delete" class="btn btn-danger"
                                                    onclick="confirmDelete(<?php echo $row['club_id']; ?>, '<?php echo $row['name']; ?>')">Delete</button>
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
            window.location.href = "./admindash";

        });


        function confirmDelete(clubId, clubName) {
            if (confirm('Are you sure you want to delete this Club ?')) {
                // Set the program_id to the hidden input field and submit the form
                document.getElementById('clubId').value = clubId;
                document.getElementById('deleteForm').submit();
            }
            else {
                // Prevent form submission if cancel is clicked
                event.preventDefault();
            }
        }


    </script>
    <script src="./assets/JS/printpage.js"></script>
</body>

</html>