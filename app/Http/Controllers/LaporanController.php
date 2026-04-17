<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransOrder;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = TransOrder::with('customer', 'details.service')
            ->where('order_status', 1); // Hanya yg sudah selesai

        if ($request->dari) {
            $query->where('order_date', '>=', $request->dari);
        }
        if ($request->sampai) {
            $query->where('order_date', '<=', $request->sampai);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();
        $totalOmzet = $orders->sum('total');

        return view('pimpinan.laporan.index', compact('orders', 'totalOmzet'));
    }
}
