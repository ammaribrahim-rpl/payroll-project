<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $karyawan = Auth::user()->karyawan; // Asumsi user karyawan punya relasi karyawan
        // Anda bisa pass data lain ke view jika perlu
        return view('karyawan.dashboard', compact('karyawan'));
    }
}