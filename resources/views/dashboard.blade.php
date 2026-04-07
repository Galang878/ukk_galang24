<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Inter, Arial, sans-serif; margin: 0; min-height: 100vh; background-color: #f3f6fb; color: #1f2937; }
        .page { max-width: 1200px; margin: 0 auto; padding: 20px; }
        header { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 0; }
        header h1 { margin: 0; font-size: 28px; }
        .subtitle { color: #475569; margin-top: 8px; }
        .panel { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05); }
        .panel + .panel { margin-top: 20px; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
        .btn, .tag, .link-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; text-decoration: none; font-weight: 600; }
        .btn { padding: 10px 16px; color: #fff; background: #2563eb; border: 1px solid transparent; transition: background 0.2s ease; }
        .btn:hover { background: #1d4ed8; }
        .link-btn { background: transparent; color: #2563eb; border: 1px solid #c7d2fe; padding: 8px 12px; }
        .link-btn:hover { background: #eff6ff; }
        .tag { padding: 4px 10px; background: #e2e8f0; color: #334155; border-radius: 9999px; font-size: 13px; }
        .table-wrapper { overflow-x: auto; margin-top: 20px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; align-items: center; }
        .grid-2 .actions { justify-self: end; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 14px 16px; border-bottom: 1px solid #e2e8f0; text-align: left; vertical-align: middle; }
        th { background: #f8fafc; color: #475569; font-weight: 700; }
        tbody tr:hover { background: #f8fafc; }
        .status { font-size: 13px; text-transform: uppercase; letter-spacing: 0.04em; }
        .status-new { color: #0f766e; background: #d1fae5; padding: 4px 10px; border-radius: 9999px; }
        .status-process { color: #1d4ed8; background: #dbeafe; padding: 4px 10px; border-radius: 9999px; }
        .status-done { color: #047857; background: #dcfce7; padding: 4px 10px; border-radius: 9999px; }
        .thumb { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1; }
        .note { color: #475569; font-size: 14px; margin-top: 8px; }
        .history-card { background: #f8fafc; border-radius: 12px; padding: 16px; margin-top: 16px; }
        .history-item { border-bottom: 1px solid #e2e8f0; padding: 12px 0; }
        .history-item:last-child { border-bottom: none; }
        .history-item span { font-size: 13px; color: #64748b; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        @media (max-width: 900px) { .grid-2 { grid-template-columns: 1fr; } }
        @media (max-width: 640px) {
            header { flex-direction: column; align-items: flex-start; }
            .actions { width: 100%; }
            table { min-width: 600px; }
        }
    </style>
</head>
<body>
<div class="page">
    @php use Illuminate\Support\Str; @endphp
    <header>
        <div>
            <h1>Dashboard</h1>
            <p class="subtitle">Halo {{ session('user') }}, lihat ringkasan pengaduan dan tanggapan Anda di sini.</p>
        </div>
        <div class="actions">
            <a href="/logout" class="btn">Logout</a>
        </div>
    </header>

    @if(session('role') == 'admin')
        <div class="panel">
            <div class="grid-2">
                <div>
                    <h2>Daftar Pengaduan</h2>
                    <p class="note">Semua pengaduan dari user. Klik "Tanggapi" atau lihat histori balasan.</p>
                </div>
            </div>

            @if($pengaduans->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelapor</th>
                                <th>Pengaduan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduans as $pengaduan)
                                <tr>
                                    <td>{{ $pengaduan->tgl_pengaduan }}</td>
                                    <td>{{ $pengaduan->user->name }}</td>
                                    <td>{{ Str::limit($pengaduan->isi_laporan, 80) }}</td>
                                    <td>
                                        @if($pengaduan->status == '0')
                                            <span class="status status-new">Belum Diproses</span>
                                        @elseif($pengaduan->status == 'proses')
                                            <span class="status status-process">Diproses</span>
                                        @else
                                            <span class="status status-done">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/admin/pengaduan/{{ $pengaduan->id }}/tanggapi" class="link-btn">Buka</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Tidak ada pengaduan.</p>
            @endif
        </div>
    @else
        <div class="panel">
            <div class="grid-2">
                <div>
                    <h2>Pengaduan Anda</h2>
                    <p class="note">Lihat status pengaduan dan balasan admin di sini.</p>
                </div>
                <div class="actions">
                    <a href="/pengaduan" class="btn">Kirim Pengaduan Baru</a>
                </div>
            </div>

            @if($pengaduans->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Foto</th>
                                <th>Isi Laporan</th>
                                <th>Status</th>
                                <th>Balasan Admin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduans as $pengaduan)
                                <tr>
                                    <td>{{ $pengaduan->tgl_pengaduan }}</td>
                                    <td>
                                        @if($pengaduan->foto)
                                            <img src="{{ asset('assets/pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="thumb">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($pengaduan->isi_laporan, 80) }}</td>
                                    <td>
                                        @if($pengaduan->status == '0')
                                            <span class="status status-new">Belum Diproses</span>
                                        @elseif($pengaduan->status == 'proses')
                                            <span class="status status-process">Diproses</span>
                                        @else
                                            <span class="status status-done">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ $pengaduan->latestTanggapan?->tanggapan ?? 'Belum ada balasan' }}</td>
                                    <td>
                                        <a href="/pengaduan/{{ $pengaduan->id }}/edit" class="link-btn">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Belum ada pengaduan.</p>
            @endif

            @php $allPengaduans = \App\Models\Pengaduan::with(['user', 'latestTanggapan'])->orderBy('tgl_pengaduan', 'desc')->get(); @endphp

            <div class="panel" style="margin-top: 20px;">
                <h2>Semua Pengaduan</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelapor</th>
                                <th>Pengaduan</th>
                                <th>Status</th>
                                <th>Balasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPengaduans as $pengaduan)
                                <tr>
                                    <td>{{ $pengaduan->tgl_pengaduan }}</td>
                                    <td>{{ $pengaduan->user->name }}</td>
                                    <td>{{ Str::limit($pengaduan->isi_laporan, 80) }}</td>
                                    <td>
                                        @if($pengaduan->status == '0')
                                            <span class="status status-new">Belum Diproses</span>
                                        @elseif($pengaduan->status == 'proses')
                                            <span class="status status-process">Diproses</span>
                                        @else
                                            <span class="status status-done">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ $pengaduan->latestTanggapan?->tanggapan ?? 'Belum ada balasan' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
</body>
</html>