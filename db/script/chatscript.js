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