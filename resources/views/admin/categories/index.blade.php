@extends('layouts.admin')

@section('title', 'Manage Product Categories')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Add New Category Form -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4">
        <h3 class="font-serif text-lg font-bold text-gray-900 pb-2 border-b border-gray-100">Add New Category</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Category Name</label>
                <input type="text" name="name" required placeholder="e.g. Scented Candles" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-amber-500">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Description</label>
                <textarea name="description" rows="3" placeholder="Category description..." class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-amber-500"></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-600 mb-1">Banner Image URL</label>
                <input type="text" name="image_path" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs">
            </div>
            <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow">
                Save Category
            </button>
        </form>
    </div>

    <!-- Category List Table -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-serif text-lg font-bold text-gray-900">Existing Categories</h3>
        </div>

        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 uppercase tracking-wider text-gray-500 font-bold">
                <tr>
                    <th class="p-4">Category</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4">Items Count</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($categories as $cat)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-bold text-gray-900 flex items-center space-x-3">
                            <img src="{{ $cat->image_path ?: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=150&q=80' }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                            <div>
                                <span class="text-sm block">{{ $cat->name }}</span>
                                <span class="text-[10px] text-gray-400 font-normal line-clamp-1">{{ $cat->description }}</span>
                            </div>
                        </td>
                        <td class="p-4 font-mono text-gray-500">{{ $cat->slug }}</td>
                        <td class="p-4 font-bold text-brand-600">{{ $cat->products_count }} products</td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete category?')" class="p-2 text-rose-600 hover:text-rose-900 font-bold">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
