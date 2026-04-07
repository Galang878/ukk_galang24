<!DOCTYPE html>
<html>
<head>
    <title>Edit Tanggapan</title>
    <style>
        body { font-family: Inter, Arial, sans-serif; margin: 0; min-height: 100vh; background: #f3f6fb; color: #1f2937; }
        .page { max-width: 820px; margin: 24px auto; padding: 0 16px; }
        .card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); }
        h1 { margin-top: 0; font-size: 28px; }
        p { margin: 0; color: #475569; }
        .meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin: 20px 0; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; }
        textarea, select { width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; background: #ffffff; color: #0f172a; }
        textarea { min-height: 140px; resize: vertical; }
        button { padding: 12px 20px; background: #2563eb; color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; }
        button:hover { background: #1d4ed8; }
        .back { display: inline-flex; margin-top: 18px; color: #2563eb; text-decoration: none; }
        .back:hover { text-decoration: underline; }
        @media (max-width: 720px) { .meta { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <h1>Edit Tanggapan</h1>
        <div class="meta">
            <div>
                <p><strong>Pelapor:</strong> {{ $tanggapan->pengaduan->user->name }}</p>
                <p><strong>NIS:</strong> {{ $tanggapan->pengaduan->user->nis }}</p>
            </div>
            <div>
                <p><strong>Tanggal Pengaduan:</strong> {{ $tanggapan->pengaduan->tgl_pengaduan }}</p>
                <p><strong>Status Saat Ini:</strong> {{ $tanggapan->pengaduan->status == 'selesai' ? 'Selesai' : 'Diproses' }}</p>
            </div>
        </div>

        <form action="/admin/tanggapan/{{ $tanggapan->id }}" method="POST">
            @csrf
            @method('PUT')

            <label>Status</label>
            <select name="status" required>
                <option value="proses" {{ $tanggapan->pengaduan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ $tanggapan->pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>

            <label>Tanggapan</label>
            <textarea name="tanggapan" rows="6" required>{{ $tanggapan->tanggapan }}</textarea>

            <button type="submit">Simpan Perubahan</button>
        </form>

        <a href="/admin/pengaduan/{{ $tanggapan->pengaduan->id }}/tanggapi" class="back">&larr; Kembali ke Histori Pengaduan</a>
    </div>
</div>
</body>
</html>