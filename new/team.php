<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Doctors</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .team-item img {
            height: 300px;
            width: 100%;
            object-fit: cover;
        }
        .team-item .row {
            align-items: center;
        }
        .team-item .d-flex {
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <div class="container" id="doctor">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Our Doctors</h5>
                <h1 class="display-4">Qualified Healthcare Professionals</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="team-item bg-light rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-12 col-sm-5">
                                <img class="img-fluid" src="../img/team-5.jpg">
                            </div>
                            <div class="col-12 col-sm-7 d-flex flex-column">
                                <div class="p-4">
                                    <h3>Dr. Disha Arora</h3>
                                    <h6 class="fw-normal fst-italic text-primary mb-4">Nuclear Medicine Specialist</h6>
                                    <p class="m-0">A skilled Nuclear Medicine Specialist known for her expertise in diagnosing and treating diseases, with 10 years of experience.</p>
                                </div>
                                <div class="d-flex border-top p-4">
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="team-item bg-light rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-12 col-sm-5">
                                <img class="img-fluid" src="../img/team-2.jpg">
                            </div>
                            <div class="col-12 col-sm-7 d-flex flex-column">
                                <div class="p-4">
                                    <h3>Dr. John Abraham</h3>
                                    <h6 class="fw-normal fst-italic text-primary mb-4">Medicine Specialist</h6>
                                    <p class="m-0">A highly skilled Medicine Specialist known for his precision and vast knowledge of diseases, with 15 years of experience.</p>
                                </div>
                                <div class="d-flex border-top p-4">
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="team-item bg-light rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-12 col-sm-5">
                                <img class="img-fluid" src="../img/team-1.jpg">
                            </div>
                            <div class="col-12 col-sm-7 d-flex flex-column">
                                <div class="p-4">
                                    <h3>Dr. Ram Aoual</h3>
                                    <h6 class="fw-normal fst-italic text-primary mb-4">Retina and Cornea Specialist</h6>
                                    <p class="m-0">A dedicated cornea and retina specialist known for her gentle and empathetic approach in providing comprehensive care to patients.</p>
                                </div>
                                <div class="d-flex border-top p-4">
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="team-item bg-light rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-12 col-sm-5">
                                <img class="img-fluid" src="../img/team-11.jpg">
                            </div>
                            <div class="col-12 col-sm-7 d-flex flex-column">
                                <div class="p-4">
                                    <h3>Dr. Simran Chowhan</h3>
                                    <h6 class="fw-normal fst-italic text-primary mb-4">Cornea Specialist</h6>
                                    <p class="m-0">10 years of experience in corneal transplantation and retina surgery. She obtained a PhD in corneal surgery from the UK.</p>
                                </div>
                                <div class="d-flex border-top p-4">
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <?php
    include("footer.php");
    ?>
</body>
</html>
