<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeOfService;

class ServiceController extends Controller
{
    public function index()
    {
        $services = TypeOfService::all();
        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|max:50',
            'price' => 'required|integer',
            'description' => 'required',
        ]);

        TypeOfService::create($request->only('service_name', 'price', 'description'));
        return redirect('/admin/service')->with('success', 'Service berhasil ditambahkan');
    }

    public function edit($id)
    {
        $service = TypeOfService::findOrFail($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|max:50',
            'price' => 'required|integer',
            'description' => 'required',
        ]);

        $service = TypeOfService::findOrFail($id);
        $service->update($request->only('service_name', 'price', 'description'));
        return redirect('/admin/service')->with('success', 'Service berhasil diupdate');
    }

    public function destroy($id)
    {
        TypeOfService::findOrFail($id)->delete();
        return redirect('/admin/service')->with('success', 'Service berhasil dihapus');
    }
}
