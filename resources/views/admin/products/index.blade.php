@extends('layouts.admin')

@section('title', 'Manage Products Catalog')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <h2 class="font-serif text-xl font-bold text-gray-900">Products Inventory</h2>
            <p class="text-xs text-gray-500">Manage pricing, stock levels, and product imagery.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow">
            + Add New Product
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 uppercase tracking-wider text-gray-500 font-bold">
                <tr>
                    <th class="p-4">Product</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Standard Price</th>
                    <th class="p-4">Stock</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $p)
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-4 flex items-center space-x-3">
                            <img src="{{ $p->image_path }}" class="w-12 h-12 rounded-xl object-cover bg-gray-100">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $p->name }}</h4>
                                <span class="text-[10px] text-gray-400">SLUG: {{ $p->slug }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-gray-700 font-medium">
                            {{ $p->category ? $p->category->name : 'Uncategorized' }}
                        </td>
                        <td class="p-4 font-bold text-gray-900">₹{{ number_format($p->price, 2) }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] {{ $p->stock_quantity > 20 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $p->stock_quantity }} units
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] uppercase {{ $p->status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.products.edit', $p->id) }}" class="p-2 text-indigo-600 hover:text-indigo-900 font-bold" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this product?')" class="p-2 text-rose-600 hover:text-rose-900 font-bold" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
