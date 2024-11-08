<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Perubahan Email</title>
</head>
<body>
    <form action="{{ route('updateEmail') }}" method="POST">
        @csrf
        <div>
            <label for="new_email">Email Baru:</label>
            <input type="email" name="new_email" id="new_email" required>
            @error('new_email')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Ganti Email</button>
    </form>
</body>
</html>
