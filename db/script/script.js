      $(document).ready(function(){
        // Open appointment popup on button click
        $("#open-appointment").click(function(){
            // Load content from appointall.php using AJAX
            $("#appointment-content").load("appointall.php");
            // Show the appointment popup
            $("#appointment-popup").modal('show');
        });

        // Close appointment popup when clicking outside the form
        $(document).on('click', function(event) {
            // Check if the clicked element is outside the appointment form
            if (!$(event.target).closest('#appointment-content, #open-appointment').length) {
                // Hide the appointment popup
                $("#appointment-popup").modal('hide');
            }
        });
    });

    $(document).ready(function(){
        // Open appointment popup on button click
        $("#open-appointment").click(function(){
            // Load content from appointall.php using AJAX
            $("#appointment-content").load("appointall.php");
            // Show the appointment popup
            $("#appointment-popup").modal('show');
        });

        // Close appointment popup on close icon click
        $(".close-icon").click(function(){
            // Hide the appointment popup
            $("#appointment-popup").modal('hide');
        });
    });
     $(document).ready(function(){
            // Open appointment popup on button click
            $("#open-appointment").click(function(){
                // Show the appointment popup
                $("#appointment-popup").modal('show');
            });

            // Close appointment popup on close icon click
            $("#close-appointment").click(function(){
                // Hide the appointment popup
                $("#appointment-popup").modal('hide');
            });
        });
document.addEventListener("DOMContentLoaded", function() {
    var serviceDropdown = document.getElementById('serviceDropdown');
    var serviceDropdownMenu = document.getElementById('serviceDropdownMenu');

    // Add click event listener to the service dropdown link
    serviceDropdown.addEventListener('click', function() {
        // Toggle the 'show' class on the dropdown menu
        serviceDropdownMenu.classList.toggle('show');
    });

    // Close the dropdown menu if the user clicks outside of it
    window.addEventListener('click', function(event) {
        if (!serviceDropdownMenu.contains(event.target) && !serviceDropdown.contains(event.target)) {
            serviceDropdownMenu.classList.remove('show');
        }
    });
});


