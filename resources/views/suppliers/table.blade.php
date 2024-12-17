<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border px-4 py-2">Supplier Name</th>
            <th class="border px-4 py-2">No Of Products Supplied</th>
            <th class="border px-4 py-2">Email</th>
            <th class="border px-4 py-2">Phone Number</th>
            <th class="border px-4 py-2">Address</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody id="supplier-table-body">
        @foreach ($suppliers as $supplier)
            <tr id="row-{{ $supplier->id }}">
                <td class="border px-4 py-2">{{ $supplier->name }}</td>
                <td class="border px-4 py-2">{{ $supplier->products_count }}</td>
                <td class="border px-4 py-2">{{ $supplier->email }}</td>
                <td class="border px-4 py-2">{{ $supplier->phone }}</td>
                <td class="border px-4 py-2">{{ $supplier->address }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="{{ $supplier->id }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="pagination-links" class="mt-4">
    {{ $suppliers->links('pagination::bootstrap-5') }}
</div>
