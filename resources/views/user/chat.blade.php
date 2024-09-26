<div class="chat">
    <div class="top">
        @auth

        <img
            src="https://media.npr.org/assets/img/2024/04/29/spongebobsquarepants_key_art_custom-3ce5c431ab9bbe048686fd56a6e535dbf7b41cf5.jpg"
            alt="Avatar" style="width:50px;height:50px;">
        <div>
            <p>Spongi Bobi</p>
            <small>Online</small>
        </div>
    </div>

    <div class="messages">

            <!-- If user is authenticated, display the chat messages -->
            @include('components.receive-message', ['message'=>"Hey wasup"])

    </div>

    <div class="bottom">
            <form method="POST" action="/broadcast">

                <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                <button type="submit" style="height: 30px;width:30px;"></button>
            </form>


    </div>
    @else
        <div class="messages">
            <h4>You need to register to use the chat feature</h4>
            <a href="{{ route('register') }}" class="btn btn-primary mt-3">Register</a>
        </div>
    @endauth
</div>


@include('user.pusher')
