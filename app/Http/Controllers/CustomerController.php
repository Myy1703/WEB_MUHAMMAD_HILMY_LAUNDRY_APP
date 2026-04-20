<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:50',
            'phone' => 'required|max:13',
            'address' => 'required',
        ]);

        $data = $request->only('customer_name', 'phone', 'address');
        // $data['is_member'] = $request->has('is_member') ? 1 : 0;

        Customer::create($data);
        return redirect('/admin/customer')->with('success', 'Customer berhasil ditambahkan');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|max:50',
            'phone' => 'required|max:13',
            'address' => 'required',
        ]);

        $customer = Customer::findOrFail($id);
        
        $data = $request->only('customer_name', 'phone', 'address');
        // $data['is_member'] = $request->has('is_member') ? 1 : 0;
        
        $customer->update($data);
        return redirect('/admin/customer')->with('success', 'Customer berhasil diupdate');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect('/admin/customer')->with('success', 'Customer berhasil dihapus');
    }
}
