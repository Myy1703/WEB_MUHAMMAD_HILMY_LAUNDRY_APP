<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\Customer;
use App\Models\TypeOfService;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi.
     */
    public function index()
    {
        $orders = TransOrder::with('customer', 'details')->orderBy('id', 'desc')->get();
        return view('operator.transaksi.index', compact('orders'));
    }

    /**
     * Menampilkan form buat transaksi baru.
     */
    public function create()
    {
        $customers = Customer::all();
        $services = TypeOfService::all();
        return view('operator.transaksi.create', compact('customers', 'services'));
    }

    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_date'     => 'required|date',
            'order_end_date' => 'required|date',
            'services'       => 'required|array|min:1',
            'customer_name'  => 'required|string|max:50',
            'phone'          => 'required|string|max:13',
            'address'        => 'required|string',
        ]);

        // Buat data customer baru dari input form
        $customer = Customer::create([
            'customer_name' => $request->customer_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
        ]);

        // Generate kode order unik
        $orderCode = 'ORD-' . date('Ymd') . '-' . str_pad(TransOrder::count() + 1, 4, '0', STR_PAD_LEFT);

        // Hitung total harga dari semua layanan yang dipilih
        $total = 0;
        foreach ($request->services as $item) {
            $service = TypeOfService::find($item['id_service']);
            if ($service) {
                $total += $service->price * ($item['qty'] ?? 1);
            }
        }

        // Simpan order utama
        $order = TransOrder::create([
            'id_customer'    => $customer->id,
            'order_code'     => $orderCode,
            'order_date'     => $request->order_date,
            'order_end_date' => $request->order_end_date,
            'order_status'   => 0,
            'total'          => $total,
        ]);

        // Simpan detail layanan per item
        foreach ($request->services as $item) {
            $service = TypeOfService::find($item['id_service']);
            if ($service) {
                TransOrderDetail::create([
                    'id_order'   => $order->id,
                    'id_service' => $item['id_service'],
                    'qty'        => $item['qty'] ?? 1,
                    'subtotal'   => $service->price * ($item['qty'] ?? 1),
                    'notes'      => $item['notes'] ?? null,
                ]);
            }
        }

        return redirect('/operator/transaksi')->with('success', 'Transaksi berhasil disimpan');
    }

    /**
     * Menampilkan detail satu transaksi.
     */
    public function show($id)
    {
        $order = TransOrder::with('customer', 'details.service')->findOrFail($id);
        return view('operator.transaksi.show', compact('order'));
    }
}
