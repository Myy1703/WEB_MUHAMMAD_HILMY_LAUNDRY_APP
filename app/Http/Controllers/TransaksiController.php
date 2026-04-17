<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\Customer;
use App\Models\TypeOfService;

class TransaksiController extends Controller
{
    public function index()
    {
        $orders = TransOrder::with('customer', 'details')->orderBy('id', 'desc')->get();
        return view('operator.transaksi.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services = TypeOfService::all();
        return view('operator.transaksi.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        // Validasi conditional
        $rules = [
            'order_date' => 'required|date',
            'order_end_date' => 'required|date',
            'services' => 'required|array|min:1',
            'tipe_customer' => 'required|in:terdaftar,baru',
        ];

        if ($request->tipe_customer == 'terdaftar') {
            $rules['id_customer'] = 'required|exists:customers,id';
        } else {
            $rules['customer_name'] = 'required|string|max:50';
            $rules['phone'] = 'required|string|max:13';
            $rules['address'] = 'required|string';
        }
        $request->validate($rules);

        // Manage Customer ID
        $id_customer = $request->id_customer;
        $isMember = false;

        if ($request->tipe_customer == 'baru') {
            $customerBaru = Customer::create([
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_member' => 0
            ]);
            $id_customer = $customerBaru->id;
        } else {
            $customerLama = Customer::findOrFail($id_customer);
            $isMember = $customerLama->is_member;
        }

        // Generate kode order
        $orderCode = 'ORD-' . date('Ymd') . '-' . str_pad(TransOrder::count() + 1, 4, '0', STR_PAD_LEFT);

        // Hitung total
        $subtotal = 0;
        foreach ($request->services as $item) {
            $service = TypeOfService::find($item['id_service']);
            if ($service) {
                $subtotal += $service->price * ($item['qty'] ?? 1);
            }
        }

        // Diskon Member
        $memberDiscountPersen = 0;
        $memberDiscountNominal = 0;
        if ($isMember) {
            $memberDiscountPersen = env('DISKON_MEMBER', 5);
            $memberDiscountNominal = ($subtotal * $memberDiscountPersen) / 100;
        }

        // Diskon Voucher
        $voucherCode = $request->voucher_code;
        $voucherDiscountPersen = 0;
        $voucherDiscountNominal = 0;

        if ($voucherCode) {
            $voucher = \App\Models\Voucher::where('voucher_code', $voucherCode)->where('is_active', 1)->first();
            if ($voucher && strtotime($voucher->valid_until) >= strtotime(date('Y-m-d'))) {
                $voucherDiscountPersen = $isMember ? env('DISKON_VOUCHER_MEMBER', 15) : env('DISKON_VOUCHER_NON_MEMBER', 10);
                $voucherDiscountNominal = ($subtotal * $voucherDiscountPersen) / 100;
            } else {
                $voucherCode = null;
            }
        }

        $totalAfterDiscount = $subtotal - $memberDiscountNominal - $voucherDiscountNominal;
        if ($totalAfterDiscount < 0) $totalAfterDiscount = 0;

        // Hitung Pajak dari subtotal
        $taxRate = env('PAJAK_LAUNDRY', 10); 
        $taxNominal = ($subtotal * $taxRate) / 100;
        
        $grandTotal = $totalAfterDiscount + $taxNominal;

        $order = TransOrder::create([
            'id_customer' => $id_customer,
            'order_code' => $orderCode,
            'order_date' => $request->order_date,
            'order_end_date' => $request->order_end_date,
            'order_status' => 0,
            'total' => $grandTotal,
            'pajak_persen' => $taxRate,
            'pajak_nominal' => $taxNominal,
            'member_discount_persen' => $memberDiscountPersen,
            'member_discount_nominal' => $memberDiscountNominal,
            'voucher_code' => $voucherCode,
            'voucher_discount_persen' => $voucherDiscountPersen,
            'voucher_discount_nominal' => $voucherDiscountNominal,
        ]);

        // Simpan detail
        foreach ($request->services as $item) {
            $service = TypeOfService::find($item['id_service']);
            if ($service) {
                TransOrderDetail::create([
                    'id_order' => $order->id,
                    'id_service' => $item['id_service'],
                    'qty' => $item['qty'] ?? 1,
                    'subtotal' => $service->price * ($item['qty'] ?? 1),
                    'notes' => $item['notes'] ?? null,
                ]);
            }
        }

        return redirect('/operator/transaksi')->with('success', 'Transaksi berhasil disimpan');
    }

    public function show($id)
    {
        $order = TransOrder::with('customer', 'details.service')->findOrFail($id);
        return view('operator.transaksi.show', compact('order'));
    }
}
