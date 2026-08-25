@extends('layouts.admin')

@section('title', 'Edit Product - ' . $product->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
            <h2 class="font-serif text-xl font-bold text-gray-900">Edit Product</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">&larr; Back to Products</a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Product Title</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Category</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-amber-500">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Description</label>
                <textarea name="description" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-amber-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Standard Price (₹)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm font-bold">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm">
                        <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active (Visible)</option>
                        <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Image URL</label>
                <input type="text" name="image_path" value="{{ old('image_path', $product->image_path) }}" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs">
            </div>

            <div class="flex items-center">
                <label class="text-xs font-bold text-gray-700 flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-amber-500 mr-2"> Feature on Storefront Homepage
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow">
                Update Product Details
            </button>
        </form>
    </div>
</div>
@endsection
