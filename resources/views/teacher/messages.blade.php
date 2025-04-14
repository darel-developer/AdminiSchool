<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\teacher\messages.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages des Parents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Messages des Parents</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="list-group">
        @foreach($messages as $message)
            <div class="list-group-item">
                <h5>De : {{ $message->tuteur->nom }} {{ $message->tuteur->prenom }}</h5>
                <p><strong>Message :</strong> {{ $message->message }}</p>

                @if($message->reply)
                    <p><strong>Réponse :</strong> {{ $message->reply }}</p>
                @else
                    <form action="{{ route('teacher.messages.reply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="message_id" value="{{ $message->id }}">
                        <div class="mb-3">
                            <textarea name="reply" class="form-control" rows="3" placeholder="Écrire une réponse..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>