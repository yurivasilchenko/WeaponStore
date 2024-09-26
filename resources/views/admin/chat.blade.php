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

           {{-- <div class="user-list">
                <ul>
                    @foreach($users as $user)
                        <li data-user-id="{{ $user->id }}" class="user-select">{{ $user->name }}</li>
                    @endforeach
                </ul>
            </div>--}}
            <div class="user-list">
                <ul>
                    @foreach($users as $user)
                        <li data-user-id="{{ $user->id }}" class="user-select">{{ $user->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="messages" id="chat-messages">
                @foreach($messages as $message)
                    <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                        <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                    </div>
                @endforeach
            </div>


            {{--<div class="bottom">
                <form method="POST" action="/broadcast">
                    @csrf
                    <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">

                    <!-- Hidden field to store the recipient ID -->
                    <input type="hidden" id="recipient_id" name="recipient_id" value="">

                    <button type="submit" style="height: 30px;width:30px;"></button>
                </form>
            </div>--}}
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
    // Check if 'pusher' is already defined to prevent redeclaration
    if (typeof pusher === 'undefined') {
        // Initialize Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true
        });


        $(document).ready(function() {
            // Automatically select the first user when the page loads
            const firstUser = $('.user-select').first();
            if (firstUser.length > 0) {
                const firstUserId = firstUser.data('user-id');

                // Set the hidden input's value to the first user's ID
                $('#recipient_id').val(firstUserId);

                // Simulate a click on the first user to trigger message load
                firstUser.addClass('active');
                loadMessagesForUser(firstUserId);
            }

            // Handle user selection when a user is clicked
            $('.user-select').click(function() {
                // Remove active class from all users
                $('.user-select').removeClass('active');

                // Add active class to the clicked user
                $(this).addClass('active');

                // Get the selected user's ID from the data attribute
                const selectedUserId = $(this).data('user-id');

                // Set the hidden input's value to the selected user's ID
                $('#recipient_id').val(selectedUserId);

                // Load messages for the selected user
                loadMessagesForUser(selectedUserId);
            });

            // Function to load messages for the selected user
            function loadMessagesForUser(userId) {
                // Example: Make an AJAX call to fetch messages for the selected user
                $.ajax({
                    url: '/adminchat/' + userId, // Adjust this URL based on your routes
                    method: 'GET',
                    success: function(data) {
                        // Update the chat message area with the retrieved messages
                        $('#chat-messages').html(data);
                    },
                    error: function(xhr) {
                        console.log('Error loading messages: ', xhr);
                    }
                });
            }
        });




        // Subscribe to the 'public' channel
        const channel = pusher.subscribe('public');
        channel.bind('chat', function(data) {
            console.log('Received message:', data);
        });

        // Listen for the 'chat' event
        channel.bind('chat', function(data) {
            // Append the received message to the chat window
            const newMessage = `<div class="left message"><p>${data.message}</p></div>`;
            $(".messages").append(newMessage);

            // Scroll to the bottom of the chat
            $(document).scrollTop($(document).height());
        });

        // Broadcast messages
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
                // Display your own message
                $(".messages").append(`<div class="right message"><p>${$("#message").val()}</p></div>`);
                $("#message").val('');
                $(document).scrollTop($(document).height());
                console.log('Message sent');
            });
        });
    } else {
        console.log("Pusher already initialized.");
    }
</script>


