<script>
    // Check if 'pusher' is already defined to prevent redeclaration
    if (typeof pusher === 'undefined') {
        // Initialize Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            encrypted: true
        });
        console.log(pusher);

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
                    message: $("form #message").val(),
                }
            }).done(function(res) {
                // Display your own message
                $(".messages").append(`<div class="right message"><p>${$("form #message").val()}</p></div>`);
                $("form #message").val('');
                $(document).scrollTop($(document).height());
                console.log('sent');
            });
        });
    } else {
        console.log("Pusher already initialized.");
    }
</script>
