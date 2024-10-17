<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
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

    <div class="container-scroller">
        <div class="chat">
            <div class="user-list">
                <ul>
                    @foreach($users as $user)
                        <li data-user-id="{{ $user->id }}" class="user-select">{{ $user->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="messages" id="chat-messages" style="display: none;">
                @foreach($messages as $message)
                    <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                        <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Loading indicator -->
            <div id="loading-indicator" style="display: none;">
                <p>Loading...</p>
            </div>

            <!-- Message input and submit form -->
            <div class="bottom">
                <form method="POST" action="/broadcast">
                    @csrf
                    <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                    <input type="hidden" id="recipient_id" name="recipient_id">
                    <button type="submit" style="height: 30px;width:30px;"></button>
                </form>
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
            authEndpoint: '/broadcasting/auth',  // This handles private channel authentication
            auth: {
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'  // Include CSRF token
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

            // Subscribe to the Pusher private channel for the first user
            subscribeToPrivateChannel(firstUserId);
        }

        // Handle user selection when a user is clicked
        $('.user-select').click(function() {
            $('.user-select').removeClass('active');
            $(this).addClass('active');

            const selectedUserId = $(this).data('user-id');
            $('#recipient_id').val(selectedUserId);
            loadMessagesForUser(selectedUserId);

            // Subscribe to the Pusher private channel for the selected user
            subscribeToPrivateChannel(selectedUserId);
        });

        // Function to subscribe to private Pusher channel
        function subscribeToPrivateChannel(recipientId) {
            if (channel) {
                // Unbind and unsubscribe the previous channel before subscribing to a new one
                channel.unbind();
                pusher.unsubscribe('private-chat.' + recipientId);
            }


            // Subscribe to a new private channel

            channel = pusher.subscribe('private-chat.' + recipientId);
            console.log(recipientId)
            Pusher.logToConsole = true;

            pusher.connection.bind('connected', function() {
                console.log("Pusher connected successfully");
            });

            pusher.connection.bind('error', function(err) {
                console.error("Pusher connection error: ", err);
            });


            // Bind the chat event to receive messages for this channel
            channel.bind('chat', function(data) {
                // Append the received message to the chat window
                const newMessage = `<div class="left message"><p>${data.message}</p></div>`;
                $(".messages").append(newMessage);
                console.log("binded");

                // Scroll to the bottom of the chat
                $(document).scrollTop($(document).height());
            });
        }

        // Function to load messages for the selected user
        function loadMessagesForUser(userId) {
            $('#loading-indicator').show();
            $('#chat-messages').hide();

            $.ajax({
                url: '/adminchat/' + userId,
                method: 'GET',
                success: function(data) {
                    console.log('Succes: ');
                    $('#chat-messages').html(data);
                    $('#loading-indicator').hide();
                    $('#chat-messages').show();
                },
                error: function(xhr) {
                    console.log('Error loading messages: ', xhr);
                    $('#loading-indicator').hide();
                    $('#chat-messages').show();
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
                    recipient_id: $("#recipient_id").val()  // Include recipient_id here
                }
            }).done(function(res) {
                // Append the message to the chat, with appropriate alignment
                $(".messages").append(`<div class="message sent"><p><strong>You:</strong> ${messageContent}</p></div>`);
                $("#message").val('');  // Clear the input
                $(document).scrollTop($(document).height());  // Scroll to the bottom
                console.log('Message sent');
            });
        });
    });

</script>


