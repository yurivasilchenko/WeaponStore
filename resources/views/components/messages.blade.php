@foreach($messages as $message)
    <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
        <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
    </div>
@endforeach
