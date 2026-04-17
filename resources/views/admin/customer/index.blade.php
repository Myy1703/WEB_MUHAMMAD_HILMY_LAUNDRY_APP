{{-- resources/views/admin/customer/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-people me-2"></i>Data Customer</h4>
    <a href="/admin/customer/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Customer
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Customer</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $i => $customer)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $customer->customer_name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                    <td class="text-center">
                        <a href="/admin/customer/{{ $customer->id }}/edit"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="/admin/customer/{{ $customer->id }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus customer ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada data customer
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection