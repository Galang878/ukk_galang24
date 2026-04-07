<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background-color: white; padding: 40px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .error { color: red; text-align: center; }
        .success { color: green; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>

    @if(session('error'))
    <p class="error">{{ session('error') }}</p>
    @endif

    @if(session('success'))
    <p class="success">{{ session('success') }}</p>
    @endif

    <form action="/actionlogin" method="POST">
        @csrf
        <input type="text" name="nis" placeholder="Masukkan NIS" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p style="text-align: center;">Belum punya akun? <a href="/register">Daftar</a></p>
</div>

</body>
</html>