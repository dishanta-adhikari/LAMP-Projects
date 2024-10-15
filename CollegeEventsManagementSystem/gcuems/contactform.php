<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            text-align: center;
        }

        .closelogin {
            position: absolute;
            top: 1px;
            right: 20px;
            font-size: 40px;
            cursor: pointer;
            transition: 0.4s ease;
            padding: 1%;
        }

        .closelogin:hover {
            transform: scale(1.5);
        }

        .division {
            padding: 10%;
        }
    </style>
</head>

<body>
    <div class="division" style="background-color:#fffbe9;">
        <span class="closelogin" id="closeModal">&times;</span>
        <h1>Thank You ! We will Get Back to You Soon.</h1>
    </div>

    <script>
        const closeModal = document.getElementById('closeModal');
        closeModal.addEventListener('click', () => {
            window.location.href = "./index.php";

        });
    </script>
</body>

</html>