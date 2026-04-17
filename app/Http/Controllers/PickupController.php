<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransOrder;
use App\Models\TransLaundryPickup;

class PickupController extends Controller
{
    public function index()
    {
        // Order yang belum diambil (status = 0)
        $orders = TransOrder::with('customer', 'details')
            ->where('order_status', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view('operator.pickup.index', compact('orders'));
    }

    public function show($id)
    {
        $order = TransOrder::with('customer', 'details.service')->findOrFail($id);
        return view('operator.pickup.show', compact('order'));
    }

    public function proses(Request $request, $id)
    {
        $request->validate([
            'order_pay' => 'required|integer',
        ]);

        $order = TransOrder::findOrFail($id);

        // Update status dan pembayaran
        $order->update([
            'order_status' => 1,
            'order_pay' => $request->order_pay,
            'order_change' => $request->order_pay - $order->total,
        ]);

        // Catat pickup
        TransLaundryPickup::create([
            'id_order' => $order->id,
            'id_customer' => $order->id_customer,
            'pickup_date' => now(),
            'notes' => $request->notes,
        ]);

        return redirect('/operator/pickup')->with('success', 'Pickup berhasil diproses');
    }
}
