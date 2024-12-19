<table class="table-auto w-full border-collapse border border-red-300">
    <thead>
        <tr>
            <th class="border px-4 py-2">User</th>
            <th class="border px-4 py-2">Order Date</th>
            <th class="border px-4 py-2">Total Amount</th>
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td class="border px-4 py-2">{{ $order->user->name }}</td>
                <td class="border px-4 py-2">{{ $order->created_at->format('d M, Y') }}</td>
                <td class="border px-4 py-2">${{ $order->total_amount }}</td>
                <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('orders.show',  ['orderId' => $order->id]) }}" class="btn btn-primary">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- <div id="pagination-links" class="mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div> --}}
