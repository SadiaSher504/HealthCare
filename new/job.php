<?php
include('../index/service.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Packages</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Owl Carousel CSS (for carousels) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <style>
        .price-carousel img {
            width: 100%;
            height: auto;
        }
        .price-carousel .position-absolute {
            transition: all 0.3s ease-in-out;
            opacity: 0;
        }
        
    </style>
</head>
<body>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Medical Packages</h5>
                <h1 class="display-4">Awesome Medical Programs</h1>
            </div>
            <div class="owl-carousel price-carousel position-relative" style="padding: 0 45px 45px 45px;">
                <!-- Package 1 -->
                <div class="bg-light rounded text-center">
                    <div class="position-relative">
                        <img class="img rounded-top" src="../img/price-2.jpg" alt="">
                        <div class="position-absolute w-100 h-100 top-50 start-50 translate-middle rounded-top d-flex flex-column align-items-center justify-content-center" style="background: rgba(29, 42, 77, .8);">
                            <h3 class="text-white">Pregnancy Care</h3>
                            <h1 class="display-4 text-white mb-0">
                                <small class="align-top fw-normal" style="font-size: 22px;">RS</small>49<small class="align-bottom fw-normal" style="font-size: 16px;">/ Year</small>
                            </h1>
                        </div>
                    </div>
                    <div class="text-center py-5">
                        <p>Emergency Medical Treatment</p>
                        <p>Highly Experienced Doctors</p>
                        <p>Highest Success Rate</p>
                        <p><b>Telephone Service</b></p>
                        <a href="#" class="btn btn-primary rounded-pill py-3 px-5 my-2" data-bs-toggle="modal" data-bs-target="#jobApplicationModal">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Application Modal -->
    <div class="modal fade" id="jobApplicationModal" tabindex="-1" aria-labelledby="jobApplicationModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="jobApplicationModalLabel">Job Application Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="JobForm">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
              </div>
              <div class="mb-3">
                <label for="resume" class="form-label">Upload Resume</label>
                <input type="file" class="form-control" id="resume" name="resume">
              </div>
              <button type="submit" class="btn btn-primary">Submit Application</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Appointment Successful</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your appointment has been booked successfully!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (required for Owl Carousel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                autoplay: true,
                autoplayTimeout: 3000,
                responsive:{
                    0:{ items:1 },
                    600:{ items:2 },
                    1000:{ items:3 }
                }
            });
        });
        document.getElementById('JobForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    </script>
    
    <?php
    include("footer.php");
    ?>

</body>
</html>
