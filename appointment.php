<?php
include("database.php");
?>

<!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Appointment form</title>
     <style>
         body {
             font-family: sans-serif;
             margin: 0;
             padding: 0;
             background-color: transparent;
             background-size: 100% auto;

         }

         header {
             color: #fff;
             padding: 0px;
             text-align: center;
         }

         form {
             max-width: 600px;
             margin: 10px auto;
             padding: 20px;
             border-radius: 8px;
             box-shadow: 0 0 10px rgba(0, 120, 220, 150.1);
             background-color: rgba(135, 206, 250, 0.7);
            
            }

         label {
             display: block;
             margin-bottom: 8px;
             margin-left: 80px;

         }

         input,
         select {
             width: 300px;
             padding: 10px;
             margin-bottom: 12px;
             margin-left: 80px;
             box-sizing: border-box;
         }

        button{
            background-color: #333;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;

        }
     </style>
 </head>

 <body>
     <form action="" method="post" >
         <h2 style="margin-left:80px">Appointment Form</h2>

         <label for="name">Full Name</label><br>
         <input type="text" name="name" required autocomplte="off" id="name" placeholder="Enter full name"><br>

         <label for="email">Email </label><br>
         <input type="email" name="email" required autocomplte="off" id="email" placeholder="Enter email address"><br>

         <label for="phone">Phone Number</label><br>
         <input type="tel" name="phone" required autocomplte="off" id="phone" placeholder="Enter phone number"><br>

         <label for="gender">Gender</label><br>
         <select name="gender" id="gender" required autocomplte="off" placeholder="Select Gender">

             <option value="male">Male</option>
             <option value="female">Female</option>
             <option value="others">Others</option>
         </select> <br>

         <label for="location">Select Location</label><br>
         <select name="division" id="division" onchange="populateDistrict()">Select Division<br>
         <option value="lahore">Lahore</option>
         <option value="karachi">Karachi</option>
         <option value="islamabad">Islamabad</option>
         </select><br>

         <select name="district">
             <option value="" disabled selected></option>
         </select><br>

         <label for="department">Select Department</label><br>
         <select name="department" id="department" required onchange="populateDoctors()">
             <option value="" disabled selected> Select Department</option>
             <option value="cardiology">Cardiology</option>
             <option value="neurology">Neurology</option>
             <option value="pediatrics">Pediatrics</option>
         </select><br>

         <label for="doctor">Select Doctor</label> <br>
         <select name="doctor" id="doctor" required>
             <option value="" disabled selected>Select Doctor First</option>
             <option value="">DR AMAN</option>
             <option value="">DR AMAN</option>
             <option value="">DR AMAN</option>
         </select><br>

         <label for="date">Select Appoint date</label><br>
         <input type="date" name="date" id="date" required><br>
         <label for="time">Time</label>
         <input type="time" name="time" required><br><br>

         <button type="submit" style="margin-left: 150px;">Book Appointment</button>

     </form>

 </body>
<script src="script.js">

</script>

 </html>