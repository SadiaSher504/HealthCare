<div id="chat-icon" class="position-fixed bottom-0 end-0 p-3" style="cursor: pointer; z-index: 1;">
        <i class="fa-solid fa-headset fa-3x text-primary"></i>
    </div>

    <!-- Additional features modal -->
    <div class="modal fade" id="additionalFeaturesModal" tabindex="-1" role="dialog"
        aria-labelledby="additionalFeaturesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="additionalFeaturesModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <body class="container mt-5">

    <div id="chat-container" class="card">
        <div class="card-header">
            <h6 class="card-title">Admin in Online</h6>
            <div class="online-indicator"></div>
            <div id="notification-bar"></div>
        </div>
        <div id="chatbox" class="card-body"></div>
        <div id="input-container" class="card-footer">
            <div class="input-group mb-3">
                <input type="text" id="message" class="form-control" placeholder="Type your message">
                <button onclick="sendMessage('user', 'admin')" class="btn btn-primary" style="margin-left: 20px;">Send</button>
            </div>
            <button id="deleteButton" class="btn btn-danger btn-block" style="margin-left:20px; margin-top:-15px; width:100px; font-size: 10px;">Clear chat</button>

                </div>
            </div>
        </div>
    </div>