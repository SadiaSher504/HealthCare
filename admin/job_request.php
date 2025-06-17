<?php
include("../include/connection.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Job Requests - Admin Panel</title>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>

<body>

    <!-- Top Navbar -->
    <?php include("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include("sidenav.php"); ?>

            <!-- Main Content -->
            <div class="col-12 col-md-10">
                <div class="container-fluid">
                    <h2 class="mb-4 text-center">Pending Job Requests</h2>
                    <div id="show"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resume Modal -->
    <div class="modal fade" id="resumeModal" tabindex="-1" aria-labelledby="resumeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resumeModalLabel">Resume Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="resumeContent" style="height: 80vh;">
                    <!-- Resume iframe loads here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- <script>$(document).ready(function(){
  loadRequests();

  function loadRequests() {
    $.ajax({
      url: "ajax_job_request.php",
      method: "POST",
      success: function(data){
        $("#show").html(data);
      }
    });
  }

  $(document).on('click', '.approve', function() {
    var id = $(this).attr('id');
    var type = $(this).data('type');
    var salary = $('#salaryInput-' + type + '-' + id).val(); 

    // Only require salary for doctor and employee
    if ((type === 'doctor' || type === 'employee') && (salary == "")) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Salary is required!',
        });
        return;
    }

    $.ajax({
        url: "update_job_status.php",
        method: "POST",
        data: {id: id, type: type, action: 'approve', salary: salary},
        success: function(response) {
            Swal.fire(
                'Approved!',
                'The request has been approved.',
                'success'
            ).then(() => {
                location.reload();
            });
        },
        error: function() {
            Swal.fire(
                'Error!',
                'There was an issue processing your request.',
                'error'
            );
        }
    });
  });

  $(document).on('click', '.reject', function() {
    var id = $(this).attr('id');
    var type = $(this).data('type');

    // Perform AJAX request to update the status
    $.ajax({
        url: "reject_job_status.php",  // Ensure this URL is correct for rejection
        method: "POST",
        data: {id: id, type: type, action: 'reject'},
        success: function(response) {
            Swal.fire(
                'Rejected!',
                'The request has been rejected.',
                'error'
            ).then(() => {
                location.reload(); // Reload the page after rejection
            });
        },
        error: function() {
            Swal.fire(
                'Error!',
                'There was an issue processing your request.',
                'error'
            );
        }
    });
  });

  $(document).on('click', '.view-resume', function(){
    var resumeUrl = $(this).data('resume-url');
    if(resumeUrl){
      $("#resumeContent").html("<iframe src='" + resumeUrl + "' width='100%' height='100%' style='border: none;'></iframe>");
      $("#resumeModal").modal('show');
    } else {
      alert("Resume not available!");
    }
  });
}); 
</script>-->
    <script>
        $(document).ready(function() {
            loadRequests();

            function loadRequests() {
                $.ajax({
                    url: "ajax_job_request.php",
                    method: "POST",
                    success: function(data) {
                        $("#show").html(data);
                    }
                });
            }

            // $(document).on('click', '.approve', function() {
            //     var id = $(this).attr('id');
            //     var type = $(this).data('type');
            //     var salary = $('#salaryInput-' + type + '-' + id).val();

            //     // Only require salary for doctor and employee
            //     if ((type === 'doctor' || type === 'employee') && (salary == "")) {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Oops...',
            //             text: 'Salary is required!',
            //         });
            //         return;
            //     }

            //     $.ajax({
            //         url: "update_job_status.php",
            //         method: "POST",
            //         data: {id: id, type: type, action: 'approve', salary: salary},
            //         success: function(response) {
            //             Swal.fire(
            //                 'Approved!',
            //                 'The request has been approved.',
            //                 'success'
            //             ).then(() => {
            //                 location.reload();
            //             });
            //         },
            //         error: function() {
            //             Swal.fire(
            //                 'Error!',
            //                 'There was an issue processing your request.',
            //                 'error'
            //             );
            //         }
            //     });
            // });
            // $(document).on('click', '.approve', function() {
            //     var id = $(this).attr('id');
            //     var type = $(this).data('type');
            //     var salary = $('#salaryInput-' + type + '-' + id).val();

            //     // Check if salary is provided (for doctor and employee)
            //     if ((type === 'doctor' || type === 'employee') && (salary == "" || isNaN(salary))) {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Oops...',
            //             text: 'Salary is required and must be a valid number!',
            //         });
            //         return;
            //     }

            //     $.ajax({
            //         url: "update_job_status.php",
            //         method: "POST",
            //         data: {
            //             id: id,
            //             type: type,
            //             action: 'approve',
            //             salary: salary
            //         },
            //         success: function(response) {
            //             Swal.fire(
            //                 'Approved!',
            //                 'The request has been approved.',
            //                 'success'
            //             ).then(() => {
            //                 location.reload(); // Reload the page after approval
            //             });
            //         },
            //         error: function() {
            //             Swal.fire(
            //                 'Error!',
            //                 'There was an issue processing your request.',
            //                 'error'
            //             );
            //         }
            //     });
            // });
           
           
           
           
           
            // $(document).on('click', '.approve', function() {
            //     var id = $(this).attr('id');
            //     var type = $(this).data('type');
            //     var salaryInputId = '#salaryInput-' + type + '-' + id;

            //     // For employees, we need to ask for salary first
            //     if (type === 'employee') {
            //         Swal.fire({
            //             title: 'Enter Salary',
            //             input: 'number',
            //             inputLabel: 'Salary for the Employee',
            //             inputPlaceholder: 'Enter salary',
            //             showCancelButton: true,
            //             inputValidator: (value) => {
            //                 if (!value || isNaN(value) || value <= 0) {
            //                     return 'Please enter a valid salary!';
            //                 }
            //             }
            //         }).then((result) => {
            //             if (result.isConfirmed) {
            //                 var salary = result.value;

            //                 // Now perform the approval with the entered salary
            //                 $.ajax({
            //                     url: "update_job_status.php",
            //                     method: "POST",
            //                     data: {
            //                         id: id,
            //                         type: type,
            //                         action: 'approve',
            //                         salary: salary // Send the entered salary
            //                     },
            //                     success: function(response) {
            //                         var res = JSON.parse(response); // Parse the response from PHP
            //                         if (res.status === 'success') {
            //                             Swal.fire(
            //                                 'Approved!',
            //                                 'The request has been approved.',
            //                                 'success'
            //                             ).then(() => {
            //                                 location.reload(); // Reload the page after approval
            //                             });
            //                         } else {
            //                             Swal.fire(
            //                                 'Error!',
            //                                 res.message,
            //                                 'error'
            //                             );
            //                         }
            //                     },
            //                     error: function() {
            //                         Swal.fire(
            //                             'Error!',
            //                             'There was an issue processing your request.',
            //                             'error'
            //                         );
            //                     }
            //                 });
            //             }
            //         });
            //     } else {
            //         // For non-employee types, you can directly proceed to approval
            //         $.ajax({
            //             url: "update_job_status.php",
            //             method: "POST",
            //             data: {
            //                 id: id,
            //                 type: type,
            //                 action: 'approve'
            //             },
            //             success: function(response) {
            //                 var res = JSON.parse(response);
            //                 if (res.status === 'success') {
            //                     Swal.fire(
            //                         'Approved!',
            //                         'The request has been approved.',
            //                         'success'
            //                     ).then(() => {
            //                         location.reload();
            //                     });
            //                 } else {
            //                     Swal.fire(
            //                         'Error!',
            //                         res.message,
            //                         'error'
            //                     );
            //                 }
            //             },
            //             error: function() {
            //                 Swal.fire(
            //                     'Error!',
            //                     'There was an issue processing your request.',
            //                     'error'
            //                 );
            //             }
            //         });
            //     }
            // });
            $(document).on('click', '.approve', function() {
    var id = $(this).attr('id');
    var type = $(this).data('type');
    
    // Check if type is employee, doctor, or account branch to ask for salary
    if (type === 'employee' || type === 'doctor' || type === 'account_branch') {
        Swal.fire({
            title: 'Enter Salary',
            input: 'number',
            inputLabel: 'Salary for the ' + type.charAt(0).toUpperCase() + type.slice(1),
            inputPlaceholder: 'Enter salary',
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value || isNaN(value) || value <= 0) {
                    return 'Please enter a valid salary!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var salary = result.value;

                // Now perform the approval with the entered salary
                $.ajax({
                    url: "update_job_status.php",
                    method: "POST",
                    data: {
                        id: id,
                        type: type,
                        action: 'approve',
                        salary: salary // Send the entered salary
                    },
                    success: function(response) {
                        var res = JSON.parse(response); // Parse the response from PHP
                        if (res.status === 'success') {
                            Swal.fire(
                                'Approved!',
                                'The request has been approved.',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page after approval
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                res.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an issue processing your request.',
                            'error'
                        );
                    }
                });
            }
        });
    } else {
        // For non-employee types, proceed with approval without asking salary
        $.ajax({
            url: "update_job_status.php",
            method: "POST",
            data: {
                id: id,
                type: type,
                action: 'approve'
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    Swal.fire(
                        'Approved!',
                        'The request has been approved.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        res.message,
                        'error'
                    );
                }
            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'There was an issue processing your request.',
                    'error'
                );
            }
        });
    }
});


            $(document).on('click', '.reject', function() {
                var id = $(this).attr('id');
                var type = $(this).data('type');

                $.ajax({
                    url: "reject_job_status.php", // Ensure this URL is correct for rejection
                    method: "POST",
                    data: {
                        id: id,
                        type: type,
                        action: 'reject'
                    },
                    success: function(response) {
                        var res = JSON.parse(response); // Parse the response from PHP
                        if (res.status === 'success') {
                            Swal.fire(
                                'Rejected!',
                                'The request has been rejected.',
                                'error'
                            ).then(() => {
                                location.reload(); // Reload the page after rejection
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                res.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an issue processing your request.',
                            'error'
                        );
                    }
                });
            });


            $(document).on('click', '.view-resume', function() {
                var resumeUrl = $(this).data('resume-url');
                if (resumeUrl) {
                    $("#resumeContent").html("<iframe src='" + resumeUrl + "' width='100%' height='100%' style='border: none;'></iframe>");
                    $("#resumeModal").modal('show');
                } else {
                    alert("Resume not available!");
                }
            });
        });
    </script>


</body>

</html>