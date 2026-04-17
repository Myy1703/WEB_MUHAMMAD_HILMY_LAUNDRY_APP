<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('id', 'desc')->get();
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|unique:vouchers,voucher_code|max:50',
            'valid_until' => 'required|date',
        ]);

        $data = $request->only('voucher_code', 'description', 'valid_until');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Voucher::create($data);
        return redirect('/admin/voucher')->with('success', 'Voucher berhasil dibuat');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'voucher_code' => 'required|max:50|unique:vouchers,voucher_code,'.$id,
            'valid_until' => 'required|date',
        ]);

        $voucher = Voucher::findOrFail($id);
        $data = $request->only('voucher_code', 'description', 'valid_until');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        
        $voucher->update($data);
        return redirect('/admin/voucher')->with('success', 'Voucher diubah');
    }

    public function destroy($id)
    {
        Voucher::findOrFail($id)->delete();
        return redirect('/admin/voucher')->with('success', 'Voucher dihapus');
    }

    // Ajax Handler to check voucher validity (Callable by Operator)
    public function check(Request $request)
    {
        $code = $request->code;
        $voucher = Voucher::where('voucher_code', $code)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Voucher tidak ditemukan']);
        }
        
        if (!$voucher->is_active) {
            return response()->json(['success' => false, 'message' => 'Voucher sudah tidak aktif']);
        }

        if (strtotime($voucher->valid_until) < strtotime(date('Y-m-d'))) {
            return response()->json(['success' => false, 'message' => 'Voucher sudah expired']);
        }

        return response()->json([
            'success' => true,
            'voucher' => $voucher,
            'message' => 'Voucher berhasil diaplikasikan'
        ]);
    }
}
