<!DOCTYPE html>
<html>
<head>
    <title>Tanggapi Pengaduan</title>
    <style>
        body { font-family: Inter, Arial, sans-serif; margin: 0; min-height: 100vh; background: #f3f6fb; color: #1f2937; }
        .page { max-width: 920px; margin: 24px auto; padding: 0 16px; }
        .card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); }
        h1 { margin-top: 0; font-size: 28px; }
        .meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin: 20px 0; }
        .meta p { margin: 0; color: #475569; }
        .content { background: #f8fafc; padding: 18px; border-radius: 14px; margin-bottom: 20px; line-height: 1.7; }
        .content img { max-width: 100%; border-radius: 12px; margin-top: 12px; }
        form { display: grid; gap: 14px; }
        label { font-weight: 600; color: #334155; }
        select, textarea { width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; background: #ffffff; color: #0f172a; }
        textarea { min-height: 140px; resize: vertical; }
        button { width: fit-content; padding: 12px 20px; background: #2563eb; color: #ffffff; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; }
        button:hover { background: #1d4ed8; }
        .history { margin-top: 28px; }
        .history h2 { margin-bottom: 14px; }
        .history-item { border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px; background: #f8fafc; margin-bottom: 12px; }
        .history-item:last-child { margin-bottom: 0; }
        .history-item .top { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
        .history-item .date { color: #64748b; font-size: 13px; }
        .history-item .status { display: inline-block; margin-top: 8px; color: #1d4ed8; font-size: 12px; font-weight: 700; background: #dbeafe; padding: 4px 10px; border-radius: 9999px; }
        .history-item p { margin: 12px 0 0; color: #334155; }
        .history-item .edit-link { display: inline-flex; margin-top: 10px; color: #2563eb; text-decoration: none; font-size: 14px; }
        .history-item .edit-link:hover { text-decoration: underline; }
        a.back { display: inline-flex; margin-top: 20px; color: #2563eb; text-decoration: none; }
        a.back:hover { text-decoration: underline; }
        @media (max-width: 720px) { .meta { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        <h1>Tanggapi Pengaduan</h1>

        <div class="meta">
            <p><strong>Pelapor</strong><br>{{ $pengaduan->user->name }}</p>
            <p><strong>NIS</strong><br>{{ $pengaduan->user->nis }}</p>
            <p><strong>Tanggal</strong><br>{{ $pengaduan->tgl_pengaduan }}</p>
            <p><strong>Status</strong><br>
                @if($pengaduan->status == '0') Belum Diproses
                @elseif($pengaduan->status == 'proses') Diproses
                @else Selesai
                @endif
            </p>
        </div>

        <div class="content">
            <h2>Isi Laporan</h2>
            <p>{{ $pengaduan->isi_laporan }}</p>
            @if($pengaduan->foto)
                <img src="{{ asset('assets/pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan">
            @endif
        </div>

        <form action="/admin/pengaduan/{{ $pengaduan->id }}/tanggapi" method="POST">
            @csrf
            <label>Status</label>
            <select name="status" required>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
            </select>
            <label>Tanggapan Admin</label>
            <textarea name="tanggapan" rows="6" required></textarea>
            <button type="submit">Kirim Tanggapan</button>
        </form>

        @if($pengaduan->tanggapans->count() > 0)
            <div class="history">
                <h2>Histori Tanggapan</h2>
                @foreach($pengaduan->tanggapans as $item)
                    <div class="history-item">
                        <div class="top">
                            <span class="date">{{ $item->created_at->format('d M Y H:i') }}</span>
                            <span class="status">{{ $item->pengaduan->status == 'selesai' ? 'Selesai' : 'Diproses' }}</span>
                        </div>
                        <p>{{ $item->tanggapan }}</p>
                        <a href="/admin/tanggapan/{{ $item->id }}/edit" class="edit-link">Edit Tanggapan</a>
                    </div>
                @endforeach
            </div>
        @endif

        <a href="/dashboard" class="back">&larr; Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>