<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Models\Pengaduan; 
use App\Models\Tanggapan; 
use Illuminate\Support\Facades\Auth; 

class PengaduanController extends Controller 
{ 
   /** 
    * Menampilkan daftar pengaduan milik masyarakat yang sedang login 
    */ 
   public function index() 
   { 
       $pengaduans = Pengaduan::where('user_id', session('user_id')) 
           ->orderBy('tgl_pengaduan', 'desc') 
           ->get(); 

       return view('dashboard.masyarakat', compact('pengaduans')); 
   } 

   /** 
    * Menyimpan data pengaduan ke database 
    */ 
   public function store(Request $req) 
   { 
       $req->validate([ 
           'isi_laporan' => 'required', 
           'foto' => 'image|max:2048', 
       ]); 

       $namaFile = null; 
       if ($req->hasFile('foto')) { 
           $file = $req->file('foto'); 
           $namaFile = date('YmdHis') . '.' . $file->getClientOriginalExtension(); 
           // Menyimpan langsung ke folder public agar mudah diakses 
           $file->move(public_path('assets/pengaduan'), $namaFile); 
       } 

       Pengaduan::create([ 
           'tgl_pengaduan' => date('Y-m-d'), 
           'user_id' => session('user_id'), 
           'isi_laporan' => $req->isi_laporan, 
           'foto' => $namaFile, 
           'status' => '0', 
       ]); 

       return redirect()->back()->with('success', 'Laporan Berhasil Terkirim!'); 
   }

   public function edit($id)
   {
       $pengaduan = Pengaduan::where('user_id', session('user_id'))->findOrFail($id);
       return view('edit_pengaduan', compact('pengaduan'));
   }

   public function update(Request $request, $id)
   {
       $pengaduan = Pengaduan::where('user_id', session('user_id'))->findOrFail($id);

       $request->validate([
           'isi_laporan' => 'required',
           'foto' => 'image|max:2048',
       ]);

       $namaFile = $pengaduan->foto;
       if ($request->hasFile('foto')) {
           if ($namaFile && file_exists(public_path('assets/pengaduan/' . $namaFile))) {
               unlink(public_path('assets/pengaduan/' . $namaFile));
           }
           $file = $request->file('foto');
           $namaFile = date('YmdHis') . '.' . $file->getClientOriginalExtension();
           $file->move(public_path('assets/pengaduan'), $namaFile);
       }

       $pengaduan->update([
           'isi_laporan' => $request->isi_laporan,
           'foto' => $namaFile,
       ]);

       return redirect('/dashboard')->with('success', 'Pengaduan berhasil diupdate!');
   }

   public function destroy($id)
   {
       $pengaduan = Pengaduan::where('user_id', session('user_id'))->findOrFail($id);

       if ($pengaduan->foto && file_exists(public_path('assets/pengaduan/' . $pengaduan->foto))) {
           unlink(public_path('assets/pengaduan/' . $pengaduan->foto));
       }

       $pengaduan->delete();

       return redirect('/dashboard')->with('success', 'Pengaduan berhasil dihapus!');
   } 

   /** 
    * Dashboard Admin: Menampilkan statistik dan daftar semua pengaduan 
    */ 
   public function indexAdmin() 
   { 
       $pengaduans = Pengaduan::with('user')->orderBy('tgl_pengaduan', 'desc')->get(); 

       $countBaru = Pengaduan::where('status', '0')->count(); 
       $countProses = Pengaduan::where('status', 'proses')->count(); 
       $countSelesai = Pengaduan::where('status', 'selesai')->count(); 

       return view('admin.dashboard', compact('pengaduans', 'countBaru', 'countProses', 'countSelesai')); 
   } 

   public function tanggapi($id)
   {
       $pengaduan = Pengaduan::with(['user', 'tanggapans.user'])->findOrFail($id);
       return view('tanggapi', compact('pengaduan'));
   }

   public function storeTanggapan(Request $request, $id)
   {
       $request->validate([
           'tanggapan' => 'required',
           'status' => 'required|in:proses,selesai',
       ]);

       $pengaduan = Pengaduan::findOrFail($id);
       $pengaduan->update(['status' => $request->status]);

       Tanggapan::create([
           'pengaduan_id' => $id,
           'tanggapan' => $request->tanggapan,
           'user_id' => session('user_id'),
       ]);

       return redirect('/admin/pengaduan/'.$id.'/tanggapi')->with('success', 'Tanggapan berhasil disimpan!');
   }

   public function editTanggapan($id)
   {
       $tanggapan = Tanggapan::with(['pengaduan.user'])->findOrFail($id);
       return view('edit_tanggapan', compact('tanggapan'));
   }

   public function updateTanggapan(Request $request, $id)
   {
       $request->validate([
           'tanggapan' => 'required',
           'status' => 'required|in:proses,selesai',
       ]);

       $tanggapan = Tanggapan::findOrFail($id);
       $tanggapan->update([
           'tanggapan' => $request->tanggapan,
       ]);

       $tanggapan->pengaduan->update(['status' => $request->status]);

       return redirect('/admin/pengaduan/'.$tanggapan->pengaduan_id.'/tanggapi')->with('success', 'Tanggapan berhasil diperbarui!');
   }
}



