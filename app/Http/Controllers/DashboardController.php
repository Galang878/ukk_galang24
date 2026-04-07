<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('role') == 'admin') {
            $pengaduans = Pengaduan::with('user')->orderBy('tgl_pengaduan', 'desc')->get();
            return view('dashboard', compact('pengaduans'));
        } else {
            $pengaduans = Pengaduan::where('user_id', session('user_id'))->orderBy('tgl_pengaduan', 'desc')->get();
            $allPengaduans = Pengaduan::with('user')->orderBy('tgl_pengaduan', 'desc')->get();
            return view('dashboard', compact('pengaduans', 'allPengaduans'));
        }
    }
}
