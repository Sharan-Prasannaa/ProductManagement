<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Description</th>
            <th class="border px-4 py-2">No Of Products</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody id="category-table-body">
        @foreach ($categories as $category)
            <tr id="row-{{ $category->id }}">
                <td class="border px-4 py-2">{{ $category->name }}</td>
                <td class="border px-4 py-2">{{ $category->description }}</td>
                <td class="border px-4 py-2">{{ $category->products_count }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="{{ $category->id }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    {{ $categories->links('pagination::bootstrap-5') }}
