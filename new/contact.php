<?php
include("../index/service.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .contact-form {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; /* Ensures form doesn't stretch too wide */
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-custom {
            background: #007bff;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
            <h5 class="text-primary text-uppercase border-bottom border-5 d-inline-block">Contact Us</h5>
            <h1 class="display-4">Get in Touch</h1>
        </div>

        <!-- Centering the form using d-flex and justify-content-center -->
        <div class="d-flex justify-content-center">
            <div class="contact-form">
                <h4 class="mb-4 text-center">Send Us a Message</h4>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="4" placeholder="Write your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
