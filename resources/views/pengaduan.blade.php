<!DOCTYPE html>
<html>
<head>
    <title>Kirim Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        h3 { color: #333; }
        form { background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-bottom: 5px; }
        textarea, input[type="file"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<h3>Tulis Pengaduan</h3>

<form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Isi Laporan</label>
        <textarea name="isi_laporan" required></textarea>
    </div>

    <div>
        <label>Foto (Opsional)</label>
        <input type="file" name="foto">
    </div>

    <button type="submit">Kirim</button>
</form>

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="success">
        <p>{{ session('success') }}</p>
    </div>
@endif

<a href="/dashboard">Kembali ke Dashboard</a>

</body>
</html>
