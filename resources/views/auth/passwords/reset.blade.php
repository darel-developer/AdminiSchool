<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Réinistialiser mot de passe </title>
</head>
<body>
    <form method="POST" action="{{ url('password/email') }}">
        @csrf
        <div class="row gy-3 gy-md-4 overflow-hidden">
            <div class="col-12">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
            </div>
            <div class="col-12">
                <div class="d-grid">
                    <button class="btn bsb-btn-xl btn-primary" type="submit">Reset Password</button>
                </div>
            </div>
        </div>
    </form>
    
</body>
</html>