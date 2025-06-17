
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Favicon -->
    <link href="img/favicon.png" rel="icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

    <!-- Custom Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: seashell;
            flex-direction: column;
        }
        .container {
            text-align: center;
        }
        .success-animation {
            display: inline-block;
            position: relative;
            animation: fadeinup 0.5s ease forwards;
        }
        @keyframes fadeinup {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .checkmark {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            fill: none;
            animation: drawCircle 0.5s ease forwards;
            margin: 20px auto;
        }
        .checkmark-circle {
            stroke-dashoffset: 166;
            stroke-dasharray: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #4bb71b;
            fill: none;
            animation: strokeCircle 0.6s ease forwards;
        }
        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dashoffset: 48;
            stroke-dasharray: 48;
            stroke-width: 2;
            stroke: #4bb71b;
            animation: drawCheck 0.6s ease forwards;
        }
        .success-message {
            margin-top: 10px;
            font-family: Arial, sans-serif;
            font-size: 18px;
            color: #333;
            animation: fadeIn 0.6s ease forwards 0.6s;
        }
        @keyframes drawCircle {
            0% { stroke-dashoffset: 166; }
            100% { stroke-dashoffset: 0; }
        }
        @keyframes strokeCircle {
            0% { stroke-dashoffset: 166; }
            100% { stroke-dashoffset: 0; }
        }
        @keyframes drawCheck {
            0% { stroke-dashoffset: 48; }
            100% { stroke-dashoffset: 0; }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-animation">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark-check" fill="none" stroke="#4bb71b" stroke-width="2" d="M16 26l6 6 12-12"/>
            </svg>
            <p class="success-message">Appointment Request Successfully Sent.</p>
        </div>
    </div>

    <footer style="margin-top: 100px; height: 100px; width:100%">
        <?php include("include/footer.php"); ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
