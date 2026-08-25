@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
            <h2 class="font-serif text-xl font-bold text-gray-900">Create New Product</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">&larr; Back to Products</a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Product Title</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Category</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-amber-500">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Description</label>
                <textarea name="description" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-amber-500">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Standard Price (₹)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', '450.00') }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm font-bold">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', '100') }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm">
                        <option value="active">Active (Visible)</option>
                        <option value="draft">Draft (Hidden)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Image URL</label>
                <input type="text" name="image_path" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs">
            </div>

            <div class="flex items-center">
                <label class="text-xs font-bold text-gray-700 flex items-center">
                    <input type="checkbox" name="is_featured" value="1" class="rounded text-amber-500 mr-2"> Feature on Storefront Homepage
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow">
                Save Product
            </button>
        </form>
    </div>
</div>
@endsection
