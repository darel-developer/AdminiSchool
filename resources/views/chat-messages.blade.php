<div class="chat-messages" id="chatMessages">
    @foreach ($messages as $message)
        <div class="mb-2 p-2 rounded {{ $message->tuteur_id ? 'bg-primary text-white' : 'bg-light' }}">
            @if ($message->message)
                <p>{{ $message->message }}</p>
            @endif
            @if ($message->attachment)
                <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank" class="text-decoration-none">
                    Voir la pièce jointe
                </a>
            @endif
        </div>
    @endforeach
</div>
