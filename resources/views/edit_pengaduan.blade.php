<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        h1 { color: #333; }
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

<h1>Edit Pengaduan</h1>

<form action="/pengaduan/{{ $pengaduan->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Isi Laporan</label>
        <textarea name="isi_laporan" required>{{ $pengaduan->isi_laporan }}</textarea>
    </div>

    <div>
        <label>Foto (biarkan kosong jika tidak ingin ganti)</label>
        <input type="file" name="foto">
        @if($pengaduan->foto)
            <br><img src="{{ asset('assets/pengaduan/' . $pengaduan->foto) }}" width="200">
        @endif
    </div>

    <button type="submit">Update</button>
</form>

<a href="/dashboard">Kembali</a>

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

</body>
</html>