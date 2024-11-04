<script>
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
            $(document).scrollTop($(document).height());
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
                },
                error: function(xhr) {
                    console.log('Error loading messages: ', xhr);
                    $('#loading-indicator').hide();
                    $('#chat-messages').show();
                }
            });
        }



        // Broadcast messages
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
                $(document).scrollTop($(document).height());  // Scroll to the bottom
                console.log('Message sent');
            });
        });

        @endauth
    });
</script>
