<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border px-4 py-2">Product Name</th>
            <th class="border px-4 py-2">Description</th>
            <th class="border px-4 py-2">Price</th>
            <th class="border px-4 py-2">Stock</th>
            <th class="border px-4 py-2">Category</th>
            <th class="border px-4 py-2">Supplier</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($products as $product)
            <tr id="row-{{ $product->id }}">
                <td class="border px-4 py-2">{{ $product->name }}</td>
                <td class="border px-4 py-2">{{ $product->description }}</td>
                <td class="border px-4 py-2">{{ $product->price }}</td>
                <td class="border px-4 py-2 {{ $product->stock < 50 ? 'text-red-500 font-bold' : '' }}">
                    {{ $product->stock }}
                </td>
                <td class="border px-4 py-2">{{ $product->category->name ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $product->supplier->name ?? 'N/A' }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="{{ $product->id }}">Delete</a>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan="7" class="border px-4 py-2 text-center">No products found for the selected filter.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div id="pagination-links" class="mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
