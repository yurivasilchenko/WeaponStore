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
            <div class="messages">
                @foreach($messages as $message)
                    <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                        <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                    </div>
                @endforeach
            </div>

            <div class="bottom">
                <form method="POST" action="/broadcast">
                    @csrf
                    <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">

                    <!-- Add a dropdown for selecting recipient -->
                    <select id="recipient_id" name="recipient_id">
                        @foreach($users as $user)
                            @if($user->id != Auth::id()) <!-- Exclude the current user -->
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>

                    <button type="submit" style="height: 30px;width:30px;"></button>
                </form>
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