document.addEventListener("DOMContentLoaded", function() {
    var serviceDropdown = document.getElementById('serviceDropdown');
    var serviceDropdownMenu = document.getElementById('serviceDropdownMenu');

    // Add click event listener to the service dropdown link
    serviceDropdown.addEventListener('click', function() {
        // Toggle the 'show' class on the dropdown menu
        serviceDropdownMenu.classList.toggle('show');
    });

    // Close the dropdown menu if the user clicks outside of it
    window.addEventListener('click', function(event) {
        if (!serviceDropdownMenu.contains(event.target) && !serviceDropdown.contains(event.target)) {
            serviceDropdownMenu.classList.remove('show');
        }
    });
});


 $(document).ready(function(){
        // Open appointment popup on button click
        $("#open-appointment").click(function(){
            // Load content from appointall.php using AJAX
            $("#appointment-content").load("appointall.php");
            // Show the appointment popup
            $("#appointment-popup").modal('show');
        });

        // Prevent closing of appointment popup when clicking outside the form fields
        $('#appointment-popup').click(function(event){
            if(!$(event.target).closest('.modal-body').length) {
                event.stopPropagation();
            }
        });

        // Close appointment popup on close icon click
        $(".close-icon").click(function(){
            // Hide the appointment popup
            $("#appointment-popup").modal('hide');
        });

        // Close appointment popup on form submission
        $('#appointment-form').submit(function(event){
            // Prevent default form submission behavior
            event.preventDefault();
            // Submit the form via AJAX
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response){
                    // On successful submission, hide the popup
                    $("#appointment-popup").modal('hide');
                    // Optionally, you can handle the response here
                },
                error: function(xhr, status, error){
                    // Handle errors here
                }
            });
        });
    });
        // Your existing script content

        // Event listener for the chat icon
        $('#chat-icon').on('click', function () {
            // Show the additional features modal
            $('#additionalFeaturesModal').modal('show');
        });

        // Function to load messages for receiver
        function loadMessagesForReceiver(receiver) {
            $.ajax({
                type: 'GET',
                url: 'chat.php?receiver=' + receiver,
                success: function (data) {
                    data = JSON.parse(data);
                    let chatbox = $('#chatbox');
                    chatbox.empty();
                    for (let i = data.length - 1; i >= 0; i--) {
                        let messageClass = (data[i].sender === 'user') ? 'user-message' : '';
                        chatbox.append('<p class="' + messageClass + '"><strong>' + data[i].sender + ':</strong> ' +
                            data[i].message + '</p>');
                        if (data[i].sender === 'user') {
                            showNotification(data[i].sender, data[i].message);
                        }
                    }
                    chatbox.scrollTop(chatbox[0].scrollHeight);
                }
            });
        }

        // Function to load messages
        function loadMessages() {
            loadMessagesForReceiver('admin');
            loadMessagesForReceiver('user');
        }

        // Function to send a message
        function sendMessage(sender, receiver) {
            let message = $('#message').val();

            $.ajax({
                type: 'POST',
                url: 'chat.php',
                data: {
                    sender: sender,
                    receiver: receiver,
                    message: message
                },
                success: function () {
                    loadMessages();
                    $('#message').val('');
                }
            });
        }

        // Event listener for pressing Enter key in the message input
        $('#message').on('keydown', function (e) {
            if (e.key === 'Enter') {
                sendMessage('user', 'admin');
            }
        });

        // Function to show desktop notification
        function showDesktopNotification(sender, message) {
            if (Notification.permission === 'granted') {
                let notification = new Notification('New Message from ' + sender, {
                    body: message,
                    icon: 'path/to/your/icon.png' // Replace with the path to your notification icon
                });

                notification.onclick = function () {
                    // Handle notification click event if needed
                };
            }
        }

        // Function to request notification permission
        function requestNotificationPermission() {
            Notification.requestPermission().then(function (permission) {
                if (permission === 'granted') {
                    console.log('Notification permission granted');
                }
            });
        }

        // Event listener for the delete button
        $('#deleteButton').on('click', function () {
            deleteMessages();
        });

        // Function to delete messages
        function deleteMessages() {
            $.ajax({
                type: 'POST',
                url: 'delete_messages.php',
                success: function (response) {
                    console.log(response);
                    loadMessages(); // Reload messages after deletion
                },
                error: function (error) {
                    console.error('Error deleting messages:', error);
                }
            });
        }

        // Interval to periodically load messages
        setInterval(function () {
            loadMessages();
        }, 1000);

        // Function to show notification in the notification bar
        function showNotification(sender, message) {
            let notificationBar = $('#notification-bar');
            notificationBar.empty();
            notificationBar.append('<div class="notification" style="font-size:12px;">New Message sent to Admin</div>');

            notificationBar.show();

            showDesktopNotification(sender, message);

            setTimeout(function () {
                notificationBar.hide();
            }, 5000);
        }

        $(document).ready(function () {
            if (Notification.permission !== 'granted') {
                requestNotificationPermission();
            }
        });










        // Your existing script content

        // Event listener for the chat icon
        $('#chat-icon').on('click', function () {
            // Show the additional features modal
            $('#additionalFeaturesModal').modal('show');
        });

        // Function to load messages for receiver
        function loadMessagesForReceiver(receiver) {
            $.ajax({
                type: 'GET',
                url: 'chat.php?receiver=' + receiver,
                success: function (data) {
                    data = JSON.parse(data);
                    let chatbox = $('#chatbox');
                    chatbox.empty();
                    for (let i = data.length - 1; i >= 0; i--) {
                        let messageClass = (data[i].sender === 'user') ? 'user-message' : '';
                        chatbox.append('<p class="' + messageClass + '"><strong>' + data[i].sender + ':</strong> ' +
                            data[i].message + '</p>');
                        if (data[i].sender === 'user') {
                            showNotification(data[i].sender, data[i].message);
                        }
                    }
                    chatbox.scrollTop(chatbox[0].scrollHeight);
                }
            });
        }

        // Function to load messages
        function loadMessages() {
            loadMessagesForReceiver('admin');
            loadMessagesForReceiver('user');
        }

        // Function to send a message
        function sendMessage(sender, receiver) {
            let message = $('#message').val();

            $.ajax({
                type: 'POST',
                url: 'chat.php',
                data: {
                    sender: sender,
                    receiver: receiver,
                    message: message
                },
                success: function () {
                    loadMessages();
                    $('#message').val('');
                }
            });
        }

        // Event listener for pressing Enter key in the message input
        $('#message').on('keydown', function (e) {
            if (e.key === 'Enter') {
                sendMessage('user', 'admin');
            }
        });

        // Function to show desktop notification
        function showDesktopNotification(sender, message) {
            if (Notification.permission === 'granted') {
                let notification = new Notification('New Message from ' + sender, {
                    body: message,
                    icon: 'path/to/your/icon.png' // Replace with the path to your notification icon
                });

                notification.onclick = function () {
                    // Handle notification click event if needed
                };
            }
        }

        // Function to request notification permission
        function requestNotificationPermission() {
            Notification.requestPermission().then(function (permission) {
                if (permission === 'granted') {
                    console.log('Notification permission granted');
                }
            });
        }

        // Event listener for the delete button
        $('#deleteButton').on('click', function () {
            deleteMessages();
        });

        // Function to delete messages
        function deleteMessages() {
            $.ajax({
                type: 'POST',
                url: 'delete_messages.php',
                success: function (response) {
                    console.log(response);
                    loadMessages(); // Reload messages after deletion
                },
                error: function (error) {
                    console.error('Error deleting messages:', error);
                }
            });
        }

        // Interval to periodically load messages
        setInterval(function () {
            loadMessages();
        }, 1000);

        // Function to show notification in the notification bar
        function showNotification(sender, message) {
            let notificationBar = $('#notification-bar');
            notificationBar.empty();
            notificationBar.append('<div class="notification" style="font-size:12px;">New Message sent to Admin</div>');

            notificationBar.show();

            showDesktopNotification(sender, message);

            setTimeout(function () {
                notificationBar.hide();
            }, 5000);
        }

        $(document).ready(function () {
            if (Notification.permission !== 'granted') {
                requestNotificationPermission();
            }
        });


  function populateDistricts() {
        var divisionSelect = document.getElementById("division");
        var districtSelect = document.getElementById("district");

        // Clear previous options
        districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';

        // Get selected division
        var selectedDivision = divisionSelect.value;

        // Add districts based on the selected division
        if (selectedDivision === "dhaka") {
            districtSelect.innerHTML += '<option value="dhaka">Dhaka</option>';
             districtSelect.innerHTML += '<option value="gazipur">Gazipur</option>';
            districtSelect.innerHTML += '<option value="narayanganj">Narayanganj</option>';
         districtSelect.innerHTML += '<option value="kishoreganj">Kishoreganj</option>';
           districtSelect.innerHTML += '<option value="manikganj">Manikganj</option>';
            districtSelect.innerHTML += '<option value="munshiganj">Munshiganj</option>';
            districtSelect.innerHTML += '<option value="narsingdi">Narsingdi</option>';
                districtSelect.innerHTML += '<option value="rajbari">Rajbari</option>';
        districtSelect.innerHTML += '<option value="shariatpur">Shariatpur</option>';
        districtSelect.innerHTML += '<option value="faridpur">Faridpur</option>';
        districtSelect.innerHTML += '<option value="madaripur">Madaripur</option>';
        districtSelect.innerHTML += '<option value="gopalganj">Gopalganj</option>';
        districtSelect.innerHTML += '<option value="faridpur">Faridpur</option>';

            // Add more districts for barisal
        } else if (selectedDivision === "barisal") {
            districtSelect.innerHTML += '<option value="barisal">Barisal</option>';
            districtSelect.innerHTML += '<option value="bhola">Bhola</option>';
            districtSelect.innerHTML += '<option value="patuakhali">Patuakhali</option>';

             districtSelect.innerHTML += '<option value="barguna">Barguna</option>';
              districtSelect.innerHTML += '<option value="jhalokathi">Jhalokathi</option>';
               districtSelect.innerHTML += '<option value="Pirojpur">Pirojpur</option>';
 
            // Add more districts for Barisal
        

        // Add conditions for other divisions
    }else if (selectedDivision === "chittagong") {
            districtSelect.innerHTML += '<option value="chittagong">Chittagong</option>';
            districtSelect.innerHTML += '<option value="coxs Bazar">Coxs Bazar</option>';
            districtSelect.innerHTML += '<option value="comilla">Comilla</option>';

             districtSelect.innerHTML += '<option value="feni">Feni</option>';
              districtSelect.innerHTML += '<option value="brahmanbaria">Brahmanbaria</option>';
               districtSelect.innerHTML += '<option value="chandpur">Chandpur</option>';

               districtSelect.innerHTML += '<option value="noakhali">Noakhali</option>';
               districtSelect.innerHTML += '<option value="laxmipur">Laxmipur</option>';
              
               districtSelect.innerHTML += '<option value="khagrachari">Khagrachari</option>';
               districtSelect.innerHTML += '<option value="bandarban">Bandarban</option>';
                districtSelect.innerHTML += '<option value="jhalakathi">Jhalakathi</option>';

}
else if (selectedDivision === "khulna") {
           
             districtSelect.innerHTML += '<option value="khulna">Khulna</option>';
    districtSelect.innerHTML += '<option value="bagerhat">Bagerhat</option>';
    districtSelect.innerHTML += '<option value="chuadanga">Chuadanga</option>';
    districtSelect.innerHTML += '<option value="jessore">Jessore</option>';
    districtSelect.innerHTML += '<option value="jhenaidah">Jhenaidah</option>';
     districtSelect.innerHTML += '<option value="sathkhira">Sathkhira</option>';
      districtSelect.innerHTML += '<option value="magura">Magura</option>';
       districtSelect.innerHTML += '<option value="narail">Narail</option>';
        districtSelect.innerHTML += '<option value="kushtia">Kushtia</option>';
         districtSelect.innerHTML += '<option value="jhenaidah">Jhenaidah</option>';
          districtSelect.innerHTML += '<option value="Meherpur">Meherpur</option>';
         

}else if (selectedDivision === "rajshahi") {
   
         districtSelect.innerHTML += '<option value="rajshahi">Rajshahi</option>';
    districtSelect.innerHTML += '<option value="bogura">Bogura</option>';
    districtSelect.innerHTML += '<option value="joypurhat">Joypurhat</option>';
    districtSelect.innerHTML += '<option value="pabna">Pabna</option>';
    districtSelect.innerHTML += '<option value="chapainawabganj">Chapainawabganj</option>';
    districtSelect.innerHTML += '<option value="naogaon">Naogaon</option>';
    districtSelect.innerHTML += '<option value="natore">Natore</option>';
   
    districtSelect.innerHTML += '<option value="sirajganj">Sirajganj</option>';
    districtSelect.innerHTML += '<option value="chandrima-thana">Chandrima Thana</option>';

}else if (selectedDivision === "sylhet") {
   
         districtSelect.innerHTML += '<option value="sylhet">Sylhet</option>';
    districtSelect.innerHTML += '<option value="habiganj">Habiganj</option>';
    districtSelect.innerHTML += '<option value="moulvibazar">Moulvibazar</option>';
    districtSelect.innerHTML += '<option value="sunamganj">Sunamganj</option>';  

}else if (selectedDivision === "rangpur") {
    districtSelect.innerHTML += '<option value="rangpur">Rangpur</option>';
    districtSelect.innerHTML += '<option value="gaibandha">Gaibandha</option>';
    districtSelect.innerHTML += '<option value="nilphamari">Nilphamari</option>';
    districtSelect.innerHTML += '<option value="kurigram">Kurigram</option>';
    districtSelect.innerHTML += '<option value="lalmonirhat">Lalmonirhat</option>';
    districtSelect.innerHTML += '<option value="dinajpur">Dinajpur</option>';
    districtSelect.innerHTML += '<option value="thakurgaon">Thakurgaon</option>';
    districtSelect.innerHTML += '<option value="panchagarh">Panchagarh</option>';

}else if (selectedDivision === "mymensingh") {
    districtSelect.innerHTML += '<option value="mymensingh">Mymensingh</option>';
    districtSelect.innerHTML += '<option value="netrakona">Netrakona</option>';
    districtSelect.innerHTML += '<option value="jamalpur">Jamalpur</option>';
    districtSelect.innerHTML += '<option value="tangail">Tangail</option>';
    districtSelect.innerHTML += '<option value="sherpur">Sherpur</option>';
}



  
}





    
    function populateDoctors() {
        var departmentSelect = document.getElementById('department');
        var doctorSelect = document.getElementById('doctor');

        // Clear previous options
        doctorSelect.innerHTML = '<option value="" disabled selected>Select Doctor</option>';

        // Populate doctors based on the selected department
        if (departmentSelect.value === 'cardiology') {
    addDoctors([
        'Dr. Ashok Seth',
        'Dr. Amitava Misra',
        'Zile Singh Meharwal',
        'Dr. Ajay Bahadur',
        'Dr. Alok Kumar',
        'Dr. Devi Shetty',
        'Dr. Rabiol Aoual',
     
    ]);


} if (departmentSelect.value === 'dermatology') {
    addDoctors([
        'Dr. Anuj Singh',
        'Dr. Anju Mangla',
        'Dr. DM Mahajan',
        'Dr. Monica Bambroo',
        'Dr. Adrija Datta',
      
     
    ]);
}if (departmentSelect.value === 'orthopedics') {
    addDoctors([
        'Dr. Ashok Rajgopal',
        'Dr. IPS Oberoi',
        'Dr. Pradeep Sharma',
        'Dr. Rakesh Mahajan',
        'Dr. Harshavardhan Hegde',
       
        
       
    ]);
}if (departmentSelect.value === 'neurology') {
    addDoctors([
        'Dr. Abhas Kumar',
        'Dr. Rajiv Anand',
        'Dr. Chandni Shah',
        'Dr. Rahul Gupta',
        
        
    ]);
}


    }

    function addDoctors(doctorNames) {
        var doctorSelect = document.getElementById('doctor');
        doctorNames.forEach(function (doctorName) {
            var option = document.createElement('option');
            option.value = doctorName;
            option.text = doctorName;
            doctorSelect.add(option);
        });
    }







     // Add event listener to the document
    document.addEventListener("keydown", function (event) {
        // Check if the pressed key is the down arrow key (keyCode 40)
        if (event.keyCode === 40) {
            // Get the active element (currently focused element)
            const activeElement = document.activeElement;

            // Get all input elements in the form
            const formInputs = document.querySelectorAll("form input");

            // Find the index of the active input element
            const currentIndex = Array.from(formInputs).indexOf(activeElement);

            // Calculate the next index
            const nextIndex = (currentIndex + 1) % formInputs.length;

            // Focus on the next input element
            formInputs[nextIndex].focus();
        }
    });






