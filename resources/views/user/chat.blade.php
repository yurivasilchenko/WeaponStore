<div class="chat-container">
    <!-- Chat Icon -->
    <div class="chat-icon" id="chatIcon">
        <i class="fas fa-comments"></i> <!-- Chat icon -->
    </div>

    <div class="chat" id="chat" style="display: none;"> <!-- Initially hidden -->
        @auth
            <div class="user-chat">
                <div class="messages" id="chat-messages">
                    <!-- Messages will be injected here via AJAX -->
                </div>
            </div>
            <!-- Loading indicator -->
            <div id="loading-indicator" style="display: none;">
                <p>Loading...</p>
            </div>

            <div class="bottom">
                <form method="POST" action="/broadcast" class="chat-form">
                    @csrf
                    <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                    <input type="hidden" id="recipient_id" name="recipient_id">
                    <button type="submit" class="chat-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        @else
            <div class="auth-required">
                <h4 class="auth-message">You need to log in or register to use the chat feature.</h4>
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn auth-btn login-btn">Login</a>
                    <a href="{{ route('register') }}" class="btn auth-btn register-btn">Register</a>
                </div>
            </div>
        @endauth
    </div>
</div>


{{--@include('user.pusher')--}}

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const chatIcon = document.getElementById('chatIcon');
        const chat = document.getElementById('chat');

        chatIcon.addEventListener('click', function () {
            if (chat.style.display === 'none' || chat.style.display === '') {
                chat.style.display = 'block'; // Show chat

                // Scroll to the bottom of the chat messages when the chat is opened
                const messagesContainer = document.getElementById('chat-messages');
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

            } else {
                chat.style.display = 'none'; // Hide chat
            }
        });
    });

    $(document).ready(function() {
        @auth
        // Get the authenticated user's ID
        let userId = {{ Auth::check() ? Auth::user()->id : 'null' }};

        if (userId) {
            loadMessagesForUser(userId);
        }

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

        // Subscribe to the private channel for the authenticated user
        const channel = pusher.subscribe('private-chat.' + userId);

        // Bind the chat event to receive messages
        channel.bind('chat', function(data) {
            console.log("Received message: ", data);
            const newMessage = `<div class="message received"><p><strong>Admin:</strong> ${data.message}</p></div>`;
            $(".messages").append(newMessage);

            // Scroll the chat messages container to the bottom
            const messagesContainer = document.getElementById('chat-messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });


        // Load messages for the authenticated user
        function loadMessagesForUser(userId) {
            $('#loading-indicator').show();
            $('#chat-messages').hide();

            $.ajax({
                url: '/chat/' + userId,
                method: 'GET',
                success: function(data) {
                    $('#chat-messages').html(data);  // Inject the messages into the chat container
                    $('#loading-indicator').hide();
                    $('#chat-messages').show();

                    // Scroll the chat messages container to the bottom after loading
                    const messagesContainer = document.getElementById('chat-messages');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
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
            const messageContent = $("#message").val();

            $.ajax({
                url: "/broadcast",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    message: messageContent
                }
            }).done(function(res) {
                // Append the message to the chat, with appropriate alignment
                $(".messages").append(`<div class="message sent"><p><strong>You:</strong> ${messageContent}</p></div>`);
                $("#message").val('');  // Clear the input

                // Scroll the chat messages container to the bottom
                const messagesContainer = document.getElementById('chat-messages');
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                console.log('Message sent');
            });
        });

        @endauth
    });
</script>
