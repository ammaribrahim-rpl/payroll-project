<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Bisa tambahkan data summary jika perlu
        return view('admin.dashboard');
    }
}