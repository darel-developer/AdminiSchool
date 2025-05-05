<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Notifications</h1>
        <ul class="list-group">
            @foreach ($notifications as $notification)
                <li class="list-group-item">
                    <a href="{{ $notification->url }}" class="text-decoration-none">
                        <strong>{{ $notification->message }}</strong>
                    </a>
                    <br>
                    <small>{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
