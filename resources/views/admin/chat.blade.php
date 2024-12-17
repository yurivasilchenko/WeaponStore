<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Required meta tags -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @include('admin.css')

</head>
<body>
<div class="container-scroller">

    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    @include('admin.navbar')

    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="chat">
                    <div class="user-list">
                        <ul>
                            @foreach($users as $user)
                                <li data-user-id="{{ $user->id }}" class="user-select">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    </div>



                    <div class="chat-body">

                        <div id="loading-indicator" class="loading-spinner">
                            <div class="spinner"></div>
                            <p class="loading-text">Loading messages...</p>
                        </div>

                        <div class="messages" id="chat-messages">
                            @foreach($messages as $message)
                                <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                                    <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="chat-form-container">
                            <form method="POST" action="/broadcast">
                                @csrf
                                <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                                <input type="hidden" id="recipient_id" name="recipient_id">
                                <button type="submit" class="admin-chat-button">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



        <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
@include('admin.scripts')
</body>
</html>


<script>
    $(document).ready(function() {
        let pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }
            }
        });

        let channel = null; // Define the channel globally so it can be reused

        // Automatically select the first user when the page loads
        const firstUser = $('.user-select').first();
        if (firstUser.length > 0) {
            const firstUserId = firstUser.data('user-id');
            $('#recipient_id').val(firstUserId);
            firstUser.addClass('active');
            loadMessagesForUser(firstUserId);
            subscribeToPrivateChannel(firstUserId);
        }

        // Handle user selection when a user is clicked
        $('.user-select').click(function() {
            $('.user-select').removeClass('active');
            $(this).addClass('active');

            const selectedUserId = $(this).data('user-id');
            $('#recipient_id').val(selectedUserId);
            loadMessagesForUser(selectedUserId);
            subscribeToPrivateChannel(selectedUserId);
        });

        // Function to subscribe to private Pusher channel
        function subscribeToPrivateChannel(recipientId) {
            if (channel) {
                channel.unbind();
                pusher.unsubscribe('private-chat.' + recipientId);
            }

            channel = pusher.subscribe('private-chat.' + recipientId);
            console.log(recipientId);
            Pusher.logToConsole = true;

            pusher.connection.bind('connected', function() {
                console.log("Pusher connected successfully");
            });

            pusher.connection.bind('error', function(err) {
                console.error("Pusher connection error: ", err);
            });

            // Bind the chat event to receive messages for this channel
            channel.bind('chat', function(data) {
                const selectedUser = $('.user-select.active').text(); // Get the selected user's name
                const newMessage = `<div class="message received"><p><strong>${selectedUser}:</strong> ${data.message}</p></div>`;
                $(".messages").append(newMessage);
                scrollToBottom(); // Scroll to the bottom when a new message is received
                console.log("Message received");
            });
        }

        // Function to load messages for the selected user
        function loadMessagesForUser(userId) {
            $('#loading-indicator').show();  // Show the loading spinner
            $('#chat-messages').hide();      // Hide the chat messages until they load

            $.ajax({
                url: '/adminchat/' + userId,
                method: 'GET',
                success: function(data) {
                    $('#chat-messages').html(data);
                    $('#loading-indicator').hide();  // Hide the loading spinner once messages are loaded
                    $('#chat-messages').show();      // Show the chat messages
                    scrollToBottom();                // Scroll to the bottom
                },
                error: function(xhr) {
                    console.log('Error loading messages: ', xhr);
                    $('#loading-indicator').hide();  // Hide the loading spinner if there's an error
                    $('#chat-messages').show();      // Show the chat messages
                }
            });
        }

        // Broadcast messages
        $("form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "/broadcast",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    message: $("#message").val(),
                    recipient_id: $("#recipient_id").val()
                }
            }).done(function(res) {
                $(".messages").append(`<div class="message sent"><p><strong>Admin:</strong> ${$("#message").val()}</p></div>`);
                $("#message").val(''); // Clear the input
                scrollToBottom(); // Scroll to the bottom after sending a message
                console.log('Message sent');
            });
        });

        // Function to scroll to the bottom of the messages
        function scrollToBottom() {
            const messagesContainer = $(".messages");
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
        }
    });


</script>


